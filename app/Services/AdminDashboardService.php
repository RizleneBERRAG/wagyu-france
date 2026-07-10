<?php

namespace App\Services;

use App\Models\AnimalBatch;
use App\Models\ContactMessage;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Models\ShopProduct;
use Illuminate\Support\Collection;

class AdminDashboardService
{
    public function navigationCounts(): array
    {
        return [
            'orders' => ShopOrderRequest::where('status', 'nouvelle')->count()
                + ProReservationRequest::where('status', 'nouvelle')->count(),
            'contacts' => ContactMessage::where('status', 'nouvelle')->count(),
            'low_stock' => ShopProduct::where('is_active', true)
                ->whereColumn('stock_kg', '<=', 'low_stock_threshold')
                ->count(),
            'billing_unsent' => ShopOrderRequest::whereNotNull('invoice_number')->whereNull('invoice_sent_at')->count()
                + ProReservationRequest::whereNotNull('invoice_number')->whereNull('invoice_sent_at')->count(),
            'logistics' => ShopOrderRequest::whereIn('status', ['confirmee', 'traitee'])
                    ->whereNotIn('preparation_status', ['delivered', 'cancelled'])
                    ->count()
                + ProReservationRequest::whereIn('status', ['confirmee', 'traitee'])
                    ->whereNotIn('preparation_status', ['delivered', 'cancelled'])
                    ->count(),
        ];
    }

    public function activeBatchSummary(): ?array
    {
        $batch = AnimalBatch::with('cuts')->active()->latest('id')->first();

        if (! $batch) {
            return null;
        }

        $requestedByCut = $this->requestedQuantities($batch);
        $available = (float) $batch->cuts->where('is_active', true)->sum('available_kg');
        $requested = $batch->cuts
            ->where('is_active', true)
            ->sum(fn ($cut) => min((float) $cut->available_kg, (float) ($requestedByCut[$cut->slug] ?? 0)));
        $progress = $available > 0 ? min(100, round(($requested / $available) * 100)) : 0;

        return [
            'batch' => $batch,
            'available_kg' => $available,
            'requested_kg' => $requested,
            'progress' => $progress,
            'threshold_reached' => $progress >= $batch->launch_threshold_percent,
            'cuts' => $batch->cuts->map(function ($cut) use ($requestedByCut) {
                $requested = (float) ($requestedByCut[$cut->slug] ?? 0);
                $available = (float) $cut->available_kg;

                return [
                    'model' => $cut,
                    'requested_kg' => $requested,
                    'progress' => $available > 0 ? min(100, round(($requested / $available) * 100)) : 0,
                ];
            }),
        ];
    }

    public function notifications(): array
    {
        $notifications = [];
        $counts = $this->navigationCounts();
        $batch = $this->activeBatchSummary();

        if (config('mail.default') === 'log') {
            $notifications[] = [
                'level' => 'warning',
                'title' => 'Emails encore en mode test',
                'message' => 'Les messages sont enregistrés dans les logs mais ne quittent pas encore le serveur.',
                'route' => 'admin.settings.index',
            ];
        }

        $legalIncomplete = collect([
            config('legal.company.legal_name'),
            config('legal.company.siret'),
            config('legal.company.publication_director'),
            config('legal.hosting.name'),
            config('legal.mediator.name'),
        ])->contains(fn ($value) => blank($value));

        if ($legalIncomplete) {
            $notifications[] = [
                'level' => 'info',
                'title' => 'Informations légales incomplètes',
                'message' => 'Complétez l’identité de l’entreprise, l’hébergeur et le médiateur avant la mise en ligne.',
                'route' => 'admin.settings.index',
            ];
        }

        if ($counts['orders'] > 0) {
            $notifications[] = [
                'level' => 'important',
                'title' => $counts['orders'] . ' nouvelle(s) commande(s)',
                'message' => 'Des demandes boutique ou professionnelles attendent une première lecture.',
                'route' => 'admin.demandes',
            ];
        }

        if ($counts['contacts'] > 0) {
            $notifications[] = [
                'level' => 'info',
                'title' => $counts['contacts'] . ' nouveau(x) message(s)',
                'message' => 'Des visiteurs ont contacté la maison depuis le formulaire.',
                'route' => 'admin.demandes',
            ];
        }

        if ($counts['billing_unsent'] > 0) {
            $notifications[] = [
                'level' => 'warning',
                'title' => $counts['billing_unsent'] . ' facture(s) non envoyée(s)',
                'message' => 'Des factures sont émises mais n’ont pas encore été transmises depuis le tableau de bord.',
                'route' => 'admin.billing.index',
            ];
        }

        $readyCount = ShopOrderRequest::where('preparation_status', 'ready')->count()
            + ProReservationRequest::where('preparation_status', 'ready')->count();

        if ($readyCount > 0) {
            $notifications[] = [
                'level' => 'success',
                'title' => $readyCount . ' commande(s) prête(s)',
                'message' => 'Ces dossiers peuvent être remis, expédiés ou affectés à un transporteur.',
                'route' => 'admin.logistics.index',
                'parameters' => ['status' => 'ready'],
            ];
        }

        $lateCount = ShopOrderRequest::whereIn('status', ['confirmee', 'traitee'])
                ->whereNotIn('preparation_status', ['delivered', 'cancelled'])
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '<', now())
                ->count()
            + ProReservationRequest::whereIn('status', ['confirmee', 'traitee'])
                ->whereNotIn('preparation_status', ['delivered', 'cancelled'])
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '<', now())
                ->count();

        if ($lateCount > 0) {
            $notifications[] = [
                'level' => 'critical',
                'title' => $lateCount . ' échéance(s) logistique(s) dépassée(s)',
                'message' => 'La date prévue est passée alors que la remise ou la livraison n’est pas terminée.',
                'route' => 'admin.logistics.index',
            ];
        }

        if ($counts['low_stock'] > 0) {
            $notifications[] = [
                'level' => 'warning',
                'title' => $counts['low_stock'] . ' produit(s) en stock faible',
                'message' => 'Vérifiez les quantités ou masquez les produits devenus indisponibles.',
                'route' => 'admin.products.index',
            ];
        }

        if (! $batch) {
            $notifications[] = [
                'level' => 'warning',
                'title' => 'Aucun animal actif',
                'message' => 'La réserve professionnelle ne dispose actuellement d’aucun animal publié.',
                'route' => 'admin.animals.index',
            ];
        } elseif ($batch['progress'] >= 100) {
            $notifications[] = [
                'level' => 'critical',
                'title' => 'Réserve complète à 100 %',
                'message' => 'Le seuil est dépassé. La découpe ou la clôture doit être organisée.',
                'route' => 'admin.animals.show',
                'parameters' => [$batch['batch']],
            ];
        } elseif ($batch['threshold_reached']) {
            $notifications[] = [
                'level' => 'success',
                'title' => 'Seuil de lancement atteint : ' . $batch['progress'] . ' %',
                'message' => 'La réserve a atteint le seuil fixé à ' . $batch['batch']->launch_threshold_percent . ' %. Vous pouvez préparer la découpe.',
                'route' => 'admin.animals.show',
                'parameters' => [$batch['batch']],
            ];
        }

        return $notifications;
    }

    public function latestActivity(int $limit = 10): Collection
    {
        $shop = ShopOrderRequest::latest()->take($limit)->get()->map(fn ($item) => [
            'type' => 'Boutique',
            'title' => $item->fullname,
            'reference' => $item->reference,
            'status' => $item->status,
            'amount' => (float) $item->total,
            'created_at' => $item->created_at,
        ]);

        $pro = ProReservationRequest::latest()->take($limit)->get()->map(fn ($item) => [
            'type' => 'Professionnel',
            'title' => $item->company,
            'reference' => $item->reference,
            'status' => $item->status,
            'amount' => (float) $item->total_ht,
            'created_at' => $item->created_at,
        ]);

        $contacts = ContactMessage::latest()->take($limit)->get()->map(fn ($item) => [
            'type' => 'Contact',
            'title' => $item->fullname,
            'reference' => $item->reference,
            'status' => $item->status,
            'amount' => null,
            'created_at' => $item->created_at,
        ]);

        return $shop
            ->concat($pro)
            ->concat($contacts)
            ->sortByDesc('created_at')
            ->take($limit)
            ->values();
    }

    public function requestedQuantities(AnimalBatch $batch): array
    {
        $totals = [];

        ProReservationRequest::query()
            ->where('bovin_reference', $batch->reference)
            ->where('status', '!=', 'annulee')
            ->get(['cart'])
            ->each(function ($request) use (&$totals) {
                foreach ($request->cart ?? [] as $item) {
                    $key = $item['key'] ?? null;
                    if (! $key) {
                        continue;
                    }

                    $totals[$key] = ($totals[$key] ?? 0) + (float) ($item['quantity'] ?? 0);
                }
            });

        return $totals;
    }
}

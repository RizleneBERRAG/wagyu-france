<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LogisticsStatusMail;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLogisticsController extends Controller
{
    public const STATUSES = [
        'pending' => 'À préparer',
        'preparing' => 'En préparation',
        'ready' => 'Prête',
        'dispatched' => 'Expédiée / remise',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
    ];

    public const DELIVERY_METHODS = [
        'pickup' => 'Retrait à la ferme',
        'local_delivery' => 'Livraison directe',
        'refrigerated_carrier' => 'Transporteur frigorifique',
        'other' => 'Autre organisation',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $kind = (string) $request->query('kind', 'all');
        $status = (string) $request->query('status');

        $shop = $this->shopQuery($search, $status)->get()->map(fn ($model) => [
            'kind' => 'shop',
            'model' => $model,
        ]);

        $pro = $this->proQuery($search, $status)->get()->map(fn ($model) => [
            'kind' => 'pro',
            'model' => $model,
        ]);

        $items = collect()
            ->when(in_array($kind, ['all', 'shop'], true), fn ($collection) => $collection->concat($shop))
            ->when(in_array($kind, ['all', 'pro'], true), fn ($collection) => $collection->concat($pro))
            ->sortBy(function ($item) {
                return $item['model']->scheduled_at?->timestamp
                    ?? $item['model']->created_at?->timestamp
                    ?? PHP_INT_MAX;
            })
            ->values();

        $grouped = collect(array_keys(self::STATUSES))->mapWithKeys(
            fn ($key) => [$key => $items->filter(fn ($item) => ($item['model']->preparation_status ?: 'pending') === $key)->values()]
        );

        return view('admin.logistics.index', [
            'grouped' => $grouped,
            'statuses' => self::STATUSES,
            'deliveryMethods' => self::DELIVERY_METHODS,
            'kind' => $kind,
            'status' => $status,
            'counts' => $this->counts(),
        ]);
    }

    public function updateShop(Request $request, ShopOrderRequest $shopOrderRequest): RedirectResponse
    {
        return $this->updateLogistics($request, $shopOrderRequest);
    }

    public function updatePro(Request $request, ProReservationRequest $proReservationRequest): RedirectResponse
    {
        return $this->updateLogistics($request, $proReservationRequest);
    }

    private function updateLogistics(Request $request, Model $documentable): RedirectResponse
    {
        $validated = $request->validate([
            'preparation_status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'delivery_method' => ['nullable', Rule::in(array_keys(self::DELIVERY_METHODS))],
            'scheduled_at' => ['nullable', 'date'],
            'carrier' => ['nullable', 'string', 'max:190'],
            'tracking_number' => ['nullable', 'string', 'max:190'],
            'logistics_notes' => ['nullable', 'string', 'max:3000'],
        ]);

        if (! in_array($documentable->status, ['confirmee', 'traitee'], true)
            && ($validated['preparation_status'] ?? 'pending') !== 'cancelled') {
            return back()->withErrors([
                'logistics' => 'Le dossier doit être confirmé ou traité avant d’entrer en préparation.',
            ]);
        }

        $oldStatus = $documentable->preparation_status ?: 'pending';
        $data = $this->normalizeTimeline($validated, $documentable);
        $documentable->update($data);

        if ($oldStatus !== $data['preparation_status']) {
            $this->notifyClient($documentable->fresh());
        }

        return back()->with('success', 'Le suivi logistique de ' . $documentable->reference . ' a été mis à jour.');
    }

    private function normalizeTimeline(array $data, Model $documentable): array
    {
        $status = $data['preparation_status'];

        if ($status === 'pending') {
            $data['prepared_at'] = null;
            $data['dispatched_at'] = null;
            $data['delivered_at'] = null;
        }

        if ($status === 'preparing') {
            $data['prepared_at'] = null;
            $data['dispatched_at'] = null;
            $data['delivered_at'] = null;
        }

        if ($status === 'ready') {
            $data['prepared_at'] = $documentable->prepared_at ?: now();
            $data['dispatched_at'] = null;
            $data['delivered_at'] = null;
        }

        if ($status === 'dispatched') {
            $data['prepared_at'] = $documentable->prepared_at ?: now();
            $data['dispatched_at'] = $documentable->dispatched_at ?: now();
            $data['delivered_at'] = null;
        }

        if ($status === 'delivered') {
            $data['prepared_at'] = $documentable->prepared_at ?: now();
            $data['dispatched_at'] = $documentable->dispatched_at ?: now();
            $data['delivered_at'] = $documentable->delivered_at ?: now();
        }

        return $data;
    }

    private function notifyClient(Model $documentable): void
    {
        if (blank($documentable->email)) {
            return;
        }

        try {
            Mail::to($documentable->email)->send(new LogisticsStatusMail(
                $documentable->reference,
                self::STATUSES[$documentable->preparation_status] ?? $documentable->preparation_status,
                $documentable->scheduled_at?->format('d/m/Y à H:i'),
                self::DELIVERY_METHODS[$documentable->delivery_method] ?? null,
                $documentable->carrier,
                $documentable->tracking_number,
                $documentable->logistics_notes
            ));
        } catch (\Throwable $exception) {
            Log::warning('Erreur envoi email logistique Wagyu France', [
                'reference' => $documentable->reference,
                'email' => $documentable->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function shopQuery(string $search, string $status): Builder
    {
        return ShopOrderRequest::query()
            ->where(function ($query) {
                $query->whereIn('status', ['confirmee', 'traitee'])
                    ->orWhere('preparation_status', '!=', 'pending');
            })
            ->when($status, fn ($query) => $query->where('preparation_status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('tracking_number', 'like', "%{$search}%");
                });
            });
    }

    private function proQuery(string $search, string $status): Builder
    {
        return ProReservationRequest::query()
            ->where(function ($query) {
                $query->whereIn('status', ['confirmee', 'traitee'])
                    ->orWhere('preparation_status', '!=', 'pending');
            })
            ->when($status, fn ($query) => $query->where('preparation_status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhere('bovin_reference', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('tracking_number', 'like', "%{$search}%");
                });
            });
    }

    private function counts(): array
    {
        $shopBase = ShopOrderRequest::query()->whereIn('status', ['confirmee', 'traitee']);
        $proBase = ProReservationRequest::query()->whereIn('status', ['confirmee', 'traitee']);

        $count = function (string $status) use ($shopBase, $proBase): int {
            return (clone $shopBase)->where('preparation_status', $status)->count()
                + (clone $proBase)->where('preparation_status', $status)->count();
        };

        return [
            'pending' => $count('pending'),
            'preparing' => $count('preparing'),
            'ready' => $count('ready'),
            'dispatched' => $count('dispatched'),
            'delivered' => $count('delivered'),
        ];
    }
}

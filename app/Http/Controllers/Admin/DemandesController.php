<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RequestStatusMail;
use App\Models\ContactMessage;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Services\AdminDashboardService;
use App\Services\ShopStockService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DemandesController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $status = (string) $request->query('status');
        $section = (string) $request->query('section', 'all');

        $shopOrders = ShopOrderRequest::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $proRequests = ProReservationRequest::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhere('bovin_reference', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $contactMessages = ContactMessage::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.demandes', [
            'shopOrders' => $shopOrders,
            'proRequests' => $proRequests,
            'contactMessages' => $contactMessages,
            'statuses' => $this->statuses(),
            'section' => $section,
            'counts' => [
                'shop' => ShopOrderRequest::count(),
                'pro' => ProReservationRequest::count(),
                'contact' => ContactMessage::count(),
                'new' => ShopOrderRequest::where('status', 'nouvelle')->count()
                    + ProReservationRequest::where('status', 'nouvelle')->count()
                    + ContactMessage::where('status', 'nouvelle')->count(),
            ],
        ]);
    }

    public function updateShopStatus(
        Request $request,
        ShopOrderRequest $shopOrderRequest,
        ShopStockService $stockService
    ): RedirectResponse {
        $newStatus = $this->validatedStatus($request);
        $oldStatus = $shopOrderRequest->status;

        if (in_array($newStatus, ['confirmee', 'traitee'], true)) {
            $stockService->apply($shopOrderRequest);
        } elseif ($newStatus === 'annulee') {
            $stockService->release($shopOrderRequest);
        }

        $shopOrderRequest->update(['status' => $newStatus]);
        $this->notifyStatus('shop', $shopOrderRequest, $oldStatus, $newStatus);

        $stockMessage = $shopOrderRequest->fresh()->stock_applied_at
            ? ' Le stock correspondant est réservé.'
            : ($newStatus === 'annulee' ? ' Le stock éventuellement réservé a été restauré.' : '');

        return back()->with('success', 'Statut boutique mis à jour.' . $stockMessage);
    }

    public function updateProStatus(
        Request $request,
        ProReservationRequest $proReservationRequest,
        AdminDashboardService $dashboard
    ): RedirectResponse {
        $newStatus = $this->validatedStatus($request);
        $oldStatus = $proReservationRequest->status;

        $proReservationRequest->update(['status' => $newStatus]);

        $summary = $dashboard->activeBatchSummary();
        if ($summary && $summary['batch']->reference === $proReservationRequest->bovin_reference) {
            $batch = $summary['batch'];

            if ($summary['threshold_reached'] && $batch->status === 'open') {
                $batch->update(['status' => 'ready']);
            } elseif (! $summary['threshold_reached'] && $batch->status === 'ready') {
                $batch->update(['status' => 'open']);
            }
        }

        $this->notifyStatus('pro', $proReservationRequest, $oldStatus, $newStatus);

        return back()->with('success', 'Statut professionnel mis à jour. La progression et le seuil de l’animal ont été recalculés.');
    }

    public function updateContactStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $newStatus = $this->validatedStatus($request);
        $oldStatus = $contactMessage->status;

        $contactMessage->update(['status' => $newStatus]);
        $this->notifyStatus('contact', $contactMessage, $oldStatus, $newStatus);

        return back()->with('success', 'Statut du message de contact mis à jour.');
    }

    public function export(string $section): StreamedResponse
    {
        abort_unless(in_array($section, ['shop', 'pro', 'contacts'], true), 404);

        $filename = 'wagyu-france-' . $section . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($section) {
            $handle = fopen('php://output', 'wb');
            fwrite($handle, "\xEF\xBB\xBF");

            if ($section === 'shop') {
                fputcsv($handle, ['Référence', 'Statut', 'Date', 'Client', 'Email', 'Téléphone', 'Ville', 'Pièces', 'Total estimatif', 'Stock réservé'], ';');

                ShopOrderRequest::latest()->chunk(200, function ($orders) use ($handle) {
                    foreach ($orders as $order) {
                        fputcsv($handle, [
                            $this->csvValue($order->reference),
                            $this->csvValue($this->statuses()[$order->status] ?? $order->status),
                            $order->created_at?->format('d/m/Y H:i'),
                            $this->csvValue($order->fullname),
                            $this->csvValue($order->email),
                            $this->csvValue($order->phone),
                            $this->csvValue($order->city),
                            $this->csvValue($this->cartSummary($order->cart, 'unit_price')),
                            number_format((float) $order->total, 2, ',', ' '),
                            $order->stock_applied_at ? 'Oui' : 'Non',
                        ], ';');
                    }
                });
            }

            if ($section === 'pro') {
                fputcsv($handle, ['Référence', 'Animal', 'Statut', 'Date', 'Établissement', 'Contact', 'Email', 'Téléphone', 'Type', 'Ville', 'Pièces', 'Total HT'], ';');

                ProReservationRequest::latest()->chunk(200, function ($requests) use ($handle) {
                    foreach ($requests as $item) {
                        fputcsv($handle, [
                            $this->csvValue($item->reference),
                            $this->csvValue($item->bovin_reference),
                            $this->csvValue($this->statuses()[$item->status] ?? $item->status),
                            $item->created_at?->format('d/m/Y H:i'),
                            $this->csvValue($item->company),
                            $this->csvValue($item->fullname),
                            $this->csvValue($item->email),
                            $this->csvValue($item->phone),
                            $this->csvValue($item->professional_type),
                            $this->csvValue($item->city),
                            $this->csvValue($this->cartSummary($item->cart, 'unit_price_ht')),
                            number_format((float) $item->total_ht, 2, ',', ' '),
                        ], ';');
                    }
                });
            }

            if ($section === 'contacts') {
                fputcsv($handle, ['Référence', 'Statut', 'Date', 'Profil', 'Nom', 'Email', 'Téléphone', 'Société', 'Ville', 'Objet', 'Message', 'Réponse souhaitée'], ';');

                ContactMessage::latest()->chunk(200, function ($messages) use ($handle) {
                    foreach ($messages as $message) {
                        fputcsv($handle, [
                            $this->csvValue($message->reference),
                            $this->csvValue($this->statuses()[$message->status] ?? $message->status),
                            $message->created_at?->format('d/m/Y H:i'),
                            $this->csvValue($message->audience),
                            $this->csvValue($message->fullname),
                            $this->csvValue($message->email),
                            $this->csvValue($message->phone),
                            $this->csvValue($message->company),
                            $this->csvValue($message->city),
                            $this->csvValue($message->subject),
                            $this->csvValue($message->message),
                            $this->csvValue($message->preferred_contact),
                        ], ';');
                    }
                });
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function notifyStatus(string $kind, Model $requestItem, string $oldStatus, string $newStatus): void
    {
        if ($oldStatus === $newStatus || $newStatus === 'nouvelle' || blank($requestItem->email)) {
            return;
        }

        try {
            Mail::to($requestItem->email)->send(new RequestStatusMail(
                $kind,
                $requestItem,
                $this->statuses()[$newStatus] ?? ucfirst(str_replace('_', ' ', $newStatus))
            ));
        } catch (\Throwable $exception) {
            Log::warning('Erreur envoi email de statut Wagyu France', [
                'kind' => $kind,
                'reference' => $requestItem->reference,
                'status' => $newStatus,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function cartSummary(?array $cart, string $priceKey): string
    {
        return collect($cart ?? [])->map(function ($item) use ($priceKey) {
            $name = $item['name'] ?? 'Produit';
            $quantity = number_format((float) ($item['quantity'] ?? 0), 1, ',', ' ');
            $price = number_format((float) ($item[$priceKey] ?? 0), 2, ',', ' ');

            return "{$name} : {$quantity} kg à {$price} €/kg";
        })->implode(' | ');
    }

    private function csvValue(mixed $value): string
    {
        $value = trim((string) ($value ?? ''));

        return preg_match('/^[=+\-@]/', $value) ? "'" . $value : $value;
    }

    private function validatedStatus(Request $request): string
    {
        return $request->validate([
            'status' => ['required', 'string', 'in:nouvelle,en_cours,confirmee,traitee,annulee'],
        ])['status'];
    }

    private function statuses(): array
    {
        return [
            'nouvelle' => 'Nouvelle',
            'en_cours' => 'En cours',
            'confirmee' => 'Confirmée',
            'traitee' => 'Traitée',
            'annulee' => 'Annulée',
        ];
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function updateShopStatus(Request $request, ShopOrderRequest $shopOrderRequest): RedirectResponse
    {
        $shopOrderRequest->update(['status' => $this->validatedStatus($request)]);

        return back()->with('success', 'Statut boutique mis à jour.');
    }

    public function updateProStatus(Request $request, ProReservationRequest $proReservationRequest): RedirectResponse
    {
        $proReservationRequest->update(['status' => $this->validatedStatus($request)]);

        return back()->with('success', 'Statut professionnel mis à jour.');
    }

    public function updateContactStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['status' => $this->validatedStatus($request)]);

        return back()->with('success', 'Statut du message de contact mis à jour.');
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

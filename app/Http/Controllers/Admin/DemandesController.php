<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DemandesController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (session('wf_admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        $shopOrders = ShopOrderRequest::latest()->get();
        $proRequests = ProReservationRequest::latest()->get();

        return view('admin.demandes', [
            'shopOrders' => $shopOrders,
            'proRequests' => $proRequests,
            'statuses' => $this->statuses(),
        ]);
    }

    public function updateShopStatus(Request $request, ShopOrderRequest $shopOrderRequest): RedirectResponse
    {
        if (session('wf_admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:nouvelle,en_cours,confirmee,traitee,annulee'],
        ]);

        $shopOrderRequest->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Statut boutique mis à jour.');
    }

    public function updateProStatus(Request $request, ProReservationRequest $proReservationRequest): RedirectResponse
    {
        if (session('wf_admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:nouvelle,en_cours,confirmee,traitee,annulee'],
        ]);

        $proReservationRequest->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Statut professionnel mis à jour.');
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

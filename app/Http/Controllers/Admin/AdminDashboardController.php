<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (session('wf_admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        $shopOrders = ShopOrderRequest::latest()->take(5)->get();
        $proRequests = ProReservationRequest::latest()->take(5)->get();

        return view('admin.dashboard', [
            'shopOrders' => $shopOrders,
            'proRequests' => $proRequests,
            'shopCount' => ShopOrderRequest::count(),
            'proCount' => ProReservationRequest::count(),
            'newShopCount' => ShopOrderRequest::where('status', 'nouvelle')->count(),
            'newProCount' => ProReservationRequest::where('status', 'nouvelle')->count(),
        ]);
    }
}

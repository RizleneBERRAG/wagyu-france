<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Models\ShopProduct;
use App\Services\AdminDashboardService;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(AdminDashboardService $dashboard): View
    {
        $activeBatch = $dashboard->activeBatchSummary();

        return view('admin.dashboard', [
            'shopCount' => ShopOrderRequest::count(),
            'proCount' => ProReservationRequest::count(),
            'contactCount' => ContactMessage::count(),
            'newCount' => ShopOrderRequest::where('status', 'nouvelle')->count()
                + ProReservationRequest::where('status', 'nouvelle')->count()
                + ContactMessage::where('status', 'nouvelle')->count(),
            'turnoverEstimate' => (float) ShopOrderRequest::whereNotIn('status', ['annulee'])->sum('total'),
            'productCount' => ShopProduct::count(),
            'activeProductCount' => ShopProduct::where('is_active', true)->count(),
            'lowStockCount' => ShopProduct::where('is_active', true)
                ->whereColumn('stock_kg', '<=', 'low_stock_threshold')
                ->count(),
            'activeBatch' => $activeBatch,
            'notifications' => $dashboard->notifications(),
            'latestActivity' => $dashboard->latestActivity(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Models\ShopProduct;
use App\Services\AdminDashboardService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(AdminDashboardService $dashboard): View
    {
        $user = auth()->user();
        $canOrders = $user->canAccess('orders.manage');
        $canProducts = $user->canAccess('products.manage');
        $canAnimals = $user->canAccess('animals.manage');
        $canCustomers = $user->canAccess('customers.manage');
        $canBilling = $user->canAccess('billing.manage');
        $canLogistics = $user->canAccess('logistics.manage');
        $canSettings = $user->canAccess('settings.manage');

        $shopCount = $canOrders ? ShopOrderRequest::count() : 0;
        $proCount = $canOrders ? ProReservationRequest::count() : 0;
        $contactCount = $canOrders ? ContactMessage::count() : 0;

        return view('admin.dashboard', [
            'shopCount' => $shopCount,
            'proCount' => $proCount,
            'contactCount' => $contactCount,
            'newCount' => $canOrders
                ? ShopOrderRequest::where('status', 'nouvelle')->count()
                    + ProReservationRequest::where('status', 'nouvelle')->count()
                    + ContactMessage::where('status', 'nouvelle')->count()
                : 0,
            'turnoverEstimate' => $canOrders
                ? (float) ShopOrderRequest::whereNotIn('status', ['annulee'])->sum('total')
                : 0,
            'productCount' => $canProducts ? ShopProduct::count() : 0,
            'activeProductCount' => $canProducts ? ShopProduct::where('is_active', true)->count() : 0,
            'lowStockCount' => $canProducts
                ? ShopProduct::where('is_active', true)->whereColumn('stock_kg', '<=', 'low_stock_threshold')->count()
                : 0,
            'activeBatch' => $canAnimals ? $dashboard->activeBatchSummary() : null,
            'notifications' => $this->allowedNotifications($dashboard->notifications()),
            'latestActivity' => $canOrders ? $dashboard->latestActivity() : collect(),
            'dashboardPermissions' => [
                'orders' => $canOrders,
                'products' => $canProducts,
                'animals' => $canAnimals,
                'customers' => $canCustomers,
                'billing' => $canBilling,
                'logistics' => $canLogistics,
                'settings' => $canSettings,
            ],
        ]);
    }

    private function allowedNotifications(array $notifications): array
    {
        $user = auth()->user();

        return collect($notifications)
            ->filter(function (array $notification) use ($user) {
                $permission = match (true) {
                    str_starts_with($notification['route'], 'admin.products') => 'products.manage',
                    str_starts_with($notification['route'], 'admin.animals') => 'animals.manage',
                    str_starts_with($notification['route'], 'admin.customers') => 'customers.manage',
                    str_starts_with($notification['route'], 'admin.billing') => 'billing.manage',
                    str_starts_with($notification['route'], 'admin.logistics') => 'logistics.manage',
                    str_starts_with($notification['route'], 'admin.settings') => 'settings.manage',
                    str_starts_with($notification['route'], 'admin.demandes') => 'orders.manage',
                    default => 'dashboard.view',
                };

                return $user->canAccess($permission);
            })
            ->values()
            ->all();
    }
}

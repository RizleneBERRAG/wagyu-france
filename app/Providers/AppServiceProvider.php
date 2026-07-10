<?php

namespace App\Providers;

use App\Services\AdminDashboardService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AdminDashboardService::class);
    }

    public function boot(AdminDashboardService $dashboard): void
    {
        View::composer('layouts.admin', function ($view) use ($dashboard) {
            $view->with('adminNavigationCounts', $dashboard->navigationCounts());
        });
    }
}

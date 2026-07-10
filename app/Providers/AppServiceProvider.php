<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Services\AdminDashboardService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AdminDashboardService::class);
    }

    public function boot(AdminDashboardService $dashboard): void
    {
        try {
            if (Schema::hasTable('site_settings')) {
                $settings = SiteSetting::query()->pluck('value', 'key')->all();
                $value = static function (string $key, mixed $default = null) use ($settings): mixed {
                    $setting = $settings[$key] ?? null;

                    return filled($setting) ? $setting : $default;
                };

                config([
                    'app.name' => $value('brand_name', config('app.name')),
                    'wagyu.contact_email' => $value('contact_email', config('mail.from.address')),
                    'wagyu.contact_phone' => $value('contact_phone'),
                    'wagyu.reply_delay' => $value('reply_delay', 'Sous 2 jours ouvrés'),
                    'wagyu.order_email' => $value('order_notification_email', config('mail.from.address')),
                    'wagyu.pro_email' => $value('pro_notification_email', config('mail.from.address')),
                    'wagyu.contact_notification_email' => $value('contact_notification_email', config('mail.from.address')),
                    'wagyu.delivery_area' => $value('delivery_area'),
                    'wagyu.withdrawal_address' => $value('withdrawal_address'),
                    'wagyu.preparation_delay' => $value('preparation_delay'),

                    'legal.brand_name' => $value('brand_name', config('legal.brand_name')),
                    'legal.company.legal_name' => $value('legal_company_name', config('legal.company.legal_name')),
                    'legal.company.legal_form' => $value('legal_company_form', config('legal.company.legal_form')),
                    'legal.company.address' => $value('legal_company_address', config('legal.company.address')),
                    'legal.company.siret' => $value('legal_company_siret', config('legal.company.siret')),
                    'legal.company.email' => $value('contact_email', config('legal.company.email')),
                    'legal.company.phone' => $value('contact_phone', config('legal.company.phone')),
                    'legal.company.publication_director' => $value('legal_publication_director', config('legal.company.publication_director')),
                    'legal.hosting.name' => $value('legal_host_name', config('legal.hosting.name')),
                    'legal.hosting.address' => $value('legal_host_address', config('legal.hosting.address')),
                    'legal.hosting.phone' => $value('legal_host_phone', config('legal.hosting.phone')),
                    'legal.mediator.name' => $value('legal_mediator_name', config('legal.mediator.name')),
                    'legal.mediator.address' => $value('legal_mediator_address', config('legal.mediator.address')),
                    'legal.mediator.website' => $value('legal_mediator_website', config('legal.mediator.website')),
                    'legal.sales.delivery_area' => $value('delivery_area', config('legal.sales.delivery_area')),
                    'legal.sales.withdrawal_address' => $value('withdrawal_address', config('legal.sales.withdrawal_address')),
                    'legal.sales.complaints_email' => $value('contact_email', config('legal.sales.complaints_email')),
                    'legal.privacy.contact_email' => $value('contact_email', config('legal.privacy.contact_email')),
                ]);

                View::share('siteSettings', $settings);
            }
        } catch (Throwable) {
            // Le projet doit continuer à démarrer avant l'exécution des migrations.
        }

        View::composer('layouts.admin', function ($view) use ($dashboard) {
            $view->with('adminNavigationCounts', $dashboard->navigationCounts());
        });
    }
}
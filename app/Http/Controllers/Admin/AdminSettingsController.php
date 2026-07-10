<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => SiteSetting::query()->pluck('value', 'key'),
            'mailReady' => config('mail.default') !== 'log' && filled(config('mail.from.address')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['nullable', 'email', 'max:190'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'reply_delay' => ['nullable', 'string', 'max:120'],

            'order_notification_email' => ['nullable', 'email', 'max:190'],
            'pro_notification_email' => ['nullable', 'email', 'max:190'],
            'contact_notification_email' => ['nullable', 'email', 'max:190'],

            'delivery_area' => ['nullable', 'string', 'max:1000'],
            'withdrawal_address' => ['nullable', 'string', 'max:1000'],
            'preparation_delay' => ['nullable', 'string', 'max:1000'],

            'invoice_prefix' => ['required', 'alpha_dash', 'max:20'],
            'credit_prefix' => ['required', 'alpha_dash', 'max:20'],
            'default_vat_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'invoice_payment_terms' => ['nullable', 'string', 'max:2000'],
            'invoice_bank_details' => ['nullable', 'string', 'max:2000'],
            'invoice_footer' => ['nullable', 'string', 'max:1000'],

            'legal_company_name' => ['nullable', 'string', 'max:190'],
            'legal_company_form' => ['nullable', 'string', 'max:120'],
            'legal_company_address' => ['nullable', 'string', 'max:1000'],
            'legal_company_siret' => ['nullable', 'string', 'max:40'],
            'legal_vat_number' => ['nullable', 'string', 'max:40'],
            'legal_publication_director' => ['nullable', 'string', 'max:190'],
            'legal_host_name' => ['nullable', 'string', 'max:190'],
            'legal_host_address' => ['nullable', 'string', 'max:1000'],
            'legal_host_phone' => ['nullable', 'string', 'max:40'],
            'legal_mediator_name' => ['nullable', 'string', 'max:190'],
            'legal_mediator_address' => ['nullable', 'string', 'max:1000'],
            'legal_mediator_website' => ['nullable', 'url', 'max:500'],
        ]);

        SiteSetting::putMany($validated);

        return back()->with('success', 'Les paramètres du site et des documents ont été enregistrés.');
    }
}

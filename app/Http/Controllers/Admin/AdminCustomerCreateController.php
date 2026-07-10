<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCustomerCreateController extends Controller
{
    public function create(): View
    {
        return view('admin.customers.create', [
            'types' => AdminCustomerController::TYPES,
            'statuses' => AdminCustomerController::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(array_keys(AdminCustomerController::TYPES))],
            'relationship_status' => ['required', Rule::in(array_keys(AdminCustomerController::STATUSES))],
            'company' => ['nullable', 'string', 'max:190'],
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:120'],
            'professional_type' => ['nullable', 'string', 'max:120'],
            'preferred_contact' => ['nullable', Rule::in(['email', 'telephone'])],
            'tags' => ['nullable', 'string', 'max:1000'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
            'next_follow_up_at' => ['nullable', 'date'],
            'marketing_opt_in' => ['nullable', 'boolean'],
        ]);

        $email = trim($validated['email']);
        $emailKey = mb_strtolower($email);

        if (Customer::where('email_key', $emailKey)->exists()) {
            return back()->withInput()->withErrors([
                'email' => 'Une fiche client existe déjà pour cette adresse email.',
            ]);
        }

        $tags = collect(explode(',', (string) ($validated['tags'] ?? '')))
            ->map(fn ($tag) => mb_strtolower(trim($tag)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $customer = Customer::create([
            'type' => $validated['type'],
            'relationship_status' => $validated['relationship_status'],
            'company' => $validated['company'] ?? null,
            'fullname' => $validated['fullname'],
            'email' => $email,
            'email_key' => $emailKey,
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'professional_type' => $validated['professional_type'] ?? null,
            'preferred_contact' => $validated['preferred_contact'] ?? null,
            'tags' => $tags,
            'internal_notes' => $validated['internal_notes'] ?? null,
            'next_follow_up_at' => $validated['next_follow_up_at'] ?? null,
            'marketing_opt_in' => $request->boolean('marketing_opt_in'),
            'first_contact_at' => now(),
            'last_activity_at' => now(),
        ]);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'La nouvelle fiche CRM a été créée.');
    }
}

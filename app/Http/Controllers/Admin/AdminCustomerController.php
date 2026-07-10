<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerInteraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCustomerController extends Controller
{
    public const TYPES = [
        'individual' => 'Particulier',
        'professional' => 'Professionnel',
        'partner' => 'Partenaire',
    ];

    public const STATUSES = [
        'prospect' => 'Prospect',
        'active' => 'Client actif',
        'vip' => 'Client VIP',
        'dormant' => 'À réactiver',
        'blocked' => 'Bloqué',
    ];

    public const INTERACTION_TYPES = [
        'note' => 'Note interne',
        'call' => 'Appel',
        'email' => 'Email',
        'meeting' => 'Rendez-vous',
        'follow_up' => 'Relance',
    ];

    public function index(Request $request): View
    {
        $query = Customer::query()
            ->with([
                'shopOrders.creditNotes',
                'proReservations.creditNotes',
            ])
            ->withCount(['shopOrders', 'proReservations', 'contactMessages']);

        $search = trim((string) $request->query('q'));
        $type = (string) $request->query('type');
        $status = (string) $request->query('status');
        $segment = (string) $request->query('segment');

        $query
            ->when($search, function ($builder) use ($search) {
                $builder->where(function ($subQuery) use ($search) {
                    $subQuery->where('fullname', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('professional_type', 'like', "%{$search}%");
                });
            })
            ->when(array_key_exists($type, self::TYPES), fn ($builder) => $builder->where('type', $type))
            ->when(array_key_exists($status, self::STATUSES), fn ($builder) => $builder->where('relationship_status', $status))
            ->when($segment === 'follow_up', fn ($builder) => $builder->whereNotNull('next_follow_up_at')->where('next_follow_up_at', '<=', now()))
            ->when($segment === 'inactive', fn ($builder) => $builder->where(function ($subQuery) {
                $subQuery->whereNull('last_activity_at')->orWhere('last_activity_at', '<=', now()->subMonths(6));
            }));

        $paginator = $query
            ->orderByRaw('CASE WHEN next_follow_up_at IS NOT NULL AND next_follow_up_at <= ? THEN 0 ELSE 1 END', [now()])
            ->orderByDesc('last_activity_at')
            ->orderBy('fullname')
            ->paginate(24)
            ->withQueryString();

        $paginator->setCollection(
            $paginator->getCollection()->map(fn (Customer $customer) => $this->customerSummary($customer))
        );

        return view('admin.customers.index', [
            'customers' => $paginator,
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
            'counts' => [
                'total' => Customer::count(),
                'professional' => Customer::where('type', 'professional')->count(),
                'active' => Customer::whereIn('relationship_status', ['active', 'vip'])->count(),
                'prospect' => Customer::where('relationship_status', 'prospect')->count(),
                'follow_up' => Customer::whereNotNull('next_follow_up_at')->where('next_follow_up_at', '<=', now())->count(),
            ],
        ]);
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'shopOrders.creditNotes',
            'proReservations.creditNotes',
            'contactMessages',
            'interactions',
        ]);

        $summary = $this->customerSummary($customer);

        return view('admin.customers.show', [
            'customer' => $customer,
            'summary' => $summary,
            'timeline' => $this->timeline($customer),
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
            'interactionTypes' => self::INTERACTION_TYPES,
        ]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(array_keys(self::TYPES))],
            'relationship_status' => ['required', Rule::in(array_keys(self::STATUSES))],
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

        $emailKey = mb_strtolower(trim($validated['email']));
        $duplicate = Customer::where('email_key', $emailKey)->whereKeyNot($customer->getKey())->exists();

        if ($duplicate) {
            return back()->withInput()->withErrors([
                'email' => 'Cette adresse email appartient déjà à une autre fiche client.',
            ]);
        }

        $tags = collect(explode(',', (string) ($validated['tags'] ?? '')))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->map(fn ($tag) => mb_strtolower($tag))
            ->unique()
            ->values()
            ->all();

        $customer->update([
            'type' => $validated['type'],
            'relationship_status' => $validated['relationship_status'],
            'company' => $validated['company'] ?? null,
            'fullname' => $validated['fullname'],
            'email' => trim($validated['email']),
            'email_key' => $emailKey,
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'professional_type' => $validated['professional_type'] ?? null,
            'preferred_contact' => $validated['preferred_contact'] ?? null,
            'tags' => $tags,
            'internal_notes' => $validated['internal_notes'] ?? null,
            'next_follow_up_at' => $validated['next_follow_up_at'] ?? null,
            'marketing_opt_in' => $request->boolean('marketing_opt_in'),
        ]);

        return back()->with('success', 'La fiche client a été mise à jour.');
    }

    public function addInteraction(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(array_keys(self::INTERACTION_TYPES))],
            'title' => ['nullable', 'string', 'max:190'],
            'body' => ['required', 'string', 'min:2', 'max:5000'],
            'happened_at' => ['nullable', 'date'],
            'due_at' => ['nullable', 'date'],
        ]);

        $interaction = $customer->interactions()->create([
            'type' => $validated['type'],
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'],
            'happened_at' => $validated['happened_at'] ?? now(),
            'due_at' => $validated['due_at'] ?? null,
        ]);

        $updates = ['last_activity_at' => now()];
        if (in_array($interaction->type, ['call', 'email', 'meeting'], true)) {
            $updates['last_contacted_at'] = $interaction->happened_at ?: now();
        }

        $customer->update($updates);
        $this->refreshNextFollowUp($customer);

        return back()->with('success', $interaction->due_at
            ? 'L’interaction et sa relance ont été ajoutées.'
            : 'L’interaction a été ajoutée à l’historique.');
    }

    public function completeInteraction(Customer $customer, CustomerInteraction $interaction): RedirectResponse
    {
        abort_unless($interaction->customer_id === $customer->id, 404);

        $interaction->update(['completed_at' => now()]);
        $this->refreshNextFollowUp($customer);

        return back()->with('success', 'La relance est marquée comme effectuée.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'wagyu-france-clients-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'wb');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Type', 'Statut', 'Société', 'Nom', 'Email', 'Téléphone', 'Ville',
                'Activités', 'Factures', 'CA net TTC', 'Dernière activité', 'Prochaine relance', 'Tags',
            ], ';');

            Customer::with(['shopOrders.creditNotes', 'proReservations.creditNotes'])
                ->orderBy('id')
                ->chunk(200, function ($customers) use ($handle) {
                    foreach ($customers as $customer) {
                        $summary = $this->customerSummary($customer);
                        fputcsv($handle, [
                            $customer->type_label,
                            $customer->relationship_label,
                            $this->csv($customer->company),
                            $this->csv($customer->fullname),
                            $this->csv($customer->email),
                            $this->csv($customer->phone),
                            $this->csv($customer->city),
                            $summary['activity_count'],
                            $summary['invoice_count'],
                            number_format($summary['revenue_ttc'], 2, ',', ' '),
                            $customer->last_activity_at?->format('d/m/Y H:i'),
                            $customer->next_follow_up_at?->format('d/m/Y H:i'),
                            $this->csv(implode(', ', $customer->tags ?? [])),
                        ], ';');
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function customerSummary(Customer $customer): array
    {
        $shopRevenue = $customer->shopOrders->sum(function ($order) {
            if (! $order->invoice_number) {
                return 0;
            }

            $invoice = (float) data_get($order->invoice_snapshot, 'amounts.total_ttc', $order->final_total_ttc ?? 0);
            $credits = (float) $order->creditNotes->sum('amount_ttc');

            return max(0, $invoice - $credits);
        });

        $proRevenue = $customer->proReservations->sum(function ($request) {
            if (! $request->invoice_number) {
                return 0;
            }

            $invoice = (float) data_get($request->invoice_snapshot, 'amounts.total_ttc', 0);
            $credits = (float) $request->creditNotes->sum('amount_ttc');

            return max(0, $invoice - $credits);
        });

        return [
            'model' => $customer,
            'revenue_ttc' => round($shopRevenue + $proRevenue, 2),
            'invoice_count' => $customer->shopOrders->whereNotNull('invoice_number')->count()
                + $customer->proReservations->whereNotNull('invoice_number')->count(),
            'activity_count' => $customer->shopOrders->count()
                + $customer->proReservations->count()
                + ($customer->contact_messages_count ?? $customer->contactMessages->count()),
            'shop_count' => $customer->shopOrders->count(),
            'pro_count' => $customer->proReservations->count(),
            'contact_count' => $customer->contact_messages_count ?? $customer->contactMessages->count(),
            'follow_up_due' => $customer->next_follow_up_at && $customer->next_follow_up_at->isPast(),
        ];
    }

    private function timeline(Customer $customer): Collection
    {
        $shop = $customer->shopOrders->map(fn ($order) => [
            'kind' => 'shop',
            'label' => 'Commande boutique',
            'title' => $order->reference,
            'description' => 'Statut : ' . str_replace('_', ' ', $order->status),
            'amount' => (float) ($order->final_total_ttc ?? $order->total),
            'date' => $order->created_at,
            'route' => route('admin.documents.shop.show', $order),
        ]);

        $pro = $customer->proReservations->map(fn ($request) => [
            'kind' => 'pro',
            'label' => 'Demande professionnelle',
            'title' => $request->reference,
            'description' => $request->bovin_reference . ' · ' . str_replace('_', ' ', $request->status),
            'amount' => (float) ($request->final_total_ht ?? $request->total_ht),
            'date' => $request->created_at,
            'route' => route('admin.documents.pro.show', $request),
        ]);

        $contacts = $customer->contactMessages->map(fn ($message) => [
            'kind' => 'contact',
            'label' => 'Message de contact',
            'title' => $message->subject,
            'description' => $message->reference . ' · ' . str_replace('_', ' ', $message->status),
            'amount' => null,
            'date' => $message->created_at,
            'route' => route('admin.demandes', ['section' => 'contacts', 'q' => $message->reference]),
        ]);

        $interactions = $customer->interactions->map(fn ($interaction) => [
            'kind' => 'interaction',
            'label' => $interaction->type_label,
            'title' => $interaction->title ?: $interaction->type_label,
            'description' => $interaction->body,
            'amount' => null,
            'date' => $interaction->happened_at ?: $interaction->created_at,
            'route' => null,
            'interaction' => $interaction,
        ]);

        return $shop->concat($pro)->concat($contacts)->concat($interactions)
            ->sortByDesc('date')
            ->values();
    }

    private function refreshNextFollowUp(Customer $customer): void
    {
        $nextDue = $customer->interactions()
            ->whereNull('completed_at')
            ->whereNotNull('due_at')
            ->min('due_at');

        $customer->update(['next_follow_up_at' => $nextDue]);
    }

    private function csv(mixed $value): string
    {
        $value = trim((string) ($value ?? ''));

        return preg_match('/^[=+\-@]/', $value) ? "'" . $value : $value;
    }
}

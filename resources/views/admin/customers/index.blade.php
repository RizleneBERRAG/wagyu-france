@extends('layouts.admin', [
    'title' => 'Clients & CRM — Wagyu France',
    'sectionLabel' => 'Relation commerciale',
    'pageHeading' => 'Clients & CRM',
    'bodyClass' => 'admin-customers-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-customers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-customer-create.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Fichier clients unifié</p>
            <h2>Chaque relation, chaque commande et chaque relance au même endroit.</h2>
            <p>
                Les contacts issus de la boutique, de la réserve professionnelle et du formulaire général
                sont automatiquement regroupés par adresse email.
            </p>
        </div>
        <div class="admin-crm-heading-actions">
            <a href="{{ route('admin.customers.create') }}" class="admin-primary-button">Ajouter un contact</a>
            <a href="{{ route('admin.customers.export') }}" class="admin-secondary-button">Exporter les clients</a>
        </div>
    </header>

    <section class="admin-stat-grid admin-crm-stats">
        <article class="admin-stat-card">
            <span>Fiches clients</span>
            <strong>{{ $counts['total'] }}</strong>
            <small>Toutes origines confondues.</small>
        </article>
        <article class="admin-stat-card">
            <span>Clients actifs</span>
            <strong>{{ $counts['active'] }}</strong>
            <small>Actifs et VIP.</small>
        </article>
        <article class="admin-stat-card">
            <span>Professionnels</span>
            <strong>{{ $counts['professional'] }}</strong>
            <small>Restaurants, boucheries, traiteurs…</small>
        </article>
        <article class="admin-stat-card {{ $counts['follow_up'] > 0 ? 'is-warning' : '' }}">
            <span>Relances dues</span>
            <strong>{{ $counts['follow_up'] }}</strong>
            <small>Échéances arrivées ou dépassées.</small>
        </article>
    </section>

    <nav class="admin-request-tabs admin-crm-tabs" aria-label="Segments clients">
        <a href="{{ route('admin.customers.index') }}" @class(['is-active' => !request()->hasAny(['status', 'segment'])])>
            Tous <b>{{ $counts['total'] }}</b>
        </a>
        <a href="{{ route('admin.customers.index', ['status' => 'prospect']) }}" @class(['is-active' => request('status') === 'prospect'])>
            Prospects <b>{{ $counts['prospect'] }}</b>
        </a>
        <a href="{{ route('admin.customers.index', ['status' => 'active']) }}" @class(['is-active' => request('status') === 'active'])>
            Actifs
        </a>
        <a href="{{ route('admin.customers.index', ['status' => 'vip']) }}" @class(['is-active' => request('status') === 'vip'])>
            VIP
        </a>
        <a href="{{ route('admin.customers.index', ['segment' => 'follow_up']) }}" @class(['is-active' => request('segment') === 'follow_up'])>
            À relancer <b>{{ $counts['follow_up'] }}</b>
        </a>
        <a href="{{ route('admin.customers.index', ['segment' => 'inactive']) }}" @class(['is-active' => request('segment') === 'inactive'])>
            Inactifs 6 mois
        </a>
    </nav>

    <div class="admin-toolbar admin-crm-toolbar">
        <form method="GET" action="{{ route('admin.customers.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Nom, société, email, téléphone, ville…">
            <select name="type">
                <option value="">Tous les profils</option>
                @foreach($types as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status">
                <option value="">Tous les statuts</option>
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-primary-button">Filtrer</button>
            @if(request()->hasAny(['q', 'type', 'status', 'segment']))
                <a href="{{ route('admin.customers.index') }}" class="admin-secondary-button">Réinitialiser</a>
            @endif
        </form>
    </div>

    <section class="admin-customer-grid">
        @forelse($customers as $entry)
            @php($customer = $entry['model'])
            <article class="admin-customer-card {{ $entry['follow_up_due'] ? 'has-follow-up' : '' }}">
                <header>
                    <div class="admin-customer-avatar">
                        {{ mb_strtoupper(mb_substr($customer->display_name, 0, 1)) }}
                    </div>
                    <div>
                        <p>{{ $customer->type_label }}</p>
                        <h3>{{ $customer->display_name }}</h3>
                        @if($customer->company && $customer->fullname)
                            <span>{{ $customer->fullname }}</span>
                        @endif
                    </div>
                    <span class="admin-crm-status is-{{ $customer->relationship_status }}">
                        {{ $customer->relationship_label }}
                    </span>
                </header>

                <div class="admin-customer-contact">
                    <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                    @if($customer->phone)
                        <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                    @endif
                    <span>{{ $customer->city ?: 'Ville non renseignée' }}</span>
                </div>

                <div class="admin-customer-metrics">
                    <div>
                        <span>CA net TTC</span>
                        <strong>{{ number_format($entry['revenue_ttc'], 0, ',', ' ') }} €</strong>
                    </div>
                    <div>
                        <span>Activités</span>
                        <strong>{{ $entry['activity_count'] }}</strong>
                    </div>
                    <div>
                        <span>Factures</span>
                        <strong>{{ $entry['invoice_count'] }}</strong>
                    </div>
                </div>

                @if($customer->tags)
                    <div class="admin-customer-tags">
                        @foreach($customer->tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                @if($customer->next_follow_up_at)
                    <div class="admin-customer-follow-up {{ $entry['follow_up_due'] ? 'is-due' : '' }}">
                        <span>{{ $entry['follow_up_due'] ? 'Relance à effectuer' : 'Prochaine relance' }}</span>
                        <strong>{{ $customer->next_follow_up_at->format('d/m/Y à H:i') }}</strong>
                    </div>
                @endif

                <footer>
                    <small>
                        Dernière activité :
                        {{ $customer->last_activity_at?->diffForHumans() ?? 'aucune date' }}
                    </small>
                    <a href="{{ route('admin.customers.show', $customer) }}" class="admin-primary-button">Ouvrir la fiche</a>
                </footer>
            </article>
        @empty
            <div class="admin-empty-state admin-crm-empty">
                Aucune fiche client ne correspond aux filtres sélectionnés.
            </div>
        @endforelse
    </section>

    @if($customers->hasPages())
        <nav class="admin-crm-pagination" aria-label="Pagination des clients">
            @if($customers->onFirstPage())
                <span>← Précédent</span>
            @else
                <a href="{{ $customers->previousPageUrl() }}">← Précédent</a>
            @endif
            <strong>Page {{ $customers->currentPage() }} sur {{ $customers->lastPage() }}</strong>
            @if($customers->hasMorePages())
                <a href="{{ $customers->nextPageUrl() }}">Suivant →</a>
            @else
                <span>Suivant →</span>
            @endif
        </nav>
    @endif
@endsection

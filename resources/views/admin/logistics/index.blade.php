@extends('layouts.admin', [
    'title' => 'Préparation & livraison — Wagyu France',
    'sectionLabel' => 'Exploitation',
    'pageHeading' => 'Préparation & livraison',
    'bodyClass' => 'admin-logistics-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-logistics.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Atelier & expédition</p>
            <h2>Voir immédiatement ce qui doit être préparé, remis ou livré.</h2>
            <p>
                Chaque changement d’étape actualise le dossier et peut prévenir automatiquement le client
                avec la date prévue, le transporteur et le numéro de suivi.
            </p>
        </div>
        <a href="{{ route('admin.demandes') }}" class="admin-secondary-button">Retour aux demandes</a>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>À préparer</span>
            <strong>{{ $counts['pending'] }}</strong>
            <small>Dossiers confirmés encore non commencés.</small>
        </article>
        <article class="admin-stat-card">
            <span>En préparation</span>
            <strong>{{ $counts['preparing'] }}</strong>
            <small>Découpe, pesée ou conditionnement en cours.</small>
        </article>
        <article class="admin-stat-card">
            <span>Prêtes</span>
            <strong>{{ $counts['ready'] }}</strong>
            <small>Commandes prêtes à être remises ou expédiées.</small>
        </article>
        <article class="admin-stat-card">
            <span>En circulation</span>
            <strong>{{ $counts['dispatched'] }}</strong>
            <small>Remises ou expéditions non encore livrées.</small>
        </article>
    </section>

    <section class="admin-logistics-toolbar admin-card">
        <form method="GET" action="{{ route('admin.logistics.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Référence, client, société, email ou suivi...">
            <select name="kind">
                <option value="all" @selected($kind === 'all')>Tous les dossiers</option>
                <option value="shop" @selected($kind === 'shop')>Particuliers</option>
                <option value="pro" @selected($kind === 'pro')>Professionnels</option>
            </select>
            <select name="status">
                <option value="">Toutes les étapes</option>
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-secondary-button">Filtrer</button>
        </form>
    </section>

    <section class="admin-logistics-board">
        @foreach($statuses as $statusKey => $statusLabel)
            @php($columnItems = $grouped[$statusKey] ?? collect())
            <div class="admin-logistics-column is-{{ $statusKey }}">
                <header>
                    <div>
                        <span></span>
                        <strong>{{ $statusLabel }}</strong>
                    </div>
                    <b>{{ $columnItems->count() }}</b>
                </header>

                <div class="admin-logistics-column-body">
                    @forelse($columnItems as $item)
                        @include('admin.logistics.partials.card', [
                            'documentable' => $item['model'],
                            'documentKind' => $item['kind'],
                            'statuses' => $statuses,
                            'deliveryMethods' => $deliveryMethods,
                        ])
                    @empty
                        <div class="admin-logistics-empty">Aucun dossier dans cette étape.</div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </section>
@endsection

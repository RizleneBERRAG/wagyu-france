@extends('layouts.admin', [
    'title' => 'Facturation & avoirs — Wagyu France',
    'sectionLabel' => 'Gestion commerciale',
    'pageHeading' => 'Facturation & avoirs',
    'bodyClass' => 'admin-billing-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-billing.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Documents définitifs</p>
            <h2>Factures, envois et rectifications au même endroit.</h2>
            <p>
                Téléchargez ou envoyez chaque facture, suivez sa transmission et créez un avoir partiel
                ou complet sans jamais dépasser le montant initialement facturé.
            </p>
        </div>
        <a href="{{ route('admin.demandes') }}" class="admin-secondary-button">Voir les demandes</a>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>Factures particuliers</span>
            <strong>{{ $counts['shop'] }}</strong>
            <small>Factures issues de la boutique.</small>
        </article>
        <article class="admin-stat-card">
            <span>Factures professionnelles</span>
            <strong>{{ $counts['pro'] }}</strong>
            <small>Dossiers liés à la réserve.</small>
        </article>
        <article class="admin-stat-card">
            <span>Avoirs émis</span>
            <strong>{{ $counts['credits'] }}</strong>
            <small>Rectifications partielles ou complètes.</small>
        </article>
        <article class="admin-stat-card {{ $counts['unsent'] > 0 ? 'is-warning' : '' }}">
            <span>Factures non envoyées</span>
            <strong>{{ $counts['unsent'] }}</strong>
            <small>Documents encore non transmis par email.</small>
        </article>
    </section>

    <section class="admin-billing-toolbar admin-card">
        <form method="GET" action="{{ route('admin.billing.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Facture, référence, client, société ou email...">
            <select name="kind">
                <option value="all" @selected($kind === 'all')>Toutes les factures</option>
                <option value="shop" @selected($kind === 'shop')>Particuliers</option>
                <option value="pro" @selected($kind === 'pro')>Professionnels</option>
            </select>
            <button type="submit" class="admin-secondary-button">Rechercher</button>
        </form>
    </section>

    @if($shopInvoices->isNotEmpty())
        <section class="admin-billing-section">
            <div class="admin-request-section-heading">
                <div>
                    <p class="admin-kicker">Particuliers</p>
                    <h3>Factures boutique</h3>
                </div>
                <span>{{ $shopInvoices->count() }} résultat(s)</span>
            </div>

            <div class="admin-billing-grid">
                @foreach($shopInvoices as $invoice)
                    @include('admin.billing.partials.invoice-card', ['invoice' => $invoice, 'invoiceKind' => 'shop'])
                @endforeach
            </div>
        </section>
    @endif

    @if($proInvoices->isNotEmpty())
        <section class="admin-billing-section">
            <div class="admin-request-section-heading">
                <div>
                    <p class="admin-kicker">Professionnels</p>
                    <h3>Factures de la réserve</h3>
                </div>
                <span>{{ $proInvoices->count() }} résultat(s)</span>
            </div>

            <div class="admin-billing-grid">
                @foreach($proInvoices as $invoice)
                    @include('admin.billing.partials.invoice-card', ['invoice' => $invoice, 'invoiceKind' => 'pro'])
                @endforeach
            </div>
        </section>
    @endif

    @if($shopInvoices->isEmpty() && $proInvoices->isEmpty())
        <div class="admin-empty-state admin-billing-empty">
            Aucune facture émise ne correspond à cette recherche. Les factures apparaîtront ici dès leur émission depuis un dossier.
        </div>
    @endif
@endsection

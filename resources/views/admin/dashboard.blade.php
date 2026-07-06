@extends('layouts.app', [
    'title' => 'Tableau de bord — Wagyu France',
    'bodyClass' => 'admin-dashboard-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
@endpush

@section('content')

    <section class="admin-dashboard-hero">
        <div class="admin-dashboard-grid"></div>
        <div class="admin-dashboard-glow"></div>

        <div class="admin-dashboard-inner">
            <div>
                <p class="eyebrow">Administration interne</p>

                <h1>
                    Tableau de bord
                    <span>Wagyu France.</span>
                </h1>

                <p>
                    Suivez les demandes boutique, les réservations professionnelles
                    et les actions importantes.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button type="submit">
                    Déconnexion
                </button>
            </form>
        </div>
    </section>

    <section class="admin-dashboard-stats">
        <div class="admin-dashboard-stat-grid">
            <article>
                <span>Boutique</span>
                <strong>{{ $shopCount }}</strong>
                <small>{{ $newShopCount }} nouvelle(s)</small>
            </article>

            <article>
                <span>Professionnel</span>
                <strong>{{ $proCount }}</strong>
                <small>{{ $newProCount }} nouvelle(s)</small>
            </article>

            <article>
                <span>Total</span>
                <strong>{{ $shopCount + $proCount }}</strong>
                <small>demandes reçues</small>
            </article>
        </div>
    </section>

    <section class="admin-dashboard-actions">
        <div class="admin-dashboard-action-grid">
            <a href="{{ route('admin.demandes') }}">
                <span>01</span>
                <strong>Voir toutes les demandes</strong>
                <small>Boutique particulier + réserve professionnelle.</small>
            </a>

            <a href="{{ route('boutique') }}">
                <span>02</span>
                <strong>Voir la boutique</strong>
                <small>Contrôler le parcours côté particulier.</small>
            </a>

            <a href="{{ route('reserve.pro') }}">
                <span>03</span>
                <strong>Voir la réserve pro</strong>
                <small>Tester la pré-réservation professionnelle.</small>
            </a>
        </div>
    </section>

    <section class="admin-dashboard-latest">
        <div class="admin-dashboard-latest-grid">
            <div class="admin-dashboard-panel">
                <div class="admin-dashboard-panel-head">
                    <p class="eyebrow">Boutique</p>
                    <h2>Dernières demandes</h2>
                </div>

                @forelse ($shopOrders as $order)
                    <article>
                        <div>
                            <strong>{{ $order->fullname }}</strong>
                            <span>{{ $order->reference }}</span>
                        </div>

                        <small>{{ number_format((float) $order->total, 2, ',', ' ') }} €</small>
                    </article>
                @empty
                    <p class="admin-dashboard-empty">Aucune demande boutique.</p>
                @endforelse
            </div>

            <div class="admin-dashboard-panel">
                <div class="admin-dashboard-panel-head">
                    <p class="eyebrow">Professionnel</p>
                    <h2>Dernières demandes</h2>
                </div>

                @forelse ($proRequests as $requestItem)
                    <article>
                        <div>
                            <strong>{{ $requestItem->company }}</strong>
                            <span>{{ $requestItem->reference }}</span>
                        </div>

                        <small>{{ number_format((float) $requestItem->total_ht, 2, ',', ' ') }} € HT</small>
                    </article>
                @empty
                    <p class="admin-dashboard-empty">Aucune demande professionnelle.</p>
                @endforelse
            </div>
        </div>
    </section>

@endsection

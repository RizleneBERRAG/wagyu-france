@extends('layouts.admin', [
    'title' => 'Tableau de bord — Wagyu France',
    'sectionLabel' => 'Pilotage de la maison',
    'pageHeading' => 'Vue d’ensemble',
    'bodyClass' => 'admin-dashboard-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Cockpit Wagyu France</p>
            <h2>Tout ce qui demande votre attention, au même endroit.</h2>
            <p>
                Suivez les commandes, les clients, les relances, les stocks, la facturation, la logistique,
                les messages et la progression de l’animal actif sans parcourir chaque page du site.
            </p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-primary-button">Ajouter un produit</a>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>Éléments à traiter</span>
            <strong>{{ $newCount }}</strong>
            <small>Commandes, demandes pro et messages au statut « nouvelle ».</small>
        </article>
        <article class="admin-stat-card">
            <span>Estimation boutique</span>
            <strong>{{ number_format($turnoverEstimate, 0, ',', ' ') }} €</strong>
            <small>Total estimatif des demandes boutique non annulées.</small>
        </article>
        <article class="admin-stat-card">
            <span>Catalogue actif</span>
            <strong>{{ $activeProductCount }}/{{ $productCount }}</strong>
            <small>{{ $lowStockCount }} produit(s) sous le seuil de stock défini.</small>
        </article>
        <article class="admin-stat-card">
            <span>Demandes reçues</span>
            <strong>{{ $shopCount + $proCount + $contactCount }}</strong>
            <small>{{ $shopCount }} boutique · {{ $proCount }} pro · {{ $contactCount }} contact.</small>
        </article>
    </section>

    <section class="admin-dashboard-grid">
        <article class="admin-dashboard-reserve admin-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Animal actuellement publié</p>
                    <h3>{{ $activeBatch['batch']->reference ?? 'Aucun animal actif' }}</h3>
                </div>
                @if ($activeBatch)
                    <span class="admin-status admin-status-{{ $activeBatch['batch']->status }}">
                        {{ $activeBatch['batch']->status_label }}
                    </span>
                @endif
            </div>

            @if ($activeBatch)
                <div class="admin-reserve-score">
                    <div>
                        <strong>{{ $activeBatch['progress'] }}%</strong>
                        <span>de la réserve demandée</span>
                    </div>
                    <div>
                        <strong>{{ number_format($activeBatch['requested_kg'], 1, ',', ' ') }} kg</strong>
                        <span>sur {{ number_format($activeBatch['available_kg'], 1, ',', ' ') }} kg</span>
                    </div>
                </div>

                <div class="admin-progress" aria-label="Progression de la réserve">
                    <span style="width: {{ $activeBatch['progress'] }}%"></span>
                </div>

                <div class="admin-reserve-threshold {{ $activeBatch['threshold_reached'] ? 'is-reached' : '' }}">
                    <span>Seuil de lancement</span>
                    <strong>{{ $activeBatch['batch']->launch_threshold_percent }}%</strong>
                    <p>
                        @if ($activeBatch['threshold_reached'])
                            Le seuil est atteint : la préparation de la découpe peut commencer.
                        @else
                            Encore {{ max(0, $activeBatch['batch']->launch_threshold_percent - $activeBatch['progress']) }} point(s) avant l’alerte de lancement.
                        @endif
                    </p>
                </div>

                <div class="admin-panel-actions">
                    <a href="{{ route('admin.animals.show', $activeBatch['batch']) }}" class="admin-primary-button">Gérer l’animal</a>
                    <a href="{{ route('reserve.pro') }}" target="_blank" class="admin-secondary-button">Voir la réserve</a>
                </div>
            @else
                <div class="admin-empty-state">
                    Aucun animal n’est actuellement visible dans la réserve professionnelle.
                </div>
                <a href="{{ route('admin.animals.create') }}" class="admin-primary-button">Préparer un animal</a>
            @endif
        </article>

        <article class="admin-notification-panel admin-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Centre d’attention</p>
                    <h3>Notifications métier</h3>
                </div>
                <span>{{ count($notifications) }}</span>
            </div>

            <div class="admin-notification-list">
                @forelse ($notifications as $notification)
                    <a
                        href="{{ route($notification['route'], $notification['parameters'] ?? []) }}"
                        class="admin-notification is-{{ $notification['level'] }}"
                    >
                        <i></i>
                        <div>
                            <strong>{{ $notification['title'] }}</strong>
                            <p>{{ $notification['message'] }}</p>
                        </div>
                        <span>→</span>
                    </a>
                @empty
                    <div class="admin-empty-state">Tout est à jour. Aucune action urgente.</div>
                @endforelse
            </div>
        </article>
    </section>

    <section class="admin-quick-actions">
        <a href="{{ route('admin.products.index') }}">
            <span>01</span>
            <strong>Gérer la boutique</strong>
            <p>Prix, stocks, photos, visibilité et ordre des produits.</p>
        </a>
        <a href="{{ route('admin.animals.index') }}">
            <span>02</span>
            <strong>Lancer un animal</strong>
            <p>Préparer la réserve, choisir le seuil et suivre les volumes.</p>
        </a>
        <a href="{{ route('admin.demandes') }}">
            <span>03</span>
            <strong>Traiter les demandes</strong>
            <p>Commandes particulières, réservations professionnelles et messages.</p>
        </a>
        <a href="{{ route('admin.customers.index') }}">
            <span>04</span>
            <strong>Suivre les clients</strong>
            <p>Historique, chiffre d’affaires, notes, segmentation et relances.</p>
        </a>
        <a href="{{ route('admin.billing.index') }}">
            <span>05</span>
            <strong>Facturer & rectifier</strong>
            <p>Envoyer les factures, suivre leur transmission et émettre les avoirs.</p>
        </a>
        <a href="{{ route('admin.logistics.index') }}">
            <span>06</span>
            <strong>Préparer & livrer</strong>
            <p>Planification, conditionnement, retrait, transport et suivi client.</p>
        </a>
    </section>

    <section class="admin-activity-panel admin-card">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Derniers mouvements</p>
                <h3>Activité récente</h3>
            </div>
            <a href="{{ route('admin.demandes') }}">Tout afficher</a>
        </div>

        <div class="admin-activity-table">
            <div class="admin-activity-row admin-activity-head">
                <span>Origine</span>
                <span>Client / établissement</span>
                <span>Référence</span>
                <span>Statut</span>
                <span>Montant</span>
                <span>Date</span>
            </div>
            @forelse ($latestActivity as $activity)
                <div class="admin-activity-row">
                    <strong>{{ $activity['type'] }}</strong>
                    <span>{{ $activity['title'] }}</span>
                    <code>{{ $activity['reference'] }}</code>
                    <span class="admin-status admin-status-{{ $activity['status'] }}">{{ str_replace('_', ' ', ucfirst($activity['status'])) }}</span>
                    <span>{{ $activity['amount'] !== null ? number_format($activity['amount'], 0, ',', ' ') . ' €' : '—' }}</span>
                    <small>{{ $activity['created_at']?->format('d/m/Y H:i') }}</small>
                </div>
            @empty
                <div class="admin-empty-state">Aucune activité enregistrée pour le moment.</div>
            @endforelse
        </div>
    </section>
@endsection

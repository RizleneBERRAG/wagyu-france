@extends('layouts.app', [
    'title' => 'Administration — Demandes Wagyu France',
    'bodyClass' => 'admin-demandes-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-demandes.css') }}">
@endpush

@section('content')

    <section class="admin-hero">
        <div class="admin-hero-grid"></div>
        <div class="admin-red-glow"></div>
        <div class="admin-gold-glow"></div>

        <div class="admin-hero-inner">
            <p class="eyebrow">Administration interne</p>

            <h1>
                Suivi des demandes
                <span>Wagyu France.</span>
            </h1>

            <p>
                Retrouvez ici les demandes issues de la boutique particulier
                et de la réserve professionnelle.
            </p>

            @if (session('success'))
                <div class="admin-alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </section>

    <section class="admin-stats-section">
        <div class="admin-stats-grid">
            <article>
                <span>Boutique</span>
                <strong>{{ $shopOrders->count() }}</strong>
                <small>demandes particulier</small>
            </article>

            <article>
                <span>Professionnel</span>
                <strong>{{ $proRequests->count() }}</strong>
                <small>demandes réserve pro</small>
            </article>

            <article>
                <span>Total</span>
                <strong>{{ $shopOrders->count() + $proRequests->count() }}</strong>
                <small>demandes reçues</small>
            </article>
        </div>
    </section>

    <section class="admin-section">
        <div class="admin-section-heading">
            <p class="eyebrow">Boutique particulier</p>

            <h2>
                Demandes de commande.
            </h2>
        </div>

        <div class="admin-request-grid">
            @forelse ($shopOrders as $order)
                <article class="admin-request-card">
                    <div class="admin-request-top">
                        <div>
                            <span class="admin-reference">{{ $order->reference }}</span>
                            <h3>{{ $order->fullname }}</h3>
                        </div>

                        <strong class="admin-status admin-status-{{ $order->status }}">
                            {{ $statuses[$order->status] ?? $order->status }}
                        </strong>
                    </div>

                    <div class="admin-info-grid">
                        <div>
                            <span>Email</span>
                            <strong>{{ $order->email }}</strong>
                        </div>

                        <div>
                            <span>Téléphone</span>
                            <strong>{{ $order->phone }}</strong>
                        </div>

                        <div>
                            <span>Ville</span>
                            <strong>{{ $order->city }}</strong>
                        </div>

                        <div>
                            <span>Total</span>
                            <strong>{{ number_format((float) $order->total, 2, ',', ' ') }} €</strong>
                        </div>
                    </div>

                    @if ($order->message)
                        <div class="admin-message">
                            <span>Message</span>
                            <p>{{ $order->message }}</p>
                        </div>
                    @endif

                    <div class="admin-cart">
                        <span>Pièces demandées</span>

                        @foreach ($order->cart ?? [] as $item)
                            <div class="admin-cart-line">
                                <strong>{{ $item['name'] ?? 'Produit' }}</strong>
                                <small>
                                    {{ $item['quantity'] ?? 0 }} kg ·
                                    {{ number_format((float) ($item['unit_price'] ?? 0), 2, ',', ' ') }} €/kg
                                </small>
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('admin.demandes.shop.status', $order) }}" class="admin-status-form">
                        @csrf
                        @method('PATCH')

                        <label>
                            <span>Modifier le statut</span>

                            <select name="status">
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected($order->status === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <button type="submit">
                            Mettre à jour
                        </button>
                    </form>

                    <small class="admin-date">
                        Reçue le {{ $order->created_at->format('d/m/Y à H:i') }}
                    </small>
                </article>
            @empty
                <div class="admin-empty">
                    Aucune demande boutique pour le moment.
                </div>
            @endforelse
        </div>
    </section>

    <section class="admin-section">
        <div class="admin-section-heading">
            <p class="eyebrow">Réserve professionnelle</p>

            <h2>
                Demandes pro.
            </h2>
        </div>

        <div class="admin-request-grid">
            @forelse ($proRequests as $requestItem)
                <article class="admin-request-card admin-request-card-pro">
                    <div class="admin-request-top">
                        <div>
                            <span class="admin-reference">{{ $requestItem->reference }}</span>
                            <h3>{{ $requestItem->company }}</h3>
                        </div>

                        <strong class="admin-status admin-status-{{ $requestItem->status }}">
                            {{ $statuses[$requestItem->status] ?? $requestItem->status }}
                        </strong>
                    </div>

                    <div class="admin-info-grid">
                        <div>
                            <span>Contact</span>
                            <strong>{{ $requestItem->fullname }}</strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>{{ $requestItem->email }}</strong>
                        </div>

                        <div>
                            <span>Téléphone</span>
                            <strong>{{ $requestItem->phone }}</strong>
                        </div>

                        <div>
                            <span>Type</span>
                            <strong>{{ $requestItem->professional_type }}</strong>
                        </div>

                        <div>
                            <span>Ville</span>
                            <strong>{{ $requestItem->city ?: 'Non précisée' }}</strong>
                        </div>

                        <div>
                            <span>Total HT</span>
                            <strong>{{ number_format((float) $requestItem->total_ht, 2, ',', ' ') }} €</strong>
                        </div>
                    </div>

                    @if ($requestItem->message)
                        <div class="admin-message">
                            <span>Message</span>
                            <p>{{ $requestItem->message }}</p>
                        </div>
                    @endif

                    <div class="admin-cart">
                        <span>Pièces pré-réservées</span>

                        @foreach ($requestItem->cart ?? [] as $item)
                            <div class="admin-cart-line">
                                <strong>{{ $item['name'] ?? 'Pièce' }}</strong>
                                <small>
                                    {{ $item['quantity'] ?? 0 }} kg ·
                                    {{ number_format((float) ($item['unit_price'] ?? $item['price'] ?? 0), 2, ',', ' ') }} €/kg
                                </small>
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('admin.demandes.pro.status', $requestItem) }}" class="admin-status-form">
                        @csrf
                        @method('PATCH')

                        <label>
                            <span>Modifier le statut</span>

                            <select name="status">
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected($requestItem->status === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <button type="submit">
                            Mettre à jour
                        </button>
                    </form>

                    <small class="admin-date">
                        Reçue le {{ $requestItem->created_at->format('d/m/Y à H:i') }}
                    </small>
                </article>
            @empty
                <div class="admin-empty">
                    Aucune demande professionnelle pour le moment.
                </div>
            @endforelse
        </div>
    </section>

@endsection

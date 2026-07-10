@extends('layouts.admin', [
    'title' => 'Commandes & demandes — Wagyu France',
    'sectionLabel' => 'Relation client',
    'pageHeading' => 'Commandes & demandes',
    'bodyClass' => 'admin-requests-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-exports.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Centre de traitement</p>
            <h2>Une seule file pour suivre toutes les demandes.</h2>
            <p>
                Recherchez un client, filtrez par statut et faites avancer chaque dossier
                de « nouvelle » à « traitée » sans perdre la référence ni le détail des pièces.
            </p>
        </div>
        <div class="admin-export-global">
            <a href="{{ route('admin.demandes.export', 'shop') }}" class="admin-secondary-button">Exporter boutique</a>
            <a href="{{ route('admin.demandes.export', 'pro') }}" class="admin-secondary-button">Exporter pro</a>
            <a href="{{ route('admin.demandes.export', 'contacts') }}" class="admin-secondary-button">Exporter messages</a>
        </div>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>À traiter</span>
            <strong>{{ $counts['new'] }}</strong>
            <small>Éléments encore au statut « nouvelle ».</small>
        </article>
        <article class="admin-stat-card">
            <span>Boutique</span>
            <strong>{{ $counts['shop'] }}</strong>
            <small>Demandes de particuliers.</small>
        </article>
        <article class="admin-stat-card">
            <span>Professionnels</span>
            <strong>{{ $counts['pro'] }}</strong>
            <small>Pré-réservations liées aux animaux.</small>
        </article>
        <article class="admin-stat-card">
            <span>Messages</span>
            <strong>{{ $counts['contact'] }}</strong>
            <small>Demandes générales et partenariats.</small>
        </article>
    </section>

    <nav class="admin-request-tabs" aria-label="Type de demande">
        <a href="{{ route('admin.demandes', ['section' => 'all']) }}" @class(['is-active' => $section === 'all'])>Tout</a>
        <a href="{{ route('admin.demandes', ['section' => 'shop']) }}" @class(['is-active' => $section === 'shop'])>Boutique <b>{{ $counts['shop'] }}</b></a>
        <a href="{{ route('admin.demandes', ['section' => 'pro']) }}" @class(['is-active' => $section === 'pro'])>Professionnels <b>{{ $counts['pro'] }}</b></a>
        <a href="{{ route('admin.demandes', ['section' => 'contacts']) }}" @class(['is-active' => $section === 'contacts'])>Messages <b>{{ $counts['contact'] }}</b></a>
    </nav>

    <div class="admin-toolbar">
        <form method="GET" action="{{ route('admin.demandes') }}">
            <input type="hidden" name="section" value="{{ $section }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Référence, nom, email, société...">
            <select name="status">
                <option value="">Tous les statuts</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-secondary-button">Rechercher</button>
        </form>
    </div>

    @if (in_array($section, ['all', 'shop'], true))
        <section class="admin-request-section" id="boutique">
            <div class="admin-request-section-heading">
                <div><p class="admin-kicker">Particuliers</p><h3>Demandes boutique</h3></div>
                <div class="admin-request-section-tools">
                    <span>{{ $shopOrders->count() }} résultat(s)</span>
                    <a href="{{ route('admin.demandes.export', 'shop') }}">CSV</a>
                </div>
            </div>

            <div class="admin-request-card-grid">
                @forelse ($shopOrders as $order)
                    <article class="admin-request-card">
                        <header>
                            <div>
                                <span class="admin-request-type">Boutique</span>
                                <h4>{{ $order->fullname }}</h4>
                                <code>{{ $order->reference }}</code>
                            </div>
                            <span class="admin-status admin-status-{{ $order->status }}">{{ $statuses[$order->status] ?? $order->status }}</span>
                        </header>

                        <dl class="admin-request-info">
                            <div><dt>Email</dt><dd><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></dd></div>
                            <div><dt>Téléphone</dt><dd><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></dd></div>
                            <div><dt>Ville</dt><dd>{{ $order->city }}</dd></div>
                            <div><dt>Estimation</dt><dd>{{ number_format((float) $order->total, 2, ',', ' ') }} €</dd></div>
                        </dl>

                        <div @class(['admin-stock-state', 'is-applied' => $order->stock_applied_at, 'is-free' => ! $order->stock_applied_at])>
                            <span>{{ $order->stock_applied_at ? 'Stock réservé' : 'Stock non engagé' }}</span>
                            <p>
                                {{ $order->stock_applied_at
                                    ? 'Déduit automatiquement le ' . $order->stock_applied_at->format('d/m/Y à H:i') . '. Une annulation le restaurera.'
                                    : 'Le stock sera déduit lorsque la demande passera à « Confirmée » ou « Traitée ».' }}
                            </p>
                        </div>

                        @if ($order->message)
                            <div class="admin-request-message"><strong>Message du client</strong><p>{{ $order->message }}</p></div>
                        @endif

                        <div class="admin-request-lines">
                            <strong>Pièces demandées</strong>
                            @foreach ($order->cart ?? [] as $item)
                                <div>
                                    <span>{{ $item['name'] ?? 'Produit' }}</span>
                                    <small>{{ number_format((float) ($item['quantity'] ?? 0), 1, ',', ' ') }} kg · {{ number_format((float) ($item['unit_price'] ?? 0), 2, ',', ' ') }} €/kg</small>
                                </div>
                            @endforeach
                        </div>

                        <footer>
                            <form method="POST" action="{{ route('admin.demandes.shop.status', $order) }}" class="admin-request-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="admin-primary-button">Mettre à jour</button>
                            </form>
                            <small>Reçue le {{ $order->created_at->format('d/m/Y à H:i') }}</small>
                        </footer>
                    </article>
                @empty
                    <div class="admin-empty-state">Aucune demande boutique ne correspond aux filtres.</div>
                @endforelse
            </div>
        </section>
    @endif

    @if (in_array($section, ['all', 'pro'], true))
        <section class="admin-request-section" id="professionnels">
            <div class="admin-request-section-heading">
                <div><p class="admin-kicker">Réserve</p><h3>Demandes professionnelles</h3></div>
                <div class="admin-request-section-tools">
                    <span>{{ $proRequests->count() }} résultat(s)</span>
                    <a href="{{ route('admin.demandes.export', 'pro') }}">CSV</a>
                </div>
            </div>

            <div class="admin-request-card-grid">
                @forelse ($proRequests as $requestItem)
                    <article class="admin-request-card is-pro">
                        <header>
                            <div>
                                <span class="admin-request-type">{{ $requestItem->professional_type }}</span>
                                <h4>{{ $requestItem->company }}</h4>
                                <code>{{ $requestItem->reference }} · {{ $requestItem->bovin_reference }}</code>
                            </div>
                            <span class="admin-status admin-status-{{ $requestItem->status }}">{{ $statuses[$requestItem->status] ?? $requestItem->status }}</span>
                        </header>

                        <dl class="admin-request-info">
                            <div><dt>Contact</dt><dd>{{ $requestItem->fullname }}</dd></div>
                            <div><dt>Email</dt><dd><a href="mailto:{{ $requestItem->email }}">{{ $requestItem->email }}</a></dd></div>
                            <div><dt>Téléphone</dt><dd><a href="tel:{{ $requestItem->phone }}">{{ $requestItem->phone }}</a></dd></div>
                            <div><dt>Total HT</dt><dd>{{ number_format((float) $requestItem->total_ht, 2, ',', ' ') }} €</dd></div>
                        </dl>

                        @if ($requestItem->message)
                            <div class="admin-request-message"><strong>Besoin précisé</strong><p>{{ $requestItem->message }}</p></div>
                        @endif

                        <div class="admin-request-lines">
                            <strong>Pièces pré-réservées</strong>
                            @foreach ($requestItem->cart ?? [] as $item)
                                <div>
                                    <span>{{ $item['name'] ?? 'Pièce' }}</span>
                                    <small>{{ number_format((float) ($item['quantity'] ?? 0), 1, ',', ' ') }} kg · {{ number_format((float) ($item['unit_price_ht'] ?? 0), 2, ',', ' ') }} € HT/kg</small>
                                </div>
                            @endforeach
                        </div>

                        <footer>
                            <form method="POST" action="{{ route('admin.demandes.pro.status', $requestItem) }}" class="admin-request-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($requestItem->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="admin-primary-button">Mettre à jour</button>
                            </form>
                            <small>Reçue le {{ $requestItem->created_at->format('d/m/Y à H:i') }}</small>
                        </footer>
                    </article>
                @empty
                    <div class="admin-empty-state">Aucune demande professionnelle ne correspond aux filtres.</div>
                @endforelse
            </div>
        </section>
    @endif

    @if (in_array($section, ['all', 'contacts'], true))
        <section class="admin-request-section" id="contacts">
            <div class="admin-request-section-heading">
                <div><p class="admin-kicker">Contact</p><h3>Messages reçus</h3></div>
                <div class="admin-request-section-tools">
                    <span>{{ $contactMessages->count() }} résultat(s)</span>
                    <a href="{{ route('admin.demandes.export', 'contacts') }}">CSV</a>
                </div>
            </div>

            <div class="admin-request-card-grid">
                @forelse ($contactMessages as $message)
                    <article class="admin-request-card is-contact">
                        <header>
                            <div>
                                <span class="admin-request-type">{{ ucfirst($message->audience) }}</span>
                                <h4>{{ $message->fullname }}</h4>
                                <code>{{ $message->reference }}</code>
                            </div>
                            <span class="admin-status admin-status-{{ $message->status }}">{{ $statuses[$message->status] ?? $message->status }}</span>
                        </header>

                        <dl class="admin-request-info">
                            <div><dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd></div>
                            <div><dt>Téléphone</dt><dd>{{ $message->phone ?: 'Non précisé' }}</dd></div>
                            <div><dt>Société</dt><dd>{{ $message->company ?: '—' }}</dd></div>
                            <div><dt>Réponse souhaitée</dt><dd>{{ ucfirst($message->preferred_contact) }}</dd></div>
                        </dl>

                        <div class="admin-request-message">
                            <strong>{{ $message->subject }}</strong>
                            <p>{{ $message->message }}</p>
                        </div>

                        <footer>
                            <form method="POST" action="{{ route('admin.demandes.contact.status', $message) }}" class="admin-request-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($message->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="admin-primary-button">Mettre à jour</button>
                            </form>
                            <small>Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}</small>
                        </footer>
                    </article>
                @empty
                    <div class="admin-empty-state">Aucun message ne correspond aux filtres.</div>
                @endforelse
            </div>
        </section>
    @endif
@endsection
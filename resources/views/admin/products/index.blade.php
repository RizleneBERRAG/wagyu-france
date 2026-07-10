@extends('layouts.admin', [
    'title' => 'Produits boutique — Wagyu France',
    'sectionLabel' => 'Commerce',
    'pageHeading' => 'Produits boutique',
    'bodyClass' => 'admin-products-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Catalogue administrable</p>
            <h2>Prix, stocks, photos et disponibilité.</h2>
            <p>
                Chaque modification enregistrée ici est immédiatement utilisée par la boutique publique
                et lors du calcul des nouvelles demandes clients.
            </p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-primary-button">Ajouter un produit</a>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>Total catalogue</span>
            <strong>{{ $totalProducts }}</strong>
            <small>Produits enregistrés dans la base.</small>
        </article>
        <article class="admin-stat-card">
            <span>Visibles</span>
            <strong>{{ $activeProducts }}</strong>
            <small>Produits actuellement affichés en boutique.</small>
        </article>
        <article class="admin-stat-card">
            <span>Stock faible</span>
            <strong>{{ $lowStockProducts }}</strong>
            <small>Produits ayant atteint leur seuil d’alerte.</small>
        </article>
        <article class="admin-stat-card">
            <span>Masqués</span>
            <strong>{{ $totalProducts - $activeProducts }}</strong>
            <small>Conservés dans l’admin mais invisibles au public.</small>
        </article>
    </section>

    <div class="admin-toolbar">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit ou une référence...">
            <select name="status">
                <option value="">Tous les statuts</option>
                <option value="active" @selected(request('status') === 'active')>Produits visibles</option>
                <option value="hidden" @selected(request('status') === 'hidden')>Produits masqués</option>
                <option value="low" @selected(request('status') === 'low')>Stock faible</option>
            </select>
            <button type="submit" class="admin-secondary-button">Filtrer</button>
        </form>
    </div>

    <section class="admin-product-grid">
        @forelse ($products as $product)
            <article class="admin-product-card">
                <div class="admin-product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <span class="admin-status {{ $product->is_active ? 'is-active' : 'is-hidden' }}">
                        {{ $product->is_active ? 'Visible' : 'Masqué' }}
                    </span>
                </div>

                <div class="admin-product-body">
                    <span class="admin-product-reference">{{ $product->reference ?: $product->slug }}</span>
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->description ?: 'Aucune description renseignée.' }}</p>

                    <div class="admin-product-metrics">
                        <div>
                            <span>Prix public</span>
                            <strong>{{ number_format((float) $product->price_per_kg, 2, ',', ' ') }} €/kg</strong>
                        </div>
                        <div @class(['is-low' => $product->is_low_stock])>
                            <span>Stock</span>
                            <strong>{{ number_format((float) $product->stock_kg, 1, ',', ' ') }} kg</strong>
                        </div>
                        <div>
                            <span>Minimum</span>
                            <strong>{{ number_format((float) $product->min_quantity_kg, 1, ',', ' ') }} kg</strong>
                        </div>
                        <div>
                            <span>Ordre</span>
                            <strong>{{ $product->sort_order }}</strong>
                        </div>
                    </div>

                    <div class="admin-product-actions">
                        <a href="{{ route('admin.products.edit', $product) }}" class="admin-primary-button">Modifier</a>
                        <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-secondary-button" title="{{ $product->is_active ? 'Masquer' : 'Afficher' }}">
                                {{ $product->is_active ? 'Masquer' : 'Afficher' }}
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="admin-empty-state">
                Aucun produit ne correspond à votre recherche.
            </div>
        @endforelse
    </section>
@endsection

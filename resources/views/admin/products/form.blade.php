@extends('layouts.admin', [
    'title' => $pageTitle . ' — Wagyu France',
    'sectionLabel' => 'Commerce',
    'pageHeading' => $product->exists ? 'Modifier un produit' : 'Ajouter un produit',
    'bodyClass' => 'admin-product-form-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Catalogue boutique</p>
            <h2>{{ $pageTitle }}</h2>
            <p>Les informations enregistrées ici alimentent directement la fiche visible par les particuliers.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="admin-secondary-button">Retour au catalogue</a>
    </header>

    <form
        method="POST"
        action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data"
        class="admin-form-grid"
    >
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <section class="admin-form-card">
            <h3>Présentation du produit</h3>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Nom du produit *</span>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                </label>

                <label class="admin-field">
                    <span>Identifiant technique *</span>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="entrecote" required>
                </label>

                <label class="admin-field is-wide">
                    <span>Référence éditoriale</span>
                    <input type="text" name="reference" value="{{ old('reference', $product->reference) }}" placeholder="Pièce 01 · Collection signature">
                </label>

                <label class="admin-field">
                    <span>Badge sur la photo</span>
                    <input type="text" name="badge" value="{{ old('badge', $product->badge) }}" placeholder="La signature">
                </label>

                <label class="admin-field">
                    <span>Sous-titre de catégorie</span>
                    <input type="text" name="category_label" value="{{ old('category_label', $product->category_label) }}" placeholder="Pièce noble · À saisir">
                </label>

                <label class="admin-field is-wide">
                    <span>Description</span>
                    <textarea name="description" rows="5" placeholder="Décrivez la texture, le persillage et l’usage conseillé...">{{ old('description', $product->description) }}</textarea>
                </label>

                <label class="admin-field">
                    <span>Cuisson conseillée</span>
                    <input type="text" name="cooking" value="{{ old('cooking', $product->cooking) }}" placeholder="Saisie vive">
                </label>

                <label class="admin-field">
                    <span>Caractère</span>
                    <input type="text" name="character" value="{{ old('character', $product->character) }}" placeholder="Intense">
                </label>

                <div class="admin-field is-wide">
                    <span>Filtres boutique</span>
                    @php($selectedCategories = old('categories', $product->categories ?? []))
                    <div class="admin-check-grid">
                        @foreach (['noble' => 'Pièce noble', 'grill' => 'À saisir', 'caractere' => 'De caractère', 'lent' => 'Cuisson lente'] as $value => $label)
                            <label class="admin-check">
                                <input type="checkbox" name="categories[]" value="{{ $value }}" @checked(in_array($value, $selectedCategories, true))>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <aside class="admin-form-card">
            <h3>Vente & visibilité</h3>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Prix par kilogramme *</span>
                    <input type="number" step="0.01" min="0" name="price_per_kg" value="{{ old('price_per_kg', $product->price_per_kg) }}" required>
                </label>

                <label class="admin-field">
                    <span>Stock disponible (kg) *</span>
                    <input type="number" step="0.1" min="0" name="stock_kg" value="{{ old('stock_kg', $product->stock_kg) }}" required>
                </label>

                <label class="admin-field">
                    <span>Seuil d’alerte (kg) *</span>
                    <input type="number" step="0.1" min="0" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required>
                </label>

                <label class="admin-field">
                    <span>Quantité minimale (kg) *</span>
                    <input type="number" step="0.1" min="0.1" name="min_quantity_kg" value="{{ old('min_quantity_kg', $product->min_quantity_kg) }}" required>
                </label>

                <label class="admin-field">
                    <span>Ordre d’affichage *</span>
                    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" required>
                </label>

                <div class="admin-field is-wide">
                    <span>Statuts</span>
                    <div class="admin-check-grid">
                        <label class="admin-switch">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                            <span>Visible dans la boutique</span>
                        </label>
                        <label class="admin-switch">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
                            <span>Produit mis en avant</span>
                        </label>
                    </div>
                </div>

                <label class="admin-field is-wide">
                    <span>Photo du produit</span>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                </label>

                <div class="admin-image-preview is-wide">
                    @if ($product->image_path)
                        <img src="{{ $product->image_url }}" alt="Aperçu de {{ $product->name }}">
                    @else
                        <span>Aucune image sélectionnée</span>
                    @endif
                </div>
            </div>

            <p class="admin-form-side-note">
                Formats recommandés : JPG ou WebP, image horizontale d’au moins 1200 px. Une photo remplacée
                est supprimée automatiquement du stockage lorsqu’elle avait été envoyée depuis l’administration.
            </p>
        </aside>

        <div class="admin-form-actions">
            <button type="submit" class="admin-primary-button">
                {{ $product->exists ? 'Enregistrer les modifications' : 'Créer le produit' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="admin-secondary-button">Annuler</a>
        </div>
    </form>

    @if ($product->exists)
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="margin-top: 18px" onsubmit="return confirm('Supprimer définitivement ce produit ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-danger-button">Supprimer définitivement le produit</button>
        </form>
    @endif
@endsection

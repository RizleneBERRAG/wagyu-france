@extends('layouts.admin', [
    'title' => $animal->reference . ' — Wagyu France',
    'sectionLabel' => 'Réserve professionnelle',
    'pageHeading' => $animal->reference,
    'bodyClass' => 'admin-animal-show-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Gestion de la réserve</p>
            <h2>{{ $animal->name }}</h2>
            <p>
                Modifiez les volumes et les prix pièce par pièce. La progression est calculée depuis
                les demandes professionnelles non annulées rattachées à la référence {{ $animal->reference }}.
            </p>
        </div>
        <div class="admin-panel-actions">
            <a href="{{ route('admin.animals.edit', $animal) }}" class="admin-secondary-button">Modifier le lancement</a>
            <a href="{{ route('reserve.pro') }}" target="_blank" class="admin-primary-button">Voir la réserve</a>
        </div>
    </header>

    <section class="admin-animal-summary-grid">
        <article>
            <span>Statut</span>
            <strong>{{ $animal->status_label }}</strong>
        </article>
        <article>
            <span>Progression</span>
            <strong>{{ $progress }}%</strong>
        </article>
        <article>
            <span>Volume demandé</span>
            <strong>{{ number_format($requestedTotal, 1, ',', ' ') }} kg</strong>
        </article>
        <article>
            <span>Volume disponible</span>
            <strong>{{ number_format($availableTotal, 1, ',', ' ') }} kg</strong>
        </article>
    </section>

    <section class="admin-card" style="padding: 22px; margin-bottom: 18px">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Seuil de lancement</p>
                <h3>{{ $progress >= $animal->launch_threshold_percent ? 'Seuil atteint' : 'Réserve en progression' }}</h3>
            </div>
            <span>{{ $animal->launch_threshold_percent }}%</span>
        </div>
        <div class="admin-progress" style="margin-top: 20px">
            <span style="width: {{ $progress }}%"></span>
        </div>
        <p style="margin: 14px 0 0; color: var(--admin-text); font-size: .78rem">
            @if ($progress >= $animal->launch_threshold_percent)
                La demande cumulée a atteint le seuil choisi. Vous pouvez passer l’animal au statut « Seuil atteint » ou planifier la découpe.
            @else
                Il reste {{ max(0, $animal->launch_threshold_percent - $progress) }} point(s) avant l’alerte automatique du tableau de bord.
            @endif
        </p>
    </section>

    <section class="admin-cut-list">
        @foreach ($animal->cuts as $cut)
            @php
                $requested = (float) ($requestedByCut[$cut->slug] ?? 0);
                $cutProgress = (float) $cut->available_kg > 0
                    ? min(100, round(($requested / (float) $cut->available_kg) * 100))
                    : 0;
            @endphp

            <article class="admin-cut-card">
                <div class="admin-cut-card-header">
                    <div>
                        <h3>{{ $cut->name }}</h3>
                        <p>{{ $cut->slug }} · ordre {{ $cut->sort_order }}</p>
                    </div>
                    <div class="admin-cut-progress-meta">
                        <span><strong>{{ number_format($requested, 1, ',', ' ') }} kg</strong> demandés</span>
                        <span><strong>{{ $cutProgress }}%</strong> de la pièce</span>
                    </div>
                </div>

                <div class="admin-progress" style="margin-bottom: 18px">
                    <span style="width: {{ $cutProgress }}%"></span>
                </div>

                <form method="POST" action="{{ route('admin.animals.cuts.update', [$animal, $cut]) }}" class="admin-cut-form">
                    @csrf
                    @method('PUT')

                    <label class="admin-field">
                        <span>Nom</span>
                        <input type="text" name="name" value="{{ old('name', $cut->name) }}" required>
                    </label>

                    <label class="admin-field">
                        <span>Prix HT/kg</span>
                        <input type="number" step="0.01" min="0" name="price_per_kg" value="{{ old('price_per_kg', $cut->price_per_kg) }}" required>
                    </label>

                    <label class="admin-field">
                        <span>Disponible (kg)</span>
                        <input type="number" step="0.1" min="0" name="available_kg" value="{{ old('available_kg', $cut->available_kg) }}" required>
                    </label>

                    <label class="admin-field">
                        <span>Minimum (kg)</span>
                        <input type="number" step="0.1" min="0.1" name="min_quantity_kg" value="{{ old('min_quantity_kg', $cut->min_quantity_kg) }}" required>
                    </label>

                    <label class="admin-field">
                        <span>Ordre</span>
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $cut->sort_order) }}" required>
                    </label>

                    <label class="admin-switch">
                        <input type="checkbox" name="is_active" value="1" @checked($cut->is_active)>
                        <span>Visible</span>
                    </label>

                    <label class="admin-field is-description">
                        <span>Description professionnelle</span>
                        <textarea name="description" rows="3">{{ old('description', $cut->description) }}</textarea>
                    </label>

                    <button type="submit" class="admin-primary-button">Enregistrer cette pièce</button>
                </form>
            </article>
        @endforeach
    </section>
@endsection

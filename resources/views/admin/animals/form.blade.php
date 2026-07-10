@extends('layouts.admin', [
    'title' => $pageTitle . ' — Wagyu France',
    'sectionLabel' => 'Réserve professionnelle',
    'pageHeading' => $animal->exists ? 'Modifier un animal' : 'Préparer un animal',
    'bodyClass' => 'admin-animal-form-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Lancement d’une réserve</p>
            <h2>{{ $pageTitle }}</h2>
            <p>
                Définissez la référence, le seuil d’alerte et le calendrier. Les pièces pourront être ajustées
                séparément juste après la création.
            </p>
        </div>
        <a href="{{ route('admin.animals.index') }}" class="admin-secondary-button">Retour aux animaux</a>
    </header>

    <form
        method="POST"
        action="{{ $animal->exists ? route('admin.animals.update', $animal) : route('admin.animals.store') }}"
        class="admin-form-grid"
    >
        @csrf
        @if ($animal->exists)
            @method('PUT')
        @endif

        <section class="admin-form-card">
            <h3>Identification</h3>
            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Référence de l’animal *</span>
                    <input type="text" name="reference" value="{{ old('reference', $animal->reference) }}" placeholder="WF-2026-02" required>
                </label>

                <label class="admin-field">
                    <span>Nom interne *</span>
                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" placeholder="Réserve Wagyu France · 2026-02" required>
                </label>

                <label class="admin-field">
                    <span>Statut *</span>
                    <select name="status" required>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $animal->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="admin-field">
                    <span>Seuil d’alerte de lancement *</span>
                    <input type="number" min="1" max="100" name="launch_threshold_percent" value="{{ old('launch_threshold_percent', $animal->launch_threshold_percent) }}" required>
                </label>

                <label class="admin-field">
                    <span>Date d’ouverture</span>
                    <input type="datetime-local" name="opens_at" value="{{ old('opens_at', optional($animal->opens_at)->format('Y-m-d\TH:i')) }}">
                </label>

                <label class="admin-field">
                    <span>Découpe envisagée</span>
                    <input type="datetime-local" name="cutting_planned_at" value="{{ old('cutting_planned_at', optional($animal->cutting_planned_at)->format('Y-m-d\TH:i')) }}">
                </label>

                <label class="admin-field is-wide">
                    <span>Notes internes</span>
                    <textarea name="notes" rows="7" placeholder="Informations de suivi, contraintes de planning, observations...">{{ old('notes', $animal->notes) }}</textarea>
                </label>
            </div>
        </section>

        <aside class="admin-form-card">
            <h3>Publication & logique métier</h3>

            <label class="admin-switch">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $animal->is_active))>
                <span>Publier cet animal comme réserve active</span>
            </label>

            <div class="admin-form-side-note">
                <strong>Une seule réserve active à la fois.</strong><br>
                En publiant cet animal, l’ancienne réserve active sera automatiquement désactivée.
            </div>

            <div class="admin-form-side-note">
                <strong>Alerte à {{ old('launch_threshold_percent', $animal->launch_threshold_percent ?: 50) }} %.</strong><br>
                Dès que les demandes professionnelles atteignent le seuil choisi, une notification apparaît
                sur le tableau de bord pour préparer la découpe.
            </div>

            @unless ($animal->exists)
                <div class="admin-form-side-note">
                    <strong>Pièces préremplies.</strong><br>
                    Le nouvel animal reprendra automatiquement la configuration des pièces du dernier animal,
                    puis vous pourrez modifier chaque prix, volume et minimum séparément.
                </div>
            @endunless
        </aside>

        <div class="admin-form-actions">
            <button type="submit" class="admin-primary-button">
                {{ $animal->exists ? 'Enregistrer les modifications' : 'Créer l’animal et ses pièces' }}
            </button>
            <a href="{{ route('admin.animals.index') }}" class="admin-secondary-button">Annuler</a>
        </div>
    </form>

    @if ($animal->exists && ! $animal->is_active)
        <form method="POST" action="{{ route('admin.animals.destroy', $animal) }}" style="margin-top: 18px" onsubmit="return confirm('Supprimer cet animal et toutes ses pièces ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-danger-button">Supprimer définitivement cet animal</button>
        </form>
    @endif
@endsection

@extends('layouts.admin', [
    'title' => 'Animaux & réserve — Wagyu France',
    'sectionLabel' => 'Réserve professionnelle',
    'pageHeading' => 'Animaux & réserve',
    'bodyClass' => 'admin-animals-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Pilotage des lancements</p>
            <h2>Ouvrir une réserve, suivre le seuil, préparer la découpe.</h2>
            <p>
                Un seul animal peut être publié à la fois. Les anciennes réserves restent conservées
                pour l’historique et peuvent servir de modèle au lancement suivant.
            </p>
        </div>
        <a href="{{ route('admin.animals.create') }}" class="admin-primary-button">Préparer un animal</a>
    </header>

    @if ($activeSummary)
        <section class="admin-animal-active">
            <div>
                <p class="admin-kicker">Animal actuellement visible</p>
                <h3>{{ $activeSummary['batch']->reference }}</h3>
                <p>{{ $activeSummary['batch']->name }}</p>
                <div class="admin-panel-actions">
                    <a href="{{ route('admin.animals.show', $activeSummary['batch']) }}" class="admin-primary-button">Gérer les pièces</a>
                    <a href="{{ route('admin.animals.edit', $activeSummary['batch']) }}" class="admin-secondary-button">Modifier le lancement</a>
                    <a href="{{ route('reserve.pro') }}" target="_blank" class="admin-secondary-button">Voir côté client</a>
                </div>
            </div>

            <div class="admin-animal-score">
                <strong>{{ $activeSummary['progress'] }}%</strong>
                <span>{{ number_format($activeSummary['requested_kg'], 1, ',', ' ') }} kg demandés sur {{ number_format($activeSummary['available_kg'], 1, ',', ' ') }} kg</span>
                <div class="admin-progress" style="margin-top: 18px">
                    <span style="width: {{ $activeSummary['progress'] }}%"></span>
                </div>
                <span style="margin-top: 15px">Alerte de lancement à {{ $activeSummary['batch']->launch_threshold_percent }} %</span>
            </div>
        </section>
    @endif

    <section class="admin-animal-list">
        @forelse ($animals as $animal)
            <article class="admin-animal-row">
                <div>
                    <h3>{{ $animal->reference }}</h3>
                    <p>{{ $animal->name }}</p>
                </div>
                <div>
                    <span class="admin-status admin-status-{{ $animal->status }}">{{ $animal->status_label }}</span>
                    @if ($animal->is_active)
                        <span class="admin-status is-active">Publié</span>
                    @endif
                </div>
                <div>
                    <strong>{{ $animal->cuts_count }}</strong>
                    <small>pièces configurées</small>
                </div>
                <div>
                    <strong>Seuil {{ $animal->launch_threshold_percent }}%</strong>
                    <small>{{ $animal->opens_at ? 'Ouvert le ' . $animal->opens_at->format('d/m/Y') : 'Pas encore ouvert' }}</small>
                </div>
                <div class="admin-animal-row-actions">
                    <a href="{{ route('admin.animals.show', $animal) }}" class="admin-primary-button">Gérer</a>
                    <a href="{{ route('admin.animals.edit', $animal) }}" class="admin-secondary-button">Modifier</a>
                    @unless ($animal->is_active)
                        <form method="POST" action="{{ route('admin.animals.activate', $animal) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-secondary-button">Publier</button>
                        </form>
                    @endunless
                </div>
            </article>
        @empty
            <div class="admin-empty-state">
                Aucun animal n’est encore enregistré. Préparez le premier lancement pour ouvrir la réserve.
            </div>
        @endforelse
    </section>
@endsection

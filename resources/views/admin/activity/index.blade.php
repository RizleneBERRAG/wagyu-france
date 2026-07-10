@extends('layouts.admin', [
    'title' => 'Journal d’activité — Wagyu France',
    'sectionLabel' => 'Sécurité & traçabilité',
    'pageHeading' => 'Journal d’activité',
    'bodyClass' => 'admin-activity-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-users.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Traçabilité interne</p>
            <h2>Savoir qui a fait quoi, quand et sur quel dossier.</h2>
            <p>Les actions sensibles de l’administration sont conservées avec l’utilisateur, la date, la route et l’élément concerné.</p>
        </div>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card"><span>Aujourd’hui</span><strong>{{ $counts['today'] }}</strong><small>Actions enregistrées depuis minuit.</small></article>
        <article class="admin-stat-card"><span>7 derniers jours</span><strong>{{ $counts['week'] }}</strong><small>Mouvements administratifs récents.</small></article>
        <article class="admin-stat-card"><span>Utilisateurs actifs dans le journal</span><strong>{{ $counts['users'] }}</strong><small>Comptes ayant réalisé au moins une action.</small></article>
        <article class="admin-stat-card"><span>Total</span><strong>{{ $counts['total'] }}</strong><small>Historique conservé en base.</small></article>
    </section>

    <div class="admin-toolbar admin-activity-toolbar">
        <form method="GET" action="{{ route('admin.activity.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Action, référence, description…">
            <select name="user">
                <option value="">Tous les utilisateurs</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected((string) request('user') === (string) $user->id)>{{ $user->name }} · {{ $user->email }}</option>
                @endforeach
            </select>
            <select name="action">
                <option value="">Toutes les actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" @selected(request('action') === $action)>{{ $action }}</option>
                @endforeach
            </select>
            <input type="date" name="from" value="{{ request('from') }}" aria-label="Date de début">
            <input type="date" name="to" value="{{ request('to') }}" aria-label="Date de fin">
            <button type="submit" class="admin-primary-button">Filtrer</button>
            @if(request()->hasAny(['q', 'user', 'action', 'from', 'to']))
                <a href="{{ route('admin.activity.index') }}" class="admin-secondary-button">Réinitialiser</a>
            @endif
        </form>
    </div>

    <section class="admin-card admin-activity-card">
        <div class="admin-activity-log-list">
            @forelse($logs as $log)
                <article class="admin-activity-log-row">
                    <div class="admin-activity-log-dot"></div>
                    <div class="admin-activity-log-main">
                        <header>
                            <div>
                                <strong>{{ $log->description }}</strong>
                                <span>{{ $log->action }}</span>
                            </div>
                            <time datetime="{{ $log->created_at->toIso8601String() }}">{{ $log->created_at->format('d/m/Y à H:i:s') }}</time>
                        </header>

                        <div class="admin-activity-log-meta">
                            <span><b>Utilisateur</b> {{ $log->user?->name ?? 'Compte supprimé / système' }}</span>
                            @if($log->subject_label)
                                <span><b>Élément</b> {{ $log->subject_label }}</span>
                            @endif
                            @if($log->ip_address)
                                <span><b>IP</b> {{ $log->ip_address }}</span>
                            @endif
                        </div>

                        @if($log->properties)
                            <details>
                                <summary>Voir les détails techniques</summary>
                                <dl>
                                    @foreach($log->properties as $key => $value)
                                        <div>
                                            <dt>{{ str_replace('_', ' ', ucfirst($key)) }}</dt>
                                            <dd>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </details>
                        @endif
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">Aucune action ne correspond aux filtres sélectionnés.</div>
            @endforelse
        </div>
    </section>

    @if($logs->hasPages())
        <nav class="admin-user-pagination">
            {{ $logs->links() }}
        </nav>
    @endif
@endsection

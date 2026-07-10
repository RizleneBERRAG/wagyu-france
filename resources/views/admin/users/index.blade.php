@extends('layouts.admin', [
    'title' => 'Utilisateurs & permissions — Wagyu France',
    'sectionLabel' => 'Sécurité & équipe',
    'pageHeading' => 'Utilisateurs & permissions',
    'bodyClass' => 'admin-users-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-users.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Accès à l’administration</p>
            <h2>Une identité et les bons droits pour chaque membre de l’équipe.</h2>
            <p>Créez des comptes séparés, contrôlez leurs accès et désactivez immédiatement un utilisateur qui ne doit plus se connecter.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="admin-primary-button">Ajouter un utilisateur</a>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat-card"><span>Comptes</span><strong>{{ $counts['total'] }}</strong><small>Tous les utilisateurs enregistrés.</small></article>
        <article class="admin-stat-card"><span>Actifs</span><strong>{{ $counts['active'] }}</strong><small>Peuvent actuellement se connecter.</small></article>
        <article class="admin-stat-card"><span>Propriétaires actifs</span><strong>{{ $counts['owners'] }}</strong><small>Accès complet et gestion des comptes.</small></article>
        <article class="admin-stat-card"><span>Désactivés</span><strong>{{ $counts['inactive'] }}</strong><small>Accès bloqué, historique conservé.</small></article>
    </section>

    <section class="admin-user-grid">
        @forelse($users as $adminUser)
            <article class="admin-user-card {{ $adminUser->is_active ? '' : 'is-inactive' }}">
                <header>
                    <div class="admin-user-avatar">{{ mb_strtoupper(mb_substr($adminUser->name, 0, 1)) }}</div>
                    <div>
                        <p>{{ $adminUser->role_label }}</p>
                        <h3>{{ $adminUser->name }}</h3>
                        <span>{{ $adminUser->job_title ?: 'Fonction non renseignée' }}</span>
                    </div>
                    <span class="admin-user-state {{ $adminUser->is_active ? 'is-active' : 'is-inactive' }}">
                        {{ $adminUser->is_active ? 'Actif' : 'Désactivé' }}
                    </span>
                </header>

                <div class="admin-user-contact">
                    <a href="mailto:{{ $adminUser->email }}">{{ $adminUser->email }}</a>
                    <span>
                        Dernière connexion :
                        {{ $adminUser->last_login_at?->format('d/m/Y à H:i') ?? 'jamais' }}
                    </span>
                </div>

                <div class="admin-user-permissions">
                    @foreach($adminUser->effectivePermissions() as $permission)
                        <span>{{ \App\Models\User::PERMISSIONS[$permission] ?? $permission }}</span>
                    @endforeach
                </div>

                <footer>
                    <small>{{ $adminUser->activity_logs_count }} action(s) journalisée(s)</small>
                    <div>
                        <form method="POST" action="{{ route('admin.users.toggle', $adminUser) }}" onsubmit="return confirm('{{ $adminUser->is_active ? 'Désactiver ce compte ?' : 'Réactiver ce compte ?' }}');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-secondary-button">
                                {{ $adminUser->is_active ? 'Désactiver' : 'Réactiver' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.users.edit', $adminUser) }}" class="admin-primary-button">Modifier</a>
                    </div>
                </footer>
            </article>
        @empty
            <div class="admin-empty-state">Aucun utilisateur administrateur n’est enregistré.</div>
        @endforelse
    </section>

    @if($users->hasPages())
        <nav class="admin-user-pagination">
            {{ $users->links() }}
        </nav>
    @endif
@endsection

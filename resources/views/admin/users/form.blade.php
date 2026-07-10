@php
    $isEdit = $adminUser->exists;
    $selectedRole = old('role', $adminUser->role ?: 'manager');
    $selectedPermissions = old('permissions', $adminUser->effectivePermissions());
@endphp

@extends('layouts.admin', [
    'title' => ($isEdit ? 'Modifier un utilisateur' : 'Nouvel utilisateur') . ' — Wagyu France',
    'sectionLabel' => 'Sécurité & équipe',
    'pageHeading' => $isEdit ? $adminUser->name : 'Nouvel utilisateur',
    'bodyClass' => 'admin-user-form-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-users.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const role = document.querySelector('[data-user-role]');
    const boxes = [...document.querySelectorAll('[data-permission-box]')];
    const presets = @json($rolePresets);

    role?.addEventListener('change', () => {
        const selected = presets[role.value] || ['dashboard.view'];
        boxes.forEach((box) => {
            box.checked = role.value === 'owner' || selected.includes(box.value);
            box.disabled = role.value === 'owner';
        });
    });

    if (role?.value === 'owner') {
        boxes.forEach((box) => {
            box.checked = true;
            box.disabled = true;
        });
    }
});
</script>
@endpush

@section('content')
    <header class="admin-page-heading admin-user-form-heading">
        <div>
            <a href="{{ route('admin.users.index') }}" class="admin-back-link">← Retour aux utilisateurs</a>
            <p class="admin-kicker">{{ $isEdit ? 'Compte existant' : 'Création de compte' }}</p>
            <h2>{{ $isEdit ? 'Modifier les accès de ' . $adminUser->name . '.' : 'Donner uniquement les accès nécessaires.' }}</h2>
            <p>Les permissions sont vérifiées côté serveur. Masquer un menu ne suffit jamais à autoriser ou interdire une action.</p>
        </div>
    </header>

    <form
        method="POST"
        action="{{ $isEdit ? route('admin.users.update', $adminUser) : route('admin.users.store') }}"
        class="admin-user-form"
    >
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <section class="admin-card admin-user-form-section">
            <header><span>01</span><div><p class="admin-kicker">Identité</p><h3>Compte personnel</h3></div></header>

            <div class="admin-user-form-grid">
                <label>
                    <span>Nom complet *</span>
                    <input type="text" name="name" required value="{{ old('name', $adminUser->name) }}">
                </label>
                <label>
                    <span>Fonction</span>
                    <input type="text" name="job_title" value="{{ old('job_title', $adminUser->job_title) }}" placeholder="Commercial, responsable atelier…">
                </label>
                <label class="is-wide">
                    <span>Adresse email de connexion *</span>
                    <input type="email" name="email" required value="{{ old('email', $adminUser->email) }}" autocomplete="username">
                </label>
                <label>
                    <span>{{ $isEdit ? 'Nouveau mot de passe' : 'Mot de passe *' }}</span>
                    <input type="password" name="password" {{ $isEdit ? '' : 'required' }} minlength="12" autocomplete="new-password">
                    <small>{{ $isEdit ? 'Laissez vide pour conserver le mot de passe actuel.' : '12 caractères minimum.' }}</small>
                </label>
                <label>
                    <span>Confirmation {{ $isEdit ? 'du nouveau mot de passe' : '*' }}</span>
                    <input type="password" name="password_confirmation" {{ $isEdit ? '' : 'required' }} minlength="12" autocomplete="new-password">
                </label>
            </div>
        </section>

        <section class="admin-card admin-user-form-section">
            <header><span>02</span><div><p class="admin-kicker">Rôle</p><h3>Niveau de responsabilité</h3></div></header>

            <div class="admin-user-role-row">
                <label>
                    <span>Rôle principal *</span>
                    <select name="role" required data-user-role>
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" @selected($selectedRole === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="admin-user-active-toggle">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $adminUser->is_active ?? true))>
                    <span><strong>Compte actif</strong><small>Un compte désactivé est immédiatement déconnecté et ne peut plus se reconnecter.</small></span>
                </label>
            </div>
        </section>

        <section class="admin-card admin-user-form-section">
            <header><span>03</span><div><p class="admin-kicker">Permissions</p><h3>Sections accessibles</h3></div></header>

            <p class="admin-user-permission-help">
                Changer de rôle applique automatiquement un ensemble conseillé. Les cases peuvent ensuite être adaptées, sauf pour le propriétaire qui possède toujours tous les droits.
            </p>

            <div class="admin-user-permission-grid">
                @foreach($permissions as $value => $label)
                    <label>
                        <input
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $value }}"
                            data-permission-box
                            @checked(in_array($value, $selectedPermissions, true) || $selectedRole === 'owner')
                            @disabled($selectedRole === 'owner')
                        >
                        <span><strong>{{ $label }}</strong><small>{{ $value }}</small></span>
                    </label>
                @endforeach
            </div>
        </section>

        <div class="admin-user-form-submit">
            <div>
                <strong>{{ $isEdit ? 'Enregistrer les changements' : 'Créer le compte' }}</strong>
                <p>Les nouvelles permissions seront appliquées dès la requête suivante.</p>
            </div>
            <button type="submit" class="admin-primary-button">
                {{ $isEdit ? 'Mettre à jour l’utilisateur' : 'Créer l’utilisateur' }}
            </button>
        </div>
    </form>
@endsection

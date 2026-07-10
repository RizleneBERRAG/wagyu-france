@extends('layouts.app', [
    'title' => 'Connexion admin — Wagyu France',
    'bodyClass' => 'admin-login-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-auth.css') }}">
@endpush

@section('content')
    <section class="admin-login-section">
        <div class="admin-login-glow"></div>

        <form method="POST" action="{{ route('admin.authenticate') }}" class="admin-login-card">
            @csrf

            <p class="eyebrow">Administration interne</p>

            <h1>
                Connexion
                <span>Wagyu France.</span>
            </h1>

            <p>
                Connectez-vous avec votre compte personnel pour accéder aux outils autorisés.
            </p>

            @unless($accountReady)
                <div class="admin-login-error">
                    Aucun compte administrateur actif n’existe encore. Renseignez WF_ADMIN_EMAIL et WF_ADMIN_PASSWORD avant d’exécuter la migration.
                </div>
            @endunless

            <label>
                <span>Adresse email</span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="vous@wagyufrance.fr"
                    autocomplete="username"
                    required
                    autofocus
                >
            </label>

            <label>
                <span>Mot de passe</span>
                <input
                    type="password"
                    name="password"
                    placeholder="Votre mot de passe"
                    autocomplete="current-password"
                    required
                >
            </label>

            @if($errors->any())
                <div class="admin-login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" @disabled(! $accountReady)>
                Entrer dans l’administration
            </button>
        </form>
    </section>
@endsection

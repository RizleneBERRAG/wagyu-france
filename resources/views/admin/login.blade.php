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
                Accédez au suivi des demandes boutique et professionnelles.
            </p>

            <label>
                <span>Mot de passe admin</span>

                <input
                    type="password"
                    name="password"
                    placeholder="Votre mot de passe"
                    required
                    autofocus
                >
            </label>

            @error('password')
            <div class="admin-login-error">
                {{ $message }}
            </div>
            @enderror

            <button type="submit">
                Entrer dans l’admin
            </button>
        </form>
    </section>

@endsection

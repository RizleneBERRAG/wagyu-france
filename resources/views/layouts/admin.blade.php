<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Administration — Wagyu France' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-panel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-requests.css') }}">
    @stack('styles')
</head>
<body class="wf-admin-body {{ $bodyClass ?? '' }}">
<div class="wf-admin-shell" data-admin-shell>
    <div class="wf-admin-backdrop" data-admin-backdrop></div>

    <aside class="wf-admin-sidebar" data-admin-sidebar>
        <div class="wf-admin-brand">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
            <div>
                <strong>Wagyu France</strong>
                <span>Administration</span>
            </div>
            <button type="button" class="wf-admin-sidebar-close" data-admin-close aria-label="Fermer le menu">×</button>
        </div>

        <nav class="wf-admin-nav" aria-label="Administration principale">
            <p>Pilotage</p>
            <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>
                <span class="wf-admin-nav-icon">⌂</span>
                <strong>Tableau de bord</strong>
            </a>

            <p>Commerce</p>
            <a href="{{ route('admin.products.index') }}" @class(['is-active' => request()->routeIs('admin.products.*')])>
                <span class="wf-admin-nav-icon">▦</span>
                <strong>Produits boutique</strong>
                @if (($adminNavigationCounts['low_stock'] ?? 0) > 0)
                    <b class="is-warning">{{ $adminNavigationCounts['low_stock'] }}</b>
                @endif
            </a>
            <a href="{{ route('admin.animals.index') }}" @class(['is-active' => request()->routeIs('admin.animals.*')])>
                <span class="wf-admin-nav-icon">◈</span>
                <strong>Animaux & réserve</strong>
            </a>
            <a href="{{ route('admin.demandes') }}" @class(['is-active' => request()->routeIs('admin.demandes*') && request('section') !== 'contacts'])>
                <span class="wf-admin-nav-icon">≡</span>
                <strong>Commandes & demandes</strong>
                @if (($adminNavigationCounts['orders'] ?? 0) > 0)
                    <b>{{ $adminNavigationCounts['orders'] }}</b>
                @endif
            </a>
            <a href="{{ route('admin.demandes', ['section' => 'contacts']) }}" @class(['is-active' => request()->routeIs('admin.demandes*') && request('section') === 'contacts'])>
                <span class="wf-admin-nav-icon">✉</span>
                <strong>Messages</strong>
                @if (($adminNavigationCounts['contacts'] ?? 0) > 0)
                    <b>{{ $adminNavigationCounts['contacts'] }}</b>
                @endif
            </a>

            <p>Configuration</p>
            <a href="{{ route('admin.settings.index') }}" @class(['is-active' => request()->routeIs('admin.settings.*')])>
                <span class="wf-admin-nav-icon">⚙</span>
                <strong>Paramètres du site</strong>
            </a>

            <p>Site</p>
            <a href="{{ route('boutique') }}" target="_blank" rel="noopener">
                <span class="wf-admin-nav-icon">↗</span>
                <strong>Voir la boutique</strong>
            </a>
            <a href="{{ route('reserve.pro') }}" target="_blank" rel="noopener">
                <span class="wf-admin-nav-icon">↗</span>
                <strong>Voir la réserve</strong>
            </a>
        </nav>

        <div class="wf-admin-sidebar-footer">
            <div>
                <span>Session active</span>
                <strong>Gestionnaire Wagyu France</strong>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    </aside>

    <div class="wf-admin-main">
        <header class="wf-admin-topbar">
            <button type="button" class="wf-admin-menu-button" data-admin-open aria-label="Ouvrir le menu">
                <span></span><span></span><span></span>
            </button>

            <div>
                <p>{{ $sectionLabel ?? 'Administration' }}</p>
                <h1>{{ $pageHeading ?? 'Tableau de bord' }}</h1>
            </div>

            <div class="wf-admin-topbar-actions">
                <a href="{{ route('home') }}" target="_blank" rel="noopener">Voir le site</a>
                <span class="wf-admin-alert-dot" title="{{ ($adminNavigationCounts['orders'] ?? 0) + ($adminNavigationCounts['contacts'] ?? 0) }} élément(s) nouveau(x)">
                    {{ ($adminNavigationCounts['orders'] ?? 0) + ($adminNavigationCounts['contacts'] ?? 0) }}
                </span>
            </div>
        </header>

        <main class="wf-admin-content">
            @if (session('success'))
                <div class="wf-admin-flash is-success">
                    <span>✓</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="wf-admin-flash is-error">
                    <span>!</span>
                    <div>
                        <strong>Certains éléments doivent être corrigés.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('assets/js/admin-panel.js') }}" defer></script>
@stack('scripts')
</body>
</html>
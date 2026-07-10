<header class="wf-site-header" data-site-header>
    <div class="wf-topbar">
        <div class="wf-header-container wf-topbar-inner">
            <p>
                <span class="wf-topbar-dot" aria-hidden="true"></span>
                Livraison réfrigérée en France métropolitaine
            </p>

            <div class="wf-topbar-links">
                <a href="{{ route('contact') }}">Nous contacter</a>
                <a href="{{ route('professionnels') }}">Espace professionnels</a>
            </div>
        </div>
    </div>

    <div class="wf-mainbar">
        <div class="wf-header-container wf-mainbar-inner">
            <button
                class="wf-menu-button"
                type="button"
                data-menu-open
                aria-label="Ouvrir le menu"
                aria-expanded="false"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

            <a href="{{ route('home') }}" class="wf-header-brand" aria-label="Retour à l’accueil Wagyu France">
                <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
                <span>
                    <strong>Wagyu France</strong>
                    <small>Élevage & viande d’exception</small>
                </span>
            </a>

            <nav class="wf-header-nav" aria-label="Navigation principale">
                <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Accueil</a>
                <a href="{{ route('boutique') }}" @class(['is-active' => request()->routeIs('boutique')])>La boutique</a>
                <a href="{{ route('wagyu') }}" @class(['is-active' => request()->routeIs('wagyu')])>Le Wagyu</a>
                <a href="{{ route('histoire') }}" @class(['is-active' => request()->routeIs('histoire')])>Notre histoire</a>
                <a href="{{ route('blog') }}" @class(['is-active' => request()->routeIs('blog')])>Conseils</a>
            </nav>

            <div class="wf-header-actions">
                <a href="{{ route('professionnels') }}" class="wf-pro-link">
                    Professionnels
                </a>

                <button class="wf-cart-button" type="button" data-cart-open aria-label="Ouvrir le panier">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 4h2l1.7 9.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20 7H6.1M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
                    </svg>
                    <span>Panier</span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="wf-menu-overlay" data-menu-backdrop aria-hidden="true"></div>

<aside class="wf-menu-drawer" data-menu-drawer aria-hidden="true">
    <div class="wf-menu-head">
        <a href="{{ route('home') }}" class="wf-menu-brand">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
            <span>
                <strong>Wagyu France</strong>
                <small>Élevage & viande d’exception</small>
            </span>
        </a>

        <button type="button" data-menu-close aria-label="Fermer le menu">×</button>
    </div>

    <nav class="wf-mobile-nav" aria-label="Navigation mobile">
        <a href="{{ route('home') }}">Accueil</a>
        <a href="{{ route('boutique') }}">La boutique</a>
        <a href="{{ route('wagyu') }}">Découvrir le Wagyu</a>
        <a href="{{ route('histoire') }}">Notre histoire</a>
        <a href="{{ route('blog') }}">Conseils & actualités</a>
        <a href="{{ route('contact') }}">Nous contacter</a>
    </nav>

    <div class="wf-mobile-pro-card">
        <p>Vous êtes restaurateur, boucher ou chef ?</p>
        <strong>Un espace professionnel vous est dédié.</strong>
        <a href="{{ route('professionnels') }}">Accéder à l’espace pro</a>
    </div>
</aside>

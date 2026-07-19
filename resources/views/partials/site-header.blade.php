@php
    $isProUniverse = request()->routeIs(
        'professionnels',
        'reserve.pro',
        'decoupe-volumes',
        'tracabilite'
    );
@endphp

<header class="wf-site-header {{ $isProUniverse ? 'is-pro-universe' : 'is-private-universe' }}" data-site-header>
    <div class="wf-topbar">
        <div class="wf-header-container wf-topbar-inner">
            <p>
                <span class="wf-topbar-dot" aria-hidden="true"></span>
                @if ($isProUniverse)
                    Sélection professionnelle · Pré-réservation étudiée par la maison
                @else
                    Livraison réfrigérée en France métropolitaine
                @endif
            </p>

            <div class="wf-topbar-links">
                <a href="{{ route('contact') }}">Nous contacter</a>
                <a href="{{ $isProUniverse ? route('home') : route('professionnels') }}">
                    {{ $isProUniverse ? 'Univers particuliers' : 'Espace professionnels' }}
                </a>
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

            <a
                href="{{ $isProUniverse ? route('professionnels') : route('home') }}"
                class="wf-header-brand"
                aria-label="{{ $isProUniverse ? 'Accueil de l’espace professionnel Wagyu France' : 'Retour à l’accueil Wagyu France' }}"
            >
                <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
                <span>
                    <strong>Wagyu France</strong>
                    <small>{{ $isProUniverse ? 'Sélection professionnelle' : 'Élevage & viande d’exception' }}</small>
                </span>
            </a>

            <nav class="wf-header-nav" aria-label="{{ $isProUniverse ? 'Navigation professionnelle' : 'Navigation principale' }}">
                @if ($isProUniverse)
                    <a href="{{ route('professionnels') }}" @class(['is-active' => request()->routeIs('professionnels')])>
                        Vue d’ensemble
                    </a>
                    <a href="{{ route('reserve.pro') }}" @class(['is-active' => request()->routeIs('reserve.pro')])>
                        Réserve
                    </a>
                    <a href="{{ route('decoupe-volumes') }}" @class(['is-active' => request()->routeIs('decoupe-volumes')])>
                        Découpe & volumes
                    </a>
                    <a href="{{ route('tracabilite') }}" @class(['is-active' => request()->routeIs('tracabilite')])>
                        Traçabilité
                    </a>
                @else
                    <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Accueil</a>
                    <a href="{{ route('boutique') }}" @class(['is-active' => request()->routeIs('boutique')])>La boutique</a>
                    <a href="{{ route('wagyu') }}" @class(['is-active' => request()->routeIs('wagyu')])>Le Wagyu</a>
                    <a href="{{ route('histoire') }}" @class(['is-active' => request()->routeIs('histoire')])>Notre histoire</a>
                    <a href="{{ route('blog') }}" @class(['is-active' => request()->routeIs('blog')])>Conseils</a>
                @endif
            </nav>

            <div class="wf-header-actions">
                <div class="wf-universe-switch" aria-label="Changer d’univers">
                    <a
                        href="{{ route('home') }}"
                        @class(['is-active' => ! $isProUniverse])
                        @if (! $isProUniverse) aria-current="page" @endif
                    >
                        Particuliers
                    </a>
                    <a
                        href="{{ route('professionnels') }}"
                        @class(['is-active' => $isProUniverse])
                        @if ($isProUniverse) aria-current="page" @endif
                    >
                        Professionnels
                    </a>
                </div>

                @if (request()->routeIs('boutique'))
                    <button class="wf-cart-button" type="button" data-shop-cart-open aria-label="Ouvrir le panier de la boutique">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 4h2l1.7 9.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20 7H6.1M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
                        </svg>
                        <span>Panier</span>
                    </button>
                @elseif (request()->routeIs('reserve.pro'))
                    <button class="wf-cart-button" type="button" data-cart-open aria-label="Ouvrir la sélection professionnelle">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 6h16M7 3v6m10-6v6M5 10h14l-1 10H6L5 10Z"/>
                        </svg>
                        <span>Ma sélection</span>
                    </button>
                @elseif ($isProUniverse)
                    <a href="{{ route('reserve.pro') }}" class="wf-cart-button wf-reserve-link">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 6h16M7 3v6m10-6v6M5 10h14l-1 10H6L5 10Z"/>
                        </svg>
                        <span>Réserve pro</span>
                    </a>
                @else
                    <button class="wf-cart-button" type="button" data-cart-open aria-label="Ouvrir le panier">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 4h2l1.7 9.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20 7H6.1M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
                        </svg>
                        <span>Panier</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</header>

<div class="wf-menu-overlay" data-menu-backdrop aria-hidden="true"></div>

<aside class="wf-menu-drawer {{ $isProUniverse ? 'is-pro-universe' : 'is-private-universe' }}" data-menu-drawer aria-hidden="true">
    <div class="wf-menu-head">
        <a href="{{ $isProUniverse ? route('professionnels') : route('home') }}" class="wf-menu-brand">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
            <span>
                <strong>Wagyu France</strong>
                <small>{{ $isProUniverse ? 'Sélection professionnelle' : 'Élevage & viande d’exception' }}</small>
            </span>
        </a>

        <button type="button" data-menu-close aria-label="Fermer le menu">×</button>
    </div>

    <div class="wf-mobile-universe-switch" aria-label="Changer d’univers">
        <a href="{{ route('home') }}" @class(['is-active' => ! $isProUniverse])>Particuliers</a>
        <a href="{{ route('professionnels') }}" @class(['is-active' => $isProUniverse])>Professionnels</a>
    </div>

    <nav class="wf-mobile-nav" aria-label="{{ $isProUniverse ? 'Navigation professionnelle mobile' : 'Navigation mobile' }}">
        @if ($isProUniverse)
            <a href="{{ route('professionnels') }}">Vue d’ensemble</a>
            <a href="{{ route('reserve.pro') }}">Réserve professionnelle</a>
            <a href="{{ route('decoupe-volumes') }}">Découpe & volumes</a>
            <a href="{{ route('tracabilite') }}">Traçabilité</a>
        @else
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('boutique') }}">La boutique</a>
            <a href="{{ route('wagyu') }}">Découvrir le Wagyu</a>
            <a href="{{ route('histoire') }}">Notre histoire</a>
            <a href="{{ route('blog') }}">Conseils & actualités</a>
            <a href="{{ route('contact') }}">Nous contacter</a>
        @endif
    </nav>

    <div class="wf-mobile-pro-card">
        @if ($isProUniverse)
            <p>Vous souhaitez commander pour vous-même&nbsp;?</p>
            <strong>Retrouvez la boutique et les conseils destinés aux particuliers.</strong>
            <a href="{{ route('home') }}">Revenir à l’univers particulier</a>
        @else
            <p>Vous êtes restaurateur, boucher ou chef&nbsp;?</p>
            <strong>Un espace professionnel vous est dédié.</strong>
            <a href="{{ route('professionnels') }}">Accéder à l’espace pro</a>
        @endif
    </div>
</aside>
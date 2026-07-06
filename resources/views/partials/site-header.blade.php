<header class="wf-site-header" data-site-header>
    <div class="wf-header-shell">

        <a href="{{ url('/') }}" class="wf-header-brand" aria-label="Retour à l'accueil Wagyu France">
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
            <span>
                <strong>Wagyu France</strong>
                <small data-universe-subtitle>Maison d’exception</small>
            </span>
        </a>

        <nav class="wf-header-nav" aria-label="Navigation principale">
            <div class="wf-nav-set is-active" data-nav-set="particulier">
                <a href="{{ url('/') }}?univers=particulier">Accueil</a>
                <a href="{{ url('/boutique') }}">Boutique</a>
                <a href="{{ url('/le-wagyu') }}">Le Wagyu</a>
                <a href="{{ url('/histoire') }}">Maison</a>
                <a href="{{ url('/contact') }}">Contact</a>
            </div>

            <div class="wf-nav-set" data-nav-set="pro">
                <a href="{{ url('/') }}?univers=pro">Accueil pro</a>
                <a href="{{ url('/reserve-professionnelle') }}">Réserve pro</a>
                <a href="{{ url('/decoupe-volumes') }}">Découpe & volumes</a>
                <a href="{{ url('/tracabilite') }}">Traçabilité</a>
                <a href="{{ url('/contact') }}">Contact pro</a>
            </div>
        </nav>

        <div class="wf-header-actions">

            <div class="wf-universe-switch" data-universe-switch>
                <button type="button" class="is-active" data-universe-choice="particulier">
                    Particulier
                </button>

                <button type="button" data-universe-choice="pro">
                    Pro
                </button>

                <span class="wf-switch-indicator"></span>
            </div>

            <a href="{{ url('/boutique') }}" class="wf-header-cta" data-main-cta>
                Commander
            </a>

            <button class="wf-menu-button" type="button" data-menu-open aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
            </button>
        </div>

    </div>
</header>

<div class="wf-universe-wipe" data-universe-wipe>
    <span></span>
    <strong data-wipe-label>Particulier</strong>
</div>

<div class="wf-menu-overlay" data-menu-overlay></div>

<aside class="wf-menu-drawer" data-menu-drawer aria-hidden="true">
    <div class="wf-menu-head">
        <div>
            <p class="eyebrow">Navigation</p>
            <h2 data-menu-title>Univers particulier</h2>
        </div>

        <button type="button" data-menu-close aria-label="Fermer le menu">
            ×
        </button>
    </div>

    <div class="wf-mobile-universe-tabs">
        <button type="button" class="is-active" data-universe-choice="particulier">
            Particulier
        </button>

        <button type="button" data-universe-choice="pro">
            Professionnel
        </button>
    </div>

    <div class="wf-menu-body">

        <div class="wf-menu-column is-active" data-menu-panel="particulier">
            <a href="{{ url('/') }}">
                <span>01</span>
                <strong>Accueil</strong>
                <small>Entrer dans l’univers Wagyu France.</small>
            </a>

            <a href="{{ url('/boutique') }}">
                <span>02</span>
                <strong>Boutique</strong>
                <small>Découvrir les pièces disponibles pour particuliers.</small>
            </a>

            <a href="{{ url('/le-wagyu') }}">
                <span>03</span>
                <strong>Le goût du Wagyu</strong>
                <small>Comprendre le persillage, la tendreté et l’expérience en bouche.</small>
            </a>

            <a href="{{ url('/histoire') }}">
                <span>04</span>
                <strong>Maison Wagyu France</strong>
                <small>Origine, terroir, patience et exigence.</small>
            </a>

            <a href="{{ url('/contact') }}">
                <span>05</span>
                <strong>Contact</strong>
                <small>Échanger avec la maison.</small>
            </a>
        </div>

        <div class="wf-menu-column" data-menu-panel="pro">
            <a href="{{ url('/professionnels') }}">
                <span>01</span>
                <strong>Univers professionnel</strong>
                <small>Un parcours pensé pour chefs, restaurants et boucheries.</small>
            </a>

            <a href="{{ url('/reserve-professionnelle') }}">
                <span>02</span>
                <strong>Réserve professionnelle</strong>
                <small>Pré-réserver les pièces directement sur l’animal.</small>
            </a>

            <a href="{{ url('/decoupe-volumes') }}">
                <span>03</span>
                <strong>Découpe & volumes</strong>
                <small>Organiser les besoins avant mise en préparation.</small>
            </a>

            <a href="{{ url('/tracabilite') }}">
                <span>04</span>
                <strong>Traçabilité</strong>
                <small>Origine, suivi, sélection et informations produit.</small>
            </a>

            <a href="{{ url('/contact') }}">
                <span>05</span>
                <strong>Contact pro</strong>
                <small>Demander un échange ou un accès professionnel.</small>
            </a>
        </div>

        <div class="wf-menu-universe-card">
            <p class="eyebrow" data-menu-card-eyebrow>Univers particulier</p>

            <h3 data-menu-card-title>
                Une expérience pensée pour découvrir, choisir et savourer.
            </h3>

            <p data-menu-card-text>
                Un parcours plus chaleureux, plus sensoriel, orienté dégustation,
                boutique et découverte de la maison.
            </p>

            <a href="{{ url('/boutique') }}" data-menu-card-link>
                Découvrir la boutique
            </a>
        </div>

    </div>
</aside>

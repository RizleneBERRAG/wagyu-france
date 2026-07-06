@extends('layouts.app', [
    'title' => 'Wagyu France — Viande Wagyu d’exception',
    'bodyClass' => 'home-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/home-mobile.js') }}" defer></script>
@endpush

@section('content')

    <section class="home-universe home-private-universe" data-home-universe="particulier">

        <div class="home-private-hero">
            <img
                class="home-hero-bg home-private-hero-bg"
                src="{{ asset('assets/images/wagyu/home-private-hero.jpg') }}"
                alt="Table de dégustation Wagyu France"
            >

            <div class="home-hero-overlay"></div>

            <div class="home-private-glow home-private-glow-left"></div>
            <div class="home-private-glow home-private-glow-right"></div>

            <div class="home-private-inner">
                <div class="home-kicker">
                    <span></span>
                    <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
                    <span></span>
                </div>

                <p class="eyebrow">Maison Wagyu France</p>

                <h1>
                    Le Wagyu français,
                    <span>dans toute sa noblesse.</span>
                </h1>

                <p class="home-private-lead">
                    Une viande rare, née du temps, de l’origine et d’une exigence d’élevage.
                    Wagyu France propose aux amateurs éclairés une expérience plus lisible,
                    plus élégante et plus proche du terroir.
                </p>

                <div class="home-private-actions">
                    <a href="{{ route('boutique') }}" class="home-primary-button">
                        Découvrir la boutique
                    </a>

                    <a href="{{ route('histoire') }}" class="home-secondary-button">
                        Lire notre histoire
                    </a>
                </div>

                <div class="home-private-proof">
                    <article>
                        <strong>Origine</strong>
                        <span>Domaine du Tilleul</span>
                    </article>

                    <article>
                        <strong>Approche</strong>
                        <span>Temps long & sélection</span>
                    </article>

                    <article>
                        <strong>Expérience</strong>
                        <span>Pièces d’exception</span>
                    </article>
                </div>
            </div>
        </div>

        <section class="home-private-intro">
            <div class="home-section-heading">
                <p class="eyebrow">Pour les particuliers</p>

                <h2>
                    Une expérience pensée pour choisir,
                    cuisiner et savourer autrement.
                </h2>

                <p>
                    Wagyu France accompagne celles et ceux qui recherchent une viande plus rare,
                    plus fondante et plus expressive, sans perdre le sens de son origine.
                </p>
            </div>

            <div class="home-private-cards">
                <article>
                    <span>01</span>
                    <h3>Choisir sa pièce</h3>
                    <p>
                        Entrecôte, filet, faux-filet, rumsteak ou pièces plus confidentielles :
                        chaque morceau répond à un usage et une intensité différente.
                    </p>
                </article>

                <article>
                    <span>02</span>
                    <h3>Comprendre le goût</h3>
                    <p>
                        Le persillage, la tendreté et la longueur en bouche donnent au Wagyu
                        une expérience singulière, loin d’une viande ordinaire.
                    </p>
                </article>

                <article>
                    <span>03</span>
                    <h3>Recevoir l’exception</h3>
                    <p>
                        La boutique devient un parcours simple et premium pour commander
                        une viande rare avec clarté et confiance.
                    </p>
                </article>
            </div>
        </section>

        <section class="home-private-showcase">
            <div class="home-showcase-card">
                <div>
                    <p class="eyebrow">Le goût du Wagyu</p>

                    <h2>
                        Une texture fondante,
                        un marbrage remarquable.
                    </h2>

                    <p>
                        Le Wagyu se distingue par son persillage, cette finesse du gras
                        intramusculaire qui apporte tendreté, jutosité et profondeur aromatique.
                        Une viande faite pour être dégustée avec attention.
                    </p>

                    <a href="{{ route('wagyu') }}">
                        Comprendre le Wagyu
                    </a>
                </div>

                <div class="home-showcase-visual">
                    <img
                        src="{{ asset('assets/images/wagyu/marbrage-showcase.jpg') }}"
                        alt="Marbrage d'une pièce de Wagyu"
                    >

                    <div>
                        <span>Wagyu</span>
                        <strong>Marbrage</strong>
                        <i>Texture · Tendreté · Longueur</i>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-private-products">
            <div class="home-section-heading">
                <p class="eyebrow">Sélection</p>

                <h2>
                    Des pièces pensées pour une dégustation d’exception.
                </h2>
            </div>

            <div class="home-product-grid">
                <article>
                    <div class="home-product-visual">
                        <img
                            src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}"
                            alt="Entrecôte Wagyu"
                        >
                    </div>

                    <p>Pièce noble</p>
                    <h3>Entrecôte Wagyu</h3>
                    <span>Intense, fondante, généreuse.</span>
                    <a href="{{ route('boutique') }}">Voir en boutique</a>
                </article>

                <article>
                    <div class="home-product-visual">
                        <img
                            src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}"
                            alt="Filet Wagyu"
                        >
                    </div>

                    <p>Grande tendreté</p>
                    <h3>Filet Wagyu</h3>
                    <span>Précis, élégant, rare.</span>
                    <a href="{{ route('boutique') }}">Voir en boutique</a>
                </article>

                <article>
                    <div class="home-product-visual">
                        <img
                            src="{{ asset('assets/images/boutique/rumsteak-wagyu.jpg') }}"
                            alt="Rumsteak Wagyu"
                        >
                    </div>

                    <p>Caractère</p>
                    <h3>Rumsteak Wagyu</h3>
                    <span>Goût franc, belle longueur.</span>
                    <a href="{{ route('boutique') }}">Voir en boutique</a>
                </article>
            </div>
        </section>

        <section class="home-private-cta">
            <div>
                <p class="eyebrow">Wagyu France</p>

                <h2>
                    Une viande rare mérite un parcours à sa hauteur.
                </h2>

                <p>
                    Découvrez la boutique ou entrez dans l’histoire d’une maison française
                    dédiée à la sélection, au temps et à la qualité.
                </p>

                <div>
                    <a href="{{ route('boutique') }}" class="home-primary-button">
                        Voir les produits
                    </a>

                    <a href="{{ route('histoire') }}" class="home-secondary-button">
                        Découvrir la maison
                    </a>
                </div>
            </div>
        </section>

    </section>

    <section class="home-universe home-pro-universe" data-home-universe="pro">

        <div class="home-pro-hero">
            <img
                class="home-hero-bg home-pro-hero-bg"
                src="{{ asset('assets/images/pro/home-pro-hero.jpg') }}"
                alt="Préparation professionnelle de pièces Wagyu"
            >

            <div class="home-pro-hero-overlay"></div>

            <div class="home-pro-grid-bg"></div>
            <div class="home-pro-red-glow"></div>
            <div class="home-pro-gold-glow"></div>

            <div class="home-pro-inner">
                <div class="home-pro-left">
                    <p class="eyebrow">Univers professionnel</p>

                    <h1>
                        Réserver avant découpe.
                        <span>Valoriser chaque pièce.</span>
                    </h1>

                    <p>
                        Un parcours pensé pour les chefs, restaurants, bouchers et partenaires
                        professionnels qui veulent sécuriser leurs volumes, choisir leurs pièces
                        et travailler une viande Wagyu avec plus de visibilité.
                    </p>

                    <div class="home-pro-actions">
                        <a href="{{ route('reserve.pro') }}" class="home-pro-primary">
                            Accéder à la réserve pro
                        </a>

                        <a href="{{ route('professionnels') }}" class="home-pro-secondary">
                            Découvrir l’espace pro
                        </a>
                    </div>
                </div>

                <div class="home-pro-panel">
                    <div class="home-pro-panel-image">
                        <img
                            src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                            alt="Réserve professionnelle Wagyu France"
                        >
                    </div>

                    <div class="home-pro-panel-head">
                        <span>WF-2026-01</span>
                        <strong>Animal en pré-réservation</strong>
                    </div>

                    <div class="home-pro-progress">
                        <div>
                            <span>Réservé</span>
                            <strong>68%</strong>
                        </div>

                        <i>
                            <b style="width: 68%"></b>
                        </i>
                    </div>

                    <div class="home-pro-cuts">
                        <article>
                            <span>Entrecôte</span>
                            <strong>8,5 kg</strong>
                        </article>

                        <article>
                            <span>Filet</span>
                            <strong>4,2 kg</strong>
                        </article>

                        <article>
                            <span>Rumsteak</span>
                            <strong>6,4 kg</strong>
                        </article>

                        <article>
                            <span>Jarret</span>
                            <strong>4,9 kg</strong>
                        </article>
                    </div>

                    <a href="{{ route('reserve.pro') }}">
                        Ouvrir la carte de découpe
                    </a>
                </div>
            </div>
        </div>

        <section class="home-pro-process">
            <div class="home-pro-heading">
                <p class="eyebrow">Méthode professionnelle</p>

                <h2>
                    Un système pensé pour organiser la demande avant la mise en découpe.
                </h2>

                <p>
                    La réserve professionnelle permet d’éviter l’aléatoire : les pièces sont
                    sélectionnées, les volumes sont suivis, et la découpe peut être lancée
                    lorsque la demande atteint le bon niveau.
                </p>
            </div>

            <div class="home-pro-steps">
                <article>
                    <span>01</span>
                    <h3>Accès pro</h3>
                    <p>
                        Le professionnel entre dans un parcours dédié, distinct de la boutique particulier.
                    </p>
                </article>

                <article>
                    <span>02</span>
                    <h3>Sélection sur l’animal</h3>
                    <p>
                        Les morceaux sont choisis directement depuis une carte interactive claire.
                    </p>
                </article>

                <article>
                    <span>03</span>
                    <h3>Pré-réservation</h3>
                    <p>
                        Les quantités sont ajoutées au panier pro avec total estimatif HT.
                    </p>
                </article>

                <article>
                    <span>04</span>
                    <h3>Confirmation</h3>
                    <p>
                        Wagyu France confirme les disponibilités, les volumes et les modalités.
                    </p>
                </article>
            </div>
        </section>

        <section class="home-pro-split">
            <div class="home-pro-split-card">
                <div>
                    <p class="eyebrow">Chefs & restaurateurs</p>

                    <h2>
                        Plus de précision pour travailler une matière première rare.
                    </h2>

                    <p>
                        L’univers professionnel met l’accent sur la lisibilité : pièce,
                        quantité, disponibilité, usage culinaire et valeur estimative.
                        L’objectif est de permettre aux professionnels de construire
                        leurs menus ou leurs offres avec plus de maîtrise.
                    </p>

                    <a href="{{ route('reserve.pro') }}">
                        Pré-réserver des pièces
                    </a>
                </div>

                <div class="home-pro-metrics">
                    <article>
                        <strong>7</strong>
                        <span>pièces suivies</span>
                    </article>

                    <article>
                        <strong>HT</strong>
                        <span>lecture pro</span>
                    </article>

                    <article>
                        <strong>68%</strong>
                        <span>seuil animal</span>
                    </article>
                </div>
            </div>
        </section>

        <section class="home-pro-features">
            <div class="home-pro-heading">
                <p class="eyebrow">Espace pro</p>

                <h2>
                    Deux univers, une même exigence.
                </h2>
            </div>

            <div class="home-pro-feature-grid">
                <article>
                    <h3>Réserve interactive</h3>
                    <p>
                        Visualisation de l’animal, choix des pièces, quantités et panier professionnel.
                    </p>
                </article>

                <article>
                    <h3>Découpe & volumes</h3>
                    <p>
                        Une approche pensée pour mieux organiser les besoins avant préparation.
                    </p>
                </article>

                <article>
                    <h3>Traçabilité</h3>
                    <p>
                        Un parcours orienté origine, sélection et informations utiles aux professionnels.
                    </p>
                </article>
            </div>
        </section>

        <section class="home-pro-cta">
            <div>
                <p class="eyebrow">Réserve professionnelle</p>

                <h2>
                    Construire la demande avant de lancer la découpe.
                </h2>

                <p>
                    Accédez à l’interface professionnelle et sélectionnez vos pièces
                    directement sur l’animal.
                </p>

                <a href="{{ route('reserve.pro') }}">
                    Accéder à la réserve pro
                </a>
            </div>
        </section>

    </section>

@endsection

@extends('layouts.app', [
    'title' => 'Le Wagyu — Wagyu France',
    'bodyClass' => 'wagyu-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/wagyu.css') }}">
@endpush

@section('content')

    <section class="wagyu-hero">
        <img
            class="wagyu-hero-bg"
            src="{{ asset('assets/images/wagyu/wagyu-hero.jpg') }}"
            alt="Dégustation premium de Wagyu France"
        >

        <div class="wagyu-hero-overlay"></div>

        <div class="wagyu-hero-glow wagyu-glow-left"></div>
        <div class="wagyu-hero-glow wagyu-glow-right"></div>

        <div class="wagyu-hero-inner">
            <div class="wagyu-hero-content">
                <div class="wagyu-deco">
                    <span></span>
                    <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
                    <span></span>
                </div>

                <p class="eyebrow">Le goût du Wagyu</p>

                <h1>
                    Une viande rare,
                    <span>fondante et profondément marbrée.</span>
                </h1>

                <p>
                    Le Wagyu se distingue par son persillage exceptionnel, sa tendreté
                    naturelle et une longueur en bouche incomparable. Une viande pensée
                    pour être dégustée avec précision, respect et simplicité.
                </p>

                <div class="wagyu-hero-actions">
                    <a href="{{ route('boutique') }}" class="wagyu-primary-button">
                        Découvrir la boutique
                    </a>

                    <a href="{{ route('histoire') }}" class="wagyu-secondary-button">
                        Notre histoire
                    </a>
                </div>
            </div>

            <div class="wagyu-hero-panel">
                <img
                    src="{{ asset('assets/images/wagyu/persillage-wagyu.jpg') }}"
                    alt="Persillage d'une pièce de Wagyu"
                >

                <div class="wagyu-hero-panel-content">
                    <span>Expérience</span>

                    <h2>Marbrage</h2>

                    <p>
                        Le gras intramusculaire apporte cette texture fondante, cette jutosité
                        et cette profondeur qui font la signature du Wagyu.
                    </p>

                    <div class="wagyu-panel-tags">
                        <strong>Tendreté</strong>
                        <strong>Persillage</strong>
                        <strong>Longueur</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wagyu-intro-section">
        <div class="wagyu-intro-card">
            <div>
                <p class="eyebrow">Une viande différente</p>

                <h2>
                    Le Wagyu ne se mange pas comme une viande classique.
                </h2>
            </div>

            <div>
                <p>
                    Sa richesse vient de son équilibre : une viande intense, mais délicate ;
                    généreuse, mais à savourer en petites portions ; fondante, mais jamais
                    banale lorsqu’elle est bien préparée.
                </p>

                <p>
                    L’expérience repose sur la qualité de la pièce, la maîtrise de la cuisson
                    et le respect du produit. Quelques grammes suffisent souvent à comprendre
                    pourquoi le Wagyu occupe une place à part.
                </p>
            </div>
        </div>
    </section>

    <section class="wagyu-sensations-section">
        <div class="wagyu-section-heading">
            <p class="eyebrow">Signature gustative</p>

            <h2>
                Trois sensations qui définissent l’expérience Wagyu.
            </h2>
        </div>

        <div class="wagyu-sensations-grid">
            <article>
                <span>01</span>
                <h3>Fondant</h3>
                <p>
                    Le persillage apporte une texture souple, presque beurrée,
                    qui se révèle dès les premières bouchées.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Jutosité</h3>
                <p>
                    La viande conserve une grande richesse en bouche, avec une sensation
                    plus ronde et plus généreuse qu’une viande traditionnelle.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Profondeur</h3>
                <p>
                    Le goût se développe progressivement : douceur, intensité, longueur
                    et notes gourmandes selon la pièce choisie.
                </p>
            </article>
        </div>
    </section>

    <section class="wagyu-marbling-section">
        <div class="wagyu-marbling-card">
            <div class="wagyu-marbling-visual">
                <img
                    src="{{ asset('assets/images/wagyu/persillage-wagyu.jpg') }}"
                    alt="Gros plan sur le persillage du Wagyu"
                >

                <div>
                    <span>Persillage</span>
                    <strong>Marbrage naturel</strong>
                    <small>Texture · Arômes · Fondant</small>
                </div>
            </div>

            <div class="wagyu-marbling-content">
                <p class="eyebrow">Le persillage</p>

                <h2>
                    Ce marbrage qui change tout.
                </h2>

                <p>
                    Le persillage désigne les fines veines de gras présentes dans la viande.
                    Dans le Wagyu, il ne s’agit pas d’un simple gras extérieur, mais d’une
                    matière intégrée au muscle, qui fond à la cuisson et nourrit la texture.
                </p>

                <p>
                    C’est lui qui donne cette sensation si particulière : une viande tendre,
                    parfumée, juteuse, avec une intensité qui reste longtemps en bouche.
                </p>

                <a href="{{ route('boutique') }}">
                    Choisir une pièce
                </a>
            </div>
        </div>
    </section>

    <section class="wagyu-cuts-section">
        <div class="wagyu-section-heading">
            <p class="eyebrow">Les pièces</p>

            <h2>
                Chaque morceau révèle une facette différente du Wagyu.
            </h2>

            <p>
                Les pièces nobles ne racontent pas la même chose que les morceaux à cuisson lente.
                Le choix dépend du moment, de l’usage et de l’expérience recherchée.
            </p>
        </div>

        <div class="wagyu-cuts-grid">
            <article>
                <div class="wagyu-cut-visual">
                    <img src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}" alt="Entrecôte Wagyu">
                </div>

                <span>Pièce noble</span>
                <h3>Entrecôte</h3>
                <p>
                    Généreuse, intense et très expressive. Idéale pour découvrir la puissance
                    du persillage Wagyu.
                </p>
            </article>

            <article>
                <div class="wagyu-cut-visual">
                    <img src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}" alt="Filet Wagyu">
                </div>

                <span>Grande tendreté</span>
                <h3>Filet</h3>
                <p>
                    Plus délicat, plus précis, avec une texture très fondante et une élégance
                    parfaite pour une dégustation raffinée.
                </p>
            </article>

            <article>
                <div class="wagyu-cut-visual">
                    <img src="{{ asset('assets/images/boutique/faux-filet-wagyu.jpg') }}" alt="Faux-filet Wagyu">
                </div>

                <span>Équilibre</span>
                <h3>Faux-filet</h3>
                <p>
                    Une pièce équilibrée entre tendreté, goût et tenue à la cuisson.
                    Très belle option pour une dégustation premium.
                </p>
            </article>

            <article>
                <div class="wagyu-cut-visual">
                    <img src="{{ asset('assets/images/boutique/rumsteak-wagyu.jpg') }}" alt="Rumsteak Wagyu">
                </div>

                <span>Caractère</span>
                <h3>Rumsteak</h3>
                <p>
                    Une pièce plus franche, avec du relief, une belle mâche et une expression
                    plus directe du produit.
                </p>
            </article>
        </div>
    </section>

    <section class="wagyu-cooking-section">
        <div class="wagyu-cooking-card">
            <div class="wagyu-cooking-content">
                <p class="eyebrow">Conseils de dégustation</p>

                <h2>
                    Cuire peu, servir juste, savourer lentement.
                </h2>

                <p>
                    Le Wagyu demande une cuisson maîtrisée. Une chaleur trop forte ou une cuisson
                    trop longue peuvent faire perdre l’équilibre du produit. L’idée est de saisir,
                    laisser reposer, puis déguster en portions raisonnables.
                </p>
            </div>

            <div class="wagyu-cooking-side">
                <div class="wagyu-cooking-visual">
                    <img
                        src="{{ asset('assets/images/wagyu/cuisson-wagyu.jpg') }}"
                        alt="Cuisson d'une pièce de Wagyu"
                    >
                </div>

                <div class="wagyu-cooking-steps">
                    <article>
                        <span>01</span>
                        <strong>Tempérer</strong>
                        <small>Sortir la pièce avant cuisson pour éviter le choc thermique.</small>
                    </article>

                    <article>
                        <span>02</span>
                        <strong>Saisir</strong>
                        <small>Cuisson rapide, poêle chaude, sans masquer le goût.</small>
                    </article>

                    <article>
                        <span>03</span>
                        <strong>Reposer</strong>
                        <small>Quelques minutes pour laisser les jus se stabiliser.</small>
                    </article>

                    <article>
                        <span>04</span>
                        <strong>Déguster</strong>
                        <small>Tranches fines, sel, simplicité et attention.</small>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="wagyu-private-pro-section">
        <div class="wagyu-private-pro-card">
            <div>
                <p class="eyebrow">Particuliers & professionnels</p>

                <h2>
                    Deux manières de vivre la même exigence.
                </h2>

                <p>
                    Les particuliers découvrent le Wagyu à travers une boutique claire,
                    pensée pour la dégustation. Les professionnels accèdent à une réserve
                    dédiée, plus technique, orientée pièces, volumes et pré-réservation.
                </p>
            </div>

            <div class="wagyu-private-pro-actions">
                <a href="{{ route('boutique') }}" class="wagyu-primary-button">
                    Boutique particulier
                </a>

                <a href="{{ route('reserve.pro') }}" class="wagyu-secondary-button">
                    Réserve pro
                </a>
            </div>
        </div>
    </section>

    <section class="wagyu-cta-section">
        <div class="wagyu-cta-card">
            <p class="eyebrow">Wagyu France</p>

            <h2>
                Découvrir une viande rare, dans sa forme la plus élégante.
            </h2>

            <p>
                Explorez la boutique, choisissez votre pièce et préparez une dégustation
                à la hauteur du produit.
            </p>

            <div>
                <a href="{{ route('boutique') }}" class="wagyu-primary-button">
                    Découvrir la boutique
                </a>

                <a href="{{ route('histoire') }}" class="wagyu-secondary-button">
                    Lire notre histoire
                </a>
            </div>
        </div>
    </section>

@endsection

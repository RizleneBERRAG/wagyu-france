@extends('layouts.app', [
    'title' => 'Blog & Actualités — Wagyu France',
    'bodyClass' => 'blog-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@section('content')

    <section class="blog-hero">
        <img
            class="blog-hero-bg"
            src="{{ asset('assets/images/blog/blog-persillage.jpg') }}"
            alt="Persillage Wagyu France"
        >

        <div class="blog-hero-overlay"></div>

        <div class="blog-glow blog-glow-left"></div>
        <div class="blog-glow blog-glow-right"></div>

        <div class="blog-hero-inner">
            <div class="blog-hero-content">
                <p class="eyebrow">Blog & actualités</p>

                <h1>
                    Comprendre,
                    <span>choisir et savourer le Wagyu.</span>
                </h1>

                <p>
                    Conseils de dégustation, explications sur les pièces, culture du produit,
                    actualités de la maison et regards professionnels autour du Wagyu français.
                </p>

                <div class="blog-hero-actions">
                    <a href="#articles" class="blog-primary-button">
                        Lire les articles
                    </a>

                    <a href="{{ route('wagyu') }}" class="blog-secondary-button">
                        Comprendre le Wagyu
                    </a>
                </div>
            </div>

            <div class="blog-hero-card">
                <img
                    src="{{ asset('assets/images/blog/blog-cuisson.jpg') }}"
                    alt="Carnet de conseils Wagyu France"
                >

                <div class="blog-hero-card-content">
                    <span>Carnet maison</span>

                    <h2>Notes & conseils</h2>

                    <p>
                        Un espace éditorial pour mieux raconter le produit, ses usages,
                        ses pièces et son expérience.
                    </p>

                    <div class="blog-card-tags">
                        <strong>Dégustation</strong>
                        <strong>Cuisson</strong>
                        <strong>Maison</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-featured-section">
        <div class="blog-featured-card">
            <div class="blog-featured-visual">
                <img
                    src="{{ asset('assets/images/blog/blog-persillage.jpg') }}"
                    alt="Article sur le persillage du Wagyu"
                >

                <span>Article à la une</span>
            </div>

            <div class="blog-featured-content">
                <p class="eyebrow">Guide dégustation</p>

                <h2>
                    Pourquoi le persillage donne au Wagyu cette texture si particulière ?
                </h2>

                <p>
                    Le persillage est l’une des signatures les plus reconnaissables du Wagyu.
                    Il influence la tendreté, la jutosité, la sensation en bouche et la manière
                    dont la pièce doit être cuite.
                </p>

                <a href="{{ route('wagyu') }}">
                    Lire le guide Wagyu
                </a>
            </div>
        </div>
    </section>

    <section class="blog-categories-section">
        <div class="blog-section-heading">
            <p class="eyebrow">Rubriques</p>

            <h2>
                Des contenus pour chaque usage.
            </h2>
        </div>

        <div class="blog-category-grid">
            <article>
                <span>01</span>
                <h3>Dégustation</h3>
                <p>
                    Comprendre les sensations, les portions, les associations et la manière
                    de savourer une pièce rare.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Cuisson</h3>
                <p>
                    Conseils simples pour respecter le produit : température, saisie,
                    repos et découpe.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Pièces</h3>
                <p>
                    Entrecôte, filet, rumsteak, paleron ou jarret : chaque morceau possède
                    son caractère.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>Professionnels</h3>
                <p>
                    Réserve pro, volumes, pré-réservation, traçabilité et logique de découpe.
                </p>
            </article>
        </div>
    </section>

    <section class="blog-articles-section" id="articles">
        <div class="blog-section-heading">
            <p class="eyebrow">Articles récents</p>

            <h2>
                Le carnet Wagyu France.
            </h2>

            <p>
                Ces articles sont pour l’instant statiques. Plus tard, on pourra les brancher
                à l’admin pour les créer, modifier et publier facilement.
            </p>
        </div>

        <div class="blog-articles-grid">
            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/blog/blog-persillage.jpg') }}"
                        alt="Dégustation Wagyu"
                    >

                    <span>Dégustation</span>
                </div>

                <div class="blog-article-content">
                    <small>Guide · 4 min</small>

                    <h3>
                        Comment déguster le Wagyu sans masquer son goût ?
                    </h3>

                    <p>
                        Sel, cuisson courte, repos, tranches fines : quelques gestes simples
                        suffisent à respecter une pièce d’exception.
                    </p>

                    <a href="{{ route('wagyu') }}">
                        Lire
                    </a>
                </div>
            </article>

            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/blog/blog-cuisson.jpg') }}"
                        alt="Cuisson du Wagyu"
                    >

                    <span>Cuisson</span>
                </div>

                <div class="blog-article-content">
                    <small>Conseil · 3 min</small>

                    <h3>
                        Saisir une entrecôte Wagyu : les erreurs à éviter.
                    </h3>

                    <p>
                        Une chaleur trop forte ou une cuisson trop longue peut déséquilibrer
                        la texture. Le Wagyu demande de la précision.
                    </p>

                    <a href="{{ route('boutique') }}">
                        Voir les pièces
                    </a>
                </div>
            </article>

            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/blog/blog-pieces.jpg') }}"
                        alt="Pièces de Wagyu"
                    >

                    <span>Pièces</span>
                </div>

                <div class="blog-article-content">
                    <small>Sélection · 5 min</small>

                    <h3>
                        Entrecôte, filet, rumsteak : quelle pièce choisir ?
                    </h3>

                    <p>
                        Chaque morceau révèle une facette différente du Wagyu :
                        intensité, fondant, caractère ou équilibre.
                    </p>

                    <a href="{{ route('boutique') }}">
                        Découvrir
                    </a>
                </div>
            </article>

            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/histoire/maison-wagyu-france.jpg') }}"
                        alt="Maison Wagyu France"
                    >

                    <span>Maison</span>
                </div>

                <div class="blog-article-content">
                    <small>Histoire · 4 min</small>

                    <h3>
                        Pourquoi Wagyu France sépare l’univers particulier et pro ?
                    </h3>

                    <p>
                        Les particuliers veulent déguster. Les professionnels veulent réserver,
                        anticiper et organiser leurs volumes.
                    </p>

                    <a href="{{ route('histoire') }}">
                        Comprendre
                    </a>
                </div>
            </article>

            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/blog/blog-pro.jpg') }}"
                        alt="Univers professionnel Wagyu France"
                    >

                    <span>Pro</span>
                </div>

                <div class="blog-article-content">
                    <small>Professionnels · 6 min</small>

                    <h3>
                        Pré-réserver avant découpe : pourquoi cette méthode change tout ?
                    </h3>

                    <p>
                        La demande professionnelle permet de mieux répartir, anticiper
                        et valoriser les pièces avant la mise en découpe.
                    </p>

                    <a href="{{ route('decoupe-volumes') }}">
                        Lire
                    </a>
                </div>
            </article>

            <article class="blog-article-card">
                <div class="blog-article-visual">
                    <img
                        src="{{ asset('assets/images/blog/blog-tracabilite.jpg') }}"
                        alt="Traçabilité Wagyu France"
                    >

                    <span>Confiance</span>
                </div>

                <div class="blog-article-content">
                    <small>Traçabilité · 4 min</small>

                    <h3>
                        La traçabilité, un vrai argument pour les professionnels.
                    </h3>

                    <p>
                        Origine, pièces, volumes et statut de demande renforcent la confiance
                        autour d’un produit premium.
                    </p>

                    <a href="{{ route('tracabilite') }}">
                        Découvrir
                    </a>
                </div>
            </article>
        </div>
    </section>

    <section class="blog-editorial-section">
        <div class="blog-editorial-card">
            <div>
                <p class="eyebrow">Contenu éditorial</p>

                <h2>
                    Un blog utile pour le SEO et la confiance.
                </h2>

                <p>
                    Le blog permet de créer du contenu naturel autour du Wagyu :
                    cuisson, conservation, pièces, origine, conseils de dégustation,
                    pré-réservation et univers professionnel.
                </p>

                <p>
                    Plus tard, on pourra transformer cette page en vrai module admin :
                    création d’articles, image, catégorie, brouillon, publication et SEO.
                </p>
            </div>

            <div class="blog-editorial-panel">
                <div class="blog-editorial-image">
                    <img
                        src="{{ asset('assets/images/blog/blog-pro.jpg') }}"
                        alt="Contenu éditorial Wagyu France"
                    >
                </div>

                <span>✦</span>

                <h3>Objectif SEO</h3>

                <ul>
                    <li>Créer des pages indexables</li>
                    <li>Répondre aux questions clients</li>
                    <li>Renforcer l’expertise</li>
                    <li>Améliorer le maillage interne</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="blog-cta-section">
        <div class="blog-cta-card">
            <p class="eyebrow">Wagyu France</p>

            <h2>
                Explorer le produit autrement.
            </h2>

            <p>
                Découvrez les articles, la boutique ou l’espace professionnel selon votre besoin.
            </p>

            <div>
                <a href="{{ route('boutique') }}" class="blog-primary-button">
                    Boutique particulier
                </a>

                <a href="{{ route('professionnels') }}" class="blog-secondary-button">
                    Univers professionnel
                </a>
            </div>
        </div>
    </section>

@endsection

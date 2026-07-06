@extends('layouts.app', [
    'title' => 'Notre histoire — Wagyu France',
    'bodyClass' => 'histoire-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/histoire.css') }}">
@endpush

@section('content')

    <section class="story-hero">
        <img
            class="story-hero-bg"
            src="{{ asset('assets/images/histoire/domaine-wagyu-france.jpg') }}"
            alt="Domaine Wagyu France au crépuscule"
        >

        <div class="story-hero-overlay"></div>

        <div class="story-glow story-glow-left"></div>
        <div class="story-glow story-glow-right"></div>

        <div class="story-hero-inner">
            <div class="story-hero-content">
                <div class="story-logo-line">
                    <span></span>
                    <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
                    <span></span>
                </div>

                <p class="eyebrow">Maison Wagyu France</p>

                <h1>
                    Une maison française,
                    <span>portée par le temps et l’exigence.</span>
                </h1>

                <p>
                    Wagyu France défend une vision rare de la viande : prendre le temps,
                    respecter l’origine, comprendre chaque pièce et proposer une expérience
                    à la hauteur d’un produit d’exception.
                </p>

                <div class="story-hero-actions">
                    <a href="{{ route('boutique') }}" class="story-primary-button">
                        Découvrir la boutique
                    </a>

                    <a href="{{ route('wagyu') }}" class="story-secondary-button">
                        Comprendre le Wagyu
                    </a>
                </div>
            </div>

            <div class="story-hero-card">
                <img
                    src="{{ asset('assets/images/histoire/maison-wagyu-france.jpg') }}"
                    alt="Maison Wagyu France"
                >

                <div class="story-hero-card-content">
                    <span>Signature</span>

                    <h2>Patience</h2>

                    <p>
                        Une viande d’exception ne se construit pas dans la précipitation.
                        Elle demande du temps, de l’attention et une vraie cohérence.
                    </p>

                    <div class="story-card-tags">
                        <strong>Origine</strong>
                        <strong>Sélection</strong>
                        <strong>Respect</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="story-intro-section">
        <div class="story-intro-card">
            <div>
                <p class="eyebrow">Notre vision</p>

                <h2>
                    Remettre de la valeur dans chaque morceau.
                </h2>
            </div>

            <div>
                <p>
                    Derrière une pièce de Wagyu, il y a plus qu’un prix ou qu’un morceau.
                    Il y a une origine, un choix d’élevage, une sélection, une découpe
                    et une manière de transmettre le produit.
                </p>

                <p>
                    L’ambition de Wagyu France est de rendre cette expérience plus lisible :
                    pour les particuliers qui veulent déguster une viande rare, comme pour
                    les professionnels qui veulent construire une demande précise.
                </p>
            </div>
        </div>
    </section>

    <section class="story-values-section">
        <div class="story-section-heading">
            <p class="eyebrow">Ce qui nous guide</p>

            <h2>
                Une maison construite sur des principes simples.
            </h2>
        </div>

        <div class="story-values-grid">
            <article>
                <span>01</span>
                <h3>Le temps</h3>
                <p>
                    Le Wagyu exige une approche lente, réfléchie et respectueuse.
                    La qualité ne se force pas, elle se construit.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>L’origine</h3>
                <p>
                    Le produit doit rester compréhensible. Une viande premium doit pouvoir
                    raconter d’où elle vient et pourquoi elle mérite sa place.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>La justesse</h3>
                <p>
                    Chaque pièce a son rôle, son usage et sa valeur. La maison cherche
                    à présenter le bon morceau au bon public.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>La confiance</h3>
                <p>
                    La clarté du parcours, des pièces et des demandes renforce la relation
                    entre Wagyu France, ses clients et ses partenaires.
                </p>
            </article>
        </div>
    </section>

    <section class="story-origin-section">
        <div class="story-origin-card">
            <div class="story-origin-visual">
                <img
                    src="{{ asset('assets/images/histoire/elevage-wagyu.jpg') }}"
                    alt="Élevage Wagyu France"
                >

                <div>
                    <span>Maison</span>
                    <strong>Wagyu France</strong>
                    <small>Origine · Patience · Exigence</small>
                </div>
            </div>

            <div class="story-origin-content">
                <p class="eyebrow">L’esprit maison</p>

                <h2>
                    Une expérience française autour d’une viande rare.
                </h2>

                <p>
                    Wagyu France ne cherche pas à banaliser le Wagyu. Au contraire,
                    la maison veut préserver son caractère exceptionnel en proposant
                    un parcours clair, premium et cohérent.
                </p>

                <p>
                    Côté particulier, l’expérience se concentre sur la dégustation :
                    comprendre le persillage, choisir une pièce, préparer simplement
                    et savourer avec attention.
                </p>

                <p>
                    Côté professionnel, l’expérience devient plus technique :
                    réserver avant découpe, suivre les volumes, comprendre les morceaux
                    et construire une demande plus précise.
                </p>

                <a href="{{ route('professionnels') }}">
                    Découvrir l’univers professionnel
                </a>
            </div>
        </div>
    </section>

    <section class="story-timeline-section">
        <div class="story-section-heading">
            <p class="eyebrow">Le parcours</p>

            <h2>
                De l’origine à la dégustation.
            </h2>

            <p>
                L’histoire d’une pièce ne commence pas dans l’assiette.
                Elle se construit étape après étape.
            </p>
        </div>

        <div class="story-timeline">
            <article>
                <span>01</span>
                <h3>Élever</h3>
                <p>
                    Respecter le temps nécessaire au développement d’une viande singulière.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Sélectionner</h3>
                <p>
                    Identifier les pièces, leur potentiel, leur usage et leur valeur.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Découper</h3>
                <p>
                    Penser chaque morceau comme une partie essentielle de l’animal.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>Transmettre</h3>
                <p>
                    Donner au client les clés pour comprendre, cuisiner et apprécier.
                </p>
            </article>
        </div>
    </section>

    <section class="story-dual-section">
        <div class="story-dual-card">
            <div>
                <p class="eyebrow">Deux univers</p>

                <h2>
                    Le même produit, deux expériences différentes.
                </h2>

                <p>
                    Un particulier ne cherche pas la même chose qu’un chef ou qu’un boucher.
                    C’est pour cela que Wagyu France sépare clairement les parcours.
                </p>
            </div>

            <div class="story-dual-grid">
                <article>
                    <span>Particulier</span>
                    <h3>Déguster</h3>
                    <p>
                        Boutique, conseils, choix des pièces et expérience sensorielle.
                    </p>

                    <a href="{{ route('boutique') }}">
                        Voir la boutique
                    </a>
                </article>

                <article>
                    <span>Professionnel</span>
                    <h3>Réserver</h3>
                    <p>
                        Pré-réservation, volumes, découpe, suivi et demandes qualifiées.
                    </p>

                    <a href="{{ route('reserve.pro') }}">
                        Voir la réserve pro
                    </a>
                </article>
            </div>
        </div>
    </section>

    <section class="story-proof-section">
        <div class="story-proof-card">
            <div>
                <p class="eyebrow">Pourquoi cette approche ?</p>

                <h2>
                    Parce qu’une viande rare mérite mieux qu’un simple catalogue.
                </h2>

                <p>
                    La valeur du Wagyu vient autant de sa qualité que de la manière dont il est
                    présenté. La maison doit permettre de comprendre le produit, d’en respecter
                    la cuisson, de choisir la bonne pièce et de créer une vraie expérience.
                </p>
            </div>

            <div class="story-proof-panel">
                <span>✦</span>

                <h3>Une maison, pas seulement une boutique.</h3>

                <p>
                    Wagyu France construit un univers complet : histoire, pédagogie, boutique,
                    réserve pro et suivi des demandes.
                </p>

                <ul>
                    <li>Parcours particulier clair</li>
                    <li>Réserve professionnelle dédiée</li>
                    <li>Pièces mieux valorisées</li>
                    <li>Demandes suivies en interne</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="story-cta-section">
        <div class="story-cta-card">
            <p class="eyebrow">Wagyu France</p>

            <h2>
                Entrez dans l’univers d’une viande d’exception.
            </h2>

            <p>
                Découvrez la boutique, comprenez le Wagyu ou explorez l’espace professionnel
                selon votre besoin.
            </p>

            <div>
                <a href="{{ route('boutique') }}" class="story-primary-button">
                    Boutique particulier
                </a>

                <a href="{{ route('professionnels') }}" class="story-secondary-button">
                    Univers professionnel
                </a>
            </div>
        </div>
    </section>

@endsection

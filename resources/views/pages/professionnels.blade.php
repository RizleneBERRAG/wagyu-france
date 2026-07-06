@extends('layouts.app', [
    'title' => 'Professionnels — Wagyu France',
    'bodyClass' => 'professionnels-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/professionnels.css') }}">
@endpush

@section('content')

    <section class="pro-hero">
        <img
            class="pro-hero-bg"
            src="{{ asset('assets/images/pro/pro-hero.jpg') }}"
            alt="Préparation professionnelle de pièces Wagyu"
        >

        <div class="pro-hero-overlay"></div>
        <div class="pro-hero-grid"></div>
        <div class="pro-red-glow"></div>
        <div class="pro-gold-glow"></div>

        <div class="pro-hero-inner">
            <div class="pro-hero-content">
                <p class="eyebrow">Univers professionnel</p>

                <h1>
                    Une viande d’exception,
                    <span>pensée pour vos volumes.</span>
                </h1>

                <p>
                    Wagyu France accompagne les chefs, restaurateurs, bouchers et partenaires
                    professionnels dans une approche plus claire, plus précise et plus maîtrisée
                    de la viande Wagyu française.
                </p>

                <div class="pro-hero-actions">
                    <a href="{{ route('reserve.pro') }}" class="pro-primary-button">
                        Accéder à la réserve pro
                    </a>

                    <a href="{{ route('contact') }}" class="pro-secondary-button">
                        Demander un accès
                    </a>
                </div>
            </div>

            <div class="pro-hero-panel">
                <div class="pro-panel-image">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Réserve professionnelle Wagyu France"
                    >
                </div>

                <div class="pro-panel-top">
                    <span>Réserve active</span>
                    <strong>WF-2026-01</strong>
                </div>

                <div class="pro-panel-main">
                    <p>Animal en pré-réservation</p>

                    <div>
                        <strong>68%</strong>
                        <span>réservé</span>
                    </div>

                    <i>
                        <b style="width: 68%"></b>
                    </i>
                </div>

                <div class="pro-panel-list">
                    <article>
                        <span>Entrecôte</span>
                        <strong>174 €/kg</strong>
                    </article>

                    <article>
                        <span>Filet</span>
                        <strong>198 €/kg</strong>
                    </article>

                    <article>
                        <span>Rumsteak</span>
                        <strong>137 €/kg</strong>
                    </article>
                </div>

                <a href="{{ route('reserve.pro') }}">
                    Sélectionner sur l’animal
                </a>
            </div>
        </div>
    </section>

    <section class="pro-intro-section">
        <div class="pro-intro-card">
            <div>
                <p class="eyebrow">Approche pro</p>

                <h2>
                    Commander autrement :
                    avant la découpe, avec plus de visibilité.
                </h2>
            </div>

            <div>
                <p>
                    Le marché professionnel a besoin de précision : connaître les pièces,
                    anticiper les quantités, sécuriser les volumes et comprendre la disponibilité
                    avant de construire une carte, une offre ou une sélection en boutique.
                </p>

                <p>
                    L’espace professionnel de Wagyu France répond à cette logique avec une
                    expérience distincte de la boutique particulier : plus technique, plus directe
                    et pensée pour la pré-réservation.
                </p>
            </div>
        </div>
    </section>

    <section class="pro-audience-section">
        <div class="pro-section-heading">
            <p class="eyebrow">Pour qui ?</p>

            <h2>
                Un espace conçu pour les métiers qui valorisent le produit.
            </h2>
        </div>

        <div class="pro-audience-grid">
            <article>
                <span>01</span>
                <h3>Chefs & restaurants</h3>
                <p>
                    Sélectionner les pièces adaptées à une carte, une dégustation,
                    un menu signature ou une expérience gastronomique.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Boucheries premium</h3>
                <p>
                    Anticiper les volumes, préparer une offre haut de gamme et proposer
                    des morceaux rares avec une lecture claire du produit.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Traiteurs & événements</h3>
                <p>
                    Organiser des besoins précis pour des prestations privées,
                    événements d’exception ou expériences culinaires sur mesure.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>Partenaires spécialisés</h3>
                <p>
                    Construire une relation professionnelle autour de la disponibilité,
                    de la traçabilité et de la valorisation de chaque pièce.
                </p>
            </article>
        </div>
    </section>

    <section class="pro-reservation-section">
        <div class="pro-reservation-card">
            <div class="pro-reservation-content">
                <p class="eyebrow">Réserve professionnelle</p>

                <h2>
                    Une interface pour choisir directement sur l’animal.
                </h2>

                <p>
                    Le professionnel ne parcourt pas simplement une liste de produits.
                    Il entre dans une logique de découpe : il visualise les pièces,
                    sélectionne les morceaux souhaités, indique ses quantités et transmet
                    une demande de pré-réservation.
                </p>

                <div class="pro-reservation-actions">
                    <a href="{{ route('reserve.pro') }}" class="pro-primary-button">
                        Ouvrir la réserve
                    </a>

                    <a href="{{ route('decoupe-volumes') }}" class="pro-secondary-button">
                        Découpe & volumes
                    </a>
                </div>
            </div>

            <div class="pro-reservation-side">
                <div class="pro-reservation-image">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Découpe professionnelle Wagyu"
                    >
                </div>

                <div class="pro-reservation-steps">
                    <article>
                        <span>01</span>
                        <strong>Choisir</strong>
                        <small>Pièces sélectionnées depuis l’animal.</small>
                    </article>

                    <article>
                        <span>02</span>
                        <strong>Quantifier</strong>
                        <small>Ajout au panier pro avec total HT.</small>
                    </article>

                    <article>
                        <span>03</span>
                        <strong>Demander</strong>
                        <small>Formulaire professionnel et récapitulatif.</small>
                    </article>

                    <article>
                        <span>04</span>
                        <strong>Confirmer</strong>
                        <small>Validation finale par Wagyu France.</small>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="pro-method-section">
        <div class="pro-section-heading">
            <p class="eyebrow">Méthode</p>

            <h2>
                La valeur d’un animal se construit pièce par pièce.
            </h2>

            <p>
                L’espace professionnel permet d’aligner les besoins clients avec la réalité
                de la découpe, pour mieux anticiper, mieux répartir et mieux valoriser.
            </p>
        </div>

        <div class="pro-method-grid">
            <article>
                <div class="pro-method-visual">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Découpe et volumes Wagyu"
                    >
                </div>

                <h3>Lisibilité des pièces</h3>
                <p>
                    Chaque morceau est présenté avec son usage, sa disponibilité,
                    son prix professionnel et son niveau de réservation.
                </p>
            </article>

            <article>
                <div class="pro-method-visual">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Pré-réservation professionnelle Wagyu"
                    >
                </div>

                <h3>Pré-réservation claire</h3>
                <p>
                    Le panier pro rassemble les quantités souhaitées avant une validation
                    définitive par Wagyu France.
                </p>
            </article>

            <article>
                <div class="pro-method-visual">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Traçabilité professionnelle Wagyu"
                    >
                </div>

                <h3>Découpe déclenchée au bon moment</h3>
                <p>
                    Lorsque le niveau de demande est suffisant, la mise en découpe peut être
                    organisée avec plus de cohérence.
                </p>
            </article>
        </div>
    </section>

    <section class="pro-split-section">
        <div class="pro-split-card">
            <div>
                <p class="eyebrow">Relation professionnelle</p>

                <h2>
                    Plus qu’une commande, une demande qualifiée.
                </h2>

                <p>
                    Chaque demande transmise depuis la réserve contient les informations
                    essentielles : société, contact, type de professionnel, pièces choisies,
                    quantités souhaitées et total estimatif HT.
                </p>

                <p>
                    Wagyu France peut ensuite revenir vers le professionnel avec une réponse
                    plus précise, adaptée aux disponibilités réelles et aux volumes demandés.
                </p>
            </div>

            <div class="pro-split-metrics">
                <div class="pro-split-image">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Traçabilité Wagyu France"
                    >
                </div>

                <article>
                    <strong>HT</strong>
                    <span>lecture professionnelle</span>
                </article>

                <article>
                    <strong>7</strong>
                    <span>pièces principales suivies</span>
                </article>

                <article>
                    <strong>1</strong>
                    <span>animal pré-réservé</span>
                </article>
            </div>
        </div>
    </section>

    <section class="pro-cta-section">
        <div class="pro-cta-card">
            <p class="eyebrow">Accès professionnel</p>

            <h2>
                Entrez dans l’espace réservé aux professionnels.
            </h2>

            <p>
                Sélectionnez vos pièces, construisez votre demande et transmettez votre
                pré-réservation à Wagyu France.
            </p>

            <div>
                <a href="{{ route('reserve.pro') }}" class="pro-primary-button">
                    Accéder à la réserve pro
                </a>

                <a href="{{ route('contact') }}" class="pro-secondary-button">
                    Contacter Wagyu France
                </a>
            </div>
        </div>
    </section>

@endsection

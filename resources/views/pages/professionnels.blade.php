@extends('layouts.app', [
    'title' => 'Wagyu français pour professionnels — Wagyu France',
    'description' => 'Wagyu France accompagne chefs, restaurateurs, bouchers et traiteurs avec une sélection professionnelle, une pré-réservation par pièce et un suivi précis des volumes.',
    'bodyClass' => 'professionnels-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/professionnels.css') }}">
@endpush

@section('content')

    <section class="pro-hero">
        <div class="pro-shell pro-hero-grid">
            <div class="pro-hero-copy">
                <p class="pro-kicker">Wagyu France · Espace professionnel</p>

                <h1>
                    Le Wagyu français,
                    <em>pensé pour les maisons exigeantes.</em>
                </h1>

                <p class="pro-hero-lead">
                    Chefs, restaurateurs, bouchers et traiteurs accèdent à une sélection dédiée,
                    pensée pour anticiper les volumes, comprendre les pièces et construire une
                    demande cohérente avant la découpe.
                </p>

                <div class="pro-hero-actions">
                    <a href="{{ route('reserve.pro') }}" class="pro-button pro-button-primary">
                        Accéder à la réserve
                    </a>
                    <a href="{{ route('contact') }}" class="pro-button pro-button-secondary">
                        Échanger avec la maison
                    </a>
                </div>

                <dl class="pro-hero-facts">
                    <div>
                        <dt>Sélection</dt>
                        <dd>Pièces et usages professionnels</dd>
                    </div>
                    <div>
                        <dt>Volumes</dt>
                        <dd>Demandes anticipées avant découpe</dd>
                    </div>
                    <div>
                        <dt>Suivi</dt>
                        <dd>Réponse adaptée aux disponibilités</dd>
                    </div>
                </dl>
            </div>

            <figure class="pro-hero-visual">
                <img
                    src="{{ asset('assets/images/pro/pro-hero.jpg') }}"
                    alt="Préparation professionnelle d’une pièce de Wagyu"
                >

                <figcaption class="pro-hero-caption">
                    <span>Sélection professionnelle</span>
                    <strong>Une lecture précise de la pièce, de son usage et de son potentiel.</strong>
                </figcaption>

                <div class="pro-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Professionnels</small>
                </div>
            </figure>
        </div>
    </section>

    <nav class="pro-chapters" aria-label="Parcours professionnel" data-section-nav>
        <div class="pro-shell pro-chapters-grid">
            <a href="#approche"><span>01</span> Notre approche</a>
            <a href="#services"><span>02</span> Les services</a>
            <a href="#metiers"><span>03</span> Les métiers</a>
            <a href="#methode"><span>04</span> La méthode</a>
        </div>
    </nav>

    <section class="pro-section pro-approach" id="approche">
        <div class="pro-shell pro-approach-grid">
            <div class="pro-approach-visual">
                <img
                    src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                    alt="Réserve professionnelle Wagyu France"
                >
                <div class="pro-image-index">
                    <span>Maison professionnelle</span>
                    <strong>Réserve · Découpe · Traçabilité</strong>
                </div>
            </div>

            <div class="pro-approach-copy">
                <p class="pro-kicker">Une relation avant une commande</p>
                <h2>
                    Comprendre votre besoin,
                    <em>puis sélectionner juste.</em>
                </h2>

                <p class="pro-dropcap">
                    Une pièce de Wagyu ne se choisit pas uniquement selon un prix ou un poids.
                    Elle se choisit selon une carte, un nombre de couverts, un mode de cuisson,
                    une régularité de service et l’expérience que vous souhaitez proposer.
                </p>

                <p>
                    L’espace professionnel permet de formuler cette demande plus précisément.
                    Vous identifiez les morceaux adaptés, indiquez vos quantités et transmettez
                    une pré-réservation qui sera ensuite confirmée par Wagyu France.
                </p>

                <a href="{{ route('reserve.pro') }}" class="pro-text-link">
                    Découvrir la réserve professionnelle <span>→</span>
                </a>
            </div>
        </div>
    </section>

    <section class="pro-section pro-services" id="services">
        <div class="pro-shell">
            <header class="pro-heading-row">
                <div>
                    <p class="pro-kicker">Trois espaces complémentaires</p>
                    <h2>Un parcours professionnel complet.</h2>
                </div>
                <p>
                    De la première sélection au suivi de l’origine, chaque espace répond à une
                    étape concrète de votre demande.
                </p>
            </header>

            <div class="pro-service-grid">
                <a href="{{ route('reserve.pro') }}" class="pro-service-card pro-service-card-featured">
                    <div class="pro-service-image">
                        <img
                            src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                            alt="Pré-réservation professionnelle Wagyu"
                        >
                        <span>01</span>
                    </div>
                    <div class="pro-service-body">
                        <p>Réserve professionnelle</p>
                        <h3>Sélectionner les pièces disponibles.</h3>
                        <span>
                            Constituez une demande par morceau, quantité et usage avant validation
                            définitive par la maison.
                        </span>
                        <strong>Ouvrir la réserve <i>→</i></strong>
                    </div>
                </a>

                <a href="{{ route('decoupe-volumes') }}" class="pro-service-card">
                    <div class="pro-service-image">
                        <img
                            src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                            alt="Découpe et volumes professionnels Wagyu"
                        >
                        <span>02</span>
                    </div>
                    <div class="pro-service-body">
                        <p>Découpe & volumes</p>
                        <h3>Comprendre la répartition de l’animal.</h3>
                        <span>
                            Anticipez les rendements, les volumes et la disponibilité réelle des
                            différentes familles de morceaux.
                        </span>
                        <strong>Voir la méthode <i>→</i></strong>
                    </div>
                </a>

                <a href="{{ route('tracabilite') }}" class="pro-service-card">
                    <div class="pro-service-image">
                        <img
                            src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                            alt="Traçabilité professionnelle Wagyu France"
                        >
                        <span>03</span>
                    </div>
                    <div class="pro-service-body">
                        <p>Origine & traçabilité</p>
                        <h3>Donner une histoire claire au produit.</h3>
                        <span>
                            Retrouvez les repères essentiels pour présenter l’origine et construire
                            une relation de confiance avec vos clients.
                        </span>
                        <strong>Découvrir la traçabilité <i>→</i></strong>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="pro-section pro-audience" id="metiers">
        <div class="pro-shell">
            <header class="pro-heading-centered">
                <p class="pro-kicker">Pour les métiers du goût</p>
                <h2>Une même exigence, des usages différents.</h2>
                <p>
                    Chaque métier valorise le Wagyu à sa manière. La sélection professionnelle
                    s’adapte au service, au conseil et au volume recherché.
                </p>
            </header>

            <div class="pro-audience-grid">
                <article>
                    <span>01</span>
                    <small>Restaurants</small>
                    <h3>Chefs & maisons gastronomiques</h3>
                    <p>
                        Pièces signatures, portions maîtrisées, régularité de service et sélection
                        adaptée à votre carte.
                    </p>
                </article>

                <article>
                    <span>02</span>
                    <small>Commerce de bouche</small>
                    <h3>Boucheries & épiceries premium</h3>
                    <p>
                        Morceaux lisibles, conseils de préparation et offre différenciante pour une
                        clientèle en recherche de produits rares.
                    </p>
                </article>

                <article>
                    <span>03</span>
                    <small>Événementiel</small>
                    <h3>Traiteurs & tables privées</h3>
                    <p>
                        Besoins ponctuels, quantités anticipées et accompagnement pour des expériences
                        culinaires sur mesure.
                    </p>
                </article>

                <article>
                    <span>04</span>
                    <small>Partenariats</small>
                    <h3>Distributeurs spécialisés</h3>
                    <p>
                        Relation suivie, compréhension des disponibilités et valorisation cohérente
                        de chaque partie de l’animal.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="pro-process" id="methode">
        <div class="pro-shell pro-process-grid">
            <div class="pro-process-heading">
                <p class="pro-kicker">Le parcours de pré-réservation</p>
                <h2>Une demande structurée, sans fausse promesse.</h2>
                <p>
                    Le panier professionnel exprime un besoin. Les poids, disponibilités et modalités
                    sont ensuite confirmés par la maison avant tout engagement définitif.
                </p>
            </div>

            <div class="pro-process-steps">
                <article>
                    <span>01</span>
                    <div>
                        <strong>Sélectionner</strong>
                        <p>Choisissez les pièces correspondant à votre carte ou à votre activité.</p>
                    </div>
                </article>

                <article>
                    <span>02</span>
                    <div>
                        <strong>Quantifier</strong>
                        <p>Indiquez les volumes souhaités et construisez votre demande estimative HT.</p>
                    </div>
                </article>

                <article>
                    <span>03</span>
                    <div>
                        <strong>Qualifier</strong>
                        <p>Précisez votre établissement, vos échéances et vos contraintes de service.</p>
                    </div>
                </article>

                <article>
                    <span>04</span>
                    <div>
                        <strong>Confirmer</strong>
                        <p>Wagyu France vérifie la disponibilité et revient vers vous avec une réponse précise.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="pro-section pro-selection">
        <div class="pro-shell pro-selection-grid">
            <div class="pro-selection-copy">
                <p class="pro-kicker">Une sélection qui respecte l’animal</p>
                <h2>
                    Valoriser les pièces nobles,
                    <em>sans oublier le reste.</em>
                </h2>
                <p>
                    Entrecôte, filet et faux-filet occupent naturellement une place importante.
                    Mais une approche professionnelle cohérente sait aussi travailler le rumsteak,
                    le paleron, le jarret et les morceaux destinés aux cuissons longues.
                </p>
                <p>
                    Cette lecture globale permet de construire des offres plus riches, de mieux
                    répartir la demande et de donner de la valeur à chaque pièce.
                </p>

                <div class="pro-selection-tags">
                    <span>Cuisson minute</span>
                    <span>Menu dégustation</span>
                    <span>Cuisson lente</span>
                    <span>Vente au détail</span>
                </div>
            </div>

            <div class="pro-selection-visual">
                <img
                    src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                    alt="Sélection et découpe des pièces de Wagyu"
                >
                <div>
                    <span>Lecture professionnelle</span>
                    <strong>Une pièce, un usage, une valeur.</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="pro-quote">
        <div class="pro-shell pro-quote-inner">
            <span aria-hidden="true">“</span>
            <blockquote>
                La précision ne consiste pas à promettre tous les morceaux.
                Elle consiste à comprendre lesquels correspondent réellement à votre besoin.
            </blockquote>
            <p>Wagyu France · Relation professionnelle</p>
        </div>
    </section>

    <section data-nav-end class="pro-section pro-contact">
        <div class="pro-shell pro-contact-card">
            <div>
                <p class="pro-kicker">Votre prochaine sélection</p>
                <h2>Parlons de votre carte, de vos volumes et de vos échéances.</h2>
                <p>
                    Accédez à la réserve pour constituer une première demande ou contactez directement
                    Wagyu France pour un besoin spécifique.
                </p>
            </div>

            <div class="pro-contact-actions">
                <a href="{{ route('reserve.pro') }}" class="pro-button pro-button-light">
                    Accéder à la réserve pro
                </a>
                <a href="{{ route('contact') }}" class="pro-contact-link">
                    Contacter la maison <span>→</span>
                </a>
            </div>
        </div>
    </section>

@endsection
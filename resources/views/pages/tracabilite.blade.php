@extends('layouts.app', [
    'title' => 'Traçabilité — Wagyu France',
    'bodyClass' => 'tracabilite-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tracabilite.css') }}">
@endpush

@section('content')

    <section class="trace-hero">
        <img
            class="trace-hero-bg"
            src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
            alt="Traçabilité professionnelle Wagyu France"
        >

        <div class="trace-hero-overlay"></div>
        <div class="trace-hero-grid"></div>
        <div class="trace-gold-glow"></div>
        <div class="trace-red-glow"></div>

        <div class="trace-hero-inner">
            <div class="trace-hero-content">
                <p class="eyebrow">Traçabilité</p>

                <h1>
                    Savoir d’où vient
                    <span>ce que l’on sert.</span>
                </h1>

                <p>
                    Wagyu France place la traçabilité au cœur de son expérience professionnelle :
                    origine, identification, suivi des pièces, cohérence des volumes et informations
                    utiles pour mieux comprendre chaque produit.
                </p>

                <div class="trace-hero-actions">
                    <a href="{{ route('reserve.pro') }}" class="trace-primary-button">
                        Accéder à la réserve pro
                    </a>

                    <a href="{{ route('decoupe-volumes') }}" class="trace-secondary-button">
                        Découpe & volumes
                    </a>
                </div>
            </div>

            <div class="trace-identity-card">
                <div class="trace-card-image">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Fiche professionnelle Wagyu France"
                    >
                </div>

                <div class="trace-card-top">
                    <span>Animal suivi</span>
                    <strong>WF-2026-01</strong>
                </div>

                <div class="trace-id-box">
                    <p>Fiche de suivi</p>

                    <ul>
                        <li>
                            <span>Origine</span>
                            <strong>France</strong>
                        </li>

                        <li>
                            <span>Maison</span>
                            <strong>Wagyu France</strong>
                        </li>

                        <li>
                            <span>Usage</span>
                            <strong>Pré-réservation pro</strong>
                        </li>

                        <li>
                            <span>Statut</span>
                            <strong>En suivi</strong>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('reserve.pro') }}">
                    Voir les pièces disponibles
                </a>
            </div>
        </div>
    </section>

    <section class="trace-intro-section">
        <div class="trace-intro-card">
            <div>
                <p class="eyebrow">Confiance produit</p>

                <h2>
                    La transparence donne de la valeur à la pièce.
                </h2>
            </div>

            <div>
                <p>
                    Pour un professionnel, la qualité ne se limite pas au goût. Elle repose aussi
                    sur la capacité à connaître l’origine, le parcours, les informations de découpe
                    et la cohérence du produit proposé à ses clients.
                </p>

                <p>
                    La traçabilité permet de présenter une viande d’exception avec plus de clarté :
                    ce qui est vendu, ce qui est disponible, ce qui est réservé et ce qui sera confirmé
                    avant livraison.
                </p>
            </div>
        </div>
    </section>

    <section class="trace-pillars-section">
        <div class="trace-section-heading">
            <p class="eyebrow">Les piliers</p>

            <h2>
                Une lecture claire de chaque étape.
            </h2>

            <p>
                L’objectif est simple : donner aux professionnels les informations nécessaires
                pour acheter, servir et présenter la viande avec sérieux.
            </p>
        </div>

        <div class="trace-pillars-grid">
            <article>
                <span>01</span>
                <h3>Origine identifiée</h3>
                <p>
                    Chaque animal s’inscrit dans un parcours clair, permettant de relier la pièce
                    à une origine et à une maison.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Pièces suivies</h3>
                <p>
                    Les morceaux principaux disposent d’une lecture précise : nom, quantité,
                    prix professionnel, disponibilité et niveau de réservation.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Demande conservée</h3>
                <p>
                    Les pré-réservations sont enregistrées afin de conserver une trace claire
                    des besoins exprimés par chaque professionnel.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>Confirmation maîtrisée</h3>
                <p>
                    La demande reste une pré-réservation jusqu’à validation finale des quantités
                    et modalités par Wagyu France.
                </p>
            </article>
        </div>
    </section>

    <section class="trace-flow-section">
        <div class="trace-flow-card">
            <div class="trace-flow-content">
                <p class="eyebrow">Parcours produit</p>

                <h2>
                    De l’animal à la demande professionnelle.
                </h2>

                <p>
                    La traçabilité devient utile lorsqu’elle accompagne le parcours réel du produit.
                    Wagyu France organise cette lecture autour de l’animal, des pièces, des volumes
                    et des demandes reçues.
                </p>

                <a href="{{ route('reserve.pro') }}">
                    Ouvrir la réserve professionnelle
                </a>
            </div>

            <div class="trace-flow-side">
                <div class="trace-flow-visual">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Parcours de découpe et suivi des volumes Wagyu"
                    >
                </div>

                <div class="trace-flow-list">
                    <article>
                        <span>01</span>
                        <strong>Animal identifié</strong>
                        <small>Une référence claire permet de suivre la réserve ouverte.</small>
                    </article>

                    <article>
                        <span>02</span>
                        <strong>Pièces sélectionnées</strong>
                        <small>Chaque morceau est associé à un usage, un prix et une disponibilité.</small>
                    </article>

                    <article>
                        <span>03</span>
                        <strong>Volumes demandés</strong>
                        <small>Les professionnels indiquent les quantités souhaitées.</small>
                    </article>

                    <article>
                        <span>04</span>
                        <strong>Validation finale</strong>
                        <small>Wagyu France confirme les disponibilités avant engagement définitif.</small>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="trace-data-section">
        <div class="trace-section-heading">
            <p class="eyebrow">Informations utiles</p>

            <h2>
                Des données pensées pour les professionnels.
            </h2>
        </div>

        <div class="trace-data-grid">
            <article>
                <div class="trace-data-visual">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Référence animal Wagyu France"
                    >
                </div>

                <h3>Référence animal</h3>
                <p>
                    Une référence permet d’identifier l’animal ouvert à la pré-réservation
                    et de relier les demandes à une même opération.
                </p>
            </article>

            <article>
                <div class="trace-data-visual">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Pièces et prix professionnels Wagyu"
                    >
                </div>

                <h3>Pièces & prix HT</h3>
                <p>
                    Les informations sont présentées avec une lecture professionnelle :
                    morceau, prix au kilo, quantité souhaitée et total estimatif HT.
                </p>
            </article>

            <article>
                <div class="trace-data-visual">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Statut de demande professionnelle Wagyu"
                    >
                </div>

                <h3>Statut de demande</h3>
                <p>
                    Chaque demande peut ensuite être suivie comme nouvelle, en cours,
                    confirmée ou traitée.
                </p>
            </article>
        </div>
    </section>

    <section class="trace-proof-section">
        <div class="trace-proof-card">
            <div>
                <p class="eyebrow">Pourquoi c’est important ?</p>

                <h2>
                    La traçabilité renforce autant la confiance que la valeur.
                </h2>

                <p>
                    Un chef ou un boucher ne vend pas seulement une pièce. Il raconte une origine,
                    une sélection, une rareté et une façon de travailler. Plus l’information est claire,
                    plus la viande peut être présentée avec justesse.
                </p>

                <p>
                    Dans une logique premium, la transparence n’affaiblit pas le produit :
                    elle le rend plus crédible, plus désirable et plus facile à défendre auprès
                    d’un client final exigeant.
                </p>
            </div>

            <div class="trace-proof-panel">
                <div class="trace-proof-image">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Confiance professionnelle Wagyu France"
                    >
                </div>

                <span>✦</span>

                <h3>Confiance professionnelle</h3>

                <p>
                    Origine, pièces, volumes, prix estimatif et statut : l’espace pro permet
                    de structurer la demande avec une lecture claire.
                </p>

                <ul>
                    <li>Référence animal</li>
                    <li>Pièces pré-réservées</li>
                    <li>Total estimatif HT</li>
                    <li>Confirmation par Wagyu France</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="trace-cta-section">
        <div class="trace-cta-card">
            <p class="eyebrow">Réserve professionnelle</p>

            <h2>
                Sélectionnez, suivez, confirmez.
            </h2>

            <p>
                Entrez dans l’espace professionnel pour sélectionner les pièces directement
                sur l’animal et transmettre une demande claire à Wagyu France.
            </p>

            <div>
                <a href="{{ route('reserve.pro') }}" class="trace-primary-button">
                    Accéder à la réserve pro
                </a>

                <a href="{{ route('contact') }}" class="trace-secondary-button">
                    Contacter Wagyu France
                </a>
            </div>
        </div>
    </section>

@endsection

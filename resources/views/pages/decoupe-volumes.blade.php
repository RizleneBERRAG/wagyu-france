@extends('layouts.app', [
    'title' => 'Découpe & Volumes — Wagyu France',
    'bodyClass' => 'decoupe-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/decoupe-volumes.css') }}">
@endpush

@section('content')

    <section class="cut-hero">
        <img
            class="cut-hero-bg"
            src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
            alt="Découpe professionnelle de pièces Wagyu"
        >

        <div class="cut-hero-overlay"></div>
        <div class="cut-hero-grid"></div>
        <div class="cut-red-glow"></div>
        <div class="cut-gold-glow"></div>

        <div class="cut-hero-inner">
            <div class="cut-hero-content">
                <p class="eyebrow">Découpe & volumes</p>

                <h1>
                    Organiser la demande
                    <span>avant la mise en découpe.</span>
                </h1>

                <p>
                    Wagyu France propose une approche professionnelle plus intelligente :
                    les pièces sont pré-réservées avant découpe afin de mieux anticiper
                    les volumes, limiter les pertes et valoriser chaque morceau de l’animal.
                </p>

                <div class="cut-hero-actions">
                    <a href="{{ route('reserve.pro') }}" class="cut-primary-button">
                        Accéder à la réserve pro
                    </a>

                    <a href="{{ route('professionnels') }}" class="cut-secondary-button">
                        Retour univers pro
                    </a>
                </div>
            </div>

            <div class="cut-hero-panel">
                <div class="cut-panel-image">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Réserve professionnelle Wagyu France"
                    >
                </div>

                <div class="cut-panel-head">
                    <span>Animal suivi</span>
                    <strong>WF-2026-01</strong>
                </div>

                <div class="cut-panel-progress">
                    <div>
                        <p>Seuil de pré-réservation</p>
                        <strong>68%</strong>
                    </div>

                    <i>
                        <b style="width: 68%"></b>
                    </i>
                </div>

                <div class="cut-panel-stats">
                    <article>
                        <span>Pièces</span>
                        <strong>7</strong>
                    </article>

                    <article>
                        <span>Lecture</span>
                        <strong>HT</strong>
                    </article>

                    <article>
                        <span>Statut</span>
                        <strong>Actif</strong>
                    </article>
                </div>

                <a href="{{ route('reserve.pro') }}">
                    Voir l’animal
                </a>
            </div>
        </div>
    </section>

    <section class="cut-intro-section">
        <div class="cut-intro-card">
            <div>
                <p class="eyebrow">Pourquoi cette méthode ?</p>

                <h2>
                    Une viande rare demande une gestion plus précise qu’un simple stock.
                </h2>
            </div>

            <div>
                <p>
                    Sur une viande d’exception, chaque pièce a une valeur, un usage et un public.
                    L’objectif n’est pas seulement de vendre vite, mais de répartir intelligemment
                    les morceaux selon la demande réelle des professionnels.
                </p>

                <p>
                    La pré-réservation permet de mieux savoir quels morceaux sont attendus,
                    quelles quantités sont souhaitées et à quel moment il devient pertinent
                    de lancer la mise en découpe.
                </p>
            </div>
        </div>
    </section>

    <section class="cut-process-section">
        <div class="cut-section-heading">
            <p class="eyebrow">Le principe</p>

            <h2>
                Une découpe déclenchée par la demande, pas par l’incertitude.
            </h2>

            <p>
                Le parcours professionnel transforme la commande en signal clair :
                chaque réservation contribue à construire une décision de découpe plus fiable.
            </p>
        </div>

        <div class="cut-process-grid">
            <article>
                <span>01</span>
                <h3>Un animal est ouvert à la réserve</h3>
                <p>
                    Wagyu France met à disposition un animal identifié, avec une sélection
                    de pièces disponibles à la pré-réservation.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Les pros choisissent leurs morceaux</h3>
                <p>
                    Chefs, restaurants et boucheries sélectionnent les pièces qui correspondent
                    à leurs besoins : carte, vitrine, événement ou dégustation.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Les volumes se consolident</h3>
                <p>
                    Les quantités demandées sont regroupées pour mesurer le niveau de demande
                    et mieux anticiper la valorisation globale de l’animal.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>La découpe peut être lancée</h3>
                <p>
                    Lorsque le seuil est suffisant, Wagyu France confirme les demandes
                    et organise la préparation dans de meilleures conditions.
                </p>
            </article>
        </div>
    </section>

    <section class="cut-balance-section">
        <div class="cut-balance-card">
            <div class="cut-balance-content">
                <p class="eyebrow">Équilibre des pièces</p>

                <h2>
                    Chaque morceau doit trouver sa place.
                </h2>

                <p>
                    Les pièces nobles attirent naturellement l’attention, mais un animal
                    ne se résume pas à quelques morceaux premium. La vraie valeur réside
                    dans la capacité à comprendre, répartir et valoriser l’ensemble de la découpe.
                </p>

                <p>
                    Cette approche aide Wagyu France à piloter la demande de manière plus fine :
                    les pièces les plus recherchées sont suivies, les morceaux complémentaires
                    sont mieux présentés, et les professionnels peuvent construire une demande
                    plus cohérente.
                </p>

                <a href="{{ route('reserve.pro') }}">
                    Pré-réserver une pièce
                </a>
            </div>

            <div class="cut-balance-side">
                <div class="cut-balance-visual">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Organisation des volumes Wagyu"
                    >
                </div>

                <div class="cut-balance-map">
                    <article class="is-high">
                        <span>Très demandé</span>
                        <strong>Filet</strong>
                        <small>Pièce noble · faible volume</small>
                    </article>

                    <article>
                        <span>Signature</span>
                        <strong>Entrecôte</strong>
                        <small>Persillage · restauration premium</small>
                    </article>

                    <article>
                        <span>Équilibre</span>
                        <strong>Rumsteak</strong>
                        <small>Caractère · rendement</small>
                    </article>

                    <article>
                        <span>Valorisation</span>
                        <strong>Paleron</strong>
                        <small>Cuisson lente · carte bistronomique</small>
                    </article>

                    <article>
                        <span>Technique</span>
                        <strong>Jarret</strong>
                        <small>Jus · bouillons · mijotés</small>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="cut-volume-section">
        <div class="cut-section-heading">
            <p class="eyebrow">Lecture professionnelle</p>

            <h2>
                Des volumes lisibles, des demandes mieux qualifiées.
            </h2>
        </div>

        <div class="cut-volume-grid">
            <article>
                <div class="cut-volume-visual">
                    <img
                        src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                        alt="Quantité professionnelle Wagyu"
                    >
                </div>

                <h3>Quantité souhaitée</h3>
                <p>
                    Chaque professionnel indique le volume nécessaire pour chaque pièce.
                    Cela permet d’anticiper la demande avant validation.
                </p>
            </article>

            <article>
                <div class="cut-volume-visual">
                    <img
                        src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                        alt="Total estimatif professionnel"
                    >
                </div>

                <h3>Total estimatif HT</h3>
                <p>
                    La lecture est pensée pour les professionnels avec une estimation claire,
                    hors taxes, avant confirmation définitive.
                </p>
            </article>

            <article>
                <div class="cut-volume-visual">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Statut de réservation Wagyu"
                    >
                </div>

                <h3>Statut de réservation</h3>
                <p>
                    Le niveau de réservation permet de comprendre si l’animal approche
                    du seuil pertinent pour mise en découpe.
                </p>
            </article>
        </div>
    </section>

    <section class="cut-scenario-section">
        <div class="cut-scenario-card">
            <div>
                <p class="eyebrow">Exemple de scénario</p>

                <h2>
                    Une demande pro peut transformer la décision de découpe.
                </h2>

                <p>
                    Un restaurant réserve plusieurs kilos d’entrecôte et de filet. Une boucherie
                    complète avec du rumsteak, du paleron et des pièces à cuisson lente.
                    Les demandes se complètent, le seuil progresse, et la découpe devient
                    plus cohérente économiquement.
                </p>
            </div>

            <div class="cut-scenario-side">
                <div class="cut-scenario-visual">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Suivi professionnel Wagyu France"
                    >
                </div>

                <div class="cut-scenario-flow">
                    <article>
                        <span>Chef</span>
                        <strong>Filet · Entrecôte</strong>
                    </article>

                    <i></i>

                    <article>
                        <span>Boucherie</span>
                        <strong>Rumsteak · Paleron</strong>
                    </article>

                    <i></i>

                    <article>
                        <span>Wagyu France</span>
                        <strong>Découpe confirmée</strong>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="cut-cta-section">
        <div class="cut-cta-card">
            <p class="eyebrow">Réserve professionnelle</p>

            <h2>
                Sélectionnez vos pièces directement sur l’animal.
            </h2>

            <p>
                Entrez dans l’interface professionnelle, choisissez vos morceaux,
                indiquez vos quantités et transmettez votre demande de pré-réservation.
            </p>

            <div>
                <a href="{{ route('reserve.pro') }}" class="cut-primary-button">
                    Accéder à la réserve pro
                </a>

                <a href="{{ route('tracabilite') }}" class="cut-secondary-button">
                    Voir la traçabilité
                </a>
            </div>
        </div>
    </section>

@endsection

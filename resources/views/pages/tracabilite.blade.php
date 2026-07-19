@extends('layouts.app', [
    'title' => 'Traçabilité du Wagyu français — Wagyu France',
    'description' => 'Découvrez comment Wagyu France organise l’identification des animaux, le suivi des pièces et les informations transmises aux professionnels.',
    'bodyClass' => 'tracabilite-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tracabilite.css') }}">
@endpush

@section('content')

    <section class="trace-hero">
        <div class="trace-shell trace-hero-grid">
            <div class="trace-hero-copy">
                <p class="trace-kicker">Wagyu France · Traçabilité</p>

                <h1>
                    Connaître l’origine,
                    <em>comprendre chaque pièce.</em>
                </h1>

                <p class="trace-hero-lead">
                    Pour servir une viande d’exception avec justesse, il faut pouvoir expliquer son origine,
                    son identification, sa découpe et les informations qui accompagnent la commande.
                    Wagyu France organise cette lecture pour les professionnels.
                </p>

                <div class="trace-hero-actions">
                    <a href="#parcours" class="trace-button trace-button-primary">
                        Découvrir le parcours
                    </a>
                    <a href="{{ route('reserve.pro') }}" class="trace-button trace-button-secondary">
                        Accéder à la réserve
                    </a>
                </div>

                <dl class="trace-hero-facts">
                    <div>
                        <dt>Identifier</dt>
                        <dd>Relier l’animal au dossier</dd>
                    </div>
                    <div>
                        <dt>Suivre</dt>
                        <dd>Organiser les pièces et volumes</dd>
                    </div>
                    <div>
                        <dt>Transmettre</dt>
                        <dd>Partager les informations utiles</dd>
                    </div>
                </dl>
            </div>

            <figure class="trace-hero-visual">
                <img
                    src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                    alt="Suivi et traçabilité professionnelle du Wagyu"
                >

                <figcaption>
                    <span>Dossier de suivi</span>
                    <strong>Une information claire, reliée à une sélection précise.</strong>
                </figcaption>

                <div class="trace-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Traçabilité</small>
                </div>
            </figure>
        </div>
    </section>

    <nav class="trace-chapters" aria-label="Sommaire Traçabilité" data-section-nav>
        <div class="trace-shell trace-chapters-grid">
            <a href="#principes"><span>01</span> Les principes</a>
            <a href="#parcours"><span>02</span> Le parcours</a>
            <a href="#informations"><span>03</span> Les informations</a>
            <a href="#transmission"><span>04</span> La transmission</a>
        </div>
    </nav>

    <section class="trace-section trace-intro" id="principes">
        <div class="trace-shell trace-intro-grid">
            <div class="trace-intro-heading">
                <p class="trace-kicker">Une confiance construite</p>
                <h2>
                    La traçabilité ne doit pas être
                    <em>une simple mention.</em>
                </h2>
            </div>

            <div class="trace-intro-copy">
                <p class="trace-dropcap">
                    Elle doit permettre de relier une demande professionnelle à un animal identifié,
                    à des pièces définies et à des volumes confirmés par la maison.
                </p>
                <p>
                    Cette méthode évite les informations vagues et aide chaque chef, boucher ou traiteur
                    à présenter le produit avec davantage de précision auprès de ses propres clients.
                </p>
            </div>
        </div>
    </section>

    <section class="trace-section trace-pillars">
        <div class="trace-shell">
            <header class="trace-section-heading">
                <div>
                    <p class="trace-kicker">Les quatre repères</p>
                    <h2>Une information organisée autour de faits vérifiables.</h2>
                </div>
                <p>
                    Chaque dossier professionnel est construit autour d’éléments concrets,
                    utiles avant la confirmation comme lors de la livraison.
                </p>
            </header>

            <div class="trace-pillar-grid">
                <article>
                    <span>01</span>
                    <h3>Origine</h3>
                    <p>Le produit est rattaché à son origine française et à la maison qui le sélectionne.</p>
                </article>

                <article>
                    <span>02</span>
                    <h3>Identification</h3>
                    <p>Une référence de dossier permet de regrouper les pièces et les demandes associées.</p>
                </article>

                <article>
                    <span>03</span>
                    <h3>Découpe</h3>
                    <p>Chaque morceau est nommé, quantifié et relié à un usage professionnel précis.</p>
                </article>

                <article>
                    <span>04</span>
                    <h3>Confirmation</h3>
                    <p>Les volumes, montants et modalités sont validés avant tout engagement définitif.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="trace-journey" id="parcours">
        <div class="trace-shell trace-journey-grid">
            <div class="trace-journey-copy">
                <p class="trace-kicker">La chaîne de suivi</p>
                <h2>
                    De l’animal identifié
                    <em>à la pièce livrée.</em>
                </h2>
                <p>
                    La valeur de la traçabilité réside dans la continuité. Chaque étape doit conserver
                    un lien lisible avec la précédente, afin d’éviter les ruptures d’information.
                </p>
                <a href="{{ route('decoupe-volumes') }}" class="trace-text-link">
                    Comprendre la découpe et les volumes <span>→</span>
                </a>
            </div>

            <div class="trace-journey-steps">
                <article>
                    <span>01</span>
                    <div>
                        <strong>Animal identifié</strong>
                        <p>Une référence de travail rassemble les informations liées à la sélection.</p>
                    </div>
                </article>
                <article>
                    <span>02</span>
                    <div>
                        <strong>Pièces répertoriées</strong>
                        <p>Les morceaux proposés sont nommés avec leurs volumes indicatifs et leurs usages.</p>
                    </div>
                </article>
                <article>
                    <span>03</span>
                    <div>
                        <strong>Demande enregistrée</strong>
                        <p>Le besoin du professionnel est conservé avec les quantités et coordonnées utiles.</p>
                    </div>
                </article>
                <article>
                    <span>04</span>
                    <div>
                        <strong>Commande confirmée</strong>
                        <p>La maison vérifie la disponibilité, le montant, le format et la livraison.</p>
                    </div>
                </article>
                <article>
                    <span>05</span>
                    <div>
                        <strong>Informations transmises</strong>
                        <p>Les éléments correspondant au dossier confirmé accompagnent la relation professionnelle.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="trace-section trace-dossier" id="informations">
        <div class="trace-shell trace-dossier-grid">
            <div class="trace-dossier-visual">
                <img
                    src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                    alt="Dossier de sélection professionnelle Wagyu France"
                >
                <div>
                    <span>Dossier illustratif</span>
                    <strong>WF-2026-01</strong>
                </div>
            </div>

            <div class="trace-dossier-content">
                <p class="trace-kicker">Ce que rassemble un dossier</p>
                <h2>Les informations utiles, au même endroit.</h2>
                <p>
                    La référence affichée ci-dessous illustre la structure de suivi utilisée sur la réserve.
                    Les informations définitives dépendent toujours de la sélection réellement confirmée.
                </p>

                <dl class="trace-dossier-list">
                    <div>
                        <dt>Référence</dt>
                        <dd>Identification du dossier professionnel</dd>
                    </div>
                    <div>
                        <dt>Origine</dt>
                        <dd>France · sélection Wagyu France</dd>
                    </div>
                    <div>
                        <dt>Pièces</dt>
                        <dd>Morceaux demandés et quantités associées</dd>
                    </div>
                    <div>
                        <dt>Lecture tarifaire</dt>
                        <dd>Estimation HT puis montant confirmé</dd>
                    </div>
                    <div>
                        <dt>Statut</dt>
                        <dd>Demandé, étudié, confirmé ou traité</dd>
                    </div>
                    <div>
                        <dt>Livraison</dt>
                        <dd>Modalités précisées après validation</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <section class="trace-section trace-uses">
        <div class="trace-shell">
            <header class="trace-section-heading">
                <div>
                    <p class="trace-kicker">Une information faite pour être utilisée</p>
                    <h2>Trois métiers, trois façons de transmettre la confiance.</h2>
                </div>
                <p>
                    La traçabilité prend tout son sens lorsqu’elle aide réellement le professionnel
                    à conseiller, présenter ou raconter le produit.
                </p>
            </header>

            <div class="trace-use-grid">
                <article>
                    <span>Restaurant</span>
                    <h3>Présenter une origine</h3>
                    <p>Donner au personnel de salle les informations nécessaires pour expliquer la sélection sans surpromesse.</p>
                    <ul>
                        <li>Origine du produit</li>
                        <li>Nom de la pièce</li>
                        <li>Usage et préparation</li>
                    </ul>
                </article>

                <article>
                    <span>Boucherie</span>
                    <h3>Conseiller avec précision</h3>
                    <p>Relier chaque morceau à son usage, à son format de vente et à la sélection professionnelle correspondante.</p>
                    <ul>
                        <li>Pièce identifiée</li>
                        <li>Format de découpe</li>
                        <li>Conseil de cuisson</li>
                    </ul>
                </article>

                <article>
                    <span>Traiteur</span>
                    <h3>Sécuriser une prestation</h3>
                    <p>Conserver une lecture claire des volumes et des pièces prévus pour une échéance ou un événement précis.</p>
                    <ul>
                        <li>Dossier de demande</li>
                        <li>Quantités confirmées</li>
                        <li>Modalités de livraison</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="trace-transmission" id="transmission">
        <div class="trace-shell trace-transmission-grid">
            <div class="trace-transmission-copy">
                <p class="trace-kicker">L’engagement de la maison</p>
                <h2>Dire ce qui est confirmé. Distinguer ce qui reste estimatif.</h2>
                <p>
                    La réserve professionnelle permet d’exprimer une intention. Elle ne transforme pas une estimation
                    en engagement automatique. Wagyu France confirme ensuite les informations réellement disponibles
                    avant que la commande ne soit considérée comme définitive.
                </p>
            </div>

            <div class="trace-transmission-points">
                <article>
                    <span>01</span>
                    <div>
                        <strong>Pas de promesse automatique</strong>
                        <p>La disponibilité affichée reste indicative jusqu’à la réponse de la maison.</p>
                    </div>
                </article>
                <article>
                    <span>02</span>
                    <div>
                        <strong>Pas de confusion tarifaire</strong>
                        <p>Le panier présente une estimation HT, puis le montant final est confirmé.</p>
                    </div>
                </article>
                <article>
                    <span>03</span>
                    <div>
                        <strong>Pas d’information générique</strong>
                        <p>Les éléments transmis correspondent au dossier et aux pièces réellement validés.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="trace-quote">
        <div class="trace-shell trace-quote-inner">
            <span aria-hidden="true">“</span>
            <blockquote>
                La confiance ne vient pas d’un discours plus long, mais d’une information plus précise.
            </blockquote>
            <p>Wagyu France · Relation professionnelle</p>
        </div>
    </section>

    <section data-nav-end class="trace-section trace-contact">
        <div class="trace-shell trace-contact-card">
            <div>
                <p class="trace-kicker">Votre dossier professionnel</p>
                <h2>Sélectionnez vos pièces ou échangez directement avec la maison.</h2>
                <p>
                    La réserve permet de constituer une première demande. Pour une question particulière
                    sur l’origine, les documents ou les modalités, contactez Wagyu France.
                </p>
            </div>

            <div class="trace-contact-actions">
                <a href="{{ route('reserve.pro') }}" class="trace-button trace-button-light">
                    Accéder à la réserve
                </a>
                <a href="{{ route('contact') }}" class="trace-contact-link">
                    Contacter Wagyu France <span>→</span>
                </a>
            </div>
        </div>
    </section>

@endsection
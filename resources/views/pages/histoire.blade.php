@extends('layouts.app', [
    'title' => 'Notre histoire — Wagyu France',
    'description' => 'Découvrez l’histoire de Wagyu France et du Domaine du Tilleul : une maison française guidée par le temps, l’élevage, la sélection et le respect du produit.',
    'bodyClass' => 'histoire-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/histoire.css') }}">
@endpush

@section('content')

    <section class="story-hero">
        <div class="story-shell story-hero-grid">
            <div class="story-hero-copy">
                <div class="story-kicker-line">
                    <span></span>
                    <p class="story-kicker">Maison française · Domaine du Tilleul</p>
                </div>

                <div class="story-hero-edition" aria-hidden="true">
                    <span>Édition</span>
                    <strong>01</strong>
                </div>

                <h1>
                    Le temps comme
                    <em>premier savoir-faire.</em>
                </h1>

                <p class="story-hero-lead">
                    Wagyu France est née d’une conviction simple&nbsp;: une viande remarquable ne se
                    fabrique pas dans l’urgence. Elle se construit lentement, par l’attention portée
                    au vivant, par la précision des choix et par le respect de chaque étape.
                </p>

                <div class="story-hero-actions">
                    <a href="#le-domaine" class="story-button story-button-primary">Découvrir le domaine</a>
                    <a href="{{ route('wagyu') }}" class="story-button story-button-secondary">Comprendre le Wagyu</a>
                </div>

                <div class="story-hero-signature">
                    <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="">
                    <div>
                        <span>Wagyu France</span>
                        <strong>Élever, sélectionner, transmettre.</strong>
                    </div>
                </div>
            </div>

            <div class="story-hero-media">
                <figure class="story-hero-main-image">
                    <img
                        src="{{ asset('assets/images/histoire/domaine-wagyu-france.jpg') }}"
                        alt="Le Domaine du Tilleul, maison de Wagyu France"
                    >
                    <figcaption>
                        <span>Le lieu</span>
                        <strong>Domaine du Tilleul</strong>
                    </figcaption>
                </figure>

                <figure class="story-hero-detail-image">
                    <img
                        src="{{ asset('assets/images/histoire/maison-wagyu-france.jpg') }}"
                        alt="La maison Wagyu France"
                    >
                    <figcaption>Une maison pensée autour du produit.</figcaption>
                </figure>

                <div class="story-hero-seal" aria-hidden="true">
                    <span>W</span>
                    <small>Maison française</small>
                </div>
            </div>
        </div>
    </section>

    <nav class="story-chapters" aria-label="Sommaire de notre histoire">
        <div class="story-shell story-chapters-grid">
            <a href="#vision"><span>01</span>Notre vision</a>
            <a href="#le-domaine"><span>02</span>Le domaine</a>
            <a href="#notre-methode"><span>03</span>Notre méthode</a>
            <a href="#transmission"><span>04</span>La transmission</a>
        </div>
    </nav>

    <section class="story-manifesto" id="vision">
        <div class="story-shell story-manifesto-grid">
            <div class="story-section-index" aria-hidden="true">01</div>

            <div class="story-manifesto-title">
                <p class="story-kicker">Notre vision</p>
                <h2>Remettre de la valeur dans chaque morceau.</h2>
            </div>

            <div class="story-manifesto-copy">
                <p class="story-dropcap">
                    Derrière une pièce de Wagyu, il y a une origine, un élevage, du temps, une sélection
                    et un geste de découpe. Notre rôle est de rendre cette histoire visible, pour que la
                    valeur du produit ne soit jamais réduite à son seul persillage.
                </p>
                <p>
                    Nous voulons proposer une expérience claire et sincère&nbsp;: comprendre ce que l’on
                    choisit, savoir comment le préparer et savourer une viande rare sans la dénaturer.
                </p>
            </div>
        </div>
    </section>

    <section class="story-values">
        <div class="story-shell">
            <header class="story-heading story-heading-centered">
                <p class="story-kicker">Ce qui nous guide</p>
                <h2>Quatre principes. Une même exigence.</h2>
            </header>

            <div class="story-values-grid">
                <article>
                    <span class="story-value-number">01</span>
                    <div class="story-value-mark" aria-hidden="true">T</div>
                    <h3>Le temps</h3>
                    <p>Ne jamais précipiter ce qui doit mûrir. La qualité se construit dans la durée.</p>
                </article>

                <article>
                    <span class="story-value-number">02</span>
                    <div class="story-value-mark" aria-hidden="true">O</div>
                    <h3>L’origine</h3>
                    <p>Connaître le lieu, l’histoire et le parcours qui donnent sa singularité au produit.</p>
                </article>

                <article>
                    <span class="story-value-number">03</span>
                    <div class="story-value-mark" aria-hidden="true">J</div>
                    <h3>La justesse</h3>
                    <p>Présenter chaque morceau selon son véritable caractère, son usage et sa cuisson.</p>
                </article>

                <article>
                    <span class="story-value-number">04</span>
                    <div class="story-value-mark" aria-hidden="true">C</div>
                    <h3>La confiance</h3>
                    <p>Expliquer avec clarté, conseiller avec précision et construire une relation durable.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="story-domain" id="le-domaine">
        <div class="story-shell story-domain-grid">
            <div class="story-domain-media">
                <figure>
                    <img
                        src="{{ asset('assets/images/histoire/elevage-wagyu.jpg') }}"
                        alt="Élevage Wagyu au Domaine du Tilleul"
                    >
                    <figcaption>
                        <span>Domaine du Tilleul</span>
                        <strong>Le vivant avant le produit</strong>
                    </figcaption>
                </figure>
                <div class="story-domain-frame" aria-hidden="true"></div>
                <div class="story-domain-reference">WF · 02</div>
            </div>

            <div class="story-domain-copy">
                <p class="story-kicker">Le domaine</p>
                <h2>Tout commence bien avant la découpe.</h2>

                <p class="story-domain-intro">
                    La qualité d’une viande se prépare dès l’élevage. Le rythme, l’attention quotidienne
                    et la régularité du travail façonnent progressivement ce que l’on retrouvera ensuite
                    dans l’assiette.
                </p>

                <div class="story-domain-points">
                    <article>
                        <span>01</span>
                        <div>
                            <strong>Observer</strong>
                            <p>Comprendre le vivant et adapter les gestes plutôt que d’imposer un rythme.</p>
                        </div>
                    </article>
                    <article>
                        <span>02</span>
                        <div>
                            <strong>Accompagner</strong>
                            <p>Créer les conditions d’un développement régulier et respectueux.</p>
                        </div>
                    </article>
                    <article>
                        <span>03</span>
                        <div>
                            <strong>Patienter</strong>
                            <p>Laisser le temps révéler la texture, le persillage et le caractère.</p>
                        </div>
                    </article>
                </div>

                <a href="{{ route('contact') }}" class="story-text-link">Échanger avec la maison <span>→</span></a>
            </div>
        </div>
    </section>

    <section class="story-method" id="notre-methode">
        <div class="story-shell">
            <header class="story-heading story-heading-split">
                <div>
                    <p class="story-kicker">Notre méthode</p>
                    <h2>De l’élevage à votre table.</h2>
                </div>
                <p>
                    Une pièce remarquable est le résultat d’une succession de décisions précises.
                    Chacune doit préserver ce qui a été construit auparavant.
                </p>
            </header>

            <div class="story-method-track">
                <article>
                    <span class="story-method-number">01</span>
                    <div class="story-method-line"></div>
                    <p class="story-method-label">Le vivant</p>
                    <h3>Élever</h3>
                    <p>Accompagner le développement avec constance, calme et attention.</p>
                </article>

                <article>
                    <span class="story-method-number">02</span>
                    <div class="story-method-line"></div>
                    <p class="story-method-label">Le regard</p>
                    <h3>Sélectionner</h3>
                    <p>Lire la matière, reconnaître le potentiel et attribuer le bon usage.</p>
                </article>

                <article>
                    <span class="story-method-number">03</span>
                    <div class="story-method-line"></div>
                    <p class="story-method-label">Le geste</p>
                    <h3>Découper</h3>
                    <p>Valoriser chaque partie avec une découpe adaptée et une préparation précise.</p>
                </article>

                <article>
                    <span class="story-method-number">04</span>
                    <div class="story-method-line"></div>
                    <p class="story-method-label">Le partage</p>
                    <h3>Transmettre</h3>
                    <p>Donner les clés pour choisir, cuire et apprécier sans masquer le produit.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="story-quote">
        <div class="story-shell story-quote-inner">
            <div class="story-quote-monogram" aria-hidden="true">WF</div>
            <blockquote>
                «&nbsp;Le luxe n’est pas d’en faire trop. C’est de ne rien laisser au hasard.&nbsp;»
            </blockquote>
            <p>La philosophie Wagyu France</p>
        </div>
    </section>

    <section class="story-transmission" id="transmission">
        <div class="story-shell story-transmission-grid">
            <div class="story-transmission-copy">
                <p class="story-kicker">La transmission</p>
                <h2>Une maison, deux façons de partager le produit.</h2>
                <p>
                    Le particulier recherche une dégustation juste et bien accompagnée. Le professionnel
                    a besoin d’anticiper ses volumes, ses découpes et son organisation. Nous avons donc
                    créé deux parcours distincts, guidés par la même exigence.
                </p>
            </div>

            <div class="story-paths">
                <article class="story-path story-path-private">
                    <div class="story-path-top">
                        <span>01</span>
                        <small>Pour les particuliers</small>
                    </div>
                    <h3>Déguster</h3>
                    <p>Découvrir les pièces, comprendre leurs caractères et préparer un moment qui compte.</p>
                    <ul>
                        <li>Sélection de pièces</li>
                        <li>Conseils de quantité</li>
                        <li>Recommandations de cuisson</li>
                    </ul>
                    <a href="{{ route('boutique') }}">Accéder à la boutique <span>→</span></a>
                </article>

                <article class="story-path story-path-pro">
                    <div class="story-path-top">
                        <span>02</span>
                        <small>Pour les professionnels</small>
                    </div>
                    <h3>Anticiper</h3>
                    <p>Pré-réserver les pièces, préciser les volumes et construire une demande sur mesure.</p>
                    <ul>
                        <li>Réserve avant découpe</li>
                        <li>Choix des volumes</li>
                        <li>Suivi des demandes</li>
                    </ul>
                    <a href="{{ route('reserve.pro') }}">Accéder à la réserve <span>→</span></a>
                </article>
            </div>
        </div>
    </section>

    <section class="story-final">
        <div class="story-shell story-final-card">
            <div class="story-final-mark" aria-hidden="true">
                <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="">
            </div>

            <div class="story-final-copy">
                <p class="story-kicker">La suite de l’histoire</p>
                <h2>Choisissez la pièce qui écrira votre prochain repas.</h2>
                <p>
                    Découvrez notre sélection de Wagyu français ou approfondissez les particularités
                    de cette viande avant de faire votre choix.
                </p>
            </div>

            <div class="story-final-actions">
                <a href="{{ route('boutique') }}" class="story-button story-button-light">Découvrir la boutique</a>
                <a href="{{ route('wagyu') }}" class="story-final-link">Le Wagyu en détail <span>→</span></a>
            </div>
        </div>
    </section>

@endsection
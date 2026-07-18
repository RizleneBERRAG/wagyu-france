@extends('layouts.app', [
    'title' => 'Le Wagyu français — Persillage, goût et dégustation | Wagyu France',
    'description' => 'Comprendre le Wagyu français : persillage, tendreté, sensations en bouche, choix des pièces et conseils de cuisson par Wagyu France.',
    'bodyClass' => 'wagyu-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/wagyu.css') }}">
@endpush

@section('content')

    <section class="wagyu-hero">
        <div class="wagyu-shell wagyu-hero-grid">
            <div class="wagyu-hero-copy">
                <div class="wagyu-editorial-mark">
                    <span>Collection découverte</span>
                </div>

                <p class="wagyu-kicker">Comprendre le Wagyu</p>

                <h1>
                    Une viande d’exception,
                    <em>reconnaissable entre toutes.</em>
                </h1>

                <p class="wagyu-hero-lead">
                    Le Wagyu se distingue par un persillage fin, une texture fondante et une longueur
                    en bouche singulière. Sa dégustation repose sur peu d’artifices&nbsp;: une belle pièce,
                    une cuisson précise et le respect du produit.
                </p>

            </div>

            <figure class="wagyu-hero-visual">
                <div class="wagyu-hero-frame" aria-hidden="true"></div>

                <img
                    src="{{ asset('assets/images/wagyu/wagyu-hero.jpg') }}"
                    alt="Pièce de Wagyu français préparée avec soin"
                >

                <figcaption>
                    <span>Wagyu France · Édition du Domaine</span>
                    <strong>La matière avant l’artifice.</strong>
                    <small>Élevage français · Sélection · Dégustation</small>
                </figcaption>

                <div class="wagyu-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Maison française</small>
                </div>
            </figure>
        </div>

        <div class="wagyu-shell">
            <dl class="wagyu-hero-facts">
                <div>
                    <dt>Texture</dt>
                    <dd>Fondante et délicate</dd>
                </div>
                <div>
                    <dt>Signature</dt>
                    <dd>Persillage intramusculaire</dd>
                </div>
                <div>
                    <dt>Dégustation</dt>
                    <dd>Portions mesurées</dd>
                </div>
            </dl>
        </div>
    </section>

    <nav class="wagyu-chapter-nav" aria-label="Sommaire de la page" data-section-nav>
        <div class="wagyu-shell">
            <a href="#singularite"><span>01</span> Singularité</a>
            <a href="#persillage"><span>02</span> Persillage</a>
            <a href="#sensations"><span>03</span> Sensations</a>
            <a href="#pieces"><span>04</span> Les pièces</a>
            <a href="#degustation"><span>05</span> Dégustation</a>
        </div>
    </nav>

    <section class="wagyu-intro wagyu-section" id="singularite">
        <div class="wagyu-shell">
            <div class="wagyu-intro-top">
                <header class="wagyu-section-heading">
                    <p class="wagyu-kicker">Une viande à part</p>
                    <h2>
                        Le Wagyu ne se déguste pas
                        <em>comme une viande classique.</em>
                    </h2>
                </header>

                <p class="wagyu-lead-paragraph">
                    Sa richesse ne vient pas uniquement de son intensité. Elle réside dans un équilibre
                    rare entre tendreté, gras intramusculaire, jutosité et profondeur aromatique.
                </p>
            </div>

            <div class="wagyu-intro-columns">
                <p>
                    Une portion mesurée suffit souvent à révéler toute la personnalité du produit.
                    Le Wagyu invite à ralentir, à observer la matière et à privilégier une cuisson courte.
                </p>
                <p>
                    Chaque pièce possède son propre registre&nbsp;: certaines sont délicates et précises,
                    d’autres plus puissantes, charnues ou adaptées à des cuissons longues.
                </p>
            </div>

            <blockquote class="wagyu-intro-quote">
                <p>Une viande généreuse ne demande pas davantage. Elle demande davantage d’attention.</p>
            </blockquote>
        </div>
    </section>

    <section class="wagyu-marbling wagyu-section" id="persillage">
        <div class="wagyu-shell wagyu-marbling-grid">
            <figure class="wagyu-marbling-visual">
                <div class="wagyu-offset-frame" aria-hidden="true"></div>
                <img
                    src="{{ asset('assets/images/wagyu/persillage-wagyu.jpg') }}"
                    alt="Gros plan sur le persillage d'une pièce de Wagyu"
                >
                <figcaption>
                    <span>Observation de la matière</span>
                    <strong>Fines veines de gras intramusculaire</strong>
                </figcaption>
            </figure>

            <div class="wagyu-marbling-content">
                <p class="wagyu-kicker">Le persillage</p>
                <h2>Ce marbrage fin qui transforme la dégustation.</h2>

                <p>
                    Le persillage désigne les veines de gras présentes à l’intérieur même du muscle.
                    À la cuisson, elles fondent progressivement, nourrissent la chair et contribuent
                    à la texture caractéristique du Wagyu.
                </p>

                <p>
                    Il ne s’agit donc pas seulement d’un aspect visuel. Le persillage influence directement
                    la tendreté, la jutosité, les arômes et la sensation de longueur en bouche.
                </p>

                <div class="wagyu-marbling-notes">
                    <article>
                        <span>01</span>
                        <div>
                            <strong>Fondant</strong>
                            <p>Le gras se diffuse dans la matière sans l’alourdir lorsqu’il est bien maîtrisé.</p>
                        </div>
                    </article>
                    <article>
                        <span>02</span>
                        <div>
                            <strong>Jutosité</strong>
                            <p>La viande conserve une sensation souple et généreuse après la cuisson.</p>
                        </div>
                    </article>
                    <article>
                        <span>03</span>
                        <div>
                            <strong>Arômes</strong>
                            <p>La richesse aromatique se développe progressivement au fil de la dégustation.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="wagyu-sensory wagyu-section" id="sensations">
        <div class="wagyu-shell">
            <div class="wagyu-heading-row">
                <header class="wagyu-section-heading">
                    <p class="wagyu-kicker">Profil sensoriel</p>
                    <h2>Trois sensations, une même signature.</h2>
                </header>

                <p>
                    Le Wagyu ne se résume pas à une viande tendre. Son intérêt vient de la succession
                    des sensations, de la première bouchée jusqu’à la finale aromatique.
                </p>
            </div>

            <div class="wagyu-sensory-grid" data-reveal>
                <article>
                    <div class="wagyu-card-topline">
                        <span>01</span>
                        <small>Toucher</small>
                    </div>
                    <h3>Fondant</h3>
                    <p>
                        Une texture souple et presque beurrée, qui s’exprime sans demander une cuisson longue.
                    </p>
                    <div class="wagyu-card-scale-head"><small>Intensité</small><span>92&nbsp;%</span></div>
                    <div class="wagyu-card-scale"><i style="width: 92%"></i></div>
                </article>

                <article>
                    <div class="wagyu-card-topline">
                        <span>02</span>
                        <small>Bouche</small>
                    </div>
                    <h3>Jutosité</h3>
                    <p>
                        Une sensation ample et enveloppante, portée par la fonte progressive du persillage.
                    </p>
                    <div class="wagyu-card-scale-head"><small>Intensité</small><span>86&nbsp;%</span></div>
                    <div class="wagyu-card-scale"><i style="width: 86%"></i></div>
                </article>

                <article>
                    <div class="wagyu-card-topline">
                        <span>03</span>
                        <small>Finale</small>
                    </div>
                    <h3>Longueur</h3>
                    <p>
                        Le goût reste présent après la bouchée, avec une finale douce, profonde et persistante.
                    </p>
                    <div class="wagyu-card-scale-head"><small>Intensité</small><span>89&nbsp;%</span></div>
                    <div class="wagyu-card-scale"><i style="width: 89%"></i></div>
                </article>
            </div>
        </div>
    </section>

    <section class="wagyu-cuts wagyu-section" id="pieces">
        <div class="wagyu-shell">
            <div class="wagyu-heading-row wagyu-heading-row-cuts">
                <header class="wagyu-section-heading">
                    <p class="wagyu-kicker">Le choix des pièces</p>
                    <h2>Une expression différente selon le morceau.</h2>
                </header>

                <a href="{{ route('boutique') }}" class="wagyu-text-link">Explorer toute la boutique <span>→</span></a>
            </div>

            <div class="wagyu-cuts-grid">
                <article class="wagyu-cut-card">
                    <a href="{{ route('boutique') }}#selection" class="wagyu-cut-image">
                        <img src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}" alt="Entrecôte Wagyu">
                        <span>Collection signature</span>
                        <small>Pièce 01</small>
                    </a>
                    <div class="wagyu-cut-body">
                        <p>Intensité · Persillage</p>
                        <h3>Entrecôte</h3>
                        <span>Généreuse, ample et particulièrement expressive à la cuisson.</span>
                        <dl>
                            <div><dt>Cuisson</dt><dd>Saisie vive</dd></div>
                            <div><dt>Profil</dt><dd>Intense</dd></div>
                        </dl>
                    </div>
                </article>

                <article class="wagyu-cut-card">
                    <a href="{{ route('boutique') }}#selection" class="wagyu-cut-image">
                        <img src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}" alt="Filet Wagyu">
                        <span>Collection délicatesse</span>
                        <small>Pièce 02</small>
                    </a>
                    <div class="wagyu-cut-body">
                        <p>Tendreté · Finesse</p>
                        <h3>Filet</h3>
                        <span>Une pièce précise et délicate, recherchée pour sa texture fondante.</span>
                        <dl>
                            <div><dt>Cuisson</dt><dd>Courte</dd></div>
                            <div><dt>Profil</dt><dd>Délicat</dd></div>
                        </dl>
                    </div>
                </article>

                <article class="wagyu-cut-card">
                    <a href="{{ route('boutique') }}#selection" class="wagyu-cut-image">
                        <img src="{{ asset('assets/images/boutique/faux-filet-wagyu.jpg') }}" alt="Faux-filet Wagyu">
                        <span>Collection équilibre</span>
                        <small>Pièce 03</small>
                    </a>
                    <div class="wagyu-cut-body">
                        <p>Tenue · Caractère</p>
                        <h3>Faux-filet</h3>
                        <span>Un bel équilibre entre persillage, mâche et tenue à la cuisson.</span>
                        <dl>
                            <div><dt>Cuisson</dt><dd>Poêle ou grill</dd></div>
                            <div><dt>Profil</dt><dd>Équilibré</dd></div>
                        </dl>
                    </div>
                </article>

                <article class="wagyu-cut-card">
                    <a href="{{ route('boutique') }}#selection" class="wagyu-cut-image">
                        <img src="{{ asset('assets/images/boutique/rumsteak-wagyu.jpg') }}" alt="Rumsteak Wagyu">
                        <span>Collection caractère</span>
                        <small>Pièce 04</small>
                    </a>
                    <div class="wagyu-cut-body">
                        <p>Goût franc · Mâche</p>
                        <h3>Rumsteak</h3>
                        <span>Une expression plus directe du produit, régulière et généreuse.</span>
                        <dl>
                            <div><dt>Cuisson</dt><dd>Saisie</dd></div>
                            <div><dt>Profil</dt><dd>Franc</dd></div>
                        </dl>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="wagyu-cooking wagyu-section" id="degustation">
        <div class="wagyu-shell wagyu-cooking-grid">
            <div class="wagyu-cooking-content">
                <p class="wagyu-kicker">Le geste juste</p>
                <h2>
                    Cuire peu,
                    <em>servir avec précision.</em>
                </h2>
                <p>
                    Le Wagyu demande une chaleur franche mais une cuisson courte. L’objectif est de former
                    une légère croûte tout en préservant la souplesse et la richesse de la pièce.
                </p>

                <a href="{{ route('blog') }}" class="wagyu-text-link">Lire nos conseils de cuisson <span>→</span></a>
            </div>

            <figure class="wagyu-cooking-visual">
                <img
                    src="{{ asset('assets/images/wagyu/cuisson-wagyu.jpg') }}"
                    alt="Cuisson précise d'une pièce de Wagyu"
                >
                <figcaption>
                    <span>Protocole maison</span>
                    <strong>Quelques minutes suffisent.</strong>
                </figcaption>
            </figure>

            <div class="wagyu-cooking-steps">
                <article>
                    <span>01</span>
                    <div><strong>Tempérer</strong><p>Sortir la pièce avant cuisson afin d’éviter un choc thermique.</p></div>
                </article>
                <article>
                    <span>02</span>
                    <div><strong>Saisir</strong><p>Utiliser une poêle chaude et laisser la surface se colorer.</p></div>
                </article>
                <article>
                    <span>03</span>
                    <div><strong>Reposer</strong><p>Accorder quelques minutes aux jus pour se répartir.</p></div>
                </article>
                <article>
                    <span>04</span>
                    <div><strong>Trancher</strong><p>Servir en fines portions, simplement assaisonnées.</p></div>
                </article>
            </div>
        </div>
    </section>

    <section class="wagyu-origin wagyu-section">
        <div class="wagyu-shell wagyu-origin-card">
            <div class="wagyu-origin-monogram" aria-hidden="true">WF</div>

            <div>
                <p class="wagyu-kicker">Origine & traçabilité</p>
                <h2>Une expérience remarquable commence par une origine lisible.</h2>
                <p>
                    Wagyu France défend une approche française du produit&nbsp;: un élevage identifié,
                    une sélection attentive et une présentation claire de chaque pièce.
                </p>
            </div>

            <div class="wagyu-origin-actions">
                <a href="{{ route('histoire') }}" class="wagyu-button wagyu-button-light">Découvrir notre histoire</a>
                <a href="{{ route('tracabilite') }}" class="wagyu-origin-link">Consulter la traçabilité <span>→</span></a>
            </div>
        </div>
    </section>

@endsection
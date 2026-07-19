@extends('layouts.app', [
    'title' => 'Conseils, cuisson & dégustation — Wagyu France',
    'description' => 'Les conseils de Wagyu France pour choisir une pièce, maîtriser sa cuisson, prévoir les bonnes portions et savourer le Wagyu français avec justesse.',
    'bodyClass' => 'blog-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@section('content')

    <section class="journal-hero">
        <div class="journal-shell journal-hero-grid">
            <div class="journal-hero-copy">

                <p class="journal-kicker">Conseils & savoir-faire</p>

                <h1>
                    L’art de préparer
                    <em>une viande rare.</em>
                </h1>

                <p class="journal-hero-lead">
                    Choisir la bonne pièce, respecter son persillage et maîtriser quelques gestes précis :
                    notre carnet rassemble l’essentiel pour déguster le Wagyu avec simplicité.
                </p>

                <div class="journal-hero-actions">
                    <a href="#carnet" class="journal-button journal-button-primary">Parcourir le carnet</a>
                    <a href="{{ route('boutique') }}" class="journal-button journal-button-secondary">Choisir une pièce</a>
                </div>

                <div class="journal-hero-index" aria-label="Thèmes du carnet">
                    <div><span>01</span><strong>Choisir</strong></div>
                    <div><span>02</span><strong>Préparer</strong></div>
                    <div><span>03</span><strong>Déguster</strong></div>
                </div>
            </div>

            <figure class="journal-hero-visual">
                <img src="{{ asset('assets/images/blog/blog-cuisson.jpg') }}" alt="Préparation soignée d’une pièce de Wagyu français">

                <div class="journal-hero-frame" aria-hidden="true"></div>

                <figcaption>
                    <span>Le geste juste</span>
                    <strong>Peu d’artifices, beaucoup de précision.</strong>
                </figcaption>

                <div class="journal-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Carnet</small>
                </div>
            </figure>
        </div>
    </section>

    <nav class="journal-chapters" aria-label="Sommaire des conseils" data-section-nav>
        <div class="journal-shell journal-chapters-grid">
            <a href="#selection"><span>01</span>Bien choisir sa pièce</a>
            <a href="#cuisson"><span>02</span>Maîtriser la cuisson</a>
            <a href="#portions"><span>03</span>Prévoir les portions</a>
            <a href="#carnet"><span>04</span>Lire le carnet</a>
        </div>
    </nav>

    <section class="journal-feature" id="selection">
        <div class="journal-shell journal-feature-grid">
            <div class="journal-feature-visual">
                <img src="{{ asset('assets/images/blog/blog-persillage.jpg') }}" alt="Persillage fin d’une pièce de Wagyu">
                <div class="journal-feature-number">01</div>
                <span class="journal-feature-label">Dossier à la une</span>
            </div>

            <article class="journal-feature-copy">
                <p class="journal-kicker">Comprendre le produit</p>
                <h2>Le persillage n’est pas un décor. <em>Il guide toute la dégustation.</em></h2>

                <p class="journal-feature-intro">
                    Les fines veines de gras présentes dans le muscle influencent la texture, la jutosité,
                    l’intensité aromatique et la façon dont la viande réagit à la chaleur.
                </p>

                <div class="journal-feature-notes">
                    <div>
                        <span>Texture</span>
                        <strong>Fondante et souple</strong>
                    </div>
                    <div>
                        <span>Cuisson</span>
                        <strong>Courte et maîtrisée</strong>
                    </div>
                    <div>
                        <span>Service</span>
                        <strong>En portions mesurées</strong>
                    </div>
                </div>

                <a href="{{ route('wagyu') }}" class="journal-arrow-link">Comprendre le persillage <span>→</span></a>
            </article>
        </div>
    </section>

    <section class="journal-method" id="cuisson">
        <div class="journal-shell">
            <header class="journal-heading journal-heading-split">
                <div>
                    <p class="journal-kicker">Le protocole maison</p>
                    <h2>Quatre gestes pour <em>respecter la pièce.</em></h2>
                </div>

                <p>
                    Le Wagyu ne demande ni marinade puissante ni technique compliquée. Une température juste,
                    une saisie nette et un temps de repos suffisent à révéler le produit.
                </p>
            </header>

            <div class="journal-gestes" data-reveal>
                <article>
                    <span>01</span>
                    <h3>Tempérer</h3>
                    <p>Sortez la pièce avant cuisson afin que la chaleur se diffuse plus régulièrement.</p>
                    <small>Avant cuisson</small>
                </article>

                <article>
                    <span>02</span>
                    <h3>Saisir</h3>
                    <p>Utilisez une poêle bien chaude et laissez le persillage nourrir naturellement la cuisson.</p>
                    <small>Cuisson courte</small>
                </article>

                <article>
                    <span>03</span>
                    <h3>Reposer</h3>
                    <p>Accordez quelques minutes à la viande pour que les jus se répartissent dans la pièce.</p>
                    <small>2 à 4 minutes</small>
                </article>

                <article>
                    <span>04</span>
                    <h3>Découper</h3>
                    <p>Servez en tranches fines, dans le sens opposé aux fibres, avec un assaisonnement discret.</p>
                    <small>Au dernier moment</small>
                </article>
            </div>
        </div>
    </section>

    <section class="journal-portions" id="portions">
        <div class="journal-shell journal-portions-card">
            <div class="journal-portions-copy">
                <p class="journal-kicker">La juste quantité</p>
                <h2>Le Wagyu se savoure mieux <em>lorsqu’il reste mesuré.</em></h2>
                <p>
                    Sa richesse et son persillage rendent l’expérience plus intense qu’avec une viande classique.
                    La portion dépend donc du rôle donné à la pièce dans le repas.
                </p>
                <a href="{{ route('boutique') }}" class="journal-arrow-link">Voir les pièces disponibles <span>→</span></a>
            </div>

            <div class="journal-portions-values" data-reveal>
                <article>
                    <small>Dégustation</small>
                    <strong>80–120 <span>g</span></strong>
                    <p>Pour une entrée, un partage ou un menu en plusieurs temps.</p>
                </article>

                <article>
                    <small>Plat principal</small>
                    <strong>150–200 <span>g</span></strong>
                    <p>Lorsque le Wagyu constitue le cœur du repas.</p>
                </article>

                <article>
                    <small>À partager</small>
                    <strong>1 <span>pièce</span></strong>
                    <p>Découpée en tranches fines et servie au centre de la table.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="journal-notebook" id="carnet">
        <div class="journal-shell">
            <header class="journal-heading journal-heading-center">
                <p class="journal-kicker">Le carnet Wagyu France</p>
                <h2>Choisir, préparer et servir <em>avec confiance.</em></h2>
                <p>Des repères simples pour mieux comprendre chaque pièce et créer une dégustation cohérente.</p>
            </header>

            <div class="journal-articles-grid">
                <article class="journal-article journal-article-large">
                    <a href="{{ route('wagyu') }}" class="journal-article-image">
                        <img src="{{ asset('assets/images/blog/blog-persillage.jpg') }}" alt="Guide pour déguster le Wagyu">
                        <span>Dégustation</span>
                    </a>
                    <div class="journal-article-body">
                        <div class="journal-article-meta"><span>Guide</span><small>Lecture 4 min</small></div>
                        <h3>Comment déguster le Wagyu sans masquer son goût&nbsp;?</h3>
                        <p>Sel, chaleur, repos et découpe : les gestes essentiels pour laisser la viande s’exprimer.</p>
                        <a href="{{ route('wagyu') }}">Lire le guide <span>→</span></a>
                    </div>
                </article>

                <article class="journal-article">
                    <a href="{{ route('boutique') }}" class="journal-article-image">
                        <img src="{{ asset('assets/images/blog/blog-cuisson.jpg') }}" alt="Cuisson d’une entrecôte Wagyu">
                        <span>Cuisson</span>
                    </a>
                    <div class="journal-article-body">
                        <div class="journal-article-meta"><span>Conseil</span><small>Lecture 3 min</small></div>
                        <h3>Saisir une entrecôte&nbsp;: les erreurs à éviter.</h3>
                        <p>Une cuisson trop longue ou une poêle mal préparée peuvent déséquilibrer le persillage.</p>
                        <a href="{{ route('boutique') }}">Voir les pièces <span>→</span></a>
                    </div>
                </article>

                <article class="journal-article">
                    <a href="{{ route('boutique') }}" class="journal-article-image">
                        <img src="{{ asset('assets/images/blog/blog-pieces.jpg') }}" alt="Différentes pièces de Wagyu">
                        <span>Sélection</span>
                    </a>
                    <div class="journal-article-body">
                        <div class="journal-article-meta"><span>Pièces</span><small>Lecture 5 min</small></div>
                        <h3>Entrecôte, filet ou rumsteak&nbsp;: que choisir&nbsp;?</h3>
                        <p>Intensité, tendreté ou caractère : chaque morceau révèle une facette différente du Wagyu.</p>
                        <a href="{{ route('boutique') }}">Découvrir la sélection <span>→</span></a>
                    </div>
                </article>

                <article class="journal-article">
                    <a href="{{ route('histoire') }}" class="journal-article-image">
                        <img src="{{ asset('assets/images/histoire/maison-wagyu-france.jpg') }}" alt="Maison Wagyu France">
                        <span>Maison</span>
                    </a>
                    <div class="journal-article-body">
                        <div class="journal-article-meta"><span>Histoire</span><small>Lecture 4 min</small></div>
                        <h3>Pourquoi le temps fait partie intégrante de la qualité.</h3>
                        <p>Élevage, sélection et préparation : la qualité se construit bien avant la dégustation.</p>
                        <a href="{{ route('histoire') }}">Lire notre histoire <span>→</span></a>
                    </div>
                </article>

                <article class="journal-article journal-article-dark">
                    <div class="journal-article-dark-number">05</div>
                    <p class="journal-kicker">Pour les professionnels</p>
                    <h3>Anticiper les volumes et pré-réserver avant découpe.</h3>
                    <p>Une méthode pensée pour mieux répartir les pièces et construire une demande précise.</p>
                    <a href="{{ route('decoupe-volumes') }}">Découvrir la méthode <span>→</span></a>
                </article>
            </div>
        </div>
    </section>

    <section data-nav-end class="journal-note">
        <div class="journal-shell journal-note-grid">
            <div class="journal-note-monogram" aria-hidden="true">WF</div>

            <blockquote>
                <span>Note de la maison</span>
                <p>«&nbsp;La meilleure préparation est celle qui accompagne la viande sans jamais chercher à prendre sa place.&nbsp;»</p>
            </blockquote>

            <div class="journal-note-actions">
                <a href="{{ route('boutique') }}" class="journal-button journal-button-light">Découvrir la boutique</a>
                <a href="{{ route('contact') }}" class="journal-note-link">Demander conseil <span>→</span></a>
            </div>
        </div>
    </section>

@endsection
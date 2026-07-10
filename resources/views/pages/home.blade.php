@extends('layouts.app', [
    'title' => 'Wagyu France — Wagyu français élevé avec patience',
    'description' => 'Découvrez le Wagyu français du Domaine du Tilleul : pièces d’exception, origine maîtrisée, conseils de cuisson et espace professionnel.',
    'bodyClass' => 'home-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush

@section('content')

    <section class="home-hero">
        <div class="home-shell home-hero-grid">
            <div class="home-hero-content">
                <div class="home-hero-edition" aria-hidden="true">
                    <span>Maison Wagyu France</span>
                    <i></i>
                    <strong>01</strong>
                </div>

                <p class="home-kicker">Élevé en France · Domaine du Tilleul</p>

                <h1>
                    Le Wagyu français,
                    <em>élevé avec patience.</em>
                </h1>

                <p class="home-hero-lead">
                    Une viande remarquable par son persillage et sa tendreté, issue d’un élevage
                    attentif où l’origine, le temps et le respect du produit restent essentiels.
                </p>

                <div class="home-hero-actions">
                    <a href="{{ route('boutique') }}" class="home-button home-button-primary">
                        <span>Découvrir nos pièces</span>
                    </a>

                    <a href="{{ route('histoire') }}" class="home-button home-button-secondary">
                        <span>Connaître notre élevage</span>
                    </a>
                </div>

                <dl class="home-hero-facts">
                    <div>
                        <dt>Origine</dt>
                        <dd>Élevé en France</dd>
                    </div>

                    <div>
                        <dt>Sélection</dt>
                        <dd>Pièces choisies avec soin</dd>
                    </div>

                    <div>
                        <dt>Accompagnement</dt>
                        <dd>Conseils de préparation</dd>
                    </div>
                </dl>
            </div>

            <div class="home-hero-visual">
                <span class="home-visual-index">Édition du domaine · 2026</span>

                <img
                    src="{{ asset('assets/images/wagyu/home-private-hero.jpg') }}"
                    alt="Pièce de Wagyu français préparée pour la dégustation"
                >

                <div class="home-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>France</small>
                </div>

                <div class="home-hero-note">
                    <span>La signature Wagyu France</span>
                    <strong>Persillage fin, texture fondante et goût équilibré.</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="home-trust" aria-label="Les engagements Wagyu France">
        <div class="home-shell home-trust-grid">
            <article>
                <span>01</span>
                <div>
                    <strong>Origine maîtrisée</strong>
                    <p>Un élevage français et une histoire connue.</p>
                </div>
            </article>

            <article>
                <span>02</span>
                <div>
                    <strong>Découpe soignée</strong>
                    <p>Chaque morceau est valorisé selon son usage.</p>
                </div>
            </article>

            <article>
                <span>03</span>
                <div>
                    <strong>Froid respecté</strong>
                    <p>Une préparation pensée pour préserver le produit.</p>
                </div>
            </article>

            <article>
                <span>04</span>
                <div>
                    <strong>Conseils utiles</strong>
                    <p>Cuisson, quantité et choix expliqués simplement.</p>
                </div>
            </article>
        </div>
    </section>

    <section class="home-section home-categories">
        <div class="home-shell">
            <div class="home-heading-row">
                <div class="home-heading-title">
                    <span class="home-section-number">02</span>
                    <div>
                        <p class="home-kicker">Choisir selon votre envie</p>
                        <h2>Une pièce pour chaque <em>dégustation.</em></h2>
                    </div>
                </div>

                <p>
                    À saisir rapidement, à partager ou à laisser cuire doucement :
                    chaque morceau de Wagyu possède son caractère.
                </p>
            </div>

            <div class="home-category-grid">
                <a href="{{ route('boutique') }}#selection" class="home-category-card home-category-card-featured">
                    <img src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}" alt="Entrecôte Wagyu à griller">
                    <div>
                        <small>Collection 01</small>
                        <span>À saisir</span>
                        <h3>Pièces à griller</h3>
                        <p>Entrecôte, faux-filet et morceaux à cuisson vive.</p>
                        <strong>Découvrir la sélection <i>→</i></strong>
                    </div>
                </a>

                <a href="{{ route('boutique') }}#selection" class="home-category-card">
                    <img src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}" alt="Filet Wagyu d’exception">
                    <div>
                        <small>Collection 02</small>
                        <span>Grande tendreté</span>
                        <h3>Pièces d’exception</h3>
                        <p>Des morceaux fins pour les repas qui comptent.</p>
                        <strong>Découvrir la sélection <i>→</i></strong>
                    </div>
                </a>

                <a href="{{ route('boutique') }}#selection" class="home-category-card">
                    <img src="{{ asset('assets/images/boutique/paleron-wagyu.jpg') }}" alt="Paleron Wagyu pour cuisson lente">
                    <div>
                        <small>Collection 03</small>
                        <span>À mijoter</span>
                        <h3>Cuissons lentes</h3>
                        <p>Paleron et jarret pour des recettes profondes et fondantes.</p>
                        <strong>Découvrir la sélection <i>→</i></strong>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="home-section home-products">
        <div class="home-shell">
            <div class="home-heading-row home-heading-row-products">
                <div class="home-heading-title">
                    <span class="home-section-number">03</span>
                    <div>
                        <p class="home-kicker">La sélection Wagyu France</p>
                        <h2>Nos pièces <em>emblématiques.</em></h2>
                    </div>
                </div>

                <a href="{{ route('boutique') }}" class="home-text-link">Voir toute la boutique <span>→</span></a>
            </div>

            <div class="home-product-grid">
                <article class="home-product-card">
                    <a href="{{ route('boutique') }}#selection" class="home-product-image">
                        <img src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}" alt="Entrecôte Wagyu">
                        <span>La signature</span>
                    </a>

                    <div class="home-product-body">
                        <small class="home-product-ref">Pièce 01</small>
                        <p>Pièce noble · À saisir</p>
                        <h3>Entrecôte Wagyu</h3>
                        <span>Généreuse, persillée et intense.</span>

                        <div>
                            <strong>174 € <small>/ kg</small></strong>
                            <a href="{{ route('boutique') }}#selection">Voir la pièce <i>→</i></a>
                        </div>
                    </div>
                </article>

                <article class="home-product-card">
                    <a href="{{ route('boutique') }}#selection" class="home-product-image">
                        <img src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}" alt="Filet Wagyu">
                        <span>Très tendre</span>
                    </a>

                    <div class="home-product-body">
                        <small class="home-product-ref">Pièce 02</small>
                        <p>Pièce premium · Délicate</p>
                        <h3>Filet Wagyu</h3>
                        <span>Fin, précis et particulièrement fondant.</span>

                        <div>
                            <strong>198 € <small>/ kg</small></strong>
                            <a href="{{ route('boutique') }}#selection">Voir la pièce <i>→</i></a>
                        </div>
                    </div>
                </article>

                <article class="home-product-card">
                    <a href="{{ route('boutique') }}#selection" class="home-product-image">
                        <img src="{{ asset('assets/images/boutique/faux-filet-wagyu.jpg') }}" alt="Faux-filet Wagyu">
                        <span>Équilibré</span>
                    </a>

                    <div class="home-product-body">
                        <small class="home-product-ref">Pièce 03</small>
                        <p>Persillé · À partager</p>
                        <h3>Faux-filet Wagyu</h3>
                        <span>Un bel équilibre entre tendreté et caractère.</span>

                        <div>
                            <strong>174 € <small>/ kg</small></strong>
                            <a href="{{ route('boutique') }}#selection">Voir la pièce <i>→</i></a>
                        </div>
                    </div>
                </article>

                <article class="home-product-card">
                    <a href="{{ route('boutique') }}#selection" class="home-product-image">
                        <img src="{{ asset('assets/images/boutique/rumsteak-wagyu.jpg') }}" alt="Rumsteak Wagyu">
                        <span>De caractère</span>
                    </a>

                    <div class="home-product-body">
                        <small class="home-product-ref">Pièce 04</small>
                        <p>Goût franc · Belle mâche</p>
                        <h3>Rumsteak Wagyu</h3>
                        <span>Une pièce expressive, régulière et généreuse.</span>

                        <div>
                            <strong>137 € <small>/ kg</small></strong>
                            <a href="{{ route('boutique') }}#selection">Voir la pièce <i>→</i></a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="home-section home-story">
        <div class="home-shell home-story-grid">
            <div class="home-story-visual">
                <span class="home-story-frame-label">Domaine · France</span>
                <img src="{{ asset('assets/images/pro/home-pro-hero.jpg') }}" alt="Élevage Wagyu France au Domaine du Tilleul">
                <div>
                    <span>Domaine du Tilleul</span>
                    <strong>Une histoire française</strong>
                </div>
            </div>

            <div class="home-story-content">
                <span class="home-story-quote" aria-hidden="true">“</span>
                <p class="home-kicker">De l’élevage à votre table</p>
                <h2>Le goût commence bien avant <em>la cuisson.</em></h2>

                <p>
                    Chez Wagyu France, la qualité ne se résume pas au persillage. Elle se construit
                    dans la durée, par l’attention portée aux animaux, au rythme de l’élevage et à la
                    façon dont chaque pièce est sélectionnée puis préparée.
                </p>

                <p>
                    Cette maîtrise permet de proposer une viande lisible, avec une origine claire
                    et des conseils adaptés pour la déguster sans la dénaturer.
                </p>

                <a href="{{ route('histoire') }}" class="home-button home-button-secondary">
                    <span>Découvrir notre histoire</span>
                </a>
            </div>
        </div>
    </section>

    <section class="home-guide">
        <div class="home-shell home-guide-grid">
            <div class="home-guide-heading">
                <span class="home-guide-mark">Le geste juste</span>
                <p class="home-kicker">Bien préparer le Wagyu</p>
                <h2>Peu d’artifices.<br><em>Une cuisson précise.</em></h2>
            </div>

            <div class="home-guide-steps">
                <article>
                    <span>01</span>
                    <strong>Tempérer</strong>
                    <p>Sortez la viande suffisamment tôt pour une cuisson régulière.</p>
                </article>

                <article>
                    <span>02</span>
                    <strong>Saisir</strong>
                    <p>Une poêle bien chaude suffit pour former une belle croûte.</p>
                </article>

                <article>
                    <span>03</span>
                    <strong>Laisser reposer</strong>
                    <p>Quelques minutes permettent aux sucs de se répartir correctement.</p>
                </article>
            </div>

            <a href="{{ route('blog') }}" class="home-text-link">Lire nos conseils <span>→</span></a>
        </div>
    </section>

    <section class="home-section home-professional">
        <div class="home-shell home-professional-card">
            <span class="home-professional-monogram" aria-hidden="true">WF</span>

            <div>
                <p class="home-kicker">Pour les professionnels</p>
                <h2>Chefs, restaurateurs <em>et bouchers.</em></h2>
                <p>
                    Accédez à une sélection dédiée, anticipez vos volumes et pré-réservez
                    directement les pièces qui correspondent à votre activité.
                </p>
            </div>

            <div class="home-professional-actions">
                <a href="{{ route('reserve.pro') }}" class="home-button home-button-light">
                    <span>Voir la réserve professionnelle</span>
                </a>
                <a href="{{ route('professionnels') }}" class="home-professional-link">
                    Découvrir l’offre pro <span>→</span>
                </a>
            </div>
        </div>
    </section>

@endsection

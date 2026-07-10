@extends('layouts.app', [
    'title' => 'Découpe & volumes professionnels — Wagyu France',
    'description' => 'Comprendre la répartition des pièces, anticiper les volumes et construire une demande professionnelle cohérente avant la découpe du Wagyu français.',
    'bodyClass' => 'decoupe-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/decoupe-volumes.css') }}">
@endpush

@section('content')

    <section class="cut-hero">
        <div class="cut-shell cut-hero-grid">
            <div class="cut-hero-copy">
                <p class="cut-kicker">Wagyu France · Découpe & volumes</p>

                <h1>
                    Une découpe pensée
                    <em>pour votre service.</em>
                </h1>

                <p class="cut-hero-lead">
                    Une demande professionnelle ne se résume pas à un nombre de kilogrammes.
                    Elle doit tenir compte de la pièce, de l’usage, de la cadence, du format de service
                    et de l’échéance. Wagyu France vous aide à traduire ces besoins avant la découpe.
                </p>

                <div class="cut-hero-actions">
                    <a href="{{ route('reserve.pro') }}" class="cut-button cut-button-primary">
                        Constituer ma sélection
                    </a>
                    <a href="{{ route('contact') }}" class="cut-button cut-button-secondary">
                        Parler de mes volumes
                    </a>
                </div>

                <dl class="cut-hero-facts">
                    <div>
                        <dt>Pièces</dt>
                        <dd>Choisies selon l’usage</dd>
                    </div>
                    <div>
                        <dt>Volumes</dt>
                        <dd>Estimés avant confirmation</dd>
                    </div>
                    <div>
                        <dt>Découpe</dt>
                        <dd>Organisée avec la maison</dd>
                    </div>
                </dl>
            </div>

            <figure class="cut-hero-visual">
                <img
                    src="{{ asset('assets/images/pro/decoupe-volumes.jpg') }}"
                    alt="Découpe professionnelle de pièces de Wagyu"
                >

                <figcaption>
                    <span>Lecture professionnelle</span>
                    <strong>La bonne pièce, dans le bon format, au bon moment.</strong>
                </figcaption>

                <div class="cut-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Découpe</small>
                </div>
            </figure>
        </div>
    </section>

    <nav class="cut-chapters" aria-label="Sommaire Découpe et volumes">
        <div class="cut-shell cut-chapters-grid">
            <a href="#lecture"><span>01</span> Lire l’animal</a>
            <a href="#volumes"><span>02</span> Définir les volumes</a>
            <a href="#metiers"><span>03</span> Adapter au métier</a>
            <a href="#methode"><span>04</span> Organiser la demande</a>
        </div>
    </nav>

    <section class="cut-section cut-intro" id="lecture">
        <div class="cut-shell cut-intro-grid">
            <div class="cut-intro-heading">
                <p class="cut-kicker">Une vision d’ensemble</p>
                <h2>
                    Un animal ne se résume jamais
                    <em>à ses pièces les plus célèbres.</em>
                </h2>
            </div>

            <div class="cut-intro-copy">
                <p class="cut-dropcap">
                    Le filet, l’entrecôte ou le faux-filet concentrent naturellement l’attention.
                    Pourtant, une sélection professionnelle cohérente se construit aussi avec le
                    rumsteak, le paleron, la macreuse, le jarret et les pièces destinées aux cuissons longues.
                </p>
                <p>
                    Cette lecture globale permet de mieux répartir la demande, de construire plusieurs
                    usages sur une même carte et de valoriser chaque morceau avec justesse.
                </p>
            </div>
        </div>
    </section>

    <section class="cut-section cut-families">
        <div class="cut-shell">
            <header class="cut-section-heading">
                <div>
                    <p class="cut-kicker">Familles d’usage</p>
                    <h2>Penser la découpe par destination culinaire.</h2>
                </div>
                <p>
                    Le nom de la pièce compte. Mais son rôle dans votre offre compte davantage :
                    service minute, dégustation, cuisson lente ou transformation.
                </p>
            </header>

            <div class="cut-family-grid">
                <article>
                    <span class="cut-family-number">01</span>
                    <div>
                        <small>Service minute</small>
                        <h3>Pièces à saisir</h3>
                        <p>Entrecôte, faux-filet et rumsteak pour des cuissons courtes et précises.</p>
                    </div>
                    <strong>Carte · Grill · Dégustation</strong>
                </article>

                <article>
                    <span class="cut-family-number">02</span>
                    <div>
                        <small>Service signature</small>
                        <h3>Pièces de grande finesse</h3>
                        <p>Filet et morceaux sélectionnés pour une portion mesurée et une présentation soignée.</p>
                    </div>
                    <strong>Menu · Événement · Expérience</strong>
                </article>

                <article>
                    <span class="cut-family-number">03</span>
                    <div>
                        <small>Cuisson longue</small>
                        <h3>Pièces de caractère</h3>
                        <p>Paleron, macreuse et jarret pour les braisages, mijotés, jus et bouillons.</p>
                    </div>
                    <strong>Bistronomie · Saison · Plat</strong>
                </article>

                <article>
                    <span class="cut-family-number">04</span>
                    <div>
                        <small>Valorisation complète</small>
                        <h3>Formats complémentaires</h3>
                        <p>Parures et morceaux adaptés aux préparations hachées, farces, sauces ou créations maison.</p>
                    </div>
                    <strong>Transformation · Atelier · Vente</strong>
                </article>
            </div>
        </div>
    </section>

    <section class="cut-section cut-volume-planning" id="volumes">
        <div class="cut-shell cut-volume-grid">
            <div class="cut-volume-visual">
                <img
                    src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                    alt="Sélection de volumes professionnels Wagyu France"
                >
                <div class="cut-volume-caption">
                    <span>Préparation du besoin</span>
                    <strong>Une quantité utile se calcule à partir du service réel.</strong>
                </div>
            </div>

            <div class="cut-volume-content">
                <p class="cut-kicker">Définir les volumes</p>
                <h2>
                    Partir de votre usage,
                    <em>pas d’un chiffre arbitraire.</em>
                </h2>
                <p>
                    Pour qualifier une demande, quatre informations sont essentielles : le nombre de services,
                    la portion envisagée, la fréquence et la date souhaitée. Elles permettent d’estimer un volume
                    plus réaliste avant toute confirmation.
                </p>

                <div class="cut-volume-criteria">
                    <article>
                        <span>01</span>
                        <div>
                            <strong>Le service</strong>
                            <p>Nombre de couverts, vente au détail, événement ou besoin ponctuel.</p>
                        </div>
                    </article>
                    <article>
                        <span>02</span>
                        <div>
                            <strong>La portion</strong>
                            <p>Format dégustation, plat principal, découpe boutique ou préparation longue.</p>
                        </div>
                    </article>
                    <article>
                        <span>03</span>
                        <div>
                            <strong>La cadence</strong>
                            <p>Commande unique, lancement de carte, fréquence régulière ou saison précise.</p>
                        </div>
                    </article>
                    <article>
                        <span>04</span>
                        <div>
                            <strong>L’échéance</strong>
                            <p>Date de livraison souhaitée et marge nécessaire pour votre organisation.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="cut-section cut-estimate">
        <div class="cut-shell cut-estimate-card">
            <div class="cut-estimate-heading">
                <p class="cut-kicker">Exemple de lecture</p>
                <h2>Transformer une intention en demande exploitable.</h2>
                <p>
                    Le calcul ci-dessous illustre la méthode. Il ne constitue pas une promesse de disponibilité
                    ni un devis définitif.
                </p>
            </div>

            <div class="cut-estimate-flow">
                <article>
                    <span>Besoin</span>
                    <strong>30 portions</strong>
                    <small>Menu dégustation</small>
                </article>
                <i aria-hidden="true">×</i>
                <article>
                    <span>Portion</span>
                    <strong>120 g</strong>
                    <small>Par convive</small>
                </article>
                <i aria-hidden="true">=</i>
                <article class="is-result">
                    <span>Volume de base</span>
                    <strong>3,6 kg</strong>
                    <small>À ajuster avec la maison</small>
                </article>
            </div>

            <p class="cut-estimate-note">
                Le format final dépend ensuite de la pièce, du parage, de la découpe souhaitée et de la disponibilité réelle.
            </p>
        </div>
    </section>

    <section class="cut-section cut-professions" id="metiers">
        <div class="cut-shell">
            <header class="cut-section-heading">
                <div>
                    <p class="cut-kicker">Une méthode adaptée à chaque métier</p>
                    <h2>Les mêmes pièces, des contraintes très différentes.</h2>
                </div>
                <p>
                    La demande doit refléter la façon dont le produit sera réellement travaillé,
                    présenté et vendu.
                </p>
            </header>

            <div class="cut-profession-grid">
                <article>
                    <span>Restaurant</span>
                    <h3>Construire une carte</h3>
                    <p>Portions, fréquence de service, rendement et cohérence entre pièces nobles et cuissons longues.</p>
                    <ul>
                        <li>Menu dégustation</li>
                        <li>Plat signature</li>
                        <li>Rotation de carte</li>
                    </ul>
                </article>

                <article>
                    <span>Boucherie</span>
                    <h3>Préparer une offre</h3>
                    <p>Formats de vente, poids par unité, diversité de vitrine et capacité à expliquer chaque morceau.</p>
                    <ul>
                        <li>Découpe au détail</li>
                        <li>Conseil client</li>
                        <li>Valorisation complète</li>
                    </ul>
                </article>

                <article>
                    <span>Traiteur & événement</span>
                    <h3>Sécuriser une échéance</h3>
                    <p>Nombre de convives, format de prestation, délai de préparation et homogénéité des portions.</p>
                    <ul>
                        <li>Événement privé</li>
                        <li>Prestation premium</li>
                        <li>Besoin ponctuel</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="cut-method" id="methode">
        <div class="cut-shell cut-method-grid">
            <div class="cut-method-copy">
                <p class="cut-kicker">Le parcours Wagyu France</p>
                <h2>De votre besoin à une découpe confirmée.</h2>
                <p>
                    La réserve permet d’exprimer une première intention. L’échange avec la maison
                    permet ensuite de la rendre réaliste, cohérente et compatible avec les pièces disponibles.
                </p>
                <a href="{{ route('reserve.pro') }}" class="cut-button cut-button-light">
                    Ouvrir la réserve professionnelle
                </a>
            </div>

            <div class="cut-method-steps">
                <article>
                    <span>01</span>
                    <div>
                        <strong>Sélectionner</strong>
                        <p>Choisissez les pièces qui correspondent à votre activité.</p>
                    </div>
                </article>
                <article>
                    <span>02</span>
                    <div>
                        <strong>Quantifier</strong>
                        <p>Indiquez un volume par pièce et précisez votre contexte.</p>
                    </div>
                </article>
                <article>
                    <span>03</span>
                    <div>
                        <strong>Étudier</strong>
                        <p>Wagyu France vérifie la cohérence et les disponibilités.</p>
                    </div>
                </article>
                <article>
                    <span>04</span>
                    <div>
                        <strong>Confirmer</strong>
                        <p>Le format, le montant, l’échéance et la livraison sont validés ensemble.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="cut-quote">
        <div class="cut-shell cut-quote-inner">
            <span aria-hidden="true">“</span>
            <blockquote>
                Bien organiser les volumes, c’est donner une destination précise à chaque pièce
                avant même que la découpe commence.
            </blockquote>
            <p>Wagyu France · Sélection professionnelle</p>
        </div>
    </section>

    <section class="cut-section cut-contact">
        <div class="cut-shell cut-contact-card">
            <div>
                <p class="cut-kicker">Préparer votre prochaine sélection</p>
                <h2>Décrivez votre service. Nous vous aiderons à construire les bons volumes.</h2>
                <p>
                    Constituez une première demande depuis la réserve ou contactez directement
                    la maison pour un besoin spécifique.
                </p>
            </div>

            <div class="cut-contact-actions">
                <a href="{{ route('reserve.pro') }}" class="cut-button cut-button-light">
                    Accéder à la réserve
                </a>
                <a href="{{ route('contact') }}" class="cut-contact-link">
                    Contacter Wagyu France <span>→</span>
                </a>
            </div>
        </div>
    </section>

@endsection
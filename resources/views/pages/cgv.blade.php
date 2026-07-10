@php
    $legal = config('legal');
    $company = $legal['company'];
    $sales = $legal['sales'];
    $mediator = $legal['mediator'];
    $missing = 'À renseigner avant mise en ligne';

    $isIncomplete = collect([
        $company['legal_name'],
        $company['email'],
        $company['phone'],
        $sales['complaints_email'],
        $mediator['name'],
        $mediator['website'],
    ])->contains(fn ($value) => blank($value));
@endphp

@extends('layouts.app', [
    'title' => 'Conditions générales de vente — Wagyu France',
    'description' => 'Conditions applicables aux demandes de commande et ventes de produits Wagyu France destinées aux particuliers.',
    'bodyClass' => 'legal-page legal-cgv-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}">
@endpush

@section('content')

    <section class="legal-hero">
        <div class="legal-shell legal-hero-grid">
            <div class="legal-hero-copy">
                <p class="legal-kicker">Wagyu France · Relation commerciale</p>

                <h1>
                    Conditions générales
                    <em>de vente.</em>
                </h1>

                <p class="legal-hero-lead">
                    Ces conditions encadrent les ventes conclues après une demande boutique et précisent
                    la différence entre une estimation transmise sur le site et une commande définitivement confirmée.
                </p>

                <div class="legal-document-meta">
                    <div>
                        <span>Document</span>
                        <strong>CGV particuliers</strong>
                    </div>
                    <div>
                        <span>Dernière mise à jour</span>
                        <strong>{{ $legal['last_updated'] }}</strong>
                    </div>
                    <div>
                        <span>Territoire principal</span>
                        <strong>{{ $sales['delivery_area'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="legal-hero-mark" aria-hidden="true">
                <span>WF</span>
                <small>Conditions de vente</small>
            </div>
        </div>
    </section>

    <nav class="legal-pages-nav" aria-label="Pages juridiques">
        <div class="legal-shell legal-pages-nav-inner">
            <a href="{{ route('mentions.legales') }}">Mentions légales</a>
            <a href="{{ route('confidentialite') }}">Confidentialité</a>
            <a href="{{ route('cgv') }}" class="is-active">Conditions de vente</a>
        </div>
    </nav>

    @if ($isIncomplete)
        <section class="legal-completion-alert">
            <div class="legal-shell legal-completion-alert-inner">
                <span>Informations contractuelles à finaliser</span>
                <p>
                    Les clauses correspondent au fonctionnement actuel du site, fondé sur des demandes à confirmer.
                    L’identité légale du vendeur, le contact de réclamation et le médiateur de la consommation doivent
                    être ajoutés avant l’ouverture commerciale publique.
                </p>
            </div>
        </section>
    @endif

    <section class="legal-key-points">
        <div class="legal-shell legal-key-points-grid">
            <article>
                <span>01</span>
                <strong>Une demande n’est pas encore une vente</strong>
                <p>La sélection envoyée depuis le site doit être confirmée expressément par la maison.</p>
            </article>
            <article>
                <span>02</span>
                <strong>Produits alimentaires périssables</strong>
                <p>Le droit de rétractation peut être exclu pour les produits susceptibles de se détériorer rapidement.</p>
            </article>
            <article>
                <span>03</span>
                <strong>Chaîne du froid</strong>
                <p>La préparation, le transport, la réception et la conservation exigent le respect des températures indiquées.</p>
            </article>
        </div>
    </section>

    <section class="legal-content-section">
        <div class="legal-shell legal-layout">
            <aside class="legal-summary">
                <span class="legal-summary-title">Sommaire</span>
                <a href="#vendeur"><b>01</b> Vendeur & champ</a>
                <a href="#produits"><b>02</b> Produits</a>
                <a href="#prix"><b>03</b> Prix</a>
                <a href="#commande"><b>04</b> Commande</a>
                <a href="#paiement"><b>05</b> Paiement</a>
                <a href="#livraison"><b>06</b> Livraison</a>
                <a href="#reception"><b>07</b> Réception</a>
                <a href="#retractation"><b>08</b> Rétractation</a>
                <a href="#garanties"><b>09</b> Garanties</a>
                <a href="#professionnels"><b>10</b> Professionnels</a>
                <a href="#donnees"><b>11</b> Données</a>
                <a href="#litiges"><b>12</b> Médiation</a>
            </aside>

            <div class="legal-content">
                <article class="legal-block" id="vendeur">
                    <header class="legal-block-heading">
                        <span>01</span>
                        <div>
                            <p>Cadre contractuel</p>
                            <h2>Vendeur et champ d’application</h2>
                        </div>
                    </header>

                    <p>
                        Les présentes conditions s’appliquent aux ventes conclues entre un consommateur et
                        <strong class="{{ blank($company['legal_name']) ? 'legal-inline-missing' : '' }}">
                            {{ $company['legal_name'] ?: $missing }}
                        </strong>, exploitant la marque <strong>{{ $legal['brand_name'] }}</strong>.
                    </p>

                    <dl class="legal-data-grid">
                        <div class="legal-data-wide">
                            <dt>Adresse du vendeur</dt>
                            <dd>{{ $company['address'] }}</dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd class="{{ blank($company['email']) ? 'is-missing' : '' }}">
                                {{ $company['email'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Téléphone</dt>
                            <dd class="{{ blank($company['phone']) ? 'is-missing' : '' }}">
                                {{ $company['phone'] ?: $missing }}
                            </dd>
                        </div>
                    </dl>

                    <p>
                        La transmission d’une demande depuis la boutique constitue une sollicitation de disponibilité.
                        Elle ne forme pas, à elle seule, un contrat de vente. La vente est conclue lorsque le vendeur confirme
                        par écrit les produits, quantités, prix, frais, date ou délai de livraison et modalités de paiement,
                        puis lorsque le client accepte cette confirmation selon les instructions reçues.
                    </p>

                    <p>
                        Toute condition particulière acceptée par écrit pour une commande prévaut sur la clause générale
                        incompatible des présentes CGV.
                    </p>
                </article>

                <article class="legal-block" id="produits">
                    <header class="legal-block-heading">
                        <span>02</span>
                        <div>
                            <p>Caractéristiques essentielles</p>
                            <h2>Produits et disponibilité</h2>
                        </div>
                    </header>

                    <p>
                        Les produits proposés sont principalement des pièces de viande Wagyu française, fraîches,
                        réfrigérées, congelées ou préparées selon la sélection confirmée. Les descriptions précisent,
                        selon les cas, le nom de la pièce, son usage conseillé, son prix au kilogramme et un volume indicatif.
                    </p>

                    <p>
                        La viande étant issue d’animaux et de découpes réelles, la forme, le persillage, le poids exact,
                        la couleur et la disponibilité peuvent présenter des variations naturelles. Les photographies
                        illustrent le produit mais ne constituent pas une garantie d’identité visuelle parfaite.
                    </p>

                    <p>
                        En cas d’indisponibilité après transmission de la demande, le vendeur peut proposer un ajustement,
                        une pièce équivalente, un nouveau délai ou l’annulation sans frais de la partie indisponible.
                        Aucune substitution n’est imposée sans l’accord du client.
                    </p>
                </article>

                <article class="legal-block" id="prix">
                    <header class="legal-block-heading">
                        <span>03</span>
                        <div>
                            <p>Lecture tarifaire</p>
                            <h2>Prix et frais</h2>
                        </div>
                    </header>

                    <p>
                        Les prix destinés aux consommateurs sont exprimés en euros toutes taxes comprises, sauf indication
                        contraire explicite. Les prix professionnels sont présentés hors taxes dans l’espace dédié.
                    </p>

                    <p>
                        Lorsque le produit est vendu au poids, le montant affiché sur le site peut être une estimation calculée
                        à partir du volume demandé. Le prix définitif dépend du poids réellement préparé et est communiqué
                        avant l’acceptation finale de la commande.
                    </p>

                    <p>
                        Les frais de préparation, d’emballage réfrigéré, de transport ou de retrait sont indiqués dans la
                        confirmation commerciale avant conclusion de la vente. Le vendeur peut modifier ses tarifs pour les
                        futures commandes, sans effet rétroactif sur une commande déjà confirmée.
                    </p>
                </article>

                <article class="legal-block" id="commande">
                    <header class="legal-block-heading">
                        <span>04</span>
                        <div>
                            <p>Étapes de validation</p>
                            <h2>Formation de la commande</h2>
                        </div>
                    </header>

                    <ol class="legal-numbered-list">
                        <li>
                            <span>1</span>
                            <div>
                                <strong>Sélection</strong>
                                <p>Le client choisit une ou plusieurs pièces et indique les quantités souhaitées.</p>
                            </div>
                        </li>
                        <li>
                            <span>2</span>
                            <div>
                                <strong>Transmission</strong>
                                <p>Le site enregistre la demande avec une référence et un montant estimatif.</p>
                            </div>
                        </li>
                        <li>
                            <span>3</span>
                            <div>
                                <strong>Vérification</strong>
                                <p>Le vendeur contrôle la disponibilité, le poids, le conditionnement et la livraison.</p>
                            </div>
                        </li>
                        <li>
                            <span>4</span>
                            <div>
                                <strong>Confirmation</strong>
                                <p>Les conditions définitives sont communiquées au client pour acceptation.</p>
                            </div>
                        </li>
                    </ol>

                    <p>
                        Le vendeur peut refuser une demande anormale, manifestement frauduleuse, techniquement impossible,
                        contraire à la réglementation ou provenant d’un client avec lequel subsiste un incident de paiement,
                        sous réserve des règles applicables.
                    </p>
                </article>

                <article class="legal-block" id="paiement">
                    <header class="legal-block-heading">
                        <span>05</span>
                        <div>
                            <p>Règlement</p>
                            <h2>Paiement</h2>
                        </div>
                    </header>

                    <p>
                        Au stade actuel du site, l’envoi du formulaire de demande ne déclenche aucun paiement automatique.
                        Le moyen de paiement, l’éventuel acompte, la date d’exigibilité et les instructions de règlement sont
                        communiqués lors de la confirmation de commande.
                    </p>

                    <p>
                        Une commande peut être subordonnée à l’encaissement préalable de tout ou partie du prix. En cas de
                        refus, d’échec ou d’absence de paiement à l’échéance convenue, le vendeur peut suspendre la préparation
                        et annuler la commande après information du client.
                    </p>

                    <p>
                        Lorsqu’un paiement en ligne sera activé, les moyens acceptés, le prestataire sécurisé et les étapes
                        de validation seront affichés avant le paiement.
                    </p>
                </article>

                <article class="legal-block" id="livraison">
                    <header class="legal-block-heading">
                        <span>06</span>
                        <div>
                            <p>Transport alimentaire</p>
                            <h2>Préparation, livraison et chaîne du froid</h2>
                        </div>
                    </header>

                    <dl class="legal-data-grid">
                        <div>
                            <dt>Zone habituelle</dt>
                            <dd>{{ $sales['delivery_area'] }}</dd>
                        </div>
                        <div>
                            <dt>Délai</dt>
                            <dd>Communiqué avant confirmation de la commande</dd>
                        </div>
                        <div class="legal-data-wide">
                            <dt>Adresse de livraison</dt>
                            <dd>Celle validée dans la confirmation commerciale ; le client doit en vérifier l’exactitude et l’accessibilité.</dd>
                        </div>
                    </dl>

                    <p>
                        Les produits sont conditionnés et transportés selon le mode retenu pour préserver leur qualité et la
                        chaîne du froid. Le client doit être disponible au créneau convenu, réceptionner le colis sans délai
                        et placer immédiatement les produits dans les conditions de conservation indiquées sur l’emballage
                        ou dans les instructions transmises.
                    </p>

                    <p>
                        La date ou le délai annoncé dans la confirmation constitue l’engagement applicable. En cas de retard,
                        les droits du consommateur prévus par le Code de la consommation restent pleinement applicables.
                    </p>
                </article>

                <article class="legal-block" id="reception">
                    <header class="legal-block-heading">
                        <span>07</span>
                        <div>
                            <p>Contrôle à l’arrivée</p>
                            <h2>Réception et réclamation produit</h2>
                        </div>
                    </header>

                    <p>
                        À réception, le client est invité à contrôler l’état extérieur du colis, son intégrité, la présence
                        des produits et les éventuels signes de rupture de la chaîne du froid. En cas d’anomalie, il doit
                        conserver le produit et son emballage, prendre des photographies et contacter rapidement le vendeur.
                    </p>

                    <p>
                        Une réclamation doit mentionner la référence de commande, la nature du problème et tout élément utile.
                        Elle peut être adressée à
                        <strong class="{{ blank($sales['complaints_email']) ? 'legal-inline-missing' : '' }}">
                            {{ $sales['complaints_email'] ?: $missing }}
                        </strong>. Cette procédure pratique ne limite pas les garanties légales du consommateur.
                    </p>
                </article>

                <article class="legal-block legal-emphasis-block" id="retractation">
                    <header class="legal-block-heading">
                        <span>08</span>
                        <div>
                            <p>Produits alimentaires</p>
                            <h2>Droit de rétractation</h2>
                        </div>
                    </header>

                    <p>
                        Le droit de rétractation de quatorze jours applicable à de nombreux contrats conclus à distance
                        connaît des exceptions. Conformément à l’article L. 221-28 du Code de la consommation, il ne peut
                        notamment être exercé pour les biens susceptibles de se détériorer ou de se périmer rapidement,
                        ainsi que dans certains cas pour les produits personnalisés ou descellés ne pouvant être renvoyés
                        pour des raisons d’hygiène ou de protection de la santé.
                    </p>

                    <p>
                        Les pièces de viande fraîches, réfrigérées, congelées, découpées ou préparées pour une commande
                        peuvent relever de ces exceptions. Lorsque l’absence de droit de rétractation s’applique, le client
                        en est informé avant la conclusion de la vente.
                    </p>

                    <p>
                        Si un produit non périssable et non exclu est ajouté ultérieurement à la boutique, le consommateur
                        bénéficiera du délai légal de rétractation correspondant. Les modalités et le formulaire applicable
                        devront alors être communiqués avec la commande. L’adresse de retour prévue est :
                        <strong class="{{ blank($sales['withdrawal_address']) ? 'legal-inline-missing' : '' }}">
                            {{ $sales['withdrawal_address'] ?: 'à renseigner si des produits rétractables sont commercialisés' }}
                        </strong>.
                    </p>
                </article>

                <article class="legal-block" id="garanties">
                    <header class="legal-block-heading">
                        <span>09</span>
                        <div>
                            <p>Protection du consommateur</p>
                            <h2>Garanties légales</h2>
                        </div>
                    </header>

                    <p>
                        Le consommateur bénéficie de la garantie légale de conformité et de la garantie contre les vices
                        cachés dans les conditions prévues par la loi. Aucune clause des présentes CGV ne réduit ces droits.
                    </p>

                    <p>
                        Pour les denrées alimentaires, l’appréciation d’une non-conformité tient compte notamment de la nature
                        du produit, des informations communiquées, des conditions de transport, de la date de consommation,
                        des températures de conservation et du délai de signalement.
                    </p>
                </article>

                <article class="legal-block" id="professionnels">
                    <header class="legal-block-heading">
                        <span>10</span>
                        <div>
                            <p>Réserve B2B</p>
                            <h2>Demandes professionnelles</h2>
                        </div>
                    </header>

                    <p>
                        La réserve professionnelle permet de transmettre une intention sur des pièces et volumes. Elle ne
                        constitue ni un devis accepté, ni une réservation ferme, ni un transfert de propriété. Chaque dossier
                        fait l’objet d’une confirmation spécifique précisant les prix HT, quantités, préparation, échéance,
                        paiement et livraison.
                    </p>

                    <p>
                        Les ventes conclues avec un professionnel peuvent être régies par des conditions commerciales,
                        devis ou contrats particuliers adaptés à son activité. Ces documents prévalent sur les présentes CGV
                        lorsqu’ils comportent des dispositions spécifiques.
                    </p>
                </article>

                <article class="legal-block" id="donnees">
                    <header class="legal-block-heading">
                        <span>11</span>
                        <div>
                            <p>Informations clients</p>
                            <h2>Données personnelles</h2>
                        </div>
                    </header>

                    <p>
                        Les données nécessaires aux demandes, commandes, paiements, livraisons et réclamations sont traitées
                        conformément à la politique de confidentialité du site. Le client peut y consulter les finalités,
                        durées de conservation, destinataires et modalités d’exercice de ses droits.
                    </p>

                    <a href="{{ route('confidentialite') }}" class="legal-action-link">
                        Consulter la politique de confidentialité <span>→</span>
                    </a>
                </article>

                <article class="legal-block" id="litiges">
                    <header class="legal-block-heading">
                        <span>12</span>
                        <div>
                            <p>Solution amiable</p>
                            <h2>Réclamations, médiation et droit applicable</h2>
                        </div>
                    </header>

                    <p>
                        Les présentes conditions sont soumises au droit français. En cas de difficulté, le client est invité
                        à adresser d’abord une réclamation écrite au vendeur afin de rechercher une solution amiable.
                    </p>

                    <dl class="legal-data-grid">
                        <div>
                            <dt>Contact réclamation</dt>
                            <dd class="{{ blank($sales['complaints_email']) ? 'is-missing' : '' }}">
                                {{ $sales['complaints_email'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Médiateur de la consommation</dt>
                            <dd class="{{ blank($mediator['name']) ? 'is-missing' : '' }}">
                                {{ $mediator['name'] ?: $missing }}
                            </dd>
                        </div>
                        <div class="legal-data-wide">
                            <dt>Coordonnées du médiateur</dt>
                            <dd class="{{ blank($mediator['address']) && blank($mediator['website']) ? 'is-missing' : '' }}">
                                {{ $mediator['address'] ?: '' }}
                                @if ($mediator['address'] && $mediator['website']) · @endif
                                {{ $mediator['website'] ?: (blank($mediator['address']) ? $missing : '') }}
                            </dd>
                        </div>
                    </dl>

                    <p>
                        Après une réclamation préalable restée sans solution, le consommateur peut saisir gratuitement le
                        médiateur compétent selon ses règles d’éligibilité. À défaut d’accord amiable, les juridictions
                        territorialement compétentes sont déterminées selon les règles protectrices applicables au consommateur.
                    </p>
                </article>

                <article class="legal-block legal-version-block">
                    <header class="legal-block-heading">
                        <span>V.</span>
                        <div>
                            <p>Version du document</p>
                            <h2>Opposabilité et évolution</h2>
                        </div>
                    </header>

                    <p>
                        La version applicable est celle communiquée au client au moment de la confirmation de sa commande.
                        Le vendeur peut faire évoluer ces conditions pour l’avenir afin de tenir compte d’un changement légal,
                        technique ou commercial. La date de mise à jour figure en tête de page.
                    </p>
                </article>
            </div>
        </div>
    </section>

@endsection

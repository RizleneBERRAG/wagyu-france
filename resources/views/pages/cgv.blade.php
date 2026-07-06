@extends('layouts.app', [
    'title' => 'Conditions générales de vente — Wagyu France',
    'bodyClass' => 'legal-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}">
@endpush

@section('content')

    <section class="legal-hero">
        <div class="legal-glow legal-glow-left"></div>
        <div class="legal-glow legal-glow-right"></div>

        <div class="legal-hero-inner">
            <p class="eyebrow">Conditions commerciales</p>

            <h1>
                Conditions générales de vente
                <span>Wagyu France.</span>
            </h1>

            <p>
                Ces conditions encadrent les demandes de commande boutique et les échanges
                commerciaux réalisés avec Wagyu France.
            </p>
        </div>
    </section>

    <section class="legal-content-section">
        <div class="legal-layout">

            <aside class="legal-summary">
                <p class="eyebrow">Sommaire</p>

                <a href="#objet">Objet</a>
                <a href="#produits">Produits</a>
                <a href="#prix">Prix</a>
                <a href="#commande">Commande</a>
                <a href="#paiement">Paiement</a>
                <a href="#livraison">Livraison / retrait</a>
                <a href="#retractation">Rétractation</a>
                <a href="#garanties">Garanties</a>
                <a href="#litiges">Litiges</a>
            </aside>

            <div class="legal-content">

                <article class="legal-block legal-warning">
                    <span>!</span>

                    <h2>Texte à faire valider</h2>

                    <p>
                        Ces CGV sont une base de travail pour la maquette. Elles doivent être
                        relues et adaptées par Wagyu France selon son mode réel de vente :
                        paiement en ligne ou non, livraison, retrait, produits frais,
                        chaîne du froid, droit de rétractation applicable ou non.
                    </p>
                </article>

                <article class="legal-block" id="objet">
                    <span>01</span>

                    <h2>Objet</h2>

                    <p>
                        Les présentes conditions générales de vente ont pour objet de définir
                        les droits et obligations de Wagyu France et de ses clients dans le cadre
                        de la vente ou de la demande de commande de produits proposés sur le site.
                    </p>

                    <p>
                        Le site peut permettre au client de transmettre une demande de commande
                        ou de pré-réservation. Cette demande ne vaut pas nécessairement confirmation
                        définitive tant qu’elle n’a pas été validée par Wagyu France.
                    </p>
                </article>

                <article class="legal-block" id="produits">
                    <span>02</span>

                    <h2>Produits</h2>

                    <p>
                        Les produits proposés sont principalement des pièces de viande Wagyu,
                        présentées avec leurs caractéristiques essentielles : nom de la pièce,
                        usage conseillé, prix indicatif, quantité souhaitée ou informations
                        de disponibilité.
                    </p>

                    <p>
                        Les photographies, visuels et descriptions sont fournis à titre indicatif.
                        Le poids, la disponibilité et les découpes peuvent varier selon les animaux,
                        les préparations et les confirmations effectuées par Wagyu France.
                    </p>
                </article>

                <article class="legal-block" id="prix">
                    <span>03</span>

                    <h2>Prix</h2>

                    <p>
                        Les prix affichés sur le site sont indiqués en euros.
                    </p>

                    <p>
                        Pour la boutique particulier, les prix doivent être affichés TTC lorsque
                        la vente est effectivement ouverte aux consommateurs.
                    </p>

                    <p>
                        Pour l’espace professionnel, les prix peuvent être présentés hors taxes
                        lorsque le parcours est destiné aux professionnels.
                    </p>

                    <p>
                        Les prix peuvent être modifiés à tout moment. Le prix applicable sera celui
                        confirmé par Wagyu France au moment de la validation définitive de la commande.
                    </p>
                </article>

                <article class="legal-block" id="commande">
                    <span>04</span>

                    <h2>Commande et demande de disponibilité</h2>

                    <p>
                        Le client peut sélectionner des produits ou pièces et transmettre une demande
                        via le formulaire prévu à cet effet.
                    </p>

                    <p>
                        La demande transmise permet à Wagyu France de vérifier les disponibilités,
                        les quantités, les modalités de préparation et les conditions de livraison
                        ou de retrait.
                    </p>

                    <p>
                        La commande devient définitive uniquement après confirmation explicite
                        de Wagyu France et, le cas échéant, paiement selon les modalités indiquées.
                    </p>
                </article>

                <article class="legal-block" id="paiement">
                    <span>05</span>

                    <h2>Paiement</h2>

                    <p>
                        Les modalités de paiement seront communiquées au client lors de la confirmation
                        de sa commande.
                    </p>

                    <p>
                        Si un paiement en ligne est ajouté ultérieurement, le site devra préciser
                        les moyens de paiement acceptés, les conditions de sécurisation du paiement,
                        les éventuelles étapes de validation et les règles applicables en cas d’échec
                        de paiement.
                    </p>
                </article>

                <article class="legal-block" id="livraison">
                    <span>06</span>

                    <h2>Livraison, retrait et chaîne du froid</h2>

                    <p>
                        Les modalités de livraison, retrait, emballage, transport et conservation
                        seront précisées au client avant confirmation définitive de la commande.
                    </p>

                    <p>
                        Lorsque les produits sont des denrées périssables, une attention particulière
                        est portée au respect de la chaîne du froid et aux conditions de conservation.
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Zone de livraison</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Mode de retrait</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Délais estimatifs</strong>
                            <p>[À compléter]</p>
                        </div>
                    </div>
                </article>

                <article class="legal-block" id="retractation">
                    <span>07</span>

                    <h2>Droit de rétractation</h2>

                    <p>
                        Le droit de rétractation dépend de la nature des produits vendus et des règles
                        applicables aux denrées périssables ou produits personnalisés.
                    </p>

                    <p>
                        Cette rubrique doit être adaptée précisément selon les produits, le mode de vente
                        et les conditions de préparation appliquées par Wagyu France.
                    </p>

                    <p>
                        <strong>[À faire valider juridiquement avant mise en production]</strong>
                    </p>
                </article>

                <article class="legal-block" id="garanties">
                    <span>08</span>

                    <h2>Garanties légales</h2>

                    <p>
                        Le client bénéficie des garanties légales applicables, notamment la garantie
                        légale de conformité et la garantie contre les vices cachés, dans les conditions
                        prévues par les textes en vigueur.
                    </p>

                    <p>
                        Les réclamations doivent être transmises à Wagyu France dans les meilleurs délais
                        avec les éléments permettant d’identifier la commande et le problème rencontré.
                    </p>
                </article>

                <article class="legal-block" id="litiges">
                    <span>09</span>

                    <h2>Réclamations, médiation et litiges</h2>

                    <p>
                        En cas de difficulté, le client est invité à contacter Wagyu France afin de rechercher
                        une solution amiable.
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Email de réclamation</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Médiateur de la consommation</strong>
                            <p>[À compléter — obligatoire si vente à des consommateurs]</p>
                        </div>

                        <div>
                            <strong>Tribunal compétent</strong>
                            <p>[À compléter]</p>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

@endsection

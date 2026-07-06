@extends('layouts.app', [
    'title' => 'Politique de confidentialité — Wagyu France',
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
            <p class="eyebrow">Données personnelles</p>

            <h1>
                Politique de confidentialité
                <span>Wagyu France.</span>
            </h1>

            <p>
                Cette page explique quelles données peuvent être collectées, pourquoi elles
                sont utilisées, combien de temps elles sont conservées et quels droits peuvent
                être exercés.
            </p>
        </div>
    </section>

    <section class="legal-content-section">
        <div class="legal-layout">

            <aside class="legal-summary">
                <p class="eyebrow">Sommaire</p>

                <a href="#responsable">Responsable du traitement</a>
                <a href="#donnees">Données collectées</a>
                <a href="#finalites">Finalités</a>
                <a href="#base-legale">Base légale</a>
                <a href="#conservation">Conservation</a>
                <a href="#destinataires">Destinataires</a>
                <a href="#droits">Vos droits</a>
                <a href="#cookies">Cookies</a>
            </aside>

            <div class="legal-content">

                <article class="legal-block" id="responsable">
                    <span>01</span>

                    <h2>Responsable du traitement</h2>

                    <p>
                        Le responsable du traitement des données personnelles collectées sur le site est :
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Entreprise</strong>
                            <p>[À compléter — nom exact de la société]</p>
                        </div>

                        <div>
                            <strong>Adresse</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Email de contact</strong>
                            <p>[À compléter]</p>
                        </div>
                    </div>
                </article>

                <article class="legal-block" id="donnees">
                    <span>02</span>

                    <h2>Données personnelles collectées</h2>

                    <p>
                        Dans le cadre de l’utilisation du site, Wagyu France peut collecter les données
                        suivantes lorsque l’utilisateur remplit un formulaire ou transmet une demande :
                    </p>

                    <ul class="legal-list">
                        <li>Nom et prénom</li>
                        <li>Adresse email</li>
                        <li>Numéro de téléphone</li>
                        <li>Ville</li>
                        <li>Entreprise ou établissement pour les demandes professionnelles</li>
                        <li>Type de professionnel</li>
                        <li>Message transmis via un formulaire</li>
                        <li>Pièces ou produits demandés</li>
                        <li>Montants estimatifs associés aux demandes</li>
                    </ul>
                </article>

                <article class="legal-block" id="finalites">
                    <span>03</span>

                    <h2>Finalités du traitement</h2>

                    <p>
                        Les données collectées peuvent être utilisées pour :
                    </p>

                    <ul class="legal-list">
                        <li>Répondre à une demande de contact</li>
                        <li>Traiter une demande de commande boutique</li>
                        <li>Traiter une demande de pré-réservation professionnelle</li>
                        <li>Recontacter l’utilisateur pour confirmer une disponibilité</li>
                        <li>Assurer le suivi administratif des demandes</li>
                        <li>Améliorer la qualité du service et du parcours client</li>
                    </ul>
                </article>

                <article class="legal-block" id="base-legale">
                    <span>04</span>

                    <h2>Base légale</h2>

                    <p>
                        Les traitements peuvent être fondés sur l’exécution de mesures précontractuelles
                        ou contractuelles lorsque l’utilisateur transmet une demande de commande ou de
                        réservation.
                    </p>

                    <p>
                        Certains traitements peuvent également reposer sur l’intérêt légitime de Wagyu
                        France à assurer le suivi de ses demandes clients, ou sur le consentement lorsque
                        celui-ci est requis.
                    </p>
                </article>

                <article class="legal-block" id="conservation">
                    <span>05</span>

                    <h2>Durée de conservation</h2>

                    <p>
                        Les données sont conservées pendant une durée adaptée aux finalités pour lesquelles
                        elles ont été collectées.
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Demandes de contact</strong>
                            <p>[À compléter — exemple : 12 mois après le dernier échange]</p>
                        </div>

                        <div>
                            <strong>Demandes de commande</strong>
                            <p>[À compléter — durée liée au suivi commercial et obligations légales]</p>
                        </div>

                        <div>
                            <strong>Données administratives</strong>
                            <p>[À compléter — selon obligations comptables ou légales applicables]</p>
                        </div>
                    </div>
                </article>

                <article class="legal-block" id="destinataires">
                    <span>06</span>

                    <h2>Destinataires des données</h2>

                    <p>
                        Les données sont destinées aux personnes habilitées au sein de Wagyu France
                        pour assurer le traitement des demandes.
                    </p>

                    <p>
                        Elles peuvent également être transmises à des prestataires techniques strictement
                        nécessaires au fonctionnement du site, comme l’hébergeur ou les outils d’envoi
                        d’emails, lorsque ces services sont utilisés.
                    </p>
                </article>

                <article class="legal-block" id="droits">
                    <span>07</span>

                    <h2>Vos droits</h2>

                    <p>
                        Conformément à la réglementation applicable en matière de protection des données
                        personnelles, vous pouvez exercer vos droits d’accès, de rectification, d’effacement,
                        d’opposition, de limitation et, lorsque cela s’applique, de portabilité.
                    </p>

                    <p>
                        Pour exercer vos droits, vous pouvez écrire à :
                        <strong>[À compléter — email de contact RGPD]</strong>.
                    </p>

                    <p>
                        Vous disposez également du droit d’introduire une réclamation auprès de la CNIL.
                    </p>
                </article>

                <article class="legal-block" id="cookies">
                    <span>08</span>

                    <h2>Cookies et traceurs</h2>

                    <p>
                        Le site peut utiliser des cookies strictement nécessaires au bon fonctionnement
                        du service, notamment pour la session, la sécurité ou certaines préférences
                        d’interface.
                    </p>

                    <p>
                        Si des cookies de mesure d’audience, de publicité, de personnalisation ou de
                        suivi externe sont ajoutés ultérieurement, un dispositif de consentement adapté
                        devra être mis en place.
                    </p>
                </article>

            </div>
        </div>
    </section>

@endsection

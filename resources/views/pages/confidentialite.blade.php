@php
    $legal = config('legal');
    $company = $legal['company'];
    $privacy = $legal['privacy'];
    $missing = 'À renseigner avant mise en ligne';

    $isIncomplete = collect([
        $company['legal_name'],
        $company['email'],
        $privacy['contact_email'],
    ])->contains(fn ($value) => blank($value));
@endphp

@extends('layouts.app', [
    'title' => 'Politique de confidentialité — Wagyu France',
    'description' => 'Données collectées, finalités, durées de conservation et droits des utilisateurs du site Wagyu France.',
    'bodyClass' => 'legal-page legal-privacy-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}">
@endpush

@section('content')

    <section class="legal-hero">
        <div class="legal-shell legal-hero-grid">
            <div class="legal-hero-copy">
                <p class="legal-kicker">Wagyu France · Données personnelles</p>

                <h1>
                    Politique de
                    <em>confidentialité.</em>
                </h1>

                <p class="legal-hero-lead">
                    Cette politique explique quelles informations sont collectées lorsque vous contactez
                    la maison, préparez une demande boutique ou constituez une sélection professionnelle.
                </p>

                <div class="legal-document-meta">
                    <div>
                        <span>Document</span>
                        <strong>Confidentialité & RGPD</strong>
                    </div>
                    <div>
                        <span>Dernière mise à jour</span>
                        <strong>{{ $legal['last_updated'] }}</strong>
                    </div>
                    <div>
                        <span>Point de contact</span>
                        <strong>{{ $privacy['contact_email'] ?: 'À compléter' }}</strong>
                    </div>
                </div>
            </div>

            <div class="legal-hero-mark" aria-hidden="true">
                <span>WF</span>
                <small>Données protégées</small>
            </div>
        </div>
    </section>

    <nav class="legal-pages-nav" aria-label="Pages juridiques">
        <div class="legal-shell legal-pages-nav-inner">
            <a href="{{ route('mentions.legales') }}">Mentions légales</a>
            <a href="{{ route('confidentialite') }}" class="is-active">Confidentialité</a>
            <a href="{{ route('cgv') }}">Conditions de vente</a>
        </div>
    </nav>

    @if ($isIncomplete)
        <section class="legal-completion-alert">
            <div class="legal-shell legal-completion-alert-inner">
                <span>Coordonnées RGPD à finaliser</span>
                <p>
                    Le contenu de la politique est structuré selon les traitements réellement prévus par le site.
                    Le nom légal du responsable et l’adresse dédiée à l’exercice des droits doivent encore être
                    renseignés avant publication.
                </p>
            </div>
        </section>
    @endif

    <section class="legal-content-section">
        <div class="legal-shell legal-layout">
            <aside class="legal-summary">
                <span class="legal-summary-title">Sommaire</span>
                <a href="#responsable"><b>01</b> Responsable</a>
                <a href="#collecte"><b>02</b> Données collectées</a>
                <a href="#finalites"><b>03</b> Finalités & bases</a>
                <a href="#obligatoire"><b>04</b> Champs obligatoires</a>
                <a href="#conservation"><b>05</b> Conservation</a>
                <a href="#destinataires"><b>06</b> Destinataires</a>
                <a href="#securite"><b>07</b> Sécurité</a>
                <a href="#droits"><b>08</b> Vos droits</a>
                <a href="#cookies"><b>09</b> Cookies</a>
            </aside>

            <div class="legal-content">
                <article class="legal-block" id="responsable">
                    <header class="legal-block-heading">
                        <span>01</span>
                        <div>
                            <p>Identité du traitement</p>
                            <h2>Responsable des données</h2>
                        </div>
                    </header>

                    <p>
                        Le responsable du traitement est
                        <strong class="{{ blank($company['legal_name']) ? 'legal-inline-missing' : '' }}">
                            {{ $company['legal_name'] ?: $missing }}
                        </strong>, exploitant le site sous le nom commercial
                        <strong>{{ $legal['brand_name'] }}</strong>.
                    </p>

                    <dl class="legal-data-grid">
                        <div class="legal-data-wide">
                            <dt>Adresse</dt>
                            <dd>{{ $company['address'] }}</dd>
                        </div>
                        <div>
                            <dt>Contact général</dt>
                            <dd class="{{ blank($company['email']) ? 'is-missing' : '' }}">
                                {{ $company['email'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Exercice des droits</dt>
                            <dd class="{{ blank($privacy['contact_email']) ? 'is-missing' : '' }}">
                                {{ $privacy['contact_email'] ?: $missing }}
                            </dd>
                        </div>
                    </dl>
                </article>

                <article class="legal-block" id="collecte">
                    <header class="legal-block-heading">
                        <span>02</span>
                        <div>
                            <p>Informations concernées</p>
                            <h2>Données collectées</h2>
                        </div>
                    </header>

                    <p>
                        Les données sont principalement fournies directement par l’utilisateur dans les formulaires
                        du site. Elles varient selon le parcours utilisé.
                    </p>

                    <div class="legal-category-grid">
                        <section>
                            <span>Contact</span>
                            <h3>Message à la maison</h3>
                            <ul class="legal-list">
                                <li>Profil : particulier, professionnel ou partenaire</li>
                                <li>Nom, email et téléphone éventuel</li>
                                <li>Société, ville et motif de la demande</li>
                                <li>Message et moyen de réponse préféré</li>
                            </ul>
                        </section>

                        <section>
                            <span>Boutique</span>
                            <h3>Demande de commande</h3>
                            <ul class="legal-list">
                                <li>Coordonnées du demandeur</li>
                                <li>Ville ou secteur de livraison</li>
                                <li>Produits, quantités et total estimatif</li>
                                <li>Message complémentaire et référence de demande</li>
                            </ul>
                        </section>

                        <section>
                            <span>Professionnels</span>
                            <h3>Pré-réservation</h3>
                            <ul class="legal-list">
                                <li>Établissement et type de professionnel</li>
                                <li>Nom, email, téléphone et ville</li>
                                <li>Pièces, volumes et estimation HT</li>
                                <li>Échéances ou contraintes précisées dans le message</li>
                            </ul>
                        </section>
                    </div>

                    <p>
                        Des informations techniques strictement nécessaires peuvent également être générées par
                        le serveur, notamment la date de la demande, les journaux de sécurité ou les données de session.
                    </p>
                </article>

                <article class="legal-block" id="finalites">
                    <header class="legal-block-heading">
                        <span>03</span>
                        <div>
                            <p>Pourquoi les données sont utilisées</p>
                            <h2>Finalités et bases juridiques</h2>
                        </div>
                    </header>

                    <div class="legal-table-wrap">
                        <table class="legal-table">
                            <thead>
                                <tr>
                                    <th>Traitement</th>
                                    <th>Finalité</th>
                                    <th>Base juridique</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Formulaire de contact</td>
                                    <td>Répondre à une question ou étudier un projet</td>
                                    <td>Mesures précontractuelles, consentement ou intérêt légitime selon la demande</td>
                                </tr>
                                <tr>
                                    <td>Demande boutique</td>
                                    <td>Vérifier les produits, quantités et modalités</td>
                                    <td>Mesures précontractuelles demandées par l’utilisateur</td>
                                </tr>
                                <tr>
                                    <td>Réserve professionnelle</td>
                                    <td>Étudier une sélection de pièces et de volumes</td>
                                    <td>Mesures précontractuelles et intérêt légitime à organiser la relation B2B</td>
                                </tr>
                                <tr>
                                    <td>Suivi administratif</td>
                                    <td>Gérer les références, statuts, preuves et échanges</td>
                                    <td>Exécution contractuelle, obligations légales et intérêt légitime</td>
                                </tr>
                                <tr>
                                    <td>Sécurité du site</td>
                                    <td>Prévenir les abus, incidents et accès non autorisés</td>
                                    <td>Intérêt légitime et obligations de sécurité</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>
                        Les données ne sont pas utilisées pour une décision entièrement automatisée produisant
                        des effets juridiques sur l’utilisateur.
                    </p>
                </article>

                <article class="legal-block" id="obligatoire">
                    <header class="legal-block-heading">
                        <span>04</span>
                        <div>
                            <p>Transparence des formulaires</p>
                            <h2>Champs obligatoires et facultatifs</h2>
                        </div>
                    </header>

                    <p>
                        Les champs marqués d’un astérisque sont nécessaires pour identifier la demande et y répondre.
                        Sans ces informations, le formulaire ne peut pas être transmis ou la demande ne peut pas être
                        correctement étudiée.
                    </p>

                    <p>
                        Les autres champs sont facultatifs. Ils permettent simplement d’apporter davantage de contexte,
                        notamment pour les demandes professionnelles, les besoins de livraison ou les préférences de contact.
                    </p>
                </article>

                <article class="legal-block" id="conservation">
                    <header class="legal-block-heading">
                        <span>05</span>
                        <div>
                            <p>Durées limitées</p>
                            <h2>Conservation des données</h2>
                        </div>
                    </header>

                    <dl class="legal-data-grid legal-retention-grid">
                        <div>
                            <dt>Contacts sans commande</dt>
                            <dd>{{ $privacy['contact_retention'] }}</dd>
                        </div>
                        <div>
                            <dt>Demandes commerciales</dt>
                            <dd>{{ $privacy['commercial_retention'] }}</dd>
                        </div>
                        <div>
                            <dt>Documents comptables</dt>
                            <dd>{{ $privacy['accounting_retention'] }}</dd>
                        </div>
                        <div>
                            <dt>Journaux techniques</dt>
                            <dd>{{ $privacy['technical_logs_retention'] }}</dd>
                        </div>
                    </dl>

                    <p>
                        Une donnée peut être conservée plus longtemps lorsqu’une obligation légale, un contentieux
                        ou la nécessité de défendre un droit l’impose. Elle est alors placée en archivage intermédiaire
                        et son accès est limité.
                    </p>
                </article>

                <article class="legal-block" id="destinataires">
                    <header class="legal-block-heading">
                        <span>06</span>
                        <div>
                            <p>Accès encadré</p>
                            <h2>Destinataires et prestataires</h2>
                        </div>
                    </header>

                    <p>
                        Les données sont accessibles aux personnes habilitées au sein de {{ $legal['brand_name'] }}
                        qui assurent le traitement des demandes, le suivi commercial, la préparation ou la livraison.
                    </p>

                    <p>
                        Elles peuvent être communiquées, dans la stricte mesure nécessaire, à l’hébergeur, aux prestataires
                        de messagerie, de maintenance, de paiement ou de transport effectivement retenus lors de la mise
                        en production. Ces prestataires agissent selon leurs obligations contractuelles et réglementaires.
                    </p>

                    <p>
                        Aucune donnée n’est vendue à des tiers. En cas de transfert hors de l’Espace économique européen,
                        les garanties prévues par la réglementation applicable devront être mises en place et documentées.
                    </p>
                </article>

                <article class="legal-block" id="securite">
                    <header class="legal-block-heading">
                        <span>07</span>
                        <div>
                            <p>Mesures de protection</p>
                            <h2>Sécurité et confidentialité</h2>
                        </div>
                    </header>

                    <p>
                        Des mesures techniques et organisationnelles proportionnées sont mises en œuvre pour limiter
                        les accès non autorisés, la perte, l’altération ou la divulgation des données. Elles comprennent
                        notamment le contrôle des accès administratifs, la validation des formulaires, la protection CSRF,
                        la journalisation et la maintenance régulière de l’application.
                    </p>

                    <p>
                        Aucun système ne pouvant garantir une sécurité absolue, tout incident avéré est traité selon sa
                        gravité et, lorsque la réglementation l’exige, notifié aux personnes concernées et à l’autorité compétente.
                    </p>
                </article>

                <article class="legal-block" id="droits">
                    <header class="legal-block-heading">
                        <span>08</span>
                        <div>
                            <p>Contrôle par la personne</p>
                            <h2>Vos droits</h2>
                        </div>
                    </header>

                    <p>
                        Selon votre situation, vous pouvez demander l’accès, la rectification, l’effacement, la limitation
                        ou la portabilité de vos données. Vous pouvez également vous opposer à certains traitements ou retirer
                        votre consentement lorsqu’il constitue leur base juridique.
                    </p>

                    <p>
                        La demande peut être envoyée à
                        <strong class="{{ blank($privacy['contact_email']) ? 'legal-inline-missing' : '' }}">
                            {{ $privacy['contact_email'] ?: $missing }}
                        </strong>. Une preuve d’identité peut être demandée uniquement lorsqu’elle est nécessaire pour éviter
                        qu’un tiers n’accède à vos données.
                    </p>

                    <p>
                        En cas de difficulté non résolue, vous pouvez introduire une réclamation auprès de la Commission
                        nationale de l’informatique et des libertés (CNIL).
                    </p>

                    <a href="{{ route('contact') }}" class="legal-action-link">
                        Envoyer une demande relative à mes données <span>→</span>
                    </a>
                </article>

                <article class="legal-block" id="cookies">
                    <header class="legal-block-heading">
                        <span>09</span>
                        <div>
                            <p>Traceurs et stockage local</p>
                            <h2>Cookies</h2>
                        </div>
                    </header>

                    <p>
                        Le site peut utiliser des cookies ou dispositifs équivalents strictement nécessaires à la session,
                        à la sécurité, à la protection des formulaires, au fonctionnement du panier ou à la mémorisation de
                        préférences techniques. Ces traceurs ne nécessitent pas de consentement lorsqu’ils sont indispensables
                        au service demandé.
                    </p>

                    <p>
                        Tout futur outil facultatif de mesure d’audience, de publicité, de personnalisation ou de suivi tiers
                        devra être désactivé par défaut et soumis à un choix libre avant son dépôt. L’utilisateur devra pouvoir
                        accepter, refuser et modifier son choix avec la même facilité.
                    </p>

                    <div class="legal-note-card">
                        <span>Configuration actuelle</span>
                        <p>
                            Le parcours développé pour {{ $legal['brand_name'] }} repose sur les fonctions techniques de
                            Laravel et sur le stockage nécessaire aux formulaires et paniers. La liste définitive des traceurs
                            devra être contrôlée après choix de l’hébergement, des outils statistiques et des moyens de paiement.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

@endsection

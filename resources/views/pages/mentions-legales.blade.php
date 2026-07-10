@php
    $legal = config('legal');
    $company = $legal['company'];
    $hosting = $legal['hosting'];

    $requiredCompanyFields = [
        $company['legal_name'],
        $company['legal_form'],
        $company['siret'],
        $company['email'],
        $company['phone'],
        $company['publication_director'],
    ];

    $requiredHostingFields = [
        $hosting['name'],
        $hosting['address'],
        $hosting['phone'],
    ];

    $isIncomplete = collect(array_merge($requiredCompanyFields, $requiredHostingFields))
        ->contains(fn ($value) => blank($value));

    $missing = 'À renseigner avant mise en ligne';
@endphp

@extends('layouts.app', [
    'title' => 'Mentions légales — Wagyu France',
    'description' => 'Identité de l’éditeur, hébergement, responsabilité et propriété intellectuelle du site Wagyu France.',
    'bodyClass' => 'legal-page legal-mentions-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}">
@endpush

@section('content')

    <section class="legal-hero">
        <div class="legal-shell legal-hero-grid">
            <div class="legal-hero-copy">
                <p class="legal-kicker">Wagyu France · Cadre juridique</p>

                <h1>
                    Mentions
                    <em>légales.</em>
                </h1>

                <p class="legal-hero-lead">
                    Cette page permet d’identifier l’éditeur du site, son responsable de publication,
                    son hébergeur et les règles essentielles qui encadrent l’utilisation des contenus.
                </p>

                <div class="legal-document-meta">
                    <div>
                        <span>Document</span>
                        <strong>Mentions légales</strong>
                    </div>
                    <div>
                        <span>Dernière mise à jour</span>
                        <strong>{{ $legal['last_updated'] }}</strong>
                    </div>
                    <div>
                        <span>Site concerné</span>
                        <strong>{{ $legal['brand_name'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="legal-hero-mark" aria-hidden="true">
                <span>WF</span>
                <small>Informations légales</small>
            </div>
        </div>
    </section>

    <nav class="legal-pages-nav" aria-label="Pages juridiques">
        <div class="legal-shell legal-pages-nav-inner">
            <a href="{{ route('mentions.legales') }}" class="is-active">Mentions légales</a>
            <a href="{{ route('confidentialite') }}">Confidentialité</a>
            <a href="{{ route('cgv') }}">Conditions de vente</a>
        </div>
    </nav>

    @if ($isIncomplete)
        <section class="legal-completion-alert">
            <div class="legal-shell legal-completion-alert-inner">
                <span>Informations administratives à finaliser</span>
                <p>
                    La structure juridique de cette page est prête. L’identité légale complète de l’entreprise
                    et les coordonnées exactes de l’hébergeur doivent encore être renseignées dans la configuration
                    avant la mise en ligne publique.
                </p>
            </div>
        </section>
    @endif

    <section class="legal-content-section">
        <div class="legal-shell legal-layout">
            <aside class="legal-summary">
                <span class="legal-summary-title">Sommaire</span>
                <a href="#editeur"><b>01</b> Éditeur</a>
                <a href="#publication"><b>02</b> Publication</a>
                <a href="#hebergement"><b>03</b> Hébergement</a>
                <a href="#propriete"><b>04</b> Propriété intellectuelle</a>
                <a href="#responsabilite"><b>05</b> Responsabilité</a>
                <a href="#liens"><b>06</b> Liens externes</a>
                <a href="#contact-legal"><b>07</b> Contact</a>
            </aside>

            <div class="legal-content">
                <article class="legal-block" id="editeur">
                    <header class="legal-block-heading">
                        <span>01</span>
                        <div>
                            <p>Identification</p>
                            <h2>Éditeur du site</h2>
                        </div>
                    </header>

                    <p>
                        Le site <strong>{{ $legal['brand_name'] }}</strong>, accessible à l’adresse
                        <strong>{{ $legal['site_url'] }}</strong>, est édité par l’entité ci-dessous.
                    </p>

                    <dl class="legal-data-grid">
                        <div>
                            <dt>Dénomination légale</dt>
                            <dd class="{{ blank($company['legal_name']) ? 'is-missing' : '' }}">
                                {{ $company['legal_name'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Nom commercial</dt>
                            <dd>{{ $legal['brand_name'] }}</dd>
                        </div>
                        <div>
                            <dt>Forme juridique</dt>
                            <dd class="{{ blank($company['legal_form']) ? 'is-missing' : '' }}">
                                {{ $company['legal_form'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Capital social</dt>
                            <dd class="{{ blank($company['capital']) ? 'is-missing' : '' }}">
                                {{ $company['capital'] ?: 'À préciser si applicable' }}
                            </dd>
                        </div>
                        <div class="legal-data-wide">
                            <dt>Siège social</dt>
                            <dd>{{ $company['address'] }}</dd>
                        </div>
                        <div>
                            <dt>SIREN</dt>
                            <dd class="{{ blank($company['siren']) ? 'is-missing' : '' }}">
                                {{ $company['siren'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>SIRET</dt>
                            <dd class="{{ blank($company['siret']) ? 'is-missing' : '' }}">
                                {{ $company['siret'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>RCS / RNE</dt>
                            <dd class="{{ blank($company['rcs']) && blank($company['rne']) ? 'is-missing' : '' }}">
                                {{ $company['rcs'] ?: ($company['rne'] ?: $missing) }}
                            </dd>
                        </div>
                        <div>
                            <dt>TVA intracommunautaire</dt>
                            <dd class="{{ blank($company['vat']) ? 'is-missing' : '' }}">
                                {{ $company['vat'] ?: 'À préciser si applicable' }}
                            </dd>
                        </div>
                    </dl>
                </article>

                <article class="legal-block" id="publication">
                    <header class="legal-block-heading">
                        <span>02</span>
                        <div>
                            <p>Responsabilité éditoriale</p>
                            <h2>Direction de la publication</h2>
                        </div>
                    </header>

                    <p>
                        La direction de la publication est assurée par
                        <strong class="{{ blank($company['publication_director']) ? 'legal-inline-missing' : '' }}">
                            {{ $company['publication_director'] ?: $missing }}
                        </strong>, en qualité de représentant légal de l’éditeur.
                    </p>
                </article>

                <article class="legal-block" id="hebergement">
                    <header class="legal-block-heading">
                        <span>03</span>
                        <div>
                            <p>Infrastructure</p>
                            <h2>Hébergement du site</h2>
                        </div>
                    </header>

                    <p>Le site est hébergé par le prestataire suivant :</p>

                    <dl class="legal-data-grid">
                        <div>
                            <dt>Nom commercial</dt>
                            <dd class="{{ blank($hosting['name']) ? 'is-missing' : '' }}">
                                {{ $hosting['name'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Raison sociale</dt>
                            <dd class="{{ blank($hosting['legal_name']) ? 'is-missing' : '' }}">
                                {{ $hosting['legal_name'] ?: 'À préciser si différente' }}
                            </dd>
                        </div>
                        <div class="legal-data-wide">
                            <dt>Adresse</dt>
                            <dd class="{{ blank($hosting['address']) ? 'is-missing' : '' }}">
                                {{ $hosting['address'] ?: $missing }}
                            </dd>
                        </div>
                        <div>
                            <dt>Téléphone</dt>
                            <dd class="{{ blank($hosting['phone']) ? 'is-missing' : '' }}">
                                {{ $hosting['phone'] ?: $missing }}
                            </dd>
                        </div>
                    </dl>
                </article>

                <article class="legal-block" id="propriete">
                    <header class="legal-block-heading">
                        <span>04</span>
                        <div>
                            <p>Contenus et marque</p>
                            <h2>Propriété intellectuelle</h2>
                        </div>
                    </header>

                    <p>
                        La structure du site, son identité visuelle, ses textes, photographies, vidéos,
                        illustrations, logos, interfaces et éléments graphiques sont protégés par les règles
                        françaises et internationales relatives à la propriété intellectuelle.
                    </p>

                    <p>
                        Toute reproduction, représentation, adaptation, extraction, diffusion ou exploitation,
                        totale ou partielle, sans autorisation écrite préalable de leur titulaire est interdite,
                        sauf exception prévue par la loi.
                    </p>
                </article>

                <article class="legal-block" id="responsabilite">
                    <header class="legal-block-heading">
                        <span>05</span>
                        <div>
                            <p>Utilisation du service</p>
                            <h2>Responsabilité</h2>
                        </div>
                    </header>

                    <p>
                        L’éditeur veille à présenter des informations aussi exactes et actualisées que possible.
                        Des erreurs, omissions, interruptions techniques ou évolutions de disponibilité peuvent
                        toutefois survenir.
                    </p>

                    <p>
                        Les prix, volumes, délais et disponibilités présentés dans les parcours boutique ou
                        professionnel restent indicatifs tant qu’ils n’ont pas fait l’objet d’une confirmation
                        expresse de {{ $legal['brand_name'] }}.
                    </p>

                    <p>
                        L’utilisateur reste responsable de son équipement, de sa connexion et de l’usage qu’il fait
                        des informations accessibles sur le site.
                    </p>
                </article>

                <article class="legal-block" id="liens">
                    <header class="legal-block-heading">
                        <span>06</span>
                        <div>
                            <p>Sites tiers</p>
                            <h2>Liens externes</h2>
                        </div>
                    </header>

                    <p>
                        Le site peut proposer des liens vers des services tiers. L’éditeur ne contrôle pas leur
                        contenu, leur disponibilité ni leurs pratiques et ne peut être tenu responsable d’un dommage
                        résultant de leur consultation ou de leur utilisation.
                    </p>
                </article>

                <article class="legal-block legal-contact-block" id="contact-legal">
                    <header class="legal-block-heading">
                        <span>07</span>
                        <div>
                            <p>Nous joindre</p>
                            <h2>Contact juridique</h2>
                        </div>
                    </header>

                    <dl class="legal-data-grid">
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
                        <div class="legal-data-wide">
                            <dt>Adresse postale</dt>
                            <dd>{{ $company['address'] }}</dd>
                        </div>
                    </dl>

                    <a href="{{ route('contact') }}" class="legal-action-link">
                        Utiliser le formulaire de contact <span>→</span>
                    </a>
                </article>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.app', [
    'title' => 'Mentions légales — Wagyu France',
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
            <p class="eyebrow">Informations légales</p>

            <h1>
                Mentions légales
                <span>Wagyu France.</span>
            </h1>

            <p>
                Cette page regroupe les informations légales relatives à l’éditeur du site,
                à son hébergement et aux conditions d’utilisation du service.
            </p>
        </div>
    </section>

    <section class="legal-content-section">
        <div class="legal-layout">

            <aside class="legal-summary">
                <p class="eyebrow">Sommaire</p>

                <a href="#editeur">Éditeur du site</a>
                <a href="#publication">Direction de publication</a>
                <a href="#hebergeur">Hébergement</a>
                <a href="#propriete">Propriété intellectuelle</a>
                <a href="#responsabilite">Responsabilité</a>
                <a href="#contact">Contact</a>
            </aside>

            <div class="legal-content">

                <article class="legal-block" id="editeur">
                    <span>01</span>

                    <h2>Éditeur du site</h2>

                    <p>
                        Le présent site est édité par :
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Dénomination sociale</strong>
                            <p>[À compléter — Wagyu France / nom exact de la société]</p>
                        </div>

                        <div>
                            <strong>Forme juridique</strong>
                            <p>[À compléter — SAS, SARL, EI, etc.]</p>
                        </div>

                        <div>
                            <strong>Capital social</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Siège social</strong>
                            <p>[À compléter — adresse complète]</p>
                        </div>

                        <div>
                            <strong>SIREN / SIRET</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>RCS</strong>
                            <p>[À compléter — ville d’immatriculation]</p>
                        </div>

                        <div>
                            <strong>TVA intracommunautaire</strong>
                            <p>[À compléter si applicable]</p>
                        </div>

                        <div>
                            <strong>Contact</strong>
                            <p>[À compléter — email et téléphone]</p>
                        </div>
                    </div>
                </article>

                <article class="legal-block" id="publication">
                    <span>02</span>

                    <h2>Direction de la publication</h2>

                    <p>
                        Le directeur ou la directrice de la publication est :
                        <strong>[À compléter — nom du représentant légal]</strong>.
                    </p>
                </article>

                <article class="legal-block" id="hebergeur">
                    <span>03</span>

                    <h2>Hébergement</h2>

                    <p>
                        Le site est hébergé par :
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Hébergeur</strong>
                            <p>[À compléter — OVH, Hostinger, Ionos, etc.]</p>
                        </div>

                        <div>
                            <strong>Adresse</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Téléphone</strong>
                            <p>[À compléter]</p>
                        </div>
                    </div>
                </article>

                <article class="legal-block" id="propriete">
                    <span>04</span>

                    <h2>Propriété intellectuelle</h2>

                    <p>
                        L’ensemble des contenus présents sur le site Wagyu France, notamment
                        les textes, éléments graphiques, interfaces, logos, photographies,
                        illustrations, vidéos et éléments de marque, sont protégés par les règles
                        relatives à la propriété intellectuelle.
                    </p>

                    <p>
                        Toute reproduction, représentation, modification, adaptation ou exploitation,
                        totale ou partielle, sans autorisation préalable écrite est interdite.
                    </p>
                </article>

                <article class="legal-block" id="responsabilite">
                    <span>05</span>

                    <h2>Responsabilité</h2>

                    <p>
                        Wagyu France s’efforce d’assurer l’exactitude et la mise à jour des informations
                        diffusées sur le site. Toutefois, des erreurs, omissions ou indisponibilités
                        temporaires peuvent survenir.
                    </p>

                    <p>
                        Les informations présentes sur le site sont fournies à titre indicatif et ne
                        constituent pas un engagement contractuel définitif, notamment concernant
                        les disponibilités, prix, volumes ou délais, qui peuvent faire l’objet d’une
                        confirmation spécifique.
                    </p>
                </article>

                <article class="legal-block" id="contact">
                    <span>06</span>

                    <h2>Contact</h2>

                    <p>
                        Pour toute question relative au site, vous pouvez contacter Wagyu France :
                    </p>

                    <div class="legal-info-grid">
                        <div>
                            <strong>Email</strong>
                            <p>[À compléter]</p>
                        </div>

                        <div>
                            <strong>Téléphone</strong>
                            <p>[À compléter]</p>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

@endsection

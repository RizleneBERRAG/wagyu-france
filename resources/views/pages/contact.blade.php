@extends('layouts.app', [
    'title' => 'Contacter Wagyu France — Particuliers & professionnels',
    'description' => 'Contactez Wagyu France pour une question boutique, une demande professionnelle, une pré-réservation, un partenariat ou un besoin sur mesure.',
    'bodyClass' => 'contact-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/contact.js') }}" defer></script>
@endpush

@section('content')

    <section class="contact-hero">
        <div class="contact-shell contact-hero-grid">
            <div class="contact-hero-copy">
                <p class="contact-kicker">Wagyu France · La maison vous répond</p>

                <h1>
                    Parlons de votre demande,
                    <em>avec précision.</em>
                </h1>

                <p class="contact-hero-lead">
                    Une question sur une pièce, un besoin professionnel, une pré-réservation
                    ou un projet particulier&nbsp;? Décrivez-nous votre situation afin que la maison
                    puisse vous apporter une réponse réellement adaptée.
                </p>

                <div class="contact-hero-actions">
                    <a href="#contact-form" class="contact-button contact-button-primary">
                        Écrire à la maison
                    </a>
                    <a href="{{ route('reserve.pro') }}" class="contact-button contact-button-secondary">
                        Accéder à la réserve pro
                    </a>
                </div>

                <dl class="contact-hero-facts">
                    <div>
                        <dt>Particuliers</dt>
                        <dd>Produit, commande et dégustation</dd>
                    </div>
                    <div>
                        <dt>Professionnels</dt>
                        <dd>Pièces, volumes et échéances</dd>
                    </div>
                    <div>
                        <dt>Projets</dt>
                        <dd>Événement, presse et partenariat</dd>
                    </div>
                </dl>
            </div>

            <figure class="contact-hero-visual">
                <img
                    src="{{ asset('assets/images/histoire/maison-wagyu-france.jpg') }}"
                    alt="La maison Wagyu France"
                >

                <figcaption>
                    <span>Contact direct</span>
                    <strong>Une demande claire permet une réponse plus juste.</strong>
                </figcaption>

                <div class="contact-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Contact</small>
                </div>
            </figure>
        </div>
    </section>

    <nav class="contact-chapters" aria-label="Sommaire de la page contact">
        <div class="contact-shell contact-chapters-grid">
            <a href="#parcours"><span>01</span> Choisir son parcours</a>
            <a href="#contact-form"><span>02</span> Envoyer une demande</a>
            <a href="#suivi"><span>03</span> Comprendre le suivi</a>
            <a href="#questions"><span>04</span> Questions fréquentes</a>
        </div>
    </nav>

    <section class="contact-section contact-paths" id="parcours">
        <div class="contact-shell">
            <header class="contact-section-heading">
                <div>
                    <p class="contact-kicker">Le bon interlocuteur, dès le départ</p>
                    <h2>Trois parcours, une même exigence de réponse.</h2>
                </div>
                <p>
                    Sélectionnez le profil qui correspond le mieux à votre demande. Le formulaire
                    restera ouvert à tous, mais le contexte transmis aidera la maison à mieux vous orienter.
                </p>
            </header>

            <div class="contact-path-grid">
                <article>
                    <span>01</span>
                    <small>Univers particulier</small>
                    <h3>Conseil & boutique</h3>
                    <p>
                        Choix d’une pièce, quantité, disponibilité, conservation, préparation
                        ou suivi d’une demande boutique.
                    </p>
                    <a href="#contact-form" data-contact-profile="particulier">
                        Préparer ma demande <b>→</b>
                    </a>
                </article>

                <article class="is-featured">
                    <span>02</span>
                    <small>Univers professionnel</small>
                    <h3>Volumes & sélection</h3>
                    <p>
                        Restaurant, boucherie, traiteur ou hôtel souhaitant échanger sur les pièces,
                        les quantités, la découpe ou une échéance précise.
                    </p>
                    <a href="#contact-form" data-contact-profile="professionnel">
                        Présenter mon besoin <b>→</b>
                    </a>
                </article>

                <article>
                    <span>03</span>
                    <small>Projets & collaborations</small>
                    <h3>Partenariat sur mesure</h3>
                    <p>
                        Presse, événement, expérience gastronomique, collaboration de marque
                        ou projet nécessitant un échange spécifique.
                    </p>
                    <a href="#contact-form" data-contact-profile="partenaire">
                        Parler de mon projet <b>→</b>
                    </a>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-form-section" id="contact-form">
        <div class="contact-shell contact-form-layout">
            <aside class="contact-form-intro">
                <p class="contact-kicker">Votre demande</p>
                <h2>
                    Donnez-nous les éléments
                    <em>qui feront la différence.</em>
                </h2>
                <p>
                    Plus votre message est précis, plus la réponse pourra l’être. Pour une demande
                    professionnelle, indiquez votre établissement, votre ville, les pièces recherchées,
                    les volumes envisagés et votre échéance.
                </p>

                <div class="contact-form-image">
                    <img
                        src="{{ asset('assets/images/pro/tracabilite.jpg') }}"
                        alt="Suivi professionnel Wagyu France"
                    >
                    <div>
                        <span>Suivi de la demande</span>
                        <strong>Chaque message reçoit une référence unique.</strong>
                    </div>
                </div>

                <div class="contact-form-promises">
                    <article>
                        <span>01</span>
                        <div>
                            <strong>Demande enregistrée</strong>
                            <p>Votre message est conservé dans l’espace administratif.</p>
                        </div>
                    </article>
                    <article>
                        <span>02</span>
                        <div>
                            <strong>Contexte identifié</strong>
                            <p>Particulier, professionnel ou partenaire&nbsp;: le besoin est qualifié.</p>
                        </div>
                    </article>
                    <article>
                        <span>03</span>
                        <div>
                            <strong>Réponse personnalisée</strong>
                            <p>La maison revient vers vous selon les informations transmises.</p>
                        </div>
                    </article>
                </div>
            </aside>

            <div class="contact-form-panel">
                <form
                    class="contact-form"
                    data-contact-form
                    data-request-url="{{ route('contact.store') }}"
                    novalidate
                >
                    @csrf

                    <div class="contact-form-heading">
                        <span>Formulaire de contact</span>
                        <h3>Commençons par votre profil.</h3>
                    </div>

                    <fieldset class="contact-audience-fieldset">
                        <legend>Vous êtes *</legend>
                        <div class="contact-audience-grid">
                            <label>
                                <input type="radio" name="audience" value="particulier" checked>
                                <span>
                                    <strong>Particulier</strong>
                                    <small>Boutique & conseils</small>
                                </span>
                            </label>
                            <label>
                                <input type="radio" name="audience" value="professionnel">
                                <span>
                                    <strong>Professionnel</strong>
                                    <small>Pièces & volumes</small>
                                </span>
                            </label>
                            <label>
                                <input type="radio" name="audience" value="partenaire">
                                <span>
                                    <strong>Partenaire</strong>
                                    <small>Projet & collaboration</small>
                                </span>
                            </label>
                        </div>
                    </fieldset>

                    <div class="contact-field-grid">
                        <label>
                            <span>Nom complet *</span>
                            <input type="text" name="fullname" required maxlength="190" autocomplete="name" placeholder="Votre nom et prénom">
                        </label>

                        <label>
                            <span>Adresse email *</span>
                            <input type="email" name="email" required maxlength="190" autocomplete="email" placeholder="vous@exemple.fr">
                        </label>

                        <label>
                            <span>Téléphone</span>
                            <input type="tel" name="phone" maxlength="40" autocomplete="tel" placeholder="06 00 00 00 00">
                        </label>

                        <label>
                            <span>Ville</span>
                            <input type="text" name="city" maxlength="120" autocomplete="address-level2" placeholder="Votre ville">
                        </label>

                        <label class="contact-full" data-company-field>
                            <span>Établissement ou société</span>
                            <input type="text" name="company" maxlength="190" autocomplete="organization" placeholder="Nom de votre établissement, si applicable">
                        </label>

                        <label class="contact-full">
                            <span>Motif de la demande *</span>
                            <select name="subject" required>
                                <option value="">Sélectionner un motif</option>
                                <option value="Question boutique ou produit">Question boutique ou produit</option>
                                <option value="Suivi d’une demande boutique">Suivi d’une demande boutique</option>
                                <option value="Demande professionnelle">Demande professionnelle</option>
                                <option value="Réserve professionnelle">Réserve professionnelle</option>
                                <option value="Découpe et volumes">Découpe et volumes</option>
                                <option value="Traçabilité et informations produit">Traçabilité et informations produit</option>
                                <option value="Collaboration ou partenariat">Collaboration ou partenariat</option>
                                <option value="Autre demande">Autre demande</option>
                            </select>
                        </label>

                        <label class="contact-full">
                            <span>Votre message *</span>
                            <textarea
                                name="message"
                                rows="7"
                                required
                                minlength="10"
                                maxlength="5000"
                                placeholder="Décrivez votre demande, les pièces recherchées, les quantités éventuelles et votre échéance..."
                            ></textarea>
                            <small class="contact-character-note">10 caractères minimum</small>
                        </label>
                    </div>

                    <fieldset class="contact-preference-fieldset">
                        <legend>Moyen de contact préféré *</legend>
                        <div>
                            <label>
                                <input type="radio" name="preferred_contact" value="email" checked>
                                <span>Email</span>
                            </label>
                            <label>
                                <input type="radio" name="preferred_contact" value="telephone">
                                <span>Téléphone</span>
                            </label>
                        </div>
                    </fieldset>

                    <label class="contact-privacy">
                        <input type="checkbox" name="privacy" value="1" required>
                        <span>
                            J’accepte que mes informations soient utilisées pour répondre à ma demande,
                            conformément à la <a href="{{ route('confidentialite') }}">politique de confidentialité</a>.
                        </span>
                    </label>

                    <div class="contact-form-errors is-hidden" data-contact-errors role="alert"></div>

                    <button type="submit" class="contact-submit-button">
                        <span>Transmettre ma demande</span>
                        <b aria-hidden="true">→</b>
                    </button>

                    <p class="contact-form-note">
                        L’envoi de ce formulaire ne confirme ni une disponibilité produit, ni une commande,
                        ni une pré-réservation. La maison vous répond après étude de votre demande.
                    </p>
                </form>

                <div class="contact-confirmation is-hidden" data-contact-confirmation aria-live="polite">
                    <span class="contact-confirmation-mark">✓</span>
                    <p class="contact-kicker">Message transmis</p>
                    <h3>Merci, votre demande est bien enregistrée.</h3>
                    <p>
                        Wagyu France dispose maintenant des informations nécessaires pour étudier votre message.
                        Conservez votre référence pour tout échange ultérieur.
                    </p>
                    <div class="contact-reference-card">
                        <span>Votre référence</span>
                        <strong data-contact-reference>WF-CONTACT</strong>
                    </div>
                    <button type="button" data-contact-reset>Envoyer un autre message</button>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-followup" id="suivi">
        <div class="contact-shell contact-followup-grid">
            <div class="contact-followup-copy">
                <p class="contact-kicker">Après l’envoi</p>
                <h2>Une demande suivie, pas un message perdu dans une boîte générique.</h2>
                <p>
                    Votre message est enregistré avec une référence et un statut. La maison peut ainsi
                    distinguer une nouvelle demande, un échange en cours et un dossier déjà traité.
                </p>
            </div>

            <div class="contact-followup-steps">
                <article>
                    <span>01</span>
                    <div>
                        <strong>Réception</strong>
                        <p>Le formulaire contrôle les informations essentielles avant l’envoi.</p>
                    </div>
                </article>
                <article>
                    <span>02</span>
                    <div>
                        <strong>Qualification</strong>
                        <p>Le profil, le motif et le contexte permettent d’orienter la demande.</p>
                    </div>
                </article>
                <article>
                    <span>03</span>
                    <div>
                        <strong>Traitement</strong>
                        <p>La demande est consultable et suivie depuis l’administration Wagyu France.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-section contact-faq" id="questions">
        <div class="contact-shell">
            <header class="contact-section-heading">
                <div>
                    <p class="contact-kicker">Avant de nous écrire</p>
                    <h2>Les réponses aux questions les plus fréquentes.</h2>
                </div>
                <p>
                    Ces repères vous permettent parfois de rejoindre directement le parcours le plus adapté.
                </p>
            </header>

            <div class="contact-faq-grid">
                <article>
                    <span>01</span>
                    <h3>Je souhaite commander pour moi-même.</h3>
                    <p>
                        Consultez d’abord la boutique afin d’identifier la pièce souhaitée. Le formulaire
                        reste disponible pour une question particulière ou un besoin de conseil.
                    </p>
                    <a href="{{ route('boutique') }}">Voir la boutique <b>→</b></a>
                </article>

                <article>
                    <span>02</span>
                    <h3>Je représente un établissement.</h3>
                    <p>
                        La réserve professionnelle permet de préparer une première sélection de pièces
                        et de volumes avant confirmation par la maison.
                    </p>
                    <a href="{{ route('reserve.pro') }}">Ouvrir la réserve <b>→</b></a>
                </article>

                <article>
                    <span>03</span>
                    <h3>Mon message confirme-t-il une commande&nbsp;?</h3>
                    <p>
                        Non. Le formulaire prépare l’échange. Les disponibilités, quantités, tarifs
                        et modalités sont toujours confirmés séparément par Wagyu France.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-quote">
        <div class="contact-shell contact-quote-inner">
            <span aria-hidden="true">“</span>
            <blockquote>
                Une relation de confiance commence par une demande comprise avec précision.
            </blockquote>
            <p>Wagyu France · Relation client</p>
        </div>
    </section>

@endsection

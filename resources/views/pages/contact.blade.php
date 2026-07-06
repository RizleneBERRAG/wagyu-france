@extends('layouts.app', [
    'title' => 'Contact — Wagyu France',
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
        <div class="contact-glow contact-glow-left"></div>
        <div class="contact-glow contact-glow-right"></div>

        <div class="contact-hero-inner">
            <div class="contact-hero-content">
                <p class="eyebrow">Contact</p>

                <h1>
                    Échanger avec
                    <span>Wagyu France.</span>
                </h1>

                <p>
                    Une question sur une pièce, une demande professionnelle, une disponibilité,
                    une pré-réservation ou une collaboration ? Laissez un message clair,
                    Wagyu France pourra revenir vers vous avec une réponse adaptée.
                </p>

                <div class="contact-hero-actions">
                    <a href="#contact-form" class="contact-primary-button">
                        Envoyer un message
                    </a>

                    <a href="{{ route('reserve.pro') }}" class="contact-secondary-button">
                        Réserve pro
                    </a>
                </div>
            </div>

            <div class="contact-hero-card">
                <span>Maison</span>

                <h2>Contact direct</h2>

                <p>
                    Un parcours simple pour les particuliers, chefs, restaurants,
                    boucheries et partenaires professionnels.
                </p>

                <div class="contact-card-tags">
                    <strong>Particulier</strong>
                    <strong>Professionnel</strong>
                    <strong>Partenariat</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-intro-section">
        <div class="contact-intro-card">
            <div>
                <p class="eyebrow">Avant d’écrire</p>

                <h2>
                    Choisissez le bon motif pour une réponse plus précise.
                </h2>
            </div>

            <div>
                <p>
                    Les demandes ne se ressemblent pas toutes : un particulier peut avoir besoin
                    d’un conseil de dégustation, tandis qu’un professionnel peut chercher un volume,
                    une pièce ou une pré-réservation.
                </p>

                <p>
                    Le formulaire permet d’orienter votre message afin que Wagyu France comprenne
                    rapidement votre besoin.
                </p>
            </div>
        </div>
    </section>

    <section class="contact-options-section">
        <div class="contact-section-heading">
            <p class="eyebrow">Motifs fréquents</p>

            <h2>
                À chaque besoin, son parcours.
            </h2>
        </div>

        <div class="contact-options-grid">
            <article>
                <span>01</span>
                <h3>Question boutique</h3>
                <p>
                    Choix d’une pièce, quantité, dégustation, conservation ou conseil de cuisson.
                </p>
            </article>

            <article>
                <span>02</span>
                <h3>Demande professionnelle</h3>
                <p>
                    Restaurant, chef, boucherie ou partenaire souhaitant échanger sur des volumes.
                </p>
            </article>

            <article>
                <span>03</span>
                <h3>Réserve pro</h3>
                <p>
                    Question liée à la pré-réservation, aux pièces disponibles ou à la découpe.
                </p>
            </article>

            <article>
                <span>04</span>
                <h3>Collaboration</h3>
                <p>
                    Presse, événement, partenariat, demande spécifique ou projet sur mesure.
                </p>
            </article>
        </div>
    </section>

    <section class="contact-form-section" id="contact-form">
        <div class="contact-form-card">
            <div class="contact-form-content">
                <p class="eyebrow">Votre message</p>

                <h2>
                    Dites-nous ce dont vous avez besoin.
                </h2>

                <p>
                    Remplissez le formulaire avec les informations utiles. Pour une demande pro,
                    pensez à préciser votre établissement, votre ville et les volumes recherchés.
                </p>

                <div class="contact-info-list">
                    <article>
                        <span>Réponse</span>
                        <strong>Selon disponibilité</strong>
                    </article>

                    <article>
                        <span>Demandes pro</span>
                        <strong>Volumes & pièces</strong>
                    </article>

                    <article>
                        <span>Boutique</span>
                        <strong>Conseils produit</strong>
                    </article>
                </div>
            </div>

            <form class="contact-form" data-contact-form>
                <div class="contact-field-grid">
                    <label>
                        <span>Nom complet *</span>
                        <input type="text" name="fullname" required placeholder="Votre nom">
                    </label>

                    <label>
                        <span>Email *</span>
                        <input type="email" name="email" required placeholder="votre@email.fr">
                    </label>

                    <label>
                        <span>Téléphone</span>
                        <input type="tel" name="phone" placeholder="06 00 00 00 00">
                    </label>

                    <label>
                        <span>Ville</span>
                        <input type="text" name="city" placeholder="Votre ville">
                    </label>

                    <label class="contact-full">
                        <span>Motif *</span>
                        <select name="subject" required>
                            <option value="">Choisir un motif</option>
                            <option value="Boutique particulier">Boutique particulier</option>
                            <option value="Demande professionnelle">Demande professionnelle</option>
                            <option value="Réserve professionnelle">Réserve professionnelle</option>
                            <option value="Découpe & volumes">Découpe & volumes</option>
                            <option value="Collaboration / partenariat">Collaboration / partenariat</option>
                            <option value="Autre demande">Autre demande</option>
                        </select>
                    </label>

                    <label class="contact-full">
                        <span>Message *</span>
                        <textarea name="message" rows="6" required placeholder="Expliquez votre demande..."></textarea>
                    </label>
                </div>

                <button type="submit">
                    Envoyer le message
                </button>

                <p class="contact-form-note">
                    Maquette front : à l’étape suivante, on branchera ce formulaire à Laravel
                    pour enregistrer les messages dans l’admin.
                </p>
            </form>

            <div class="contact-confirmation is-hidden" data-contact-confirmation>
                <span>✓</span>

                <h3>Message prêt</h3>

                <p>
                    Votre message est prêt à être envoyé. La prochaine étape sera de le connecter
                    à Laravel pour l’enregistrer réellement dans l’espace admin.
                </p>

                <button type="button" data-contact-reset>
                    Envoyer un autre message
                </button>
            </div>
        </div>
    </section>

    <section class="contact-dual-section">
        <div class="contact-dual-card">
            <div>
                <p class="eyebrow">Deux univers</p>

                <h2>
                    Particulier ou professionnel, le bon accès au bon endroit.
                </h2>

                <p>
                    Pour commander une pièce ou préparer une dégustation, la boutique particulier
                    reste le parcours le plus simple. Pour réserver des volumes avant découpe,
                    l’espace professionnel est plus adapté.
                </p>
            </div>

            <div class="contact-dual-grid">
                <article>
                    <span>Particulier</span>
                    <h3>Boutique</h3>
                    <p>
                        Découvrir les pièces, préparer une dégustation et envoyer une demande.
                    </p>

                    <a href="{{ route('boutique') }}">
                        Voir la boutique
                    </a>
                </article>

                <article>
                    <span>Professionnel</span>
                    <h3>Réserve pro</h3>
                    <p>
                        Pré-réserver les pièces, suivre les volumes et organiser la demande.
                    </p>

                    <a href="{{ route('reserve.pro') }}">
                        Accéder à la réserve
                    </a>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-faq-section">
        <div class="contact-section-heading">
            <p class="eyebrow">Questions rapides</p>

            <h2>
                Quelques repères avant de nous contacter.
            </h2>
        </div>

        <div class="contact-faq-grid">
            <article>
                <h3>Je suis particulier, où commander ?</h3>
                <p>
                    Le parcours le plus adapté est la boutique. Vous pouvez y sélectionner
                    une pièce et transmettre une demande de commande.
                </p>
            </article>

            <article>
                <h3>Je suis professionnel, où réserver ?</h3>
                <p>
                    L’espace réserve pro permet de sélectionner les pièces directement
                    sur l’animal et d’indiquer les quantités souhaitées.
                </p>
            </article>

            <article>
                <h3>Les demandes sont-elles confirmées automatiquement ?</h3>
                <p>
                    Non. Les demandes permettent de préparer l’échange. Wagyu France confirme
                    ensuite les disponibilités, quantités et modalités.
                </p>
            </article>
        </div>
    </section>

    <section class="contact-cta-section">
        <div class="contact-cta-card">
            <p class="eyebrow">Wagyu France</p>

            <h2>
                Une question mérite une réponse précise.
            </h2>

            <p>
                Contactez Wagyu France ou accédez directement au parcours qui correspond
                à votre besoin.
            </p>

            <div>
                <a href="#contact-form" class="contact-primary-button">
                    Écrire un message
                </a>

                <a href="{{ route('professionnels') }}" class="contact-secondary-button">
                    Univers professionnel
                </a>
            </div>
        </div>
    </section>

@endsection

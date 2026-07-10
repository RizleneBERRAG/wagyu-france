@extends('layouts.app', [
    'title' => 'Réserve professionnelle Wagyu — Wagyu France',
    'description' => 'Constituez une demande professionnelle de Wagyu français en sélectionnant les pièces et les volumes souhaités avant confirmation par Wagyu France.',
    'bodyClass' => 'reserve-pro-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/reserve-pro.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/reserve-pro.js') }}" defer></script>
@endpush

@section('content')

    <section class="reserve-hero">
        <div class="reserve-shell reserve-hero-grid">
            <div class="reserve-hero-copy">
                <p class="reserve-kicker">Wagyu France · Réserve professionnelle</p>

                <h1>
                    Sélectionnez vos pièces,
                    <em>avant la découpe.</em>
                </h1>

                <p class="reserve-hero-lead">
                    Un espace dédié aux chefs, restaurateurs, bouchers et traiteurs pour exprimer
                    précisément leurs besoins en pièces et en volumes. Chaque demande est ensuite
                    étudiée et confirmée par Wagyu France.
                </p>

                <div class="reserve-hero-actions">
                    <a href="#selection" class="reserve-button-link reserve-button-primary">
                        Commencer la sélection
                    </a>
                    <a href="{{ route('professionnels') }}" class="reserve-button-link reserve-button-secondary">
                        Retour à l’espace pro
                    </a>
                </div>

                <dl class="reserve-hero-facts">
                    <div>
                        <dt>Référence</dt>
                        <dd>WF-2026-01</dd>
                    </div>
                    <div>
                        <dt>Demande</dt>
                        <dd>Pré-réservation sans paiement</dd>
                    </div>
                    <div>
                        <dt>Validation</dt>
                        <dd>Confirmation par la maison</dd>
                    </div>
                </dl>
            </div>

            <figure class="reserve-hero-visual">
                <img
                    src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}"
                    alt="Sélection professionnelle de pièces de Wagyu"
                >

                <figcaption>
                    <span>Réserve en cours</span>
                    <strong>Une sélection construite pièce par pièce, selon votre usage.</strong>
                </figcaption>

                <div class="reserve-hero-seal" aria-hidden="true">
                    <span>WF</span>
                    <small>Réserve pro</small>
                </div>
            </figure>
        </div>
    </section>

    <section class="reserve-status" aria-label="État de la réserve">
        <div class="reserve-shell reserve-status-grid">
            <div class="reserve-status-reference">
                <span>Dossier actif</span>
                <strong>WF-2026-01</strong>
            </div>

            <div class="reserve-status-progress">
                <div>
                    <span>Niveau indicatif de réservation</span>
                    <strong>68 %</strong>
                </div>
                <i><b style="width: 68%"></b></i>
            </div>

            <div class="reserve-status-note">
                <span>Statut</span>
                <strong>Demandes ouvertes</strong>
            </div>

            <button class="pro-cart-top-button" type="button" data-cart-open>
                <span>Ma sélection</span>
                <strong data-cart-count>0</strong>
            </button>
        </div>
    </section>

    <section class="reserve-workspace" id="selection">
        <div class="reserve-shell">
            <header class="reserve-workspace-heading">
                <div>
                    <p class="reserve-kicker">Carte de sélection</p>
                    <h2>Choisissez une zone sur l’animal.</h2>
                </div>

                <p>
                    Cliquez sur une étiquette ou directement sur la silhouette. Les informations
                    de disponibilité et de prix HT s’actualisent sous la carte.
                </p>
            </header>

            <div class="reserve-main-card" id="animal-reservation">
                <div class="reserve-card-top">
                    <div>
                        <span class="reserve-card-index">Plan de découpe · 01</span>
                        <strong>Animal de référence</strong>
                    </div>

                    <div class="reserve-card-legend">
                        <span><i></i> Zone sélectionnable</span>
                        <span><i></i> Pièce active</span>
                    </div>

                    <a href="{{ route('contact') }}" class="pro-access-button">
                        Besoin d’un conseil&nbsp;? <span>→</span>
                    </a>
                </div>

                <div class="luxury-animal-area" data-selected-cut="paleron">
                    <div class="exception-card">
                        <span class="exception-index">Note de sélection</span>
                        <h3>Une lecture globale de l’animal</h3>
                        <p>
                            Les pièces nobles, les morceaux de caractère et les cuissons longues
                            sont présentés ensemble afin de construire une demande cohérente.
                        </p>
                    </div>

                    <div class="animal-stage" data-animal-stage>
                        <img
                            class="animal-image animal-dark"
                            src="{{ asset('assets/images/reserve/wagyu-cow-dark-clean.png') }}"
                            alt="Bovin Wagyu noir - réserve professionnelle"
                        >

                        <img
                            class="animal-image animal-light"
                            src="{{ asset('assets/images/reserve/wagyu-cow-light-clean.png') }}"
                            alt="Bovin Wagyu clair - réserve professionnelle"
                        >

                        <button class="cut-hit" type="button" data-cut="paleron" aria-label="Sélectionner le paleron"></button>
                        <button class="cut-hit" type="button" data-cut="entrecote" aria-label="Sélectionner l’entrecôte"></button>
                        <button class="cut-hit" type="button" data-cut="fauxfilet" aria-label="Sélectionner le faux-filet"></button>
                        <button class="cut-hit" type="button" data-cut="rumsteak" aria-label="Sélectionner le rumsteak"></button>
                        <button class="cut-hit" type="button" data-cut="filet" aria-label="Sélectionner le filet"></button>
                        <button class="cut-hit" type="button" data-cut="macreuse" aria-label="Sélectionner la macreuse"></button>
                        <button class="cut-hit" type="button" data-cut="jarret" aria-label="Sélectionner le jarret"></button>

                        <span class="cut-frame" data-cut="paleron"></span>
                        <span class="cut-frame" data-cut="entrecote"></span>
                        <span class="cut-frame" data-cut="fauxfilet"></span>
                        <span class="cut-frame" data-cut="rumsteak"></span>
                        <span class="cut-frame" data-cut="filet"></span>
                        <span class="cut-frame" data-cut="macreuse"></span>
                        <span class="cut-frame" data-cut="jarret"></span>

                        <span class="cut-line" data-cut="paleron"></span>
                        <span class="cut-line" data-cut="entrecote"></span>
                        <span class="cut-line" data-cut="fauxfilet"></span>
                        <span class="cut-line" data-cut="rumsteak"></span>
                        <span class="cut-line" data-cut="filet"></span>
                        <span class="cut-line" data-cut="macreuse"></span>
                        <span class="cut-line" data-cut="jarret"></span>

                        <span class="cut-dot" data-cut="paleron"></span>
                        <span class="cut-dot" data-cut="entrecote"></span>
                        <span class="cut-dot" data-cut="fauxfilet"></span>
                        <span class="cut-dot" data-cut="rumsteak"></span>
                        <span class="cut-dot" data-cut="filet"></span>
                        <span class="cut-dot" data-cut="macreuse"></span>
                        <span class="cut-dot" data-cut="jarret"></span>

                        <button class="cut-tag" type="button" data-cut="paleron"><span>Paleron</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="entrecote"><span>Entrecôte</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="fauxfilet"><span>Faux-filet</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="rumsteak"><span>Rumsteak</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="filet"><span>Filet</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="macreuse"><span>Macreuse</span><i>+</i></button>
                        <button class="cut-tag" type="button" data-cut="jarret"><span>Jarret</span><i>+</i></button>
                    </div>
                </div>

                <div class="reserve-mobile-cuts" aria-label="Sélection des pièces sur mobile">
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="paleron"><span>Paleron</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="entrecote"><span>Entrecôte</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="fauxfilet"><span>Faux-filet</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="rumsteak"><span>Rumsteak</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="filet"><span>Filet</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="macreuse"><span>Macreuse</span><i>+</i></button>
                    <button class="cut-tag reserve-mobile-cut" type="button" data-cut="jarret"><span>Jarret</span><i>+</i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="cut-reservation-section">
        <div class="reserve-shell cut-detail-luxury">
            <div class="cut-detail-left">
                <p class="reserve-kicker">Pièce sélectionnée</p>
                <span class="cut-detail-reference">Sélection professionnelle · WF</span>

                <h2 data-cut-name>Paleron Wagyu</h2>

                <p data-cut-description>
                    Pièce riche et savoureuse, idéale pour cuisson lente, effiloché premium ou carte bistronomique.
                </p>

                <div class="cut-stats">
                    <div>
                        <span>Prix professionnel</span>
                        <strong data-cut-price>143 €/kg</strong>
                        <small>Hors taxes</small>
                    </div>
                    <div>
                        <span>Volume indicatif</span>
                        <strong data-cut-stock>5,8 kg</strong>
                        <small>Sous réserve de confirmation</small>
                    </div>
                    <div>
                        <span>Déjà demandé</span>
                        <strong data-cut-reserved>33%</strong>
                        <small>Niveau indicatif</small>
                    </div>
                    <div>
                        <span>Demande minimale</span>
                        <strong data-cut-min>2 kg</strong>
                        <small>Par pièce sélectionnée</small>
                    </div>
                </div>
            </div>

            <div class="cut-detail-right">
                <span class="cut-order-index">Votre demande · 01</span>

                <div class="piece-progress">
                    <div class="piece-progress-top">
                        <span>Niveau de réservation de cette pièce</span>
                        <strong data-cut-percent-label>33%</strong>
                    </div>
                    <div class="piece-progress-line">
                        <span data-cut-percent-bar style="width: 33%"></span>
                    </div>
                </div>

                <div class="quantity-box">
                    <label for="reserveQuantity">Quantité souhaitée en kilogrammes</label>
                    <div>
                        <button type="button" data-quantity-minus aria-label="Réduire la quantité">−</button>
                        <input id="reserveQuantity" type="number" min="1" value="1" data-quantity-input>
                        <button type="button" data-quantity-plus aria-label="Augmenter la quantité">+</button>
                    </div>
                </div>

                <button class="reserve-button" type="button" data-reserve-button>
                    Ajouter à ma sélection
                </button>

                <button class="quote-button" type="button" data-cart-open>
                    Consulter ma demande
                </button>

                <p class="reserve-feedback" data-reserve-feedback aria-live="polite"></p>

                <p class="cut-order-note">
                    Aucun paiement n’est demandé à cette étape. Les volumes, le prix et la livraison
                    sont confirmés par Wagyu France après étude de votre demande.
                </p>
            </div>
        </div>
    </section>

    <section class="pro-flow-section">
        <div class="reserve-shell">
            <header class="section-heading">
                <div>
                    <p class="reserve-kicker">Après votre sélection</p>
                    <h2>Une demande étudiée, puis confirmée avec précision.</h2>
                </div>
                <p>
                    La réserve facilite l’expression du besoin. Elle ne remplace pas l’échange avec
                    la maison : chaque dossier est vérifié selon les pièces et les volumes disponibles.
                </p>
            </header>

            <div class="pro-flow-grid">
                <article>
                    <span>01</span>
                    <h3>Vous sélectionnez</h3>
                    <p>Choisissez les pièces et indiquez les quantités utiles à votre activité.</p>
                </article>
                <article>
                    <span>02</span>
                    <h3>Vous précisez</h3>
                    <p>Renseignez votre établissement, votre localisation et vos échéances.</p>
                </article>
                <article>
                    <span>03</span>
                    <h3>Nous vérifions</h3>
                    <p>Les disponibilités et la cohérence de la demande sont étudiées par la maison.</p>
                </article>
                <article>
                    <span>04</span>
                    <h3>Nous confirmons</h3>
                    <p>Vous recevez une réponse précise sur les volumes, le montant et la livraison.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="reserve-help">
        <div class="reserve-shell reserve-help-card">
            <div>
                <p class="reserve-kicker">Besoin d’une sélection sur mesure&nbsp;?</p>
                <h2>Parlons de votre carte et de vos contraintes de service.</h2>
            </div>
            <a href="{{ route('contact') }}" class="reserve-button-link reserve-button-light">
                Contacter la maison
            </a>
        </div>
    </section>

    <button class="pro-cart-floating" type="button" data-cart-open aria-label="Ouvrir la sélection professionnelle">
        <span>Ma sélection</span>
        <strong data-cart-count>0</strong>
    </button>

    <div class="pro-cart-overlay" data-cart-overlay></div>

    <aside class="pro-cart-drawer" data-cart-drawer aria-hidden="true">
        <div class="pro-cart-head">
            <div>
                <p class="reserve-kicker">Réserve professionnelle</p>
                <h2>Ma sélection</h2>
            </div>
            <button class="pro-cart-close" type="button" data-cart-close aria-label="Fermer la sélection">×</button>
        </div>

        <div class="pro-cart-body">
            <div class="pro-cart-empty" data-cart-empty>
                <span>WF</span>
                <h3>Votre sélection est vide</h3>
                <p>
                    Choisissez une pièce sur l’animal, indiquez la quantité souhaitée,
                    puis ajoutez-la à votre demande.
                </p>
            </div>

            <div class="pro-cart-items" data-cart-items></div>

            <form
                class="pro-checkout-form is-hidden"
                data-checkout-form
                data-request-url="{{ route('reserve-pro.request.store') }}"
            >
                @csrf

                <div class="checkout-intro">
                    <p class="reserve-kicker">Finalisation</p>
                    <h3>Votre établissement</h3>
                    <p>
                        Ces informations permettront à Wagyu France d’étudier votre demande
                        et de vous répondre avec les disponibilités réelles.
                    </p>
                </div>

                <div class="checkout-grid">
                    <label>
                        <span>Société *</span>
                        <input type="text" name="company" required placeholder="Nom de votre établissement">
                    </label>
                    <label>
                        <span>Nom complet *</span>
                        <input type="text" name="fullname" required placeholder="Votre nom">
                    </label>
                    <label>
                        <span>Email *</span>
                        <input type="email" name="email" required placeholder="contact@entreprise.fr">
                    </label>
                    <label>
                        <span>Téléphone *</span>
                        <input type="tel" name="phone" required placeholder="06 00 00 00 00">
                    </label>
                    <label>
                        <span>Type de professionnel *</span>
                        <select name="professional_type" required>
                            <option value="">Sélectionner</option>
                            <option value="Restaurant">Restaurant</option>
                            <option value="Boucherie">Boucherie</option>
                            <option value="Traiteur">Traiteur</option>
                            <option value="Hôtel">Hôtel</option>
                            <option value="Grossiste">Grossiste</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </label>
                    <label>
                        <span>Ville de livraison</span>
                        <input type="text" name="city" placeholder="Ville / secteur">
                    </label>
                    <label class="checkout-full">
                        <span>Votre besoin</span>
                        <textarea name="message" rows="4" placeholder="Échéance, fréquence, préférences de découpe ou contraintes de livraison..."></textarea>
                    </label>
                </div>

                <div class="checkout-actions">
                    <button class="checkout-back-button" type="button" data-checkout-back>Retour à la sélection</button>
                    <button class="checkout-submit-button" type="submit">Transmettre ma demande</button>
                </div>
            </form>

            <div class="pro-cart-confirmation is-hidden" data-cart-confirmation>
                <span>✓</span>
                <h3>Demande enregistrée</h3>
                <p>
                    Votre demande de pré-réservation a bien été transmise. Wagyu France pourra
                    vous recontacter pour confirmer les quantités, le montant et la livraison.
                </p>
                <div class="confirmation-summary" data-confirmation-summary></div>
                <button type="button" data-cart-close>Fermer</button>
            </div>
        </div>

        <div class="pro-cart-summary">
            <div>
                <span>Total estimatif HT</span>
                <strong data-cart-total>0 €</strong>
            </div>
            <p>
                Estimation calculée à partir des quantités demandées. Le montant définitif
                sera confirmé avant toute validation.
            </p>
            <button class="cart-submit-button" type="button" data-cart-submit>Finaliser ma demande</button>
            <button class="cart-clear-button" type="button" data-cart-clear>Vider la sélection</button>
        </div>
    </aside>

@endsection
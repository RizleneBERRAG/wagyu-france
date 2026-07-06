@extends('layouts.app', [
    'title' => 'Réserve Professionnelle — Wagyu France',
    'bodyClass' => 'reserve-pro-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/reserve-pro.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/reserve-pro.js') }}" defer></script>
@endpush

@section('content')

    <section class="reserve-luxury-hero">

        <div class="reserve-deco">
            <span></span>
            <img src="{{ asset('assets/images/logo/wagyufrance-logo.png') }}" alt="Wagyu France">
            <span></span>
        </div>

        <div class="reserve-title-block">
            <p class="eyebrow">Interface professionnelle</p>

            <h1>
                Réserve
                <span>Professionnelle</span>
            </h1>

            <p>
                L’excellence du Wagyu, sélectionnée pour les professionnels exigeants.
            </p>
        </div>

        <div class="reserve-main-card" id="animal-reservation">
            <div class="reserve-card-glow reserve-glow-left"></div>
            <div class="reserve-card-glow reserve-glow-right"></div>

            <div class="reserve-card-top">
                <div>
                    <p class="eyebrow">Bovin sélectionné</p>
                    <h2>WF-2026-01</h2>
                </div>

                <div class="reserve-progress-mini">
                    <strong>68%</strong>
                    <span>réservé</span>

                    <div>
                        <i style="width: 68%"></i>
                    </div>
                </div>

                <button class="pro-cart-top-button" type="button" data-cart-open>
                    <span>Panier pro</span>
                    <strong data-cart-count>0</strong>
                </button>

                <a href="{{ route('contact') }}" class="pro-access-button">
                    Demander un accès pro
                </a>
            </div>

            <div class="luxury-animal-area" data-selected-cut="paleron">

                <div class="exception-card">
                    <span class="exception-icon">✦</span>

                    <h3>Sélection d’exception</h3>

                    <p>
                        Traçabilité complète, maturation optimale et qualité irréprochable
                        pour sublimer chaque création.
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

                    <button class="cut-tag" type="button" data-cut="paleron">
                        <span>Paleron</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="entrecote">
                        <span>Entrecôte</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="fauxfilet">
                        <span>Faux-filet</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="rumsteak">
                        <span>Rumsteak</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="filet">
                        <span>Filet</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="macreuse">
                        <span>Macreuse</span>
                        <i>+</i>
                    </button>

                    <button class="cut-tag" type="button" data-cut="jarret">
                        <span>Jarret</span>
                        <i>+</i>
                    </button>

                </div>
            </div>
        </div>
    </section>

    <section class="cut-reservation-section">
        <div class="cut-detail-luxury">

            <div class="cut-detail-left">
                <p class="eyebrow">Pièce sélectionnée</p>

                <h2 data-cut-name>Paleron Wagyu</h2>

                <p data-cut-description>
                    Pièce riche et savoureuse, idéale pour cuisson lente, effiloché premium ou carte bistronomique.
                </p>

                <div class="cut-stats">
                    <div>
                        <span>Prix pro HT</span>
                        <strong data-cut-price>143 €/kg</strong>
                    </div>

                    <div>
                        <span>Disponible</span>
                        <strong data-cut-stock>5,8 kg</strong>
                    </div>

                    <div>
                        <span>Réservé</span>
                        <strong data-cut-reserved>33%</strong>
                    </div>

                    <div>
                        <span>Commande min.</span>
                        <strong data-cut-min>2 kg</strong>
                    </div>
                </div>
            </div>

            <div class="cut-detail-right">
                <div class="piece-progress">
                    <div class="piece-progress-top">
                        <span>Taux de réservation</span>
                        <strong data-cut-percent-label>33%</strong>
                    </div>

                    <div class="piece-progress-line">
                        <span data-cut-percent-bar style="width: 33%"></span>
                    </div>
                </div>

                <div class="quantity-box">
                    <label for="reserveQuantity">Quantité souhaitée</label>

                    <div>
                        <button type="button" data-quantity-minus>-</button>
                        <input id="reserveQuantity" type="number" min="1" value="1" data-quantity-input>
                        <button type="button" data-quantity-plus>+</button>
                    </div>
                </div>

                <button class="reserve-button" type="button" data-reserve-button>
                    Ajouter à ma pré-réservation
                </button>

                <button class="quote-button" type="button" data-cart-open>
                    Voir mon panier pro
                </button>

                <p class="reserve-feedback" data-reserve-feedback></p>
            </div>

        </div>
    </section>

    <section class="pro-flow-section">
        <div class="section-heading">
            <p class="eyebrow">Parcours professionnel</p>

            <h2>
                Une découpe confirmée uniquement quand l’objectif est atteint.
            </h2>

            <p>
                L’interface permet de sécuriser les volumes avant mise en découpe,
                de limiter les pertes et de valoriser chaque pièce auprès des bons clients.
            </p>
        </div>

        <div class="pro-flow-grid">
            <article>
                <span>01</span>
                <h3>Accès validé</h3>
                <p>Le restaurateur, chef ou boucher demande un accès professionnel.</p>
            </article>

            <article>
                <span>02</span>
                <h3>Sélection sur l’animal</h3>
                <p>Il choisit directement ses pièces depuis la carte interactive.</p>
            </article>

            <article>
                <span>03</span>
                <h3>Pré-réservation</h3>
                <p>Les quantités sont bloquées avec devis, acompte ou validation manuelle.</p>
            </article>

            <article>
                <span>04</span>
                <h3>Mise en découpe</h3>
                <p>Quand le seuil est atteint, Wagyu France confirme la découpe et les livraisons.</p>
            </article>
        </div>
    </section>

    <button class="pro-cart-floating" type="button" data-cart-open aria-label="Ouvrir le panier professionnel">
        <span>Panier pro</span>
        <strong data-cart-count>0</strong>
    </button>

    <div class="pro-cart-overlay" data-cart-overlay></div>

    <aside class="pro-cart-drawer" data-cart-drawer aria-hidden="true">
        <div class="pro-cart-head">
            <div>
                <p class="eyebrow">Pré-réservation</p>
                <h2>Panier professionnel</h2>
            </div>

            <button class="pro-cart-close" type="button" data-cart-close aria-label="Fermer le panier">
                ×
            </button>
        </div>

        <div class="pro-cart-body">
            <div class="pro-cart-empty" data-cart-empty>
                <span>✦</span>
                <h3>Aucune pièce sélectionnée</h3>
                <p>
                    Choisissez un morceau sur l’animal, indiquez une quantité,
                    puis ajoutez-le à votre pré-réservation.
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
                    <p class="eyebrow">Finalisation</p>
                    <h3>Vos informations professionnelles</h3>
                    <p>
                        Ces informations permettront à Wagyu France de confirmer la disponibilité,
                        les quantités et les modalités de livraison.
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
                        <span>Message</span>
                        <textarea name="message" rows="4" placeholder="Précisez vos besoins, délais, préférences de livraison..."></textarea>
                    </label>
                </div>

                <div class="checkout-actions">
                    <button class="checkout-back-button" type="button" data-checkout-back>
                        Retour au panier
                    </button>

                    <button class="checkout-submit-button" type="submit">
                        Envoyer ma demande pro
                    </button>
                </div>
            </form>

            <div class="pro-cart-confirmation is-hidden" data-cart-confirmation>
                <span>✓</span>

                <h3>Demande enregistrée</h3>

                <p>
                    Votre demande de pré-réservation a bien été enregistrée.
                    Wagyu France pourra vous recontacter pour confirmer les quantités,
                    la disponibilité et les modalités de livraison.
                </p>

                <div class="confirmation-summary" data-confirmation-summary></div>

                <button type="button" data-cart-close>
                    Fermer
                </button>
            </div>
        </div>

        <div class="pro-cart-summary">
            <div>
                <span>Total estimatif HT</span>
                <strong data-cart-total>0 €</strong>
            </div>

            <p>
                Ce panier est une demande de pré-réservation. La disponibilité finale
                sera confirmée par Wagyu France avant validation.
            </p>

            <button class="cart-submit-button" type="button" data-cart-submit>
                Finaliser la demande pro
            </button>

            <button class="cart-clear-button" type="button" data-cart-clear>
                Vider le panier
            </button>
        </div>
    </aside>

@endsection

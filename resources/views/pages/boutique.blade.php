@extends('layouts.app', [
    'title' => 'Boutique — Wagyu France',
    'bodyClass' => 'boutique-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/boutique.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/boutique.js') }}" defer></script>
@endpush

@section('content')

    <section class="shop-hero">
        <div class="shop-glow shop-glow-left"></div>
        <div class="shop-glow shop-glow-right"></div>

        <div class="shop-hero-inner">
            <div class="shop-hero-content">
                <p class="eyebrow">Boutique particulier</p>

                <h1>
                    Choisir une pièce rare,
                    <span>pour une dégustation d’exception.</span>
                </h1>

                <p>
                    Une sélection pensée pour les amateurs qui veulent découvrir le Wagyu
                    dans sa forme la plus élégante : pièces nobles, morceaux de caractère
                    et formats adaptés à une dégustation premium.
                </p>

                <div class="shop-hero-actions">
                    <a href="#selection" class="shop-primary-button">
                        Voir la sélection
                    </a>

                    <a href="{{ route('wagyu') }}" class="shop-secondary-button">
                        Comprendre le Wagyu
                    </a>
                </div>
            </div>

            <div class="shop-hero-card">
                <img
                    src="{{ asset('assets/images/wagyu/marbrage-showcase.jpg') }}"
                    alt="Pièce de Wagyu marbrée Wagyu France"
                >

                <div class="shop-hero-card-content">
                    <span>Collection</span>

                    <h2>Wagyu France</h2>

                    <p>
                        Persillage, fondant, intensité et traçabilité dans une expérience
                        pensée pour la dégustation à domicile.
                    </p>

                    <div class="shop-hero-tags">
                        <strong>Pièces nobles</strong>
                        <strong>Découpe premium</strong>
                        <strong>Froid maîtrisé</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-intro-section">
        <div class="shop-intro-card">
            <div>
                <p class="eyebrow">Sélection maison</p>

                <h2>
                    Une boutique claire, premium et pensée pour bien choisir.
                </h2>
            </div>

            <div>
                <p>
                    Le Wagyu ne s’achète pas comme une viande classique. Chaque morceau
                    possède une intensité, une texture et un usage différent.
                </p>

                <p>
                    La boutique guide le choix entre pièces à saisir, morceaux à partager,
                    formats dégustation et sélections plus confidentielles.
                </p>
            </div>
        </div>
    </section>

    <section class="shop-products-section" id="selection">
        <div class="shop-section-heading">
            <p class="eyebrow">Produits</p>

            <h2>
                La sélection Wagyu France.
            </h2>

            <p>
                Les prix affichés sont indicatifs pour la maquette. Ils pourront ensuite être
                connectés à une vraie gestion produit Laravel.
            </p>
        </div>

        <div class="shop-toolbar">
            <div class="shop-filters" data-shop-filters>
                <button type="button" class="is-active" data-filter="all">Tout</button>
                <button type="button" data-filter="noble">Pièces nobles</button>
                <button type="button" data-filter="grill">À saisir</button>
                <button type="button" data-filter="caractere">Caractère</button>
                <button type="button" data-filter="lent">Cuisson lente</button>
            </div>

            <button type="button" class="shop-cart-button" data-shop-cart-open>
                <span>Panier</span>
                <strong data-shop-cart-count>0</strong>
            </button>
        </div>

        <div class="shop-product-grid" data-shop-grid>

            <article class="shop-product-card" data-category="noble grill" data-product-id="entrecote" data-name="Entrecôte Wagyu" data-price="174">
                <div class="shop-product-visual is-entrecote">
                    <img
                        src="{{ asset('assets/images/boutique/entrecote-wagyu.jpg') }}"
                        alt="Entrecôte Wagyu marbrée"
                    >
                    <span>Signature</span>
                </div>

                <div class="shop-product-content">
                    <p>Pièce noble</p>
                    <h3>Entrecôte Wagyu</h3>

                    <span>
                        Généreuse, persillée et intense. La pièce idéale pour découvrir
                        la puissance aromatique du Wagyu.
                    </span>

                    <div class="shop-product-meta">
                        <strong>174 €/kg</strong>
                        <small>À saisir</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

            <article class="shop-product-card" data-category="noble grill" data-product-id="filet" data-name="Filet Wagyu" data-price="198">
                <div class="shop-product-visual is-filet">
                    <img
                        src="{{ asset('assets/images/boutique/filet-wagyu.jpg') }}"
                        alt="Filet Wagyu premium"
                    >
                    <span>Rare</span>
                </div>

                <div class="shop-product-content">
                    <p>Grande tendreté</p>
                    <h3>Filet Wagyu</h3>

                    <span>
                        Une pièce délicate et très fondante, parfaite pour une dégustation
                        raffinée et précise.
                    </span>

                    <div class="shop-product-meta">
                        <strong>198 €/kg</strong>
                        <small>Pièce premium</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

            <article class="shop-product-card" data-category="noble grill" data-product-id="fauxfilet" data-name="Faux-filet Wagyu" data-price="174">
                <div class="shop-product-visual is-fauxfilet">
                    <img
                        src="{{ asset('assets/images/boutique/faux-filet-wagyu.jpg') }}"
                        alt="Faux-filet Wagyu marbré"
                    >
                    <span>Équilibre</span>
                </div>

                <div class="shop-product-content">
                    <p>Équilibre</p>
                    <h3>Faux-filet Wagyu</h3>

                    <span>
                        Une pièce équilibrée entre tendreté, persillage et tenue à la cuisson.
                    </span>

                    <div class="shop-product-meta">
                        <strong>174 €/kg</strong>
                        <small>À saisir</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

            <article class="shop-product-card" data-category="caractere grill" data-product-id="rumsteak" data-name="Rumsteak Wagyu" data-price="137">
                <div class="shop-product-visual is-rumsteak">
                    <img
                        src="{{ asset('assets/images/boutique/rumsteak-wagyu.jpg') }}"
                        alt="Rumsteak Wagyu de caractère"
                    >
                    <span>Caractère</span>
                </div>

                <div class="shop-product-content">
                    <p>Goût franc</p>
                    <h3>Rumsteak Wagyu</h3>

                    <span>
                        Un morceau plus direct, avec une belle mâche et une expression
                        marquée du produit.
                    </span>

                    <div class="shop-product-meta">
                        <strong>137 €/kg</strong>
                        <small>Caractère</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

            <article class="shop-product-card" data-category="lent caractere" data-product-id="paleron" data-name="Paleron Wagyu" data-price="143">
                <div class="shop-product-visual is-paleron">
                    <img
                        src="{{ asset('assets/images/boutique/paleron-wagyu.jpg') }}"
                        alt="Paleron Wagyu pour cuisson lente"
                    >
                    <span>Bistronomie</span>
                </div>

                <div class="shop-product-content">
                    <p>Cuisson lente</p>
                    <h3>Paleron Wagyu</h3>

                    <span>
                        Riche, savoureux et parfait pour une cuisson lente ou une préparation
                        gastronomique fondante.
                    </span>

                    <div class="shop-product-meta">
                        <strong>143 €/kg</strong>
                        <small>Cuisson lente</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

            <article class="shop-product-card" data-category="lent caractere" data-product-id="jarret" data-name="Jarret Wagyu" data-price="92">
                <div class="shop-product-visual is-jarret">
                    <img
                        src="{{ asset('assets/images/boutique/jarret-wagyu.jpg') }}"
                        alt="Jarret Wagyu pour préparation longue"
                    >
                    <span>Tradition</span>
                </div>

                <div class="shop-product-content">
                    <p>Préparation longue</p>
                    <h3>Jarret Wagyu</h3>

                    <span>
                        Idéal pour jus, bouillons, plats mijotés et recettes profondes
                        à cuisson lente.
                    </span>

                    <div class="shop-product-meta">
                        <strong>92 €/kg</strong>
                        <small>Mijoté</small>
                    </div>

                    <div class="shop-product-actions">
                        <div class="shop-qty">
                            <button type="button" data-product-minus>-</button>
                            <input type="number" min="1" value="1" data-product-qty>
                            <button type="button" data-product-plus>+</button>
                        </div>

                        <button type="button" class="shop-add-button" data-add-product>
                            Ajouter
                        </button>
                    </div>
                </div>
            </article>

        </div>
    </section>

    <section class="shop-experience-section">
        <div class="shop-experience-card">
            <div>
                <p class="eyebrow">Expérience particulier</p>

                <h2>
                    Une commande pensée comme une dégustation.
                </h2>

                <p>
                    Le parcours particulier doit rester simple, clair et élégant :
                    choisir une pièce, comprendre son usage, ajouter une quantité et préparer
                    une dégustation premium.
                </p>
            </div>

            <div class="shop-experience-list">
                <article>
                    <span>01</span>
                    <strong>Sélection</strong>
                    <small>Choisir une pièce selon le goût recherché.</small>
                </article>

                <article>
                    <span>02</span>
                    <strong>Quantité</strong>
                    <small>Adapter le format à la dégustation.</small>
                </article>

                <article>
                    <span>03</span>
                    <strong>Préparation</strong>
                    <small>Recevoir des conseils de cuisson simples.</small>
                </article>
            </div>
        </div>
    </section>

    <section class="shop-cta-section">
        <div class="shop-cta-card">
            <p class="eyebrow">Wagyu France</p>

            <h2>
                Le plaisir d’une pièce rare, choisie avec précision.
            </h2>

            <p>
                Explorez la sélection ou découvrez l’histoire de Wagyu France pour mieux
                comprendre l’origine de cette expérience.
            </p>

            <div>
                <a href="#selection" class="shop-primary-button">
                    Voir les produits
                </a>

                <a href="{{ route('histoire') }}" class="shop-secondary-button">
                    Notre histoire
                </a>
            </div>
        </div>
    </section>

    <button class="shop-floating-cart" type="button" data-shop-cart-open>
        <span>Panier</span>
        <strong data-shop-cart-count>0</strong>
    </button>

    <div class="shop-cart-overlay" data-shop-cart-overlay></div>

    <aside class="shop-cart-drawer" data-shop-cart-drawer aria-hidden="true">
        <div class="shop-cart-head">
            <div>
                <p class="eyebrow">Votre sélection</p>
                <h2>Panier particulier</h2>
            </div>

            <button type="button" data-shop-cart-close aria-label="Fermer le panier">
                ×
            </button>
        </div>

        <div class="shop-cart-body">
            <div class="shop-cart-empty" data-shop-cart-empty>
                <span>✦</span>
                <h3>Votre panier est vide</h3>
                <p>
                    Ajoutez une pièce de Wagyu à votre sélection pour préparer votre commande.
                </p>
            </div>

            <div class="shop-cart-items" data-shop-cart-items></div>

            <form
                class="shop-checkout-form is-hidden"
                data-shop-checkout-form
                data-order-url="{{ route('shop.order.store') }}"
            >
                @csrf

                <div class="shop-checkout-intro">
                    <p class="eyebrow">Finalisation</p>
                    <h3>Vos informations</h3>
                    <p>
                        Ces informations permettront de préparer votre demande de commande
                        et de vous recontacter pour confirmer la disponibilité.
                    </p>
                </div>

                <div class="shop-checkout-grid">
                    <label>
                        <span>Nom complet *</span>
                        <input type="text" name="fullname" required placeholder="Votre nom">
                    </label>

                    <label>
                        <span>Email *</span>
                        <input type="email" name="email" required placeholder="votre@email.fr">
                    </label>

                    <label>
                        <span>Téléphone *</span>
                        <input type="tel" name="phone" required placeholder="06 00 00 00 00">
                    </label>

                    <label>
                        <span>Ville *</span>
                        <input type="text" name="city" required placeholder="Votre ville">
                    </label>

                    <label class="shop-checkout-full">
                        <span>Message</span>
                        <textarea name="message" rows="4" placeholder="Précisez vos préférences, date souhaitée, questions..."></textarea>
                    </label>
                </div>

                <div class="shop-checkout-actions">
                    <button type="button" class="shop-checkout-back" data-shop-checkout-back>
                        Retour au panier
                    </button>

                    <button type="submit" class="shop-checkout-submit">
                        Valider ma demande
                    </button>
                </div>
            </form>

            <div class="shop-order-confirmation is-hidden" data-shop-confirmation>
                <span>✓</span>

                <h3>Demande enregistrée</h3>

                <p>
                    Votre demande de commande a bien été enregistrée.
                    Wagyu France pourra vous recontacter pour confirmer les disponibilités,
                    les quantités et les modalités de préparation.
                </p>

                <div class="shop-confirmation-summary" data-shop-confirmation-summary></div>

                <button type="button" data-shop-cart-close>
                    Fermer
                </button>
            </div>
        </div>

        <div class="shop-cart-summary">
            <div>
                <span>Total estimatif</span>
                <strong data-shop-cart-total>0 €</strong>
            </div>

            <p>
                Votre demande sera ensuite confirmée selon les disponibilités,
                les quantités et les modalités de préparation.
            </p>

            <button type="button" data-shop-checkout>
                Finaliser ma demande
            </button>

            <button type="button" data-shop-cart-clear>
                Vider le panier
            </button>
        </div>
    </aside>

@endsection

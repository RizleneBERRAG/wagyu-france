@extends('layouts.app', [
    'title' => 'Boutique Wagyu français — Wagyu France',
    'description' => 'Découvrez les pièces de Wagyu français proposées par Wagyu France : entrecôte, filet, faux-filet, rumsteak et morceaux à cuisson lente.',
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
        <div class="shop-shell shop-hero-grid">
            <div class="shop-hero-copy">
                <div class="shop-hero-edition" aria-hidden="true">
                    <span>Collection particulière</span>
                    <i></i>
                    <strong>{{ str_pad((string) max(1, $products->count()), 2, '0', STR_PAD_LEFT) }}</strong>
                </div>

                <p class="shop-kicker">La boutique Wagyu France</p>
                <h1>Des pièces choisies pour <em>une dégustation juste.</em></h1>
                <p class="shop-hero-text">
                    Entrecôte, filet, faux-filet ou morceaux à cuisson lente : choisissez votre pièce
                    selon son caractère, sa tendreté et la manière dont vous souhaitez la préparer.
                </p>

                <div class="shop-hero-actions">
                    <a href="#selection" class="shop-button shop-button-primary"><span>Découvrir les pièces</span></a>
                    <a href="{{ route('wagyu') }}" class="shop-button shop-button-secondary"><span>Bien choisir son Wagyu</span></a>
                </div>

                <dl class="shop-hero-facts">
                    <div><dt>Origine</dt><dd>Élevé en France</dd></div>
                    <div><dt>Préparation</dt><dd>Découpe soignée</dd></div>
                    <div><dt>Livraison</dt><dd>Chaîne du froid</dd></div>
                </dl>
            </div>

            <figure class="shop-hero-visual">
                <span class="shop-visual-index">Sélection de la maison · {{ date('Y') }}</span>
                <img src="{{ asset('assets/images/wagyu/marbrage-showcase.jpg') }}" alt="Pièce de Wagyu français finement persillée">
                <div class="shop-hero-seal" aria-hidden="true"><span>WF</span><small>Sélection</small></div>
                <figcaption><span>Le persillage Wagyu</span><strong>Fondant, équilibre et longueur en bouche.</strong></figcaption>
            </figure>
        </div>
    </section>

    <section class="shop-service-strip" aria-label="Engagements de la boutique">
        <div class="shop-shell shop-service-grid">
            <article><span>01</span><div><strong>Origine connue</strong><p>Un élevage français et une histoire identifiable.</p></div></article>
            <article><span>02</span><div><strong>Pièces sélectionnées</strong><p>Chaque morceau est présenté selon son véritable usage.</p></div></article>
            <article><span>03</span><div><strong>Froid maîtrisé</strong><p>Une préparation pensée pour préserver la viande.</p></div></article>
            <article><span>04</span><div><strong>Conseils inclus</strong><p>Quantité et cuisson expliquées simplement.</p></div></article>
        </div>
    </section>

    <section class="shop-products-section" id="selection">
        <div class="shop-shell">
            <header class="shop-products-heading">
                <div class="shop-heading-title">
                    <span class="shop-section-number">02</span>
                    <div><p class="shop-kicker">Notre sélection</p><h2>Choisissez votre <em>pièce.</em></h2></div>
                </div>
                <div class="shop-products-intro">
                    <span>Collection du domaine</span>
                    <p>Les prix sont indiqués au kilogramme. La disponibilité et le poids exact sont confirmés après votre demande.</p>
                </div>
            </header>

            <div class="shop-toolbar">
                <div class="shop-filters" data-shop-filters aria-label="Filtrer les produits">
                    <button type="button" class="is-active" data-filter="all">Toute la sélection</button>
                    <button type="button" data-filter="noble">Pièces nobles</button>
                    <button type="button" data-filter="grill">À saisir</button>
                    <button type="button" data-filter="caractere">De caractère</button>
                    <button type="button" data-filter="lent">Cuisson lente</button>
                </div>

                <button type="button" class="shop-cart-button" data-shop-cart-open>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l1.7 9.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20 7H6.1M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg>
                    <span>Voir mon panier</span>
                    <strong data-shop-cart-count>0</strong>
                </button>
            </div>

            <div class="shop-product-grid" data-shop-grid>
                @forelse ($products as $index => $product)
                    <article
                        class="shop-product-card"
                        data-category="{{ implode(' ', $product->categories ?? []) }}"
                        data-product-id="{{ $product->slug }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ (float) $product->price_per_kg }}"
                        data-stock="{{ (float) $product->stock_kg }}"
                    >
                        <div class="shop-product-visual">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            @if ($product->badge)<span>{{ $product->badge }}</span>@endif
                        </div>

                        <div class="shop-product-content">
                            <small class="shop-product-reference">{{ $product->reference ?: 'Pièce ' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</small>
                            <p class="shop-product-category">{{ $product->category_label ?: 'Sélection Wagyu France' }}</p>
                            <h3>{{ $product->name }}</h3>
                            <p class="shop-product-description">{{ $product->description }}</p>

                            <ul class="shop-product-details">
                                <li><span>Cuisson</span><strong>{{ $product->cooking ?: 'Selon la pièce' }}</strong></li>
                                <li><span>Caractère</span><strong>{{ $product->character ?: 'Équilibré' }}</strong></li>
                                <li><span>Disponibilité</span><strong>{{ number_format((float) $product->stock_kg, 1, ',', ' ') }} kg</strong></li>
                            </ul>

                            <div class="shop-product-purchase">
                                <div class="shop-product-price">
                                    <strong>{{ number_format((float) $product->price_per_kg, 0, ',', ' ') }} €</strong>
                                    <span>/ kg</span>
                                </div>

                                <div class="shop-product-actions">
                                    <div class="shop-qty" aria-label="Quantité en kilogrammes">
                                        <button type="button" data-product-minus aria-label="Réduire la quantité">−</button>
                                        <input
                                            type="number"
                                            min="{{ max(1, (int) ceil((float) $product->min_quantity_kg)) }}"
                                            max="{{ max(1, (int) floor((float) $product->stock_kg)) }}"
                                            value="{{ max(1, (int) ceil((float) $product->min_quantity_kg)) }}"
                                            data-product-qty
                                            aria-label="Quantité"
                                        >
                                        <button type="button" data-product-plus aria-label="Augmenter la quantité">+</button>
                                    </div>
                                    <button
                                        type="button"
                                        class="shop-add-button"
                                        data-add-product
                                        @disabled((float) $product->stock_kg < (float) $product->min_quantity_kg)
                                    >
                                        {{ (float) $product->stock_kg < (float) $product->min_quantity_kg ? 'Indisponible' : 'Ajouter' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="shop-empty-products">
                        <span>WF</span>
                        <h3>La sélection est momentanément indisponible.</h3>
                        <p>La maison prépare actuellement les prochaines pièces proposées à la commande.</p>
                        <a href="{{ route('contact') }}" class="shop-button shop-button-primary"><span>Contacter Wagyu France</span></a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="shop-guide-section">
        <div class="shop-shell shop-guide-grid">
            <div class="shop-guide-heading">
                <span class="shop-guide-label">Le conseil de la maison</span>
                <p class="shop-kicker">Bien choisir</p>
                <h2>Quelle quantité <em>prévoir&nbsp;?</em></h2>
                <p>Le Wagyu se déguste en portions mesurées. Son persillage permet une expérience généreuse sans quantité excessive.</p>
            </div>
            <div class="shop-guide-values">
                <article><span>01</span><strong>120 à 150 g</strong><small>par personne</small><p>Pour une dégustation ou un menu en plusieurs services.</p></article>
                <article><span>02</span><strong>180 à 220 g</strong><small>par personne</small><p>Pour faire de la pièce le cœur du repas.</p></article>
                <article><span>03</span><strong>2 à 4 min</strong><small>de repos</small><p>Après cuisson, pour laisser les jus se répartir.</p></article>
            </div>
        </div>
    </section>

    <section class="shop-reassurance-section">
        <div class="shop-shell">
            <header class="shop-reassurance-heading">
                <div class="shop-heading-title"><span class="shop-section-number">03</span><div><p class="shop-kicker">Votre commande</p><h2>Soignée jusqu’à <em>votre table.</em></h2></div></div>
            </header>
            <div class="shop-reassurance-grid">
                <article><span>01</span><strong>Vous sélectionnez</strong><p>La pièce et la quantité souhaitées sont ajoutées à votre demande.</p></article>
                <article><span>02</span><strong>Nous confirmons</strong><p>La disponibilité, le poids exact et le montant final sont vérifiés.</p></article>
                <article><span>03</span><strong>Nous préparons</strong><p>Votre commande est découpée et conditionnée avec attention.</p></article>
                <article><span>04</span><strong>Vous dégustez</strong><p>Nos recommandations vous accompagnent jusqu’à la cuisson.</p></article>
            </div>
        </div>
    </section>

    <section class="shop-contact-cta">
        <div class="shop-shell shop-contact-card">
            <span class="shop-contact-monogram" aria-hidden="true">WF</span>
            <div>
                <p class="shop-kicker">Une question sur une pièce&nbsp;?</p>
                <h2>Nous vous aidons <em>à choisir.</em></h2>
                <p>Nombre de convives, cuisson souhaitée ou morceau à privilégier : échangez avec Wagyu France.</p>
            </div>
            <a href="{{ route('contact') }}" class="shop-button shop-button-light"><span>Nous contacter</span></a>
        </div>
    </section>

    <button class="shop-floating-cart" type="button" data-shop-cart-open aria-label="Ouvrir le panier">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l1.7 9.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20 7H6.1M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg>
        <span>Panier</span><strong data-shop-cart-count>0</strong>
    </button>

    <div class="shop-cart-overlay" data-shop-cart-overlay></div>
    <aside class="shop-cart-drawer" data-shop-cart-drawer aria-hidden="true">
        <div class="shop-cart-head">
            <div><p class="shop-kicker">Votre sélection</p><h2>Mon panier</h2></div>
            <button type="button" data-shop-cart-close aria-label="Fermer le panier">×</button>
        </div>

        <div class="shop-cart-body">
            <div class="shop-cart-empty" data-shop-cart-empty><span>01</span><h3>Votre panier est vide</h3><p>Ajoutez une pièce à votre sélection pour préparer votre demande.</p></div>
            <div class="shop-cart-items" data-shop-cart-items></div>

            <form class="shop-checkout-form is-hidden" data-shop-checkout-form data-order-url="{{ route('shop.order.store') }}">
                @csrf
                <div class="shop-checkout-intro">
                    <p class="shop-kicker">Finalisation</p><h3>Vos coordonnées</h3>
                    <p>Nous vous recontacterons pour confirmer la disponibilité, le poids exact et les modalités de préparation.</p>
                </div>
                <div class="shop-checkout-grid">
                    <label><span>Nom complet *</span><input type="text" name="fullname" required placeholder="Votre nom"></label>
                    <label><span>Email *</span><input type="email" name="email" required placeholder="votre@email.fr"></label>
                    <label><span>Téléphone *</span><input type="tel" name="phone" required placeholder="06 00 00 00 00"></label>
                    <label><span>Ville *</span><input type="text" name="city" required placeholder="Votre ville"></label>
                    <label class="shop-checkout-full"><span>Message</span><textarea name="message" rows="4" placeholder="Date souhaitée, préférences ou questions..."></textarea></label>
                </div>
                <div class="shop-checkout-actions">
                    <button type="button" class="shop-checkout-back" data-shop-checkout-back>Retour</button>
                    <button type="submit" class="shop-checkout-submit">Valider ma demande</button>
                </div>
            </form>

            <div class="shop-order-confirmation is-hidden" data-shop-confirmation>
                <span>✓</span><h3>Demande enregistrée</h3>
                <p>Votre sélection a bien été transmise. Wagyu France vous recontactera pour confirmer les disponibilités.</p>
                <div class="shop-confirmation-summary" data-shop-confirmation-summary></div>
                <button type="button" data-shop-cart-close>Fermer</button>
            </div>
        </div>

        <div class="shop-cart-summary">
            <div><span>Total estimatif</span><strong data-shop-cart-total>0 €</strong></div>
            <p>Le poids et le montant définitifs seront confirmés avant préparation.</p>
            <button type="button" class="shop-cart-checkout" data-shop-checkout>Finaliser ma demande</button>
            <button type="button" class="shop-cart-clear" data-shop-cart-clear>Vider le panier</button>
        </div>
    </aside>
@endsection

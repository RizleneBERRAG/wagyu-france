@php
    $batch = $activeBatch;
    $summary = $reserveSummary;
    $progress = $summary['progress'] ?? 0;
    $activeCuts = $batch?->cuts?->where('is_active', true) ?? collect();
    $firstCut = $activeCuts->first();
    $firstCutData = $firstCut ? ($reserveCuts[$firstCut->slug] ?? null) : null;
@endphp

@extends('layouts.app', [
    'title' => 'Réserve professionnelle Wagyu — Wagyu France',
    'description' => 'Constituez une demande professionnelle de Wagyu français en sélectionnant les pièces et les volumes souhaités avant confirmation par Wagyu France.',
    'bodyClass' => 'reserve-pro-page is-pro'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/reserve-pro.css') }}">
@endpush

@push('scripts')
    <script type="application/json" id="reserve-cuts-data">@json($reserveCuts)</script>
    <script src="{{ asset('assets/js/reserve-pro.js') }}" defer></script>
@endpush

@section('content')
    <section class="reserve-hero">
        <div class="reserve-shell reserve-hero-grid">
            <div class="reserve-hero-copy">
                <p class="reserve-kicker">Wagyu France · Réserve professionnelle</p>
                <h1>Sélectionnez vos pièces, <em>avant la découpe.</em></h1>
                <p class="reserve-hero-lead">
                    Un espace dédié aux chefs, restaurateurs, bouchers et traiteurs pour exprimer
                    précisément leurs besoins en pièces et en volumes. Chaque demande est ensuite étudiée par la maison.
                </p>

                <div class="reserve-hero-actions">
                    @if ($batch && $activeCuts->isNotEmpty())
                        <a href="#selection" class="reserve-button-link reserve-button-primary">Commencer la sélection</a>
                    @endif
                    <a href="{{ route('professionnels') }}" class="reserve-button-link reserve-button-secondary">Retour à l’espace pro</a>
                </div>

                <dl class="reserve-hero-facts">
                    <div><dt>Référence</dt><dd>{{ $batch?->reference ?? 'À venir' }}</dd></div>
                    <div><dt>Demande</dt><dd>Pré-réservation sans paiement</dd></div>
                    <div><dt>Validation</dt><dd>Confirmation par la maison</dd></div>
                </dl>
            </div>

            <figure class="reserve-hero-visual">
                <img src="{{ asset('assets/images/pro/reserve-professionnelle.jpg') }}" alt="Sélection professionnelle de pièces de Wagyu">
                <figcaption>
                    <span>{{ $batch ? 'Réserve en cours' : 'Prochaine réserve' }}</span>
                    <strong>{{ $batch ? 'Une sélection construite pièce par pièce, selon votre usage.' : 'La maison prépare actuellement le prochain animal.' }}</strong>
                </figcaption>
                <div class="reserve-hero-seal" aria-hidden="true"><span>WF</span><small>Réserve pro</small></div>
            </figure>
        </div>
    </section>

    <section class="reserve-status" aria-label="État de la réserve">
        <div class="reserve-shell reserve-status-grid">
            <div class="reserve-status-reference">
                <span>Dossier actif</span>
                <strong>{{ $batch?->reference ?? 'Aucun' }}</strong>
            </div>

            <div class="reserve-status-progress">
                <div><span>Niveau indicatif de réservation</span><strong>{{ $progress }} %</strong></div>
                <i><b style="width: {{ $progress }}%"></b></i>
            </div>

            <div class="reserve-status-note">
                <span>Statut</span>
                <strong>{{ $batch?->status_label ?? 'Réserve fermée' }}</strong>
            </div>

            @if ($batch && $activeCuts->isNotEmpty())
                <button class="pro-cart-top-button" type="button" data-cart-open>
                    <span>Ma sélection</span><strong data-cart-count>0</strong>
                </button>
            @endif
        </div>
    </section>

    @if (! $batch || $activeCuts->isEmpty())
        <section class="reserve-workspace">
            <div class="reserve-shell">
                <div class="reserve-help-card" style="text-align:center; display:block">
                    <p class="reserve-kicker">Réserve momentanément fermée</p>
                    <h2>Le prochain animal sera prochainement ouvert aux demandes.</h2>
                    <p>Contactez la maison pour être informé de la prochaine disponibilité professionnelle.</p>
                    <a href="{{ route('contact') }}" class="reserve-button-link reserve-button-light">Contacter Wagyu France</a>
                </div>
            </div>
        </section>
    @else
        <section class="reserve-workspace" id="selection">
            <div class="reserve-shell">
                <header class="reserve-workspace-heading">
                    <div><p class="reserve-kicker">Carte de sélection</p><h2>Choisissez une zone sur l’animal.</h2></div>
                    <p>Cliquez sur une étiquette ou sur la silhouette. Les informations administrées par la maison s’actualisent sous la carte.</p>
                </header>

                <div class="reserve-main-card" id="animal-reservation">
                    <div class="reserve-card-top">
                        <div><span class="reserve-card-index">Plan de découpe · {{ $batch->reference }}</span><strong>Animal de référence</strong></div>
                        <div class="reserve-card-legend"><span><i></i> Zone sélectionnable</span><span><i></i> Pièce active</span></div>
                        <a href="{{ route('contact') }}" class="pro-access-button">Besoin d’un conseil&nbsp;? <span>→</span></a>
                    </div>

                    <div class="luxury-animal-area" data-selected-cut="{{ $firstCut?->slug }}">
                        <div class="exception-card">
                            <span class="exception-index">Note de sélection</span>
                            <h3>Une lecture globale de l’animal</h3>
                            <p>Les pièces nobles, les morceaux de caractère et les cuissons longues sont présentés ensemble.</p>
                        </div>

                        <div class="animal-stage" data-animal-stage>
                            <img class="animal-image animal-dark" src="{{ asset('assets/images/reserve/wagyu-cow-dark-clean.png') }}" alt="Bovin Wagyu noir - réserve professionnelle">
                            <img class="animal-image animal-light" src="{{ asset('assets/images/reserve/wagyu-cow-light-clean.png') }}" alt="Bovin Wagyu clair - réserve professionnelle">

                            @foreach ($activeCuts as $cut)
                                <button class="cut-hit" type="button" data-cut="{{ $cut->slug }}" aria-label="Sélectionner {{ $cut->name }}"></button>
                                <span class="cut-frame" data-cut="{{ $cut->slug }}"></span>
                                <span class="cut-line" data-cut="{{ $cut->slug }}"></span>
                                <span class="cut-dot" data-cut="{{ $cut->slug }}"></span>
                                <button class="cut-tag" type="button" data-cut="{{ $cut->slug }}"><span>{{ str_replace(' Wagyu', '', $cut->name) }}</span><i>+</i></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="reserve-mobile-cuts" aria-label="Sélection des pièces sur mobile">
                        @foreach ($activeCuts as $cut)
                            <button class="cut-tag reserve-mobile-cut" type="button" data-cut="{{ $cut->slug }}"><span>{{ str_replace(' Wagyu', '', $cut->name) }}</span><i>+</i></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="cut-reservation-section">
            <div class="reserve-shell cut-detail-luxury">
                <div class="cut-detail-left">
                    <p class="reserve-kicker">Pièce sélectionnée</p>
                    <span class="cut-detail-reference">Sélection professionnelle · {{ $batch->reference }}</span>
                    <h2 data-cut-name>{{ $firstCutData['name'] ?? 'Pièce Wagyu' }}</h2>
                    <p data-cut-description>{{ $firstCutData['description'] ?? '' }}</p>

                    <div class="cut-stats">
                        <div><span>Prix professionnel</span><strong data-cut-price>{{ $firstCutData['price'] ?? '—' }}</strong><small>Hors taxes</small></div>
                        <div><span>Volume indicatif</span><strong data-cut-stock>{{ $firstCutData['stock'] ?? '—' }}</strong><small>Sous réserve de confirmation</small></div>
                        <div><span>Déjà demandé</span><strong data-cut-reserved>{{ $firstCutData['reserved'] ?? '0%' }}</strong><small>Niveau indicatif</small></div>
                        <div><span>Demande minimale</span><strong data-cut-min>{{ $firstCutData['min'] ?? '1 kg' }}</strong><small>Par pièce sélectionnée</small></div>
                    </div>
                </div>

                <div class="cut-detail-right">
                    <span class="cut-order-index">Votre demande · {{ $batch->reference }}</span>
                    <div class="piece-progress">
                        <div class="piece-progress-top"><span>Niveau de réservation de cette pièce</span><strong data-cut-percent-label>{{ $firstCutData['reserved'] ?? '0%' }}</strong></div>
                        <div class="piece-progress-line"><span data-cut-percent-bar style="width: {{ $firstCutData['percent'] ?? 0 }}%"></span></div>
                    </div>

                    <div class="quantity-box">
                        <label for="reserveQuantity">Quantité souhaitée en kilogrammes</label>
                        <div>
                            <button type="button" data-quantity-minus aria-label="Réduire la quantité">−</button>
                            <input id="reserveQuantity" type="number" min="1" value="1" data-quantity-input>
                            <button type="button" data-quantity-plus aria-label="Augmenter la quantité">+</button>
                        </div>
                    </div>

                    <button class="reserve-button" type="button" data-reserve-button>Ajouter à ma sélection</button>
                    <button class="quote-button" type="button" data-cart-open>Consulter ma demande</button>
                    <p class="reserve-feedback" data-reserve-feedback aria-live="polite"></p>
                    <p class="cut-order-note">Aucun paiement n’est demandé. Les volumes, le prix et la livraison sont confirmés par Wagyu France.</p>
                </div>
            </div>
        </section>

        <section class="pro-flow-section">
            <div class="reserve-shell">
                <header class="section-heading">
                    <div><p class="reserve-kicker">Après votre sélection</p><h2>Une demande étudiée, puis confirmée avec précision.</h2></div>
                    <p>La réserve facilite l’expression du besoin. Chaque dossier est vérifié selon les pièces et les volumes disponibles.</p>
                </header>
                <div class="pro-flow-grid">
                    <article><span>01</span><h3>Vous sélectionnez</h3><p>Choisissez les pièces et indiquez les quantités utiles.</p></article>
                    <article><span>02</span><h3>Vous précisez</h3><p>Renseignez votre établissement et vos échéances.</p></article>
                    <article><span>03</span><h3>Nous vérifions</h3><p>Les disponibilités et la cohérence sont étudiées.</p></article>
                    <article><span>04</span><h3>Nous confirmons</h3><p>Vous recevez les volumes, le montant et la livraison.</p></article>
                </div>
            </div>
        </section>

        <button class="pro-cart-floating" type="button" data-cart-open aria-label="Ouvrir la sélection professionnelle"><span>Ma sélection</span><strong data-cart-count>0</strong></button>
        <div class="pro-cart-overlay" data-cart-overlay></div>

        <aside class="pro-cart-drawer" data-cart-drawer aria-hidden="true">
            <div class="pro-cart-head">
                <div><p class="reserve-kicker">Réserve professionnelle</p><h2>Ma sélection</h2></div>
                <button class="pro-cart-close" type="button" data-cart-close aria-label="Fermer la sélection">×</button>
            </div>

            <div class="pro-cart-body">
                <div class="pro-cart-empty" data-cart-empty><span>WF</span><h3>Votre sélection est vide</h3><p>Choisissez une pièce sur l’animal, indiquez la quantité, puis ajoutez-la à votre demande.</p></div>
                <div class="pro-cart-items" data-cart-items></div>

                <form class="pro-checkout-form is-hidden" data-checkout-form data-request-url="{{ route('reserve-pro.request.store') }}" data-bovin-reference="{{ $batch->reference }}">
                    @csrf
                    <div class="checkout-intro"><p class="reserve-kicker">Finalisation</p><h3>Votre établissement</h3><p>Ces informations permettront à Wagyu France d’étudier votre demande.</p></div>
                    <div class="checkout-grid">
                        <label><span>Société *</span><input type="text" name="company" required placeholder="Nom de votre établissement"></label>
                        <label><span>Nom complet *</span><input type="text" name="fullname" required placeholder="Votre nom"></label>
                        <label><span>Email *</span><input type="email" name="email" required placeholder="contact@entreprise.fr"></label>
                        <label><span>Téléphone *</span><input type="tel" name="phone" required placeholder="06 00 00 00 00"></label>
                        <label><span>Type de professionnel *</span><select name="professional_type" required><option value="">Sélectionner</option><option value="Restaurant">Restaurant</option><option value="Boucherie">Boucherie</option><option value="Traiteur">Traiteur</option><option value="Hôtel">Hôtel</option><option value="Grossiste">Grossiste</option><option value="Autre">Autre</option></select></label>
                        <label><span>Ville de livraison</span><input type="text" name="city" placeholder="Ville / secteur"></label>
                        <label class="checkout-full"><span>Votre besoin</span><textarea name="message" rows="4" placeholder="Échéance, fréquence, découpe ou livraison..."></textarea></label>
                    </div>
                    <div class="checkout-actions"><button class="checkout-back-button" type="button" data-checkout-back>Retour à la sélection</button><button class="checkout-submit-button" type="submit">Transmettre ma demande</button></div>
                </form>

                <div class="pro-cart-confirmation is-hidden" data-cart-confirmation><span>✓</span><h3>Demande enregistrée</h3><p>Votre demande a bien été transmise. Wagyu France pourra vous recontacter pour confirmer les quantités.</p><div class="confirmation-summary" data-confirmation-summary></div><button type="button" data-cart-close>Fermer</button></div>
            </div>

            <div class="pro-cart-summary">
                <div><span>Total estimatif HT</span><strong data-cart-total>0 €</strong></div>
                <p>Estimation calculée à partir des quantités demandées. Le montant définitif sera confirmé.</p>
                <button class="cart-submit-button" type="button" data-cart-submit>Finaliser ma demande</button>
                <button class="cart-clear-button" type="button" data-cart-clear>Vider la sélection</button>
            </div>
        </aside>
    @endif
@endsection

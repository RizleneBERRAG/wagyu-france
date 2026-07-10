@extends('layouts.admin', [
    'title' => 'Paramètres du site — Wagyu France',
    'sectionLabel' => 'Configuration',
    'pageHeading' => 'Paramètres du site',
    'bodyClass' => 'admin-settings-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-settings.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading">
        <div>
            <p class="admin-kicker">Configuration centrale</p>
            <h2>Les informations importantes, modifiables sans toucher au code.</h2>
            <p>
                Les coordonnées, emails, modalités commerciales, documents PDF et données juridiques
                renseignés ici sont réutilisés dans toute l’administration.
            </p>
        </div>
        <a href="{{ route('contact') }}" target="_blank" class="admin-secondary-button">Voir la page contact</a>
    </header>

    <section class="admin-settings-health">
        <article class="admin-card {{ $mailReady ? 'is-ready' : 'is-warning' }}">
            <span>Email transactionnel</span>
            <strong>{{ $mailReady ? 'Configuration active' : 'Mode journal uniquement' }}</strong>
            <p>
                {{ $mailReady
                    ? 'Laravel peut transmettre les confirmations et notifications aux adresses configurées.'
                    : 'Les emails sont préparés mais restent inscrits dans les logs tant que le SMTP n’est pas configuré.' }}
            </p>
        </article>
        <article class="admin-card is-ready">
            <span>Documents commerciaux</span>
            <strong>PDF générés en interne</strong>
            <p>Aucune bibliothèque externe n’est nécessaire pour les bons de commande, de préparation et les factures.</p>
        </article>
        <article class="admin-card">
            <span>Sécurité</span>
            <strong>Numérotation définitive</strong>
            <p>Une facture émise conserve son numéro et son instantané même si les paramètres changent ensuite.</p>
        </article>
    </section>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="admin-settings-form">
        @csrf
        @method('PUT')

        <section class="admin-settings-section admin-card">
            <header>
                <span>01</span>
                <div>
                    <p class="admin-kicker">Identité & contact</p>
                    <h3>Informations visibles par les clients</h3>
                </div>
            </header>

            <div class="admin-settings-grid">
                <label>
                    <span>Nom de la marque *</span>
                    <input type="text" name="brand_name" required value="{{ old('brand_name', $settings['brand_name'] ?? 'Wagyu France') }}">
                </label>
                <label>
                    <span>Email général</span>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" placeholder="contact@wagyufrance.fr">
                </label>
                <label>
                    <span>Téléphone</span>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="03 00 00 00 00">
                </label>
                <label>
                    <span>Délai de réponse affiché</span>
                    <input type="text" name="reply_delay" value="{{ old('reply_delay', $settings['reply_delay'] ?? '') }}" placeholder="Sous 2 jours ouvrés">
                </label>
            </div>
        </section>

        <section class="admin-settings-section admin-card">
            <header>
                <span>02</span>
                <div>
                    <p class="admin-kicker">Notifications</p>
                    <h3>Qui reçoit les nouvelles demandes ?</h3>
                </div>
            </header>

            <div class="admin-settings-grid">
                <label>
                    <span>Commandes boutique</span>
                    <input type="email" name="order_notification_email" value="{{ old('order_notification_email', $settings['order_notification_email'] ?? '') }}">
                    <small>Nouvelle demande d’un particulier.</small>
                </label>
                <label>
                    <span>Réserve professionnelle</span>
                    <input type="email" name="pro_notification_email" value="{{ old('pro_notification_email', $settings['pro_notification_email'] ?? '') }}">
                    <small>Nouvelle sélection liée à un animal.</small>
                </label>
                <label>
                    <span>Messages de contact</span>
                    <input type="email" name="contact_notification_email" value="{{ old('contact_notification_email', $settings['contact_notification_email'] ?? '') }}">
                    <small>Contact général, partenariat et presse.</small>
                </label>
            </div>
        </section>

        <section class="admin-settings-section admin-card">
            <header>
                <span>03</span>
                <div>
                    <p class="admin-kicker">Commerce</p>
                    <h3>Livraison, retrait et préparation</h3>
                </div>
            </header>

            <div class="admin-settings-grid">
                <label class="is-wide">
                    <span>Zone de livraison</span>
                    <textarea name="delivery_area" rows="3">{{ old('delivery_area', $settings['delivery_area'] ?? '') }}</textarea>
                </label>
                <label class="is-wide">
                    <span>Adresse ou modalités de retrait</span>
                    <textarea name="withdrawal_address" rows="3">{{ old('withdrawal_address', $settings['withdrawal_address'] ?? '') }}</textarea>
                </label>
                <label class="is-wide">
                    <span>Délai et organisation de la préparation</span>
                    <textarea name="preparation_delay" rows="3">{{ old('preparation_delay', $settings['preparation_delay'] ?? '') }}</textarea>
                </label>
            </div>
        </section>

        <section class="admin-settings-section admin-card">
            <header>
                <span>04</span>
                <div>
                    <p class="admin-kicker">Documents & facturation</p>
                    <h3>Numérotation, TVA et mentions de paiement</h3>
                </div>
            </header>

            <div class="admin-settings-grid">
                <label>
                    <span>Préfixe des factures *</span>
                    <input type="text" name="invoice_prefix" required value="{{ old('invoice_prefix', $settings['invoice_prefix'] ?? 'WF') }}" placeholder="WF">
                    <small>Exemple : WF-2026-0001. Ne change pas les factures déjà émises.</small>
                </label>
                <label>
                    <span>Taux de TVA proposé par défaut</span>
                    <input type="number" name="default_vat_rate" min="0" max="100" step="0.01" value="{{ old('default_vat_rate', $settings['default_vat_rate'] ?? '') }}" placeholder="À confirmer">
                    <small>Le taux reste modifiable dossier par dossier avant émission.</small>
                </label>
                <label class="is-wide">
                    <span>Conditions de paiement</span>
                    <textarea name="invoice_payment_terms" rows="3">{{ old('invoice_payment_terms', $settings['invoice_payment_terms'] ?? '') }}</textarea>
                </label>
                <label class="is-wide">
                    <span>Coordonnées de paiement</span>
                    <textarea name="invoice_bank_details" rows="4" placeholder="IBAN, BIC ou instructions de règlement...">{{ old('invoice_bank_details', $settings['invoice_bank_details'] ?? '') }}</textarea>
                    <small>Ces informations apparaissent dans les documents commerciaux lorsqu’elles sont renseignées.</small>
                </label>
                <label class="is-wide">
                    <span>Texte de pied de page</span>
                    <textarea name="invoice_footer" rows="2">{{ old('invoice_footer', $settings['invoice_footer'] ?? 'Merci pour votre confiance.') }}</textarea>
                </label>
            </div>
        </section>

        <section class="admin-settings-section admin-card">
            <header>
                <span>05</span>
                <div>
                    <p class="admin-kicker">Cadre juridique</p>
                    <h3>Informations reprises dans les pages légales et les factures</h3>
                </div>
            </header>

            <div class="admin-settings-grid">
                <label>
                    <span>Dénomination légale</span>
                    <input type="text" name="legal_company_name" value="{{ old('legal_company_name', $settings['legal_company_name'] ?? '') }}">
                </label>
                <label>
                    <span>Forme juridique</span>
                    <input type="text" name="legal_company_form" value="{{ old('legal_company_form', $settings['legal_company_form'] ?? '') }}" placeholder="SAS, SARL, EI…">
                </label>
                <label class="is-wide">
                    <span>Adresse légale</span>
                    <textarea name="legal_company_address" rows="3">{{ old('legal_company_address', $settings['legal_company_address'] ?? '') }}</textarea>
                </label>
                <label>
                    <span>SIRET</span>
                    <input type="text" name="legal_company_siret" value="{{ old('legal_company_siret', $settings['legal_company_siret'] ?? '') }}">
                </label>
                <label>
                    <span>Numéro de TVA intracommunautaire</span>
                    <input type="text" name="legal_vat_number" value="{{ old('legal_vat_number', $settings['legal_vat_number'] ?? '') }}">
                </label>
                <label>
                    <span>Directeur de publication</span>
                    <input type="text" name="legal_publication_director" value="{{ old('legal_publication_director', $settings['legal_publication_director'] ?? '') }}">
                </label>
                <label>
                    <span>Hébergeur</span>
                    <input type="text" name="legal_host_name" value="{{ old('legal_host_name', $settings['legal_host_name'] ?? '') }}">
                </label>
                <label>
                    <span>Téléphone de l’hébergeur</span>
                    <input type="text" name="legal_host_phone" value="{{ old('legal_host_phone', $settings['legal_host_phone'] ?? '') }}">
                </label>
                <label class="is-wide">
                    <span>Adresse de l’hébergeur</span>
                    <textarea name="legal_host_address" rows="3">{{ old('legal_host_address', $settings['legal_host_address'] ?? '') }}</textarea>
                </label>
                <label>
                    <span>Médiateur de la consommation</span>
                    <input type="text" name="legal_mediator_name" value="{{ old('legal_mediator_name', $settings['legal_mediator_name'] ?? '') }}">
                </label>
                <label>
                    <span>Site du médiateur</span>
                    <input type="url" name="legal_mediator_website" value="{{ old('legal_mediator_website', $settings['legal_mediator_website'] ?? '') }}" placeholder="https://">
                </label>
                <label class="is-wide">
                    <span>Adresse du médiateur</span>
                    <textarea name="legal_mediator_address" rows="3">{{ old('legal_mediator_address', $settings['legal_mediator_address'] ?? '') }}</textarea>
                </label>
            </div>
        </section>

        <div class="admin-settings-submit">
            <div>
                <strong>Enregistrer les paramètres</strong>
                <p>Les nouvelles valeurs seront utilisées dès la requête suivante. Les factures déjà émises restent inchangées.</p>
            </div>
            <button type="submit" class="admin-primary-button">Enregistrer les modifications</button>
        </div>
    </form>
@endsection

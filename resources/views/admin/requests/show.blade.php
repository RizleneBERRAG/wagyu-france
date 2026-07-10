@php
    $isShop = $kind === 'shop';
    $displayName = $isShop ? $requestItem->fullname : $requestItem->company;
    $contactName = $isShop ? $requestItem->fullname : $requestItem->fullname;
    $items = $requestItem->cart ?? [];
    $finalInput = $isShop ? 'final_total_ttc' : 'final_total_ht';
    $finalLabel = $isShop ? 'Montant final TTC' : 'Montant final HT';
    $updateRoute = $isShop
        ? route('admin.documents.shop.update', $requestItem)
        : route('admin.documents.pro.update', $requestItem);
    $statusRoute = $isShop
        ? route('admin.demandes.shop.status', $requestItem)
        : route('admin.demandes.pro.status', $requestItem);
    $issueRoute = $isShop
        ? route('admin.documents.shop.invoice.issue', $requestItem)
        : route('admin.documents.pro.invoice.issue', $requestItem);
    $pdfRoute = fn (string $document) => $isShop
        ? route('admin.documents.shop.pdf', [$requestItem, $document])
        : route('admin.documents.pro.pdf', [$requestItem, $document]);
@endphp

@extends('layouts.admin', [
    'title' => $requestItem->reference . ' — Administration Wagyu France',
    'sectionLabel' => $isShop ? 'Commande particulier' : 'Demande professionnelle',
    'pageHeading' => $requestItem->reference,
    'bodyClass' => 'admin-document-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-documents.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading admin-document-heading">
        <div>
            <a href="{{ route('admin.demandes', ['section' => $isShop ? 'shop' : 'pro']) }}" class="admin-back-link">← Retour aux demandes</a>
            <p class="admin-kicker">{{ $isShop ? 'Boutique particuliers' : 'Réserve professionnelle' }}</p>
            <h2>{{ $displayName }}</h2>
            <p>
                Reçue le {{ $requestItem->created_at->format('d/m/Y à H:i') }}
                @unless($isShop)
                    · Animal {{ $requestItem->bovin_reference }}
                @endunless
            </p>
        </div>

        <div class="admin-document-heading-actions">
            <span class="admin-status admin-status-{{ $requestItem->status }}">
                {{ $statusLabels[$requestItem->status] ?? $requestItem->status }}
            </span>
            @if($requestItem->invoice_number)
                <span class="admin-invoice-seal">Facture {{ $requestItem->invoice_number }}</span>
            @endif
        </div>
    </header>

    <section class="admin-document-overview">
        <article class="admin-card admin-document-client">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Client</p>
                    <h3>{{ $displayName }}</h3>
                </div>
                <span>{{ $isShop ? 'Particulier' : $requestItem->professional_type }}</span>
            </div>

            <dl class="admin-request-info">
                @unless($isShop)
                    <div><dt>Contact</dt><dd>{{ $contactName }}</dd></div>
                @endunless
                <div><dt>Email</dt><dd><a href="mailto:{{ $requestItem->email }}">{{ $requestItem->email }}</a></dd></div>
                <div><dt>Téléphone</dt><dd><a href="tel:{{ $requestItem->phone }}">{{ $requestItem->phone }}</a></dd></div>
                <div><dt>Ville</dt><dd>{{ $requestItem->city ?: 'Non précisée' }}</dd></div>
                <div><dt>Référence</dt><dd><code>{{ $requestItem->reference }}</code></dd></div>
            </dl>

            @if($requestItem->message)
                <div class="admin-request-message">
                    <strong>Message transmis</strong>
                    <p>{{ $requestItem->message }}</p>
                </div>
            @endif
        </article>

        <article class="admin-card admin-document-status-card">
            <p class="admin-kicker">Avancement</p>
            <h3>Faire évoluer le dossier</h3>
            <p>Le changement de statut informe automatiquement le client. Pour la boutique, la confirmation réserve aussi le stock.</p>

            <form method="POST" action="{{ $statusRoute }}" class="admin-document-status-form">
                @csrf
                @method('PATCH')
                <label>
                    <span>Statut du dossier</span>
                    <select name="status">
                        @foreach($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected($requestItem->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit" class="admin-primary-button">Mettre à jour le statut</button>
            </form>

            @if($isShop)
                <div class="admin-stock-state {{ $requestItem->stock_applied_at ? 'is-applied' : '' }}">
                    <span>{{ $requestItem->stock_applied_at ? '✓' : '○' }}</span>
                    <div>
                        <strong>{{ $requestItem->stock_applied_at ? 'Stock réservé' : 'Stock non engagé' }}</strong>
                        <p>{{ $requestItem->stock_applied_at ? 'Les quantités ont été déduites du catalogue.' : 'Aucune quantité n’a encore été retirée.' }}</p>
                    </div>
                </div>
            @endif
        </article>
    </section>

    <section class="admin-card admin-document-items-card">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Sélection</p>
                <h3>Pièces et quantités demandées</h3>
            </div>
            <strong>{{ count($items) }} ligne(s)</strong>
        </div>

        <div class="admin-document-items-table">
            <div class="admin-document-item admin-document-item-head">
                <span>Pièce</span>
                <span>Quantité</span>
                <span>Prix unitaire</span>
                <span>Total</span>
            </div>
            @foreach($items as $item)
                @php
                    $unitPrice = (float) ($isShop ? ($item['unit_price'] ?? 0) : ($item['unit_price_ht'] ?? 0));
                    $lineTotal = (float) ($isShop ? ($item['line_total'] ?? 0) : ($item['line_total_ht'] ?? 0));
                @endphp
                <div class="admin-document-item">
                    <strong>{{ $item['name'] ?? 'Pièce' }}</strong>
                    <span>{{ number_format((float) ($item['quantity'] ?? 0), 1, ',', ' ') }} kg</span>
                    <span>{{ number_format($unitPrice, 2, ',', ' ') }} €{{ $isShop ? '' : ' HT' }}/kg</span>
                    <strong>{{ number_format($lineTotal, 2, ',', ' ') }} €{{ $isShop ? '' : ' HT' }}</strong>
                </div>
            @endforeach
        </div>

        <div class="admin-document-estimate">
            <span>Estimation initiale enregistrée</span>
            <strong>{{ number_format($baseTotal, 2, ',', ' ') }} €{{ $isShop ? ' TTC' : ' HT' }}</strong>
        </div>
    </section>

    <section class="admin-document-workspace">
        <article class="admin-card admin-document-commercial-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Finalisation commerciale</p>
                    <h3>Montant, TVA et paiement</h3>
                </div>
                @if($requestItem->invoice_number)
                    <span class="admin-lock-label">Montants verrouillés</span>
                @endif
            </div>

            <form method="POST" action="{{ $updateRoute }}" class="admin-document-commercial-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <label>
                        <span>{{ $finalLabel }}</span>
                        <input
                            type="number"
                            name="{{ $finalInput }}"
                            min="0"
                            max="999999.99"
                            step="0.01"
                            value="{{ old($finalInput, $finalTotal) }}"
                            @disabled($requestItem->invoice_number)
                            placeholder="0,00"
                        >
                        <small>Montant réellement confirmé après poids, disponibilité et préparation.</small>
                    </label>

                    <label>
                        <span>Taux de TVA applicable</span>
                        <div class="admin-input-suffix">
                            <input
                                type="number"
                                name="vat_rate"
                                min="0"
                                max="100"
                                step="0.01"
                                value="{{ old('vat_rate', $requestItem->vat_rate ?? $vatRate) }}"
                                @disabled($requestItem->invoice_number)
                            >
                            <b>%</b>
                        </div>
                        <small>À confirmer selon le régime et la nature exacte de la vente.</small>
                    </label>

                    <label>
                        <span>État du paiement</span>
                        <select name="payment_status">
                            @foreach($paymentStatuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('payment_status', $requestItem->payment_status ?? 'pending') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span>Date de règlement</span>
                        <input type="datetime-local" name="paid_at" value="{{ old('paid_at', $requestItem->paid_at?->format('Y-m-d\TH:i')) }}">
                    </label>

                    <label class="is-wide">
                        <span>Consignes et notes de préparation</span>
                        <textarea name="document_notes" rows="5" placeholder="Conditionnement, découpe, retrait, livraison, informations à faire apparaître...">{{ old('document_notes', $requestItem->document_notes) }}</textarea>
                    </label>
                </div>

                <button type="submit" class="admin-primary-button">Enregistrer la finalisation</button>
            </form>
        </article>

        <article class="admin-card admin-document-download-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Documents PDF</p>
                    <h3>Téléchargements</h3>
                </div>
                <span>PDF A4</span>
            </div>

            <div class="admin-document-download-list">
                <a href="{{ $pdfRoute('order') }}">
                    <span>01</span>
                    <div><strong>Bon de commande</strong><p>Client, pièces, quantités et montant actuel.</p></div>
                    <b>PDF ↓</b>
                </a>

                <a href="{{ $pdfRoute('preparation') }}">
                    <span>02</span>
                    <div><strong>Bon de préparation</strong><p>Document atelier sans détail tarifaire.</p></div>
                    <b>PDF ↓</b>
                </a>

                @if($requestItem->invoice_number)
                    <a href="{{ $pdfRoute('invoice') }}" class="is-invoice">
                        <span>03</span>
                        <div><strong>Facture {{ $requestItem->invoice_number }}</strong><p>Émise le {{ $requestItem->invoice_issued_at?->format('d/m/Y à H:i') }}.</p></div>
                        <b>PDF ↓</b>
                    </a>
                @else
                    <div class="admin-document-invoice-pending">
                        <span>03</span>
                        <div>
                            <strong>Facture non émise</strong>
                            <p>Une facture reçoit un numéro définitif et ne pourra plus être modifiée.</p>
                        </div>
                    </div>
                @endif
            </div>

            @unless($requestItem->invoice_number)
                <div class="admin-invoice-readiness {{ $invoiceReady === [] && $legalReady ? 'is-ready' : 'is-warning' }}">
                    <strong>{{ $invoiceReady === [] && $legalReady ? 'Le dossier est prêt à facturer.' : 'Éléments nécessaires avant émission' }}</strong>
                    @if($invoiceReady !== [] || ! $legalReady)
                        <ul>
                            @foreach($invoiceReady as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                            @unless($legalReady)
                                <li>Compléter la société, l’adresse légale et le SIRET dans les paramètres.</li>
                            @endunless
                        </ul>
                    @else
                        <p>Le montant, la TVA, le statut et les informations légales sont présents.</p>
                    @endif
                </div>

                <form method="POST" action="{{ $issueRoute }}" onsubmit="return confirm('Émettre cette facture ? Son numéro et son contenu financier deviendront définitifs.');">
                    @csrf
                    <button type="submit" class="admin-primary-button admin-issue-invoice" @disabled($invoiceReady !== [] || ! $legalReady)>
                        Émettre la facture définitive
                    </button>
                </form>
            @else
                <div class="admin-invoice-readiness is-locked">
                    <strong>Facture figée</strong>
                    <p>L’instantané légal et financier enregistré lors de l’émission est conservé indépendamment des futures modifications du site.</p>
                </div>
            @endunless
        </article>
    </section>
@endsection

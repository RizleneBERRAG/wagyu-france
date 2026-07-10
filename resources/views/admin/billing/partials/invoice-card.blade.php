@php
    $isShop = $invoiceKind === 'shop';
    $customerName = $isShop ? $invoice->fullname : $invoice->company;
    $invoiceBase = $isShop
        ? (float) data_get($invoice->invoice_snapshot, 'amounts.total_ttc', $invoice->final_total_ttc)
        : (float) data_get($invoice->invoice_snapshot, 'amounts.total_ht', $invoice->final_total_ht);
    $creditedBase = $isShop
        ? (float) $invoice->creditNotes->sum('amount_ttc')
        : (float) $invoice->creditNotes->sum('amount_ht');
    $remainingBase = max(0, round($invoiceBase - $creditedBase, 2));
    $documentRoute = $isShop
        ? route('admin.documents.shop.show', $invoice)
        : route('admin.documents.pro.show', $invoice);
    $invoicePdfRoute = $isShop
        ? route('admin.documents.shop.pdf', [$invoice, 'invoice'])
        : route('admin.documents.pro.pdf', [$invoice, 'invoice']);
    $sendInvoiceRoute = $isShop
        ? route('admin.billing.shop.invoice.send', $invoice)
        : route('admin.billing.pro.invoice.send', $invoice);
    $creditRoute = $isShop
        ? route('admin.billing.shop.credit.issue', $invoice)
        : route('admin.billing.pro.credit.issue', $invoice);
    $amountLabel = $isShop ? 'Montant TTC à créditer' : 'Montant HT à créditer';
    $amountSuffix = $isShop ? 'TTC' : 'HT';
@endphp

<article class="admin-billing-card admin-card">
    <header>
        <div>
            <span class="admin-request-type">{{ $isShop ? 'Particulier' : 'Professionnel' }}</span>
            <h4>{{ $customerName }}</h4>
            <code>{{ $invoice->invoice_number }}</code>
        </div>
        <span class="admin-payment-state is-{{ $invoice->payment_status }}">
            {{ [
                'pending' => 'À régler',
                'partial' => 'Partiel',
                'paid' => 'Réglé',
                'refunded' => 'Remboursé',
            ][$invoice->payment_status] ?? $invoice->payment_status }}
        </span>
    </header>

    <div class="admin-billing-meta">
        <div><span>Dossier</span><strong>{{ $invoice->reference }}</strong></div>
        <div><span>Émise le</span><strong>{{ $invoice->invoice_issued_at?->format('d/m/Y') }}</strong></div>
        <div><span>Montant facturé</span><strong>{{ number_format($invoiceBase, 2, ',', ' ') }} € {{ $amountSuffix }}</strong></div>
        <div><span>Encore créditable</span><strong>{{ number_format($remainingBase, 2, ',', ' ') }} € {{ $amountSuffix }}</strong></div>
    </div>

    <div class="admin-billing-send-state {{ $invoice->invoice_sent_at ? 'is-sent' : 'is-waiting' }}">
        <span>{{ $invoice->invoice_sent_at ? '✓' : '○' }}</span>
        <div>
            <strong>{{ $invoice->invoice_sent_at ? 'Facture envoyée' : 'Facture non envoyée' }}</strong>
            <p>
                {{ $invoice->invoice_sent_at
                    ? 'Dernier envoi le ' . $invoice->invoice_sent_at->format('d/m/Y à H:i') . ' à ' . $invoice->email . '.'
                    : 'Le PDF n’a pas encore été transmis depuis le tableau de bord.' }}
            </p>
        </div>
    </div>

    <div class="admin-billing-actions">
        <a href="{{ $documentRoute }}" class="admin-secondary-button">Ouvrir le dossier</a>
        <a href="{{ $invoicePdfRoute }}" class="admin-secondary-button">Télécharger la facture</a>
        <form method="POST" action="{{ $sendInvoiceRoute }}" onsubmit="return confirm('Envoyer cette facture à {{ $invoice->email }} ?');">
            @csrf
            <button type="submit" class="admin-primary-button">
                {{ $invoice->invoice_sent_at ? 'Renvoyer par email' : 'Envoyer par email' }}
            </button>
        </form>
    </div>

    @if($invoice->creditNotes->isNotEmpty())
        <div class="admin-credit-list">
            <div class="admin-credit-list-heading">
                <strong>Avoirs déjà émis</strong>
                <span>{{ $invoice->creditNotes->count() }}</span>
            </div>

            @foreach($invoice->creditNotes->sortByDesc('issued_at') as $credit)
                <div class="admin-credit-row">
                    <div>
                        <strong>{{ $credit->number }}</strong>
                        <small>{{ $credit->issued_at?->format('d/m/Y') }} · {{ number_format((float) ($isShop ? $credit->amount_ttc : $credit->amount_ht), 2, ',', ' ') }} € {{ $amountSuffix }}</small>
                    </div>
                    <div class="admin-credit-row-actions">
                        <a href="{{ route('admin.billing.credit.pdf', $credit) }}">PDF</a>
                        <form method="POST" action="{{ route('admin.billing.credit.send', $credit) }}" onsubmit="return confirm('Envoyer cet avoir à {{ $invoice->email }} ?');">
                            @csrf
                            <button type="submit">{{ $credit->sent_at ? 'Renvoyer' : 'Envoyer' }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($remainingBase > 0.005)
        <details class="admin-credit-create">
            <summary>Émettre un avoir</summary>
            <form method="POST" action="{{ $creditRoute }}" onsubmit="return confirm('Émettre cet avoir ? Son numéro sera définitif.');">
                @csrf
                <label>
                    <span>{{ $amountLabel }}</span>
                    <div class="admin-input-suffix">
                        <input type="number" name="amount" min="0.01" max="{{ $remainingBase }}" step="0.01" required>
                        <b>€</b>
                    </div>
                    <small>Maximum disponible : {{ number_format($remainingBase, 2, ',', ' ') }} € {{ $amountSuffix }}.</small>
                </label>
                <label>
                    <span>Motif de la rectification</span>
                    <textarea name="reason" rows="3" required minlength="5" maxlength="2000" placeholder="Annulation partielle, écart de poids, produit indisponible, geste commercial..."></textarea>
                </label>
                <button type="submit" class="admin-primary-button">Émettre l’avoir définitif</button>
            </form>
        </details>
    @else
        <div class="admin-credit-complete">
            <strong>Facture intégralement créditée</strong>
            <p>Aucun nouvel avoir ne peut être émis sur cette facture.</p>
        </div>
    @endif
</article>

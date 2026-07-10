<?php

namespace App\Services;

use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Models\SiteSetting;
use App\Services\Pdf\SimplePdfDocument;

class CommercialDocumentPdfService
{
    private const BURGUNDY = [88, 24, 24];
    private const GOLD = [181, 139, 76];
    private const INK = [36, 31, 27];
    private const MUTED = [103, 93, 84];
    private const PAPER = [248, 245, 239];
    private const LINE = [218, 210, 198];

    public function shop(ShopOrderRequest $order, string $type): string
    {
        if ($type === 'invoice') {
            return $this->render($this->invoiceData($order->invoice_snapshot ?? []));
        }

        $isFinal = is_array($order->final_cart) && $order->final_cart !== [];
        $items = $isFinal
            ? $this->normalizedFinalItems($order->final_cart)
            : $this->normalizedShopItems($order->cart ?? []);

        if ($type !== 'preparation') {
            $items = $this->appendAdjustment($items, $order->additional_label, (float) $order->additional_amount);
        }

        $totalTtc = $isFinal
            ? (float) $order->final_total_ttc
            : (float) $order->total;
        $vatRate = $order->vat_rate !== null
            ? (float) $order->vat_rate
            : $this->defaultVatRate();
        [$totalHt, $vatAmount] = $this->fromTtc($totalTtc, $vatRate);

        return $this->render([
            'type' => $type,
            'title' => $type === 'preparation' ? 'Bon de préparation' : 'Bon de commande',
            'number' => $order->reference,
            'date' => now()->format('d/m/Y'),
            'seller' => $this->seller(),
            'customer' => [
                'name' => $order->fullname,
                'company' => null,
                'email' => $order->email,
                'phone' => $order->phone,
                'address' => $order->city,
            ],
            'context' => [
                ['label' => 'Canal', 'value' => 'Boutique particuliers'],
                ['label' => 'Statut', 'value' => $this->statusLabel($order->status)],
                ['label' => 'Paiement', 'value' => $this->paymentLabel($order->payment_status)],
            ],
            'items' => $items,
            'amounts' => [
                'total_ht' => $totalHt,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_ttc' => $totalTtc,
                'is_estimate' => ! $isFinal,
            ],
            'notes' => $order->document_notes ?: $order->message,
            'payment_terms' => SiteSetting::valueFor('invoice_payment_terms'),
            'bank_details' => SiteSetting::valueFor('invoice_bank_details'),
            'footer' => SiteSetting::valueFor('invoice_footer', 'Merci pour votre confiance.'),
        ]);
    }

    public function pro(ProReservationRequest $requestItem, string $type): string
    {
        if ($type === 'invoice') {
            return $this->render($this->invoiceData($requestItem->invoice_snapshot ?? []));
        }

        $isFinal = is_array($requestItem->final_cart) && $requestItem->final_cart !== [];
        $items = $isFinal
            ? $this->normalizedFinalItems($requestItem->final_cart)
            : $this->normalizedProItems($requestItem->cart ?? []);

        if ($type !== 'preparation') {
            $items = $this->appendAdjustment($items, $requestItem->additional_label, (float) $requestItem->additional_amount);
        }

        $totalHt = $isFinal
            ? (float) $requestItem->final_total_ht
            : (float) $requestItem->total_ht;
        $vatRate = $requestItem->vat_rate !== null
            ? (float) $requestItem->vat_rate
            : $this->defaultVatRate();
        $vatAmount = round($totalHt * ($vatRate / 100), 2);

        return $this->render([
            'type' => $type,
            'title' => $type === 'preparation' ? 'Bon de préparation professionnel' : 'Bon de commande professionnel',
            'number' => $requestItem->reference,
            'date' => now()->format('d/m/Y'),
            'seller' => $this->seller(),
            'customer' => [
                'name' => $requestItem->fullname,
                'company' => $requestItem->company,
                'email' => $requestItem->email,
                'phone' => $requestItem->phone,
                'address' => $requestItem->city,
            ],
            'context' => [
                ['label' => 'Animal', 'value' => $requestItem->bovin_reference],
                ['label' => 'Profil', 'value' => $requestItem->professional_type],
                ['label' => 'Statut', 'value' => $this->statusLabel($requestItem->status)],
                ['label' => 'Paiement', 'value' => $this->paymentLabel($requestItem->payment_status)],
            ],
            'items' => $items,
            'amounts' => [
                'total_ht' => $totalHt,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_ttc' => $totalHt + $vatAmount,
                'is_estimate' => ! $isFinal,
            ],
            'notes' => $requestItem->document_notes ?: $requestItem->message,
            'payment_terms' => SiteSetting::valueFor('invoice_payment_terms'),
            'bank_details' => SiteSetting::valueFor('invoice_bank_details'),
            'footer' => SiteSetting::valueFor('invoice_footer', 'Merci pour votre confiance.'),
        ]);
    }

    public function shopInvoiceSnapshot(ShopOrderRequest $order, string $invoiceNumber): array
    {
        $totalTtc = (float) $order->final_total_ttc;
        $vatRate = (float) $order->vat_rate;
        [$totalHt, $vatAmount] = $this->fromTtc($totalTtc, $vatRate);
        $items = $this->appendAdjustment(
            $this->normalizedFinalItems($order->final_cart ?? []),
            $order->additional_label,
            (float) $order->additional_amount
        );

        return $this->snapshot([
            'number' => $invoiceNumber,
            'seller' => $this->seller(),
            'customer' => [
                'name' => $order->fullname,
                'company' => null,
                'email' => $order->email,
                'phone' => $order->phone,
                'address' => $order->city,
            ],
            'context' => [
                ['label' => 'Commande', 'value' => $order->reference],
                ['label' => 'Paiement', 'value' => $this->paymentLabel($order->payment_status)],
            ],
            'items' => $items,
            'amounts' => [
                'total_ht' => $totalHt,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_ttc' => $totalTtc,
                'is_estimate' => false,
            ],
            'notes' => $order->document_notes,
        ]);
    }

    public function proInvoiceSnapshot(ProReservationRequest $requestItem, string $invoiceNumber): array
    {
        $totalHt = (float) $requestItem->final_total_ht;
        $vatRate = (float) $requestItem->vat_rate;
        $vatAmount = round($totalHt * ($vatRate / 100), 2);
        $items = $this->appendAdjustment(
            $this->normalizedFinalItems($requestItem->final_cart ?? []),
            $requestItem->additional_label,
            (float) $requestItem->additional_amount
        );

        return $this->snapshot([
            'number' => $invoiceNumber,
            'seller' => $this->seller(),
            'customer' => [
                'name' => $requestItem->fullname,
                'company' => $requestItem->company,
                'email' => $requestItem->email,
                'phone' => $requestItem->phone,
                'address' => $requestItem->city,
            ],
            'context' => [
                ['label' => 'Demande', 'value' => $requestItem->reference],
                ['label' => 'Animal', 'value' => $requestItem->bovin_reference],
                ['label' => 'Paiement', 'value' => $this->paymentLabel($requestItem->payment_status)],
            ],
            'items' => $items,
            'amounts' => [
                'total_ht' => $totalHt,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_ttc' => $totalHt + $vatAmount,
                'is_estimate' => false,
            ],
            'notes' => $requestItem->document_notes,
        ]);
    }

    private function snapshot(array $data): array
    {
        return array_merge($data, [
            'type' => 'invoice',
            'title' => 'Facture',
            'date' => now()->format('d/m/Y'),
            'issued_at' => now()->toIso8601String(),
            'payment_terms' => SiteSetting::valueFor('invoice_payment_terms'),
            'bank_details' => SiteSetting::valueFor('invoice_bank_details'),
            'footer' => SiteSetting::valueFor('invoice_footer', 'Merci pour votre confiance.'),
        ]);
    }

    private function invoiceData(array $snapshot): array
    {
        abort_if($snapshot === [], 404, 'La facture n’a pas encore été émise.');

        return $snapshot;
    }

    private function normalizedFinalItems(array $items): array
    {
        return collect($items)->map(fn (array $item) => [
            'name' => $item['name'] ?? 'Pièce',
            'quantity' => (float) ($item['quantity'] ?? 0),
            'unit_price' => (float) ($item['unit_price'] ?? 0),
            'line_total' => (float) ($item['line_total'] ?? (($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0))),
        ])->values()->all();
    }

    private function normalizedShopItems(array $items): array
    {
        return collect($items)->map(fn (array $item) => [
            'name' => $item['name'] ?? 'Produit',
            'quantity' => (float) ($item['quantity'] ?? 0),
            'unit_price' => (float) ($item['unit_price'] ?? 0),
            'line_total' => (float) ($item['line_total'] ?? (($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0))),
        ])->values()->all();
    }

    private function normalizedProItems(array $items): array
    {
        return collect($items)->map(fn (array $item) => [
            'name' => $item['name'] ?? 'Pièce',
            'quantity' => (float) ($item['quantity'] ?? 0),
            'unit_price' => (float) ($item['unit_price_ht'] ?? 0),
            'line_total' => (float) ($item['line_total_ht'] ?? (($item['quantity'] ?? 0) * ($item['unit_price_ht'] ?? 0))),
        ])->values()->all();
    }

    private function appendAdjustment(array $items, ?string $label, float $amount): array
    {
        if (abs($amount) < 0.0001) {
            return $items;
        }

        $items[] = [
            'name' => $label ?: 'Ajustement commercial',
            'quantity' => 1,
            'unit_price' => $amount,
            'line_total' => $amount,
        ];

        return $items;
    }

    private function render(array $data): string
    {
        $pdf = new SimplePdfDocument();
        $cursor = $this->startPage($pdf, $data);
        $cursor = $this->partyBlocks($pdf, $data, $cursor);
        $cursor = $this->contextBlock($pdf, $data, $cursor);
        $cursor = $this->itemsTable($pdf, $data, $cursor);
        $cursor = $this->totalsBlock($pdf, $data, $cursor);
        $this->notesAndFooter($pdf, $data, $cursor);

        return $pdf->output();
    }

    private function startPage(SimplePdfDocument $pdf, array $data): float
    {
        $pdf->addPage();
        $pdf->fillRect(0, 0, 595.28, 112, self::BURGUNDY);
        $pdf->fillRect(0, 108, 595.28, 4, self::GOLD);
        $pdf->text(42, 38, strtoupper($data['seller']['brand'] ?? 'WAGYU FRANCE'), 10, 'bold', self::GOLD);
        $pdf->text(42, 72, $data['title'], 25, 'serif-bold', [255, 255, 255]);
        $pdf->text(410, 39, 'RÉFÉRENCE', 8, 'bold', [224, 204, 174]);
        $pdf->text(410, 57, (string) ($data['number'] ?? '—'), 11, 'bold', [255, 255, 255]);
        $pdf->text(410, 80, 'DATE', 8, 'bold', [224, 204, 174]);
        $pdf->text(410, 98, (string) ($data['date'] ?? now()->format('d/m/Y')), 10, 'regular', [255, 255, 255]);

        return 138;
    }

    private function partyBlocks(SimplePdfDocument $pdf, array $data, float $top): float
    {
        $this->infoBox($pdf, 42, $top, 246, 'ÉMETTEUR', [
            $data['seller']['legal_name'] ?: $data['seller']['brand'],
            $data['seller']['legal_form'],
            $data['seller']['address'],
            $data['seller']['siret'] ? 'SIRET : ' . $data['seller']['siret'] : null,
            $data['seller']['vat_number'] ? 'TVA : ' . $data['seller']['vat_number'] : null,
            $data['seller']['email'],
            $data['seller']['phone'],
        ]);

        $this->infoBox($pdf, 307, $top, 246, 'CLIENT', [
            $data['customer']['company'],
            $data['customer']['name'],
            $data['customer']['address'],
            $data['customer']['email'],
            $data['customer']['phone'],
        ]);

        return $top + 116;
    }

    private function infoBox(SimplePdfDocument $pdf, float $x, float $top, float $width, string $label, array $lines): void
    {
        $pdf->fillRect($x, $top, $width, 98, self::PAPER);
        $pdf->strokeRect($x, $top, $width, 98, self::LINE, 0.8);
        $pdf->text($x + 14, $top + 20, $label, 8, 'bold', self::GOLD);

        $cursor = $top + 39;
        foreach (array_values(array_filter($lines, fn ($line) => filled($line))) as $index => $line) {
            $pdf->text($x + 14, $cursor, (string) $line, $index === 0 ? 10 : 8.5, $index === 0 ? 'bold' : 'regular', self::INK);
            $cursor += 12;
            if ($cursor > $top + 89) {
                break;
            }
        }
    }

    private function contextBlock(SimplePdfDocument $pdf, array $data, float $top): float
    {
        $items = array_values(array_filter($data['context'] ?? [], fn ($item) => filled($item['value'] ?? null)));
        if ($items === []) {
            return $top;
        }

        $height = 50;
        $pdf->fillRect(42, $top, 511, $height, [255, 255, 255]);
        $pdf->strokeRect(42, $top, 511, $height, self::LINE, 0.8);
        $columnWidth = 511 / max(1, count($items));

        foreach ($items as $index => $item) {
            $x = 42 + ($columnWidth * $index);
            if ($index > 0) {
                $pdf->line($x, $top + 8, $x, $top + 42, self::LINE, 0.7);
            }
            $pdf->text($x + 12, $top + 18, strtoupper((string) $item['label']), 7.5, 'bold', self::MUTED);
            $pdf->text($x + 12, $top + 36, (string) $item['value'], 9, 'bold', self::INK);
        }

        return $top + $height + 22;
    }

    private function itemsTable(SimplePdfDocument $pdf, array $data, float $top): float
    {
        $preparation = ($data['type'] ?? null) === 'preparation';
        $cursor = $this->tableHeader($pdf, $top, $preparation);

        foreach ($data['items'] ?? [] as $index => $item) {
            if ($cursor > 715) {
                $this->pageFooter($pdf, $data);
                $cursor = $this->tableHeader($pdf, $this->startContinuationPage($pdf, $data), $preparation);
            }

            $rowHeight = 30;
            if ($index % 2 === 0) {
                $pdf->fillRect(42, $cursor, 511, $rowHeight, [252, 250, 247]);
            }

            $pdf->text(52, $cursor + 19, (string) ($item['name'] ?? 'Produit'), 9, 'bold', self::INK);
            $pdf->text(329, $cursor + 19, $this->quantity((float) ($item['quantity'] ?? 0)), 9, 'regular', self::INK);

            if (! $preparation) {
                $pdf->text(407, $cursor + 19, $this->money((float) ($item['unit_price'] ?? 0)), 8.5, 'regular', self::INK);
                $pdf->text(494, $cursor + 19, $this->money((float) ($item['line_total'] ?? 0)), 8.5, 'bold', self::INK);
            } else {
                $pdf->text(407, $cursor + 19, 'À préparer / contrôler', 8.5, 'regular', self::MUTED);
            }

            $pdf->line(42, $cursor + $rowHeight, 553, $cursor + $rowHeight, self::LINE, 0.5);
            $cursor += $rowHeight;
        }

        return $cursor + 18;
    }

    private function tableHeader(SimplePdfDocument $pdf, float $top, bool $preparation): float
    {
        $pdf->fillRect(42, $top, 511, 28, self::BURGUNDY);
        $pdf->text(52, $top + 18, 'PIÈCE / PRODUIT', 8, 'bold', [255, 255, 255]);
        $pdf->text(329, $top + 18, 'QUANTITÉ', 8, 'bold', [255, 255, 255]);
        $pdf->text(407, $top + 18, $preparation ? 'CONTRÔLE' : 'PRIX UNIT.', 8, 'bold', [255, 255, 255]);
        if (! $preparation) {
            $pdf->text(494, $top + 18, 'TOTAL', 8, 'bold', [255, 255, 255]);
        }

        return $top + 28;
    }

    private function totalsBlock(SimplePdfDocument $pdf, array $data, float $top): float
    {
        if (($data['type'] ?? null) === 'preparation') {
            return $top;
        }

        if ($top > 670) {
            $this->pageFooter($pdf, $data);
            $top = $this->startContinuationPage($pdf, $data);
        }

        $amounts = $data['amounts'] ?? [];
        $x = 343;
        $width = 210;
        $pdf->fillRect($x, $top, $width, 104, self::PAPER);
        $pdf->strokeRect($x, $top, $width, 104, self::LINE, 0.8);

        $prefix = ($amounts['is_estimate'] ?? false) ? 'ESTIMATIF ' : '';
        $rows = [
            [$prefix . 'TOTAL HT', $this->money((float) ($amounts['total_ht'] ?? 0))],
            ['TVA ' . $this->percent((float) ($amounts['vat_rate'] ?? 0)), $this->money((float) ($amounts['vat_amount'] ?? 0))],
            [$prefix . 'TOTAL TTC', $this->money((float) ($amounts['total_ttc'] ?? 0))],
        ];

        foreach ($rows as $index => [$label, $value]) {
            $rowTop = $top + 24 + ($index * 28);
            $pdf->text($x + 14, $rowTop, $label, $index === 2 ? 9 : 8, 'bold', $index === 2 ? self::BURGUNDY : self::MUTED);
            $pdf->text($x + 130, $rowTop, $value, $index === 2 ? 11 : 9, 'bold', self::INK);
            if ($index < 2) {
                $pdf->line($x + 14, $rowTop + 9, $x + $width - 14, $rowTop + 9, self::LINE, 0.5);
            }
        }

        return $top + 122;
    }

    private function notesAndFooter(SimplePdfDocument $pdf, array $data, float $top): void
    {
        $cursor = $top;
        foreach ([
            'NOTES' => $data['notes'] ?? null,
            'CONDITIONS DE PAIEMENT' => $data['payment_terms'] ?? null,
            'COORDONNÉES DE PAIEMENT' => $data['bank_details'] ?? null,
        ] as $label => $text) {
            if (! filled($text)) {
                continue;
            }

            if ($cursor > 720) {
                $this->pageFooter($pdf, $data);
                $cursor = $this->startContinuationPage($pdf, $data);
            }

            $pdf->text(42, $cursor, $label, 8, 'bold', self::GOLD);
            $cursor = $pdf->wrappedText(42, $cursor + 17, (string) $text, 511, 8.5, 'regular', self::MUTED, 12);
            $cursor += 12;
        }

        $this->pageFooter($pdf, $data);
    }

    private function startContinuationPage(SimplePdfDocument $pdf, array $data): float
    {
        $pdf->addPage();
        $pdf->fillRect(0, 0, 595.28, 68, self::BURGUNDY);
        $pdf->text(42, 28, strtoupper($data['seller']['brand'] ?? 'WAGYU FRANCE'), 9, 'bold', self::GOLD);
        $pdf->text(42, 50, $data['title'] . ' · suite', 16, 'serif-bold', [255, 255, 255]);
        $pdf->text(425, 43, (string) ($data['number'] ?? '—'), 9, 'bold', [255, 255, 255]);

        return 92;
    }

    private function pageFooter(SimplePdfDocument $pdf, array $data): void
    {
        $pdf->line(42, 796, 553, 796, self::LINE, 0.6);
        $pdf->text(42, 815, (string) ($data['footer'] ?? 'Wagyu France'), 7.5, 'regular', self::MUTED);
        $pdf->text(405, 815, 'Document ' . ($data['number'] ?? '—'), 7.5, 'regular', self::MUTED);
    }

    private function seller(): array
    {
        return [
            'brand' => SiteSetting::valueFor('brand_name', 'Wagyu France'),
            'legal_name' => SiteSetting::valueFor('legal_company_name'),
            'legal_form' => SiteSetting::valueFor('legal_company_form'),
            'address' => SiteSetting::valueFor('legal_company_address', SiteSetting::valueFor('withdrawal_address')),
            'siret' => SiteSetting::valueFor('legal_company_siret'),
            'vat_number' => SiteSetting::valueFor('legal_vat_number'),
            'email' => SiteSetting::valueFor('contact_email'),
            'phone' => SiteSetting::valueFor('contact_phone'),
        ];
    }

    private function defaultVatRate(): float
    {
        return (float) SiteSetting::valueFor('default_vat_rate', 0);
    }

    private function fromTtc(float $totalTtc, float $vatRate): array
    {
        if ($vatRate <= 0) {
            return [$totalTtc, 0.0];
        }

        $totalHt = round($totalTtc / (1 + ($vatRate / 100)), 2);

        return [$totalHt, round($totalTtc - $totalHt, 2)];
    }

    private function money(float $value): string
    {
        return number_format($value, 2, ',', ' ') . ' €';
    }

    private function quantity(float $value): string
    {
        return number_format($value, 3, ',', ' ') . ' kg';
    }

    private function percent(float $value): string
    {
        return number_format($value, 2, ',', ' ') . ' %';
    }

    private function statusLabel(string $status): string
    {
        return [
            'nouvelle' => 'Nouvelle',
            'en_cours' => 'En cours',
            'confirmee' => 'Confirmée',
            'traitee' => 'Traitée',
            'annulee' => 'Annulée',
        ][$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    private function paymentLabel(?string $status): string
    {
        return [
            'pending' => 'À régler',
            'partial' => 'Partiellement réglé',
            'paid' => 'Réglé',
            'refunded' => 'Remboursé',
        ][$status ?: 'pending'] ?? ucfirst((string) $status);
    }
}

<?php

namespace App\Services;

use App\Models\CreditNote;
use App\Services\Pdf\SimplePdfDocument;

class CreditNotePdfService
{
    private const BURGUNDY = [88, 24, 24];
    private const GOLD = [181, 139, 76];
    private const INK = [36, 31, 27];
    private const MUTED = [103, 93, 84];
    private const PAPER = [248, 245, 239];
    private const LINE = [218, 210, 198];

    public function make(CreditNote $creditNote): string
    {
        $data = $creditNote->snapshot ?? [];
        $seller = $data['seller'] ?? [];
        $customer = $data['customer'] ?? [];

        $pdf = new SimplePdfDocument();
        $pdf->addPage();

        $pdf->fillRect(0, 0, 595.28, 112, self::BURGUNDY);
        $pdf->fillRect(0, 108, 595.28, 4, self::GOLD);
        $pdf->text(42, 38, strtoupper((string) ($seller['brand'] ?? 'WAGYU FRANCE')), 10, 'bold', self::GOLD);
        $pdf->text(42, 72, 'Avoir', 27, 'serif-bold', [255, 255, 255]);
        $pdf->text(410, 38, 'NUMÉRO', 8, 'bold', [224, 204, 174]);
        $pdf->text(410, 57, $creditNote->number, 11, 'bold', [255, 255, 255]);
        $pdf->text(410, 80, 'DATE', 8, 'bold', [224, 204, 174]);
        $pdf->text(410, 98, $creditNote->issued_at?->format('d/m/Y') ?? now()->format('d/m/Y'), 10, 'regular', [255, 255, 255]);

        $this->infoBox($pdf, 42, 138, 246, 'ÉMETTEUR', [
            $seller['legal_name'] ?? ($seller['brand'] ?? 'Wagyu France'),
            $seller['legal_form'] ?? null,
            $seller['address'] ?? null,
            ! empty($seller['siret']) ? 'SIRET : ' . $seller['siret'] : null,
            ! empty($seller['vat_number']) ? 'TVA : ' . $seller['vat_number'] : null,
            $seller['email'] ?? null,
            $seller['phone'] ?? null,
        ]);

        $this->infoBox($pdf, 307, 138, 246, 'CLIENT', [
            $customer['company'] ?? null,
            $customer['name'] ?? null,
            $customer['address'] ?? null,
            $customer['email'] ?? null,
            $customer['phone'] ?? null,
        ]);

        $pdf->fillRect(42, 258, 511, 70, self::PAPER);
        $pdf->strokeRect(42, 258, 511, 70, self::LINE, 0.8);
        $pdf->text(56, 278, 'DOCUMENT RECTIFIÉ', 8, 'bold', self::GOLD);
        $pdf->text(56, 299, 'Facture ' . $creditNote->invoice_number, 13, 'bold', self::INK);
        $pdf->text(320, 278, 'DOSSIER', 8, 'bold', self::GOLD);
        $pdf->text(320, 299, (string) ($data['request_reference'] ?? '—'), 11, 'bold', self::INK);

        $pdf->fillRect(42, 352, 511, 42, self::BURGUNDY);
        $pdf->text(56, 378, 'MOTIF DE L’AVOIR', 8, 'bold', [245, 224, 193]);
        $cursor = $pdf->wrappedText(56, 420, $creditNote->reason, 483, 10, 'regular', self::INK, 14);

        $cursor = max($cursor + 20, 485);
        $pdf->line(310, $cursor, 553, $cursor, self::LINE, 0.8);
        $pdf->text(326, $cursor + 26, 'Montant HT', 9, 'regular', self::MUTED);
        $pdf->text(470, $cursor + 26, $this->money((float) $creditNote->amount_ht), 10, 'bold', self::INK);
        $pdf->text(326, $cursor + 50, 'TVA (' . $this->percent((float) $creditNote->vat_rate) . ')', 9, 'regular', self::MUTED);
        $pdf->text(470, $cursor + 50, $this->money((float) $creditNote->vat_amount), 10, 'bold', self::INK);
        $pdf->fillRect(310, $cursor + 66, 243, 48, self::BURGUNDY);
        $pdf->text(326, $cursor + 95, 'TOTAL TTC CRÉDITÉ', 9, 'bold', [245, 224, 193]);
        $pdf->text(451, $cursor + 95, $this->money((float) $creditNote->amount_ttc), 13, 'bold', [255, 255, 255]);

        $footerTop = min(745, $cursor + 150);
        $pdf->line(42, $footerTop, 553, $footerTop, self::LINE, 0.8);
        $pdf->wrappedText(
            42,
            $footerTop + 22,
            'Cet avoir diminue tout ou partie de la facture indiquée ci-dessus. Il doit être conservé avec la facture d’origine.',
            511,
            8.5,
            'regular',
            self::MUTED,
            12
        );

        return $pdf->output();
    }

    private function infoBox(SimplePdfDocument $pdf, float $x, float $top, float $width, string $label, array $lines): void
    {
        $pdf->fillRect($x, $top, $width, 98, self::PAPER);
        $pdf->strokeRect($x, $top, $width, 98, self::LINE, 0.8);
        $pdf->text($x + 14, $top + 20, $label, 8, 'bold', self::GOLD);

        $cursor = $top + 40;
        foreach (array_values(array_filter($lines, fn ($line) => filled($line))) as $line) {
            $pdf->text($x + 14, $cursor, (string) $line, 8.5, 'regular', self::INK);
            $cursor += 12;

            if ($cursor > $top + 88) {
                break;
            }
        }
    }

    private function money(float $value): string
    {
        return number_format($value, 2, ',', ' ') . ' €';
    }

    private function percent(float $value): string
    {
        return number_format($value, 2, ',', ' ') . ' %';
    }
}

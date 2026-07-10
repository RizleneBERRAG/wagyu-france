<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Models\SiteSetting;
use App\Services\CommercialDocumentPdfService;
use App\Services\DocumentSequenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommercialDocumentController extends Controller
{
    public function showShop(ShopOrderRequest $shopOrderRequest): View
    {
        return view('admin.requests.show', $this->viewData('shop', $shopOrderRequest));
    }

    public function showPro(ProReservationRequest $proReservationRequest): View
    {
        return view('admin.requests.show', $this->viewData('pro', $proReservationRequest));
    }

    public function updateShop(Request $request, ShopOrderRequest $shopOrderRequest): RedirectResponse
    {
        $data = $request->validate([
            'final_total_ttc' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'vat_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'payment_status' => ['required', 'in:pending,partial,paid,refunded'],
            'paid_at' => ['nullable', 'date'],
            'document_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($shopOrderRequest->invoice_number) {
            unset($data['final_total_ttc'], $data['vat_rate']);
        }

        $data = $this->normalizePaymentData($data, $shopOrderRequest->paid_at);
        $shopOrderRequest->update($data);

        return back()->with('success', 'Les informations commerciales de la commande ont été enregistrées.');
    }

    public function updatePro(Request $request, ProReservationRequest $proReservationRequest): RedirectResponse
    {
        $data = $request->validate([
            'final_total_ht' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'vat_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'payment_status' => ['required', 'in:pending,partial,paid,refunded'],
            'paid_at' => ['nullable', 'date'],
            'document_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($proReservationRequest->invoice_number) {
            unset($data['final_total_ht'], $data['vat_rate']);
        }

        $data = $this->normalizePaymentData($data, $proReservationRequest->paid_at);
        $proReservationRequest->update($data);

        return back()->with('success', 'Les informations commerciales de la demande professionnelle ont été enregistrées.');
    }

    public function issueShopInvoice(
        ShopOrderRequest $shopOrderRequest,
        DocumentSequenceService $sequence,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        if ($shopOrderRequest->invoice_number) {
            return back()->with('success', 'La facture ' . $shopOrderRequest->invoice_number . ' est déjà émise.');
        }

        $this->assertInvoiceCanBeIssued(
            $shopOrderRequest->status,
            $shopOrderRequest->final_total_ttc,
            $shopOrderRequest->vat_rate
        );

        DB::transaction(function () use ($shopOrderRequest, $sequence, $documents) {
            $shopOrderRequest->refresh();

            if ($shopOrderRequest->invoice_number) {
                return;
            }

            $number = $sequence->nextInvoiceNumber();
            $snapshot = $documents->shopInvoiceSnapshot($shopOrderRequest, $number);

            $shopOrderRequest->update([
                'invoice_number' => $number,
                'invoice_issued_at' => now(),
                'invoice_snapshot' => $snapshot,
            ]);
        });

        return back()->with('success', 'La facture a été émise. Son numéro est maintenant définitif.');
    }

    public function issueProInvoice(
        ProReservationRequest $proReservationRequest,
        DocumentSequenceService $sequence,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        if ($proReservationRequest->invoice_number) {
            return back()->with('success', 'La facture ' . $proReservationRequest->invoice_number . ' est déjà émise.');
        }

        $this->assertInvoiceCanBeIssued(
            $proReservationRequest->status,
            $proReservationRequest->final_total_ht,
            $proReservationRequest->vat_rate
        );

        DB::transaction(function () use ($proReservationRequest, $sequence, $documents) {
            $proReservationRequest->refresh();

            if ($proReservationRequest->invoice_number) {
                return;
            }

            $number = $sequence->nextInvoiceNumber();
            $snapshot = $documents->proInvoiceSnapshot($proReservationRequest, $number);

            $proReservationRequest->update([
                'invoice_number' => $number,
                'invoice_issued_at' => now(),
                'invoice_snapshot' => $snapshot,
            ]);
        });

        return back()->with('success', 'La facture professionnelle a été émise avec un numéro définitif.');
    }

    public function shopPdf(
        ShopOrderRequest $shopOrderRequest,
        string $document,
        CommercialDocumentPdfService $documents
    ): Response {
        $this->assertDocumentType($document, $shopOrderRequest->invoice_number);

        return $this->pdfResponse(
            $documents->shop($shopOrderRequest, $document),
            $this->filename($document, $document === 'invoice' ? $shopOrderRequest->invoice_number : $shopOrderRequest->reference)
        );
    }

    public function proPdf(
        ProReservationRequest $proReservationRequest,
        string $document,
        CommercialDocumentPdfService $documents
    ): Response {
        $this->assertDocumentType($document, $proReservationRequest->invoice_number);

        return $this->pdfResponse(
            $documents->pro($proReservationRequest, $document),
            $this->filename($document, $document === 'invoice' ? $proReservationRequest->invoice_number : $proReservationRequest->reference)
        );
    }

    private function viewData(string $kind, ShopOrderRequest|ProReservationRequest $requestItem): array
    {
        $isShop = $kind === 'shop';
        $baseTotal = $isShop ? (float) $requestItem->total : (float) $requestItem->total_ht;
        $finalTotal = $isShop
            ? ($requestItem->final_total_ttc !== null ? (float) $requestItem->final_total_ttc : null)
            : ($requestItem->final_total_ht !== null ? (float) $requestItem->final_total_ht : null);
        $vatRate = $requestItem->vat_rate !== null
            ? (float) $requestItem->vat_rate
            : (float) SiteSetting::valueFor('default_vat_rate', 0);

        return [
            'kind' => $kind,
            'requestItem' => $requestItem,
            'baseTotal' => $baseTotal,
            'finalTotal' => $finalTotal,
            'vatRate' => $vatRate,
            'paymentStatuses' => [
                'pending' => 'À régler',
                'partial' => 'Partiellement réglé',
                'paid' => 'Réglé',
                'refunded' => 'Remboursé',
            ],
            'statusLabels' => [
                'nouvelle' => 'Nouvelle',
                'en_cours' => 'En cours',
                'confirmee' => 'Confirmée',
                'traitee' => 'Traitée',
                'annulee' => 'Annulée',
            ],
            'invoiceReady' => $this->invoiceRequirements($requestItem->status, $finalTotal, $requestItem->vat_rate),
            'legalReady' => $this->legalReady(),
        ];
    }

    private function normalizePaymentData(array $data, mixed $existingPaidAt): array
    {
        if ($data['payment_status'] === 'paid' && empty($data['paid_at'])) {
            $data['paid_at'] = $existingPaidAt ?: now();
        }

        if ($data['payment_status'] === 'pending') {
            $data['paid_at'] = null;
        }

        return $data;
    }

    private function assertInvoiceCanBeIssued(string $status, mixed $finalTotal, mixed $vatRate): void
    {
        $errors = $this->invoiceRequirements($status, $finalTotal, $vatRate);

        if (! $this->legalReady()) {
            $errors[] = 'Complétez la dénomination légale, l’adresse et le SIRET dans les paramètres.';
        }

        if ($errors !== []) {
            abort(422, implode(' ', $errors));
        }
    }

    private function invoiceRequirements(string $status, mixed $finalTotal, mixed $vatRate): array
    {
        $errors = [];

        if (! in_array($status, ['confirmee', 'traitee'], true)) {
            $errors[] = 'Le dossier doit être confirmé ou traité avant l’émission.';
        }

        if ($finalTotal === null || (float) $finalTotal <= 0) {
            $errors[] = 'Renseignez un montant final supérieur à zéro.';
        }

        if ($vatRate === null || (float) $vatRate < 0) {
            $errors[] = 'Renseignez le taux de TVA applicable, y compris 0 si nécessaire.';
        }

        return $errors;
    }

    private function legalReady(): bool
    {
        return filled(SiteSetting::valueFor('legal_company_name'))
            && filled(SiteSetting::valueFor('legal_company_address'))
            && filled(SiteSetting::valueFor('legal_company_siret'));
    }

    private function assertDocumentType(string $document, ?string $invoiceNumber): void
    {
        abort_unless(in_array($document, ['order', 'preparation', 'invoice'], true), 404);
        abort_if($document === 'invoice' && blank($invoiceNumber), 404, 'La facture n’a pas encore été émise.');
    }

    private function pdfResponse(string $content, string $filename): Response
    {
        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => (string) strlen($content),
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    private function filename(string $type, ?string $reference): string
    {
        $label = [
            'order' => 'bon-commande',
            'preparation' => 'bon-preparation',
            'invoice' => 'facture',
        ][$type] ?? 'document';

        $reference = preg_replace('/[^A-Za-z0-9_-]/', '-', (string) $reference) ?: 'wagyu-france';

        return $label . '-' . $reference . '.pdf';
    }
}

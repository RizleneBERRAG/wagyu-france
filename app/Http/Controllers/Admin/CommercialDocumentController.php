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
use Illuminate\Validation\ValidationException;
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
        if ($shopOrderRequest->invoice_number || $shopOrderRequest->stock_applied_at) {
            $shopOrderRequest->update($this->paymentAndNotesData($request, $shopOrderRequest->paid_at));

            $reason = $shopOrderRequest->invoice_number
                ? 'la facture est déjà émise'
                : 'le stock correspondant est déjà engagé';

            return back()->with(
                'success',
                'Le suivi de paiement et les notes ont été mis à jour. Les lignes restent verrouillées car ' . $reason . '.'
            );
        }

        $data = $this->commercialData($request, $shopOrderRequest->paid_at);
        $finalCart = $this->finalCart($data['items']);
        $additionalAmount = round((float) ($data['additional_amount'] ?? 0), 2);
        $this->validateAdjustmentLabel($additionalAmount, $data['additional_label'] ?? null);
        $finalTotal = round(collect($finalCart)->sum('line_total') + $additionalAmount, 2);

        if ($finalTotal <= 0) {
            throw ValidationException::withMessages([
                'items' => 'Le montant final calculé doit être supérieur à zéro.',
            ]);
        }

        $shopOrderRequest->update([
            'final_cart' => $finalCart,
            'additional_label' => $data['additional_label'] ?? null,
            'additional_amount' => $additionalAmount,
            'final_total_ttc' => $finalTotal,
            'vat_rate' => $data['vat_rate'],
            'payment_status' => $data['payment_status'],
            'paid_at' => $data['paid_at'] ?? null,
            'document_notes' => $data['document_notes'] ?? null,
        ]);

        return back()->with('success', 'Les lignes finales, la TVA et le suivi commercial de la commande ont été enregistrés.');
    }

    public function updatePro(Request $request, ProReservationRequest $proReservationRequest): RedirectResponse
    {
        if ($proReservationRequest->invoice_number) {
            $proReservationRequest->update($this->paymentAndNotesData($request, $proReservationRequest->paid_at));

            return back()->with('success', 'Le suivi de paiement et les notes ont été mis à jour. Les données facturées restent verrouillées.');
        }

        $data = $this->commercialData($request, $proReservationRequest->paid_at);
        $finalCart = $this->finalCart($data['items']);
        $additionalAmount = round((float) ($data['additional_amount'] ?? 0), 2);
        $this->validateAdjustmentLabel($additionalAmount, $data['additional_label'] ?? null);
        $finalTotal = round(collect($finalCart)->sum('line_total') + $additionalAmount, 2);

        if ($finalTotal <= 0) {
            throw ValidationException::withMessages([
                'items' => 'Le montant final calculé doit être supérieur à zéro.',
            ]);
        }

        $proReservationRequest->update([
            'final_cart' => $finalCart,
            'additional_label' => $data['additional_label'] ?? null,
            'additional_amount' => $additionalAmount,
            'final_total_ht' => $finalTotal,
            'vat_rate' => $data['vat_rate'],
            'payment_status' => $data['payment_status'],
            'paid_at' => $data['paid_at'] ?? null,
            'document_notes' => $data['document_notes'] ?? null,
        ]);

        return back()->with('success', 'Les lignes finales, la TVA et le suivi commercial de la demande professionnelle ont été enregistrés.');
    }

    public function issueShopInvoice(
        ShopOrderRequest $shopOrderRequest,
        DocumentSequenceService $sequence,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        if ($shopOrderRequest->invoice_number) {
            return back()->with('success', 'La facture ' . $shopOrderRequest->invoice_number . ' est déjà émise.');
        }

        if ($response = $this->invoiceErrorResponse(
            $shopOrderRequest->status,
            $shopOrderRequest->final_total_ttc,
            $shopOrderRequest->vat_rate,
            $shopOrderRequest->final_cart,
            (bool) $shopOrderRequest->stock_applied_at
        )) {
            return $response;
        }

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

        return back()->with('success', 'La facture a été émise. Son numéro et ses lignes sont maintenant définitifs.');
    }

    public function issueProInvoice(
        ProReservationRequest $proReservationRequest,
        DocumentSequenceService $sequence,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        if ($proReservationRequest->invoice_number) {
            return back()->with('success', 'La facture ' . $proReservationRequest->invoice_number . ' est déjà émise.');
        }

        if ($response = $this->invoiceErrorResponse(
            $proReservationRequest->status,
            $proReservationRequest->final_total_ht,
            $proReservationRequest->vat_rate,
            $proReservationRequest->final_cart
        )) {
            return $response;
        }

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

        return back()->with('success', 'La facture professionnelle a été émise avec un numéro et des lignes définitifs.');
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
        $finalItems = $requestItem->final_cart ?: $this->initialFinalCart($requestItem->cart ?? [], $isShop);
        $commercialLocked = filled($requestItem->invoice_number)
            || ($isShop && filled($requestItem->stock_applied_at));
        $stockReady = ! $isShop || filled($requestItem->stock_applied_at);

        return [
            'kind' => $kind,
            'requestItem' => $requestItem,
            'baseTotal' => $baseTotal,
            'finalTotal' => $finalTotal,
            'vatRate' => $vatRate,
            'finalItems' => $finalItems,
            'commercialLocked' => $commercialLocked,
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
            'invoiceReady' => $this->invoiceRequirements(
                $requestItem->status,
                $finalTotal,
                $requestItem->vat_rate,
                $requestItem->final_cart,
                $stockReady
            ),
            'legalReady' => $this->legalReady(),
        ];
    }

    private function commercialData(Request $request, mixed $existingPaidAt): array
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.key' => ['required', 'string', 'max:120'],
            'items.*.name' => ['required', 'string', 'max:190'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0', 'max:99999'],
            'additional_label' => ['nullable', 'string', 'max:190'],
            'additional_amount' => ['nullable', 'numeric', 'min:-999999.99', 'max:999999.99'],
            'vat_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'payment_status' => ['required', 'in:pending,partial,paid,refunded'],
            'paid_at' => ['nullable', 'date'],
            'document_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        return $this->normalizePaymentData($data, $existingPaidAt);
    }

    private function paymentAndNotesData(Request $request, mixed $existingPaidAt): array
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:pending,partial,paid,refunded'],
            'paid_at' => ['nullable', 'date'],
            'document_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        return $this->normalizePaymentData($data, $existingPaidAt);
    }

    private function finalCart(array $items): array
    {
        return collect($items)->map(function (array $item) {
            $quantity = round((float) $item['quantity'], 3);
            $unitPrice = round((float) $item['unit_price'], 2);

            return [
                'key' => $item['key'],
                'name' => $item['name'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => round($quantity * $unitPrice, 2),
            ];
        })->values()->all();
    }

    private function initialFinalCart(array $cart, bool $isShop): array
    {
        return collect($cart)->map(function (array $item) use ($isShop) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $unitPrice = (float) ($isShop ? ($item['unit_price'] ?? 0) : ($item['unit_price_ht'] ?? 0));

            return [
                'key' => $item['key'] ?? str($item['name'] ?? 'piece')->slug()->toString(),
                'name' => $item['name'] ?? 'Pièce',
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => round($quantity * $unitPrice, 2),
            ];
        })->values()->all();
    }

    private function validateAdjustmentLabel(float $amount, ?string $label): void
    {
        if (abs($amount) > 0.0001 && blank($label)) {
            throw ValidationException::withMessages([
                'additional_label' => 'Précisez le libellé de la ligne supplémentaire ou de la remise.',
            ]);
        }
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

    private function invoiceErrorResponse(
        string $status,
        mixed $finalTotal,
        mixed $vatRate,
        mixed $finalCart,
        bool $stockReady = true
    ): ?RedirectResponse {
        $errors = $this->invoiceRequirements($status, $finalTotal, $vatRate, $finalCart, $stockReady);

        if (! $this->legalReady()) {
            $errors[] = 'Complétez la dénomination légale, l’adresse et le SIRET dans les paramètres.';
        }

        return $errors === []
            ? null
            : back()->withErrors(['invoice' => implode(' ', $errors)]);
    }

    private function invoiceRequirements(
        string $status,
        mixed $finalTotal,
        mixed $vatRate,
        mixed $finalCart,
        bool $stockReady = true
    ): array {
        $errors = [];

        if (! in_array($status, ['confirmee', 'traitee'], true)) {
            $errors[] = 'Le dossier doit être confirmé ou traité avant l’émission.';
        }

        if (! is_array($finalCart) || $finalCart === []) {
            $errors[] = 'Enregistrez les quantités et prix finaux de chaque ligne.';
        }

        if ($finalTotal === null || (float) $finalTotal <= 0) {
            $errors[] = 'Le montant final calculé doit être supérieur à zéro.';
        }

        if ($vatRate === null || (float) $vatRate < 0) {
            $errors[] = 'Renseignez le taux de TVA applicable, y compris 0 si nécessaire.';
        }

        if (! $stockReady) {
            $errors[] = 'Confirmez la commande afin de réserver les quantités finales en stock.';
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

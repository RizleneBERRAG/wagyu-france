<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CommercialPdfMail;
use App\Models\CreditNote;
use App\Models\ProReservationRequest;
use App\Models\ShopOrderRequest;
use App\Services\CommercialDocumentPdfService;
use App\Services\CreditNotePdfService;
use App\Services\DocumentSequenceService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminBillingController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $kind = (string) $request->query('kind', 'all');

        $shopInvoices = ShopOrderRequest::query()
            ->with('creditNotes')
            ->whereNotNull('invoice_number')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('invoice_number', 'like', "%{$search}%")
                        ->orWhere('reference', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest('invoice_issued_at')
            ->get();

        $proInvoices = ProReservationRequest::query()
            ->with('creditNotes')
            ->whereNotNull('invoice_number')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('invoice_number', 'like', "%{$search}%")
                        ->orWhere('reference', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest('invoice_issued_at')
            ->get();

        return view('admin.billing.index', [
            'shopInvoices' => in_array($kind, ['all', 'shop'], true) ? $shopInvoices : collect(),
            'proInvoices' => in_array($kind, ['all', 'pro'], true) ? $proInvoices : collect(),
            'kind' => $kind,
            'counts' => [
                'shop' => ShopOrderRequest::whereNotNull('invoice_number')->count(),
                'pro' => ProReservationRequest::whereNotNull('invoice_number')->count(),
                'credits' => CreditNote::count(),
                'unsent' => ShopOrderRequest::whereNotNull('invoice_number')->whereNull('invoice_sent_at')->count()
                    + ProReservationRequest::whereNotNull('invoice_number')->whereNull('invoice_sent_at')->count(),
            ],
        ]);
    }

    public function issueShopCredit(
        Request $request,
        ShopOrderRequest $shopOrderRequest,
        DocumentSequenceService $sequence
    ): RedirectResponse {
        return $this->issueCredit($request, $shopOrderRequest, 'shop', $sequence);
    }

    public function issueProCredit(
        Request $request,
        ProReservationRequest $proReservationRequest,
        DocumentSequenceService $sequence
    ): RedirectResponse {
        return $this->issueCredit($request, $proReservationRequest, 'pro', $sequence);
    }

    public function sendShopInvoice(
        ShopOrderRequest $shopOrderRequest,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        abort_if(blank($shopOrderRequest->invoice_number), 404);

        $pdf = $documents->shop($shopOrderRequest, 'invoice');
        $filename = 'facture-' . $this->safeReference($shopOrderRequest->invoice_number) . '.pdf';

        return $this->sendDocument(
            $shopOrderRequest,
            'Votre facture Wagyu France — ' . $shopOrderRequest->invoice_number,
            'Votre facture',
            'Veuillez trouver en pièce jointe la facture correspondant à votre commande Wagyu France.',
            $shopOrderRequest->invoice_number,
            $pdf,
            $filename,
            function () use ($shopOrderRequest) {
                $shopOrderRequest->update(['invoice_sent_at' => now()]);
            }
        );
    }

    public function sendProInvoice(
        ProReservationRequest $proReservationRequest,
        CommercialDocumentPdfService $documents
    ): RedirectResponse {
        abort_if(blank($proReservationRequest->invoice_number), 404);

        $pdf = $documents->pro($proReservationRequest, 'invoice');
        $filename = 'facture-' . $this->safeReference($proReservationRequest->invoice_number) . '.pdf';

        return $this->sendDocument(
            $proReservationRequest,
            'Votre facture Wagyu France — ' . $proReservationRequest->invoice_number,
            'Votre facture professionnelle',
            'Veuillez trouver en pièce jointe la facture correspondant à votre dossier professionnel Wagyu France.',
            $proReservationRequest->invoice_number,
            $pdf,
            $filename,
            function () use ($proReservationRequest) {
                $proReservationRequest->update(['invoice_sent_at' => now()]);
            }
        );
    }

    public function creditPdf(CreditNote $creditNote, CreditNotePdfService $documents): Response
    {
        $content = $documents->make($creditNote);
        $filename = 'avoir-' . $this->safeReference($creditNote->number) . '.pdf';

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => (string) strlen($content),
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    public function sendCredit(CreditNote $creditNote, CreditNotePdfService $documents): RedirectResponse
    {
        $creditNote->loadMissing('documentable');
        $documentable = $creditNote->documentable;

        abort_if(! $documentable || blank($documentable->email), 422, 'Aucune adresse email n’est disponible.');

        $pdf = $documents->make($creditNote);
        $filename = 'avoir-' . $this->safeReference($creditNote->number) . '.pdf';

        return $this->sendDocument(
            $documentable,
            'Votre avoir Wagyu France — ' . $creditNote->number,
            'Votre avoir',
            'Veuillez trouver en pièce jointe l’avoir établi en rectification de la facture ' . $creditNote->invoice_number . '.',
            $creditNote->number,
            $pdf,
            $filename,
            function () use ($creditNote) {
                $creditNote->update(['sent_at' => now()]);
            }
        );
    }

    private function issueCredit(
        Request $request,
        ShopOrderRequest|ProReservationRequest $documentable,
        string $kind,
        DocumentSequenceService $sequence
    ): RedirectResponse {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'reason' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        if (blank($documentable->invoice_number) || empty($documentable->invoice_snapshot)) {
            return back()->withErrors(['credit' => 'La facture doit être émise avant de créer un avoir.']);
        }

        $credit = DB::transaction(function () use ($documentable, $kind, $validated, $sequence) {
            $locked = $documentable->newQuery()
                ->whereKey($documentable->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $snapshot = $locked->invoice_snapshot ?? [];
            $vatRate = (float) data_get($snapshot, 'amounts.vat_rate', $locked->vat_rate ?? 0);
            $invoiceBasis = $kind === 'shop'
                ? (float) data_get($snapshot, 'amounts.total_ttc', 0)
                : (float) data_get($snapshot, 'amounts.total_ht', 0);
            $alreadyCredited = $kind === 'shop'
                ? (float) $locked->creditNotes()->sum('amount_ttc')
                : (float) $locked->creditNotes()->sum('amount_ht');
            $remaining = max(0, round($invoiceBasis - $alreadyCredited, 2));
            $requestedAmount = round((float) $validated['amount'], 2);

            if ($invoiceBasis <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Le montant de la facture d’origine est invalide ou indisponible.',
                ]);
            }

            if ($remaining <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Cette facture est déjà intégralement créditée.',
                ]);
            }

            if ($requestedAmount > $remaining + 0.005) {
                throw ValidationException::withMessages([
                    'amount' => 'Le montant dépasse le solde encore créditable de ' . number_format($remaining, 2, ',', ' ') . ' €.',
                ]);
            }

            if ($kind === 'shop') {
                $amountTtc = $requestedAmount;
                $amountHt = $vatRate > 0 ? round($amountTtc / (1 + ($vatRate / 100)), 2) : $amountTtc;
                $vatAmount = round($amountTtc - $amountHt, 2);
            } else {
                $amountHt = $requestedAmount;
                $vatAmount = round($amountHt * ($vatRate / 100), 2);
                $amountTtc = round($amountHt + $vatAmount, 2);
            }

            $number = $sequence->nextCreditNumber();
            $creditSnapshot = [
                'seller' => data_get($snapshot, 'seller', []),
                'customer' => data_get($snapshot, 'customer', []),
                'request_reference' => $locked->reference,
                'invoice_number' => $locked->invoice_number,
                'credit_number' => $number,
                'reason' => $validated['reason'],
                'amounts' => [
                    'amount_ht' => $amountHt,
                    'vat_rate' => $vatRate,
                    'vat_amount' => $vatAmount,
                    'amount_ttc' => $amountTtc,
                ],
                'issued_at' => now()->toIso8601String(),
            ];

            $credit = $locked->creditNotes()->create([
                'number' => $number,
                'invoice_number' => $locked->invoice_number,
                'reason' => $validated['reason'],
                'amount_ht' => $amountHt,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'amount_ttc' => $amountTtc,
                'snapshot' => $creditSnapshot,
                'issued_at' => now(),
            ]);

            $newCreditedBasis = round($alreadyCredited + $requestedAmount, 2);
            if ($newCreditedBasis >= $invoiceBasis - 0.005) {
                $locked->update(['payment_status' => 'refunded']);
            }

            return $credit;
        }, 5);

        return back()->with('success', 'L’avoir ' . $credit->number . ' a été émis et peut maintenant être téléchargé ou envoyé.');
    }

    private function sendDocument(
        Model $recipientModel,
        string $subject,
        string $heading,
        string $intro,
        string $reference,
        string $pdf,
        string $filename,
        callable $afterSend
    ): RedirectResponse {
        try {
            Mail::to($recipientModel->email)->send(new CommercialPdfMail(
                $subject,
                $heading,
                $intro,
                $reference,
                $pdf,
                $filename
            ));

            if (config('mail.default') === 'log') {
                return back()->with('success', 'Email généré en mode test dans les logs. Le document n’est pas marqué comme réellement envoyé.');
            }

            $afterSend();

            return back()->with('success', 'Le document a été envoyé à ' . $recipientModel->email . '.');
        } catch (\Throwable $exception) {
            Log::error('Erreur envoi document commercial Wagyu France', [
                'reference' => $reference,
                'email' => $recipientModel->email,
                'error' => $exception->getMessage(),
            ]);

            return back()->withErrors([
                'email' => 'Le document n’a pas pu être envoyé. Vérifiez la configuration email du serveur.',
            ]);
        }
    }

    private function safeReference(?string $reference): string
    {
        return preg_replace('/[^A-Za-z0-9_-]/', '-', (string) $reference) ?: 'wagyu-france';
    }
}

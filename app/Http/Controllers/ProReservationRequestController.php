<?php

namespace App\Http\Controllers;

use App\Mail\ProReservationAdminMail;
use App\Mail\ProReservationCustomerMail;
use App\Models\AnimalBatch;
use App\Models\ProReservationRequest;
use App\Services\AdminDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProReservationRequestController extends Controller
{
    public function store(Request $request, AdminDashboardService $dashboard): JsonResponse
    {
        $batch = AnimalBatch::with('cuts')
            ->when(
                $request->filled('bovin_reference'),
                fn ($query) => $query->where('reference', (string) $request->input('bovin_reference'))
            )
            ->where('is_active', true)
            ->whereIn('status', ['open', 'ready'])
            ->first();

        if (! $batch) {
            return response()->json([
                'message' => 'Aucun animal n’est actuellement ouvert à la pré-réservation.',
                'errors' => ['bovin_reference' => ['La réserve professionnelle est momentanément fermée.']],
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'company' => ['required', 'string', 'max:190'],
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'professional_type' => ['required', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:3000'],
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.key' => ['required', 'string'],
            'cart.*.quantity' => ['required', 'numeric', 'min:0.1', 'max:999'],
        ], [
            'company.required' => 'Le nom de la société est obligatoire.',
            'fullname.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse email est obligatoire.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'professional_type.required' => 'Le type de professionnel est obligatoire.',
            'cart.required' => 'Le panier ne peut pas être vide.',
            'cart.min' => 'Le panier ne peut pas être vide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Certaines informations sont manquantes ou invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $cuts = $batch->cuts->where('is_active', true)->keyBy('slug');
        $cart = [];
        $errors = [];

        foreach ($validated['cart'] as $index => $item) {
            $cut = $cuts->get($item['key']);
            $quantity = (float) $item['quantity'];

            if (! $cut) {
                $errors["cart.{$index}.key"][] = 'Cette pièce n’est plus disponible sur l’animal actif.';
                continue;
            }

            if ($quantity < (float) $cut->min_quantity_kg) {
                $errors["cart.{$index}.quantity"][] = 'La quantité minimale pour ' . $cut->name . ' est de ' . number_format((float) $cut->min_quantity_kg, 1, ',', ' ') . ' kg.';
            }

            if ($quantity > (float) $cut->available_kg) {
                $errors["cart.{$index}.quantity"][] = 'La quantité demandée dépasse le volume indicatif de ' . $cut->name . '.';
            }

            $unitPrice = (float) $cut->price_per_kg;
            $cart[] = [
                'key' => $cut->slug,
                'name' => $cut->name,
                'quantity' => $quantity,
                'unit_price_ht' => $unitPrice,
                'line_total_ht' => $unitPrice * $quantity,
            ];
        }

        if ($errors !== []) {
            return response()->json([
                'message' => 'La sélection doit être ajustée avant l’envoi.',
                'errors' => $errors,
            ], 422);
        }

        $totalHt = collect($cart)->sum('line_total_ht');

        $reservation = ProReservationRequest::create([
            'reference' => $this->generateReference(),
            'bovin_reference' => $batch->reference,
            'company' => $validated['company'],
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'professional_type' => $validated['professional_type'],
            'city' => $validated['city'] ?? null,
            'message' => $validated['message'] ?? null,
            'cart' => $cart,
            'total_ht' => $totalHt,
            'status' => 'nouvelle',
        ]);

        $summary = $dashboard->activeBatchSummary();
        if ($summary && $summary['batch']->is($batch) && $summary['threshold_reached'] && $batch->status === 'open') {
            $batch->update(['status' => 'ready']);
        }

        $this->sendReservationEmails($reservation);

        return response()->json([
            'message' => 'Votre demande de pré-réservation a bien été enregistrée.',
            'reference' => $reservation->reference,
            'total_ht' => number_format($totalHt, 2, ',', ' ') . ' € HT',
        ], 201);
    }

    private function sendReservationEmails(ProReservationRequest $reservation): void
    {
        try {
            $adminEmail = env('WAGYU_PRO_EMAIL', config('mail.from.address'));

            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ProReservationAdminMail($reservation));
            }

            Mail::to($reservation->email)->send(new ProReservationCustomerMail($reservation));
        } catch (\Throwable $exception) {
            Log::warning('Erreur envoi email demande pro Wagyu France', [
                'reservation_id' => $reservation->id,
                'reference' => $reservation->reference,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function generateReference(): string
    {
        do {
            $reference = 'WF-PRO-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (ProReservationRequest::where('reference', $reference)->exists());

        return $reference;
    }
}

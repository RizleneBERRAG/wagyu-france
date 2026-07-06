<?php

namespace App\Http\Controllers;

use App\Mail\ProReservationAdminMail;
use App\Mail\ProReservationCustomerMail;
use App\Models\ProReservationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProReservationRequestController extends Controller
{
    private array $cuts = [
        'paleron' => [
            'name' => 'Paleron Wagyu',
            'price' => 143,
        ],
        'entrecote' => [
            'name' => 'Entrecôte Wagyu',
            'price' => 174,
        ],
        'fauxfilet' => [
            'name' => 'Faux-filet Wagyu',
            'price' => 174,
        ],
        'rumsteak' => [
            'name' => 'Rumsteak Wagyu',
            'price' => 137,
        ],
        'filet' => [
            'name' => 'Filet Wagyu',
            'price' => 198,
        ],
        'macreuse' => [
            'name' => 'Macreuse Wagyu',
            'price' => 119,
        ],
        'jarret' => [
            'name' => 'Jarret Wagyu',
            'price' => 92,
        ],
    ];

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'bovin_reference' => ['nullable', 'string', 'max:80'],

            'company' => ['required', 'string', 'max:190'],
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'professional_type' => ['required', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:3000'],

            'cart' => ['required', 'array', 'min:1'],
            'cart.*.key' => ['required', 'string', Rule::in(array_keys($this->cuts))],
            'cart.*.quantity' => ['required', 'integer', 'min:1', 'max:999'],
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

        $cart = collect($validated['cart'])
            ->map(function (array $item) {
                $cut = $this->cuts[$item['key']];
                $quantity = max(1, (int) $item['quantity']);
                $unitPrice = (float) $cut['price'];

                return [
                    'key' => $item['key'],
                    'name' => $cut['name'],
                    'quantity' => $quantity,
                    'unit_price_ht' => $unitPrice,
                    'line_total_ht' => $unitPrice * $quantity,
                ];
            })
            ->values()
            ->toArray();

        $totalHt = collect($cart)->sum('line_total_ht');

        $reservation = ProReservationRequest::create([
            'reference' => $this->generateReference(),
            'bovin_reference' => $validated['bovin_reference'] ?? 'WF-2026-01',

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

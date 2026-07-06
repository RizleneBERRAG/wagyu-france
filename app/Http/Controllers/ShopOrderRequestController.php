<?php

namespace App\Http\Controllers;

use App\Models\ShopOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopOrderRequestController extends Controller
{
    private array $products = [
        'entrecote' => [
            'name' => 'Entrecôte Wagyu',
            'price' => 174,
        ],
        'filet' => [
            'name' => 'Filet Wagyu',
            'price' => 198,
        ],
        'fauxfilet' => [
            'name' => 'Faux-filet Wagyu',
            'price' => 174,
        ],
        'rumsteak' => [
            'name' => 'Rumsteak Wagyu',
            'price' => 137,
        ],
        'paleron' => [
            'name' => 'Paleron Wagyu',
            'price' => 143,
        ],
        'jarret' => [
            'name' => 'Jarret Wagyu',
            'price' => 92,
        ],
    ];

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'city' => ['required', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:3000'],

            'cart' => ['required', 'array', 'min:1'],
            'cart.*.key' => ['required', 'string', Rule::in(array_keys($this->products))],
            'cart.*.quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ], [
            'fullname.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse email est obligatoire.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
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
                $product = $this->products[$item['key']];
                $quantity = max(1, (int) $item['quantity']);
                $unitPrice = (float) $product['price'];

                return [
                    'key' => $item['key'],
                    'name' => $product['name'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $unitPrice * $quantity,
                ];
            })
            ->values()
            ->toArray();

        $total = collect($cart)->sum('line_total');

        $order = ShopOrderRequest::create([
            'reference' => $this->generateReference(),

            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'message' => $validated['message'] ?? null,

            'cart' => $cart,
            'total' => $total,
            'status' => 'nouvelle',
        ]);

        return response()->json([
            'message' => 'Votre demande de commande a bien été enregistrée.',
            'reference' => $order->reference,
            'total' => number_format($total, 2, ',', ' ') . ' €',
        ], 201);
    }

    private function generateReference(): string
    {
        do {
            $reference = 'WF-SHOP-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (ShopOrderRequest::where('reference', $reference)->exists());

        return $reference;
    }
}

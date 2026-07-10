<?php

namespace App\Http\Controllers;

use App\Mail\RequestReceivedMail;
use App\Models\ShopOrderRequest;
use App\Models\ShopProduct;
use App\Services\CustomerSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopOrderRequestController extends Controller
{
    public function store(Request $request, CustomerSyncService $customers): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'city' => ['required', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:3000'],
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.key' => [
                'required',
                'string',
                Rule::exists('shop_products', 'slug')->where(fn ($query) => $query->where('is_active', true)),
            ],
            'cart.*.quantity' => ['required', 'numeric', 'min:0.1', 'max:999'],
        ], [
            'fullname.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse email est obligatoire.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'cart.required' => 'Le panier ne peut pas être vide.',
            'cart.min' => 'Le panier ne peut pas être vide.',
            'cart.*.key.exists' => 'Un produit du panier n’est plus disponible.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Certaines informations sont manquantes ou invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $products = ShopProduct::whereIn('slug', collect($validated['cart'])->pluck('key'))
            ->where('is_active', true)
            ->get()
            ->keyBy('slug');

        $cart = [];
        $errors = [];

        foreach ($validated['cart'] as $index => $item) {
            $product = $products->get($item['key']);
            $quantity = (float) $item['quantity'];

            if (! $product) {
                $errors["cart.{$index}.key"][] = 'Ce produit n’est plus disponible.';
                continue;
            }

            if ($quantity < (float) $product->min_quantity_kg) {
                $errors["cart.{$index}.quantity"][] = 'La quantité minimale pour ' . $product->name . ' est de ' . number_format((float) $product->min_quantity_kg, 1, ',', ' ') . ' kg.';
            }

            if ($quantity > (float) $product->stock_kg) {
                $errors["cart.{$index}.quantity"][] = 'La quantité demandée dépasse le stock disponible pour ' . $product->name . '.';
            }

            $unitPrice = (float) $product->price_per_kg;
            $cart[] = [
                'key' => $product->slug,
                'name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * $quantity,
            ];
        }

        if ($errors !== []) {
            return response()->json([
                'message' => 'Le panier doit être ajusté avant l’envoi.',
                'errors' => $errors,
            ], 422);
        }

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

        $customers->sync($order, [
            'type' => 'individual',
            'relationship_status' => 'prospect',
            'fullname' => $order->fullname,
            'email' => $order->email,
            'phone' => $order->phone,
            'city' => $order->city,
        ]);

        $this->sendEmails($order);

        return response()->json([
            'message' => 'Votre demande de commande a bien été enregistrée.',
            'reference' => $order->reference,
            'total' => number_format($total, 2, ',', ' ') . ' €',
        ], 201);
    }

    private function sendEmails(ShopOrderRequest $order): void
    {
        try {
            $adminEmail = config('wagyu.order_email');

            if ($adminEmail) {
                Mail::to($adminEmail)->send(new RequestReceivedMail('shop', $order, true));
            }

            Mail::to($order->email)->send(new RequestReceivedMail('shop', $order));
        } catch (\Throwable $exception) {
            Log::warning('Erreur envoi email demande boutique Wagyu France', [
                'order_id' => $order->id,
                'reference' => $order->reference,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function generateReference(): string
    {
        do {
            $reference = 'WF-SHOP-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (ShopOrderRequest::where('reference', $reference)->exists());

        return $reference;
    }
}

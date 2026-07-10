<?php

namespace App\Services;

use App\Models\ShopOrderRequest;
use App\Models\ShopProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ShopStockService
{
    public function apply(ShopOrderRequest $order): void
    {
        DB::transaction(function () use ($order) {
            $order->refresh();

            if ($order->stock_applied_at) {
                return;
            }

            $cart = collect($order->cart ?? []);
            $products = ShopProduct::query()
                ->whereIn('slug', $cart->pluck('key')->filter())
                ->lockForUpdate()
                ->get()
                ->keyBy('slug');

            $errors = [];

            foreach ($cart as $item) {
                $slug = $item['key'] ?? null;
                $quantity = (float) ($item['quantity'] ?? 0);
                $product = $slug ? $products->get($slug) : null;

                if (! $product) {
                    $errors[] = 'Le produit « ' . ($item['name'] ?? $slug ?? 'inconnu') . ' » n’existe plus dans le catalogue.';
                    continue;
                }

                if ((float) $product->stock_kg < $quantity) {
                    $errors[] = $product->name . ' : stock disponible ' . number_format((float) $product->stock_kg, 1, ',', ' ') . ' kg, quantité demandée ' . number_format($quantity, 1, ',', ' ') . ' kg.';
                }
            }

            if ($errors !== []) {
                throw ValidationException::withMessages(['stock' => $errors]);
            }

            foreach ($cart as $item) {
                $product = $products->get($item['key']);
                $product->decrement('stock_kg', (float) $item['quantity']);
            }

            $order->update(['stock_applied_at' => now()]);
        });
    }

    public function release(ShopOrderRequest $order): void
    {
        DB::transaction(function () use ($order) {
            $order->refresh();

            if (! $order->stock_applied_at) {
                return;
            }

            $cart = collect($order->cart ?? []);
            $products = ShopProduct::query()
                ->whereIn('slug', $cart->pluck('key')->filter())
                ->lockForUpdate()
                ->get()
                ->keyBy('slug');

            foreach ($cart as $item) {
                $product = $products->get($item['key'] ?? null);

                if ($product) {
                    $product->increment('stock_kg', (float) ($item['quantity'] ?? 0));
                }
            }

            $order->update(['stock_applied_at' => null]);
        });
    }
}
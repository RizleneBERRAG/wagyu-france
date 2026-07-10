<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ShopOrderRequest extends Model
{
    protected $fillable = [
        'reference',
        'fullname',
        'email',
        'phone',
        'city',
        'message',
        'cart',
        'final_cart',
        'additional_label',
        'additional_amount',
        'total',
        'final_total_ttc',
        'vat_rate',
        'status',
        'payment_status',
        'paid_at',
        'document_notes',
        'invoice_number',
        'invoice_issued_at',
        'invoice_snapshot',
        'stock_applied_at',
    ];

    protected $casts = [
        'cart' => 'array',
        'final_cart' => 'array',
        'invoice_snapshot' => 'array',
        'total' => 'decimal:2',
        'additional_amount' => 'decimal:2',
        'final_total_ttc' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'paid_at' => 'datetime',
        'invoice_issued_at' => 'datetime',
        'stock_applied_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function (self $order) {
            $invoiceIssued = filled($order->getOriginal('invoice_number'));
            $financialFields = [
                'final_cart',
                'additional_label',
                'additional_amount',
                'final_total_ttc',
                'vat_rate',
            ];

            if ($invoiceIssued && $order->isDirty($financialFields)) {
                throw ValidationException::withMessages([
                    'invoice' => 'Les lignes et montants d’une facture émise ne peuvent plus être modifiés.',
                ]);
            }

            if ($order->getOriginal('stock_applied_at') && $order->isDirty($financialFields)) {
                throw ValidationException::withMessages([
                    'stock' => 'Libérez d’abord le stock en faisant reculer le statut avant de modifier les lignes finales.',
                ]);
            }

            if (
                $invoiceIssued
                && $order->isDirty('stock_applied_at')
                && blank($order->stock_applied_at)
            ) {
                throw ValidationException::withMessages([
                    'stock' => 'Le stock d’une commande facturée ne peut pas être libéré sans passer par un avoir.',
                ]);
            }

            if (
                $invoiceIssued
                && $order->isDirty('status')
                && ! in_array($order->status, ['confirmee', 'traitee'], true)
            ) {
                throw ValidationException::withMessages([
                    'status' => 'Une commande facturée ne peut pas être annulée ou repassée en cours sans émettre un avoir.',
                ]);
            }
        });
    }
}

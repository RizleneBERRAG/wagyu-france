<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ProReservationRequest extends Model
{
    protected $fillable = [
        'reference',
        'bovin_reference',
        'company',
        'fullname',
        'email',
        'phone',
        'professional_type',
        'city',
        'message',
        'cart',
        'final_cart',
        'additional_label',
        'additional_amount',
        'total_ht',
        'final_total_ht',
        'vat_rate',
        'status',
        'payment_status',
        'paid_at',
        'document_notes',
        'invoice_number',
        'invoice_issued_at',
        'invoice_snapshot',
    ];

    protected $casts = [
        'cart' => 'array',
        'final_cart' => 'array',
        'invoice_snapshot' => 'array',
        'total_ht' => 'decimal:2',
        'additional_amount' => 'decimal:2',
        'final_total_ht' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'paid_at' => 'datetime',
        'invoice_issued_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function (self $requestItem) {
            $invoiceIssued = filled($requestItem->getOriginal('invoice_number'));

            if (! $invoiceIssued) {
                return;
            }

            if ($requestItem->isDirty([
                'final_cart',
                'additional_label',
                'additional_amount',
                'final_total_ht',
                'vat_rate',
            ])) {
                throw ValidationException::withMessages([
                    'invoice' => 'Les lignes et montants d’une facture professionnelle émise ne peuvent plus être modifiés.',
                ]);
            }

            if (
                $requestItem->isDirty('status')
                && ! in_array($requestItem->status, ['confirmee', 'traitee'], true)
            ) {
                throw ValidationException::withMessages([
                    'status' => 'Une demande professionnelle facturée ne peut pas être annulée sans émettre un avoir.',
                ]);
            }
        });
    }
}

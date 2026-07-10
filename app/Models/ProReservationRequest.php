<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Validation\ValidationException;

class ProReservationRequest extends Model
{
    protected $fillable = [
        'customer_id',
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
        'invoice_sent_at',
        'invoice_snapshot',
        'preparation_status',
        'delivery_method',
        'scheduled_at',
        'carrier',
        'tracking_number',
        'logistics_notes',
        'prepared_at',
        'dispatched_at',
        'delivered_at',
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
        'invoice_sent_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'prepared_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creditNotes(): MorphMany
    {
        return $this->morphMany(CreditNote::class, 'documentable');
    }

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

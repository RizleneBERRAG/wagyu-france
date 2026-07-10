<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'invoice_snapshot' => 'array',
        'total_ht' => 'decimal:2',
        'final_total_ht' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'paid_at' => 'datetime',
        'invoice_issued_at' => 'datetime',
    ];
}

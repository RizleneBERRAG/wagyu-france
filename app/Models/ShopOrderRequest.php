<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'invoice_snapshot' => 'array',
        'total' => 'decimal:2',
        'final_total_ttc' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'paid_at' => 'datetime',
        'invoice_issued_at' => 'datetime',
        'stock_applied_at' => 'datetime',
    ];
}

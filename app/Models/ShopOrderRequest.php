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
}

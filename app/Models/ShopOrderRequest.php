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
        'status',
        'stock_applied_at',
    ];

    protected $casts = [
        'cart' => 'array',
        'total' => 'decimal:2',
        'stock_applied_at' => 'datetime',
    ];
}
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
    ];

    protected $casts = [
        'cart' => 'array',
        'total' => 'decimal:2',
    ];
}

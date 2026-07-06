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
        'status',
    ];

    protected $casts = [
        'cart' => 'array',
        'total_ht' => 'decimal:2',
    ];
}

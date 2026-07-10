<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    protected $fillable = [
        'customer_id',
        'reference',
        'audience',
        'fullname',
        'email',
        'phone',
        'company',
        'city',
        'subject',
        'message',
        'preferred_contact',
        'status',
        'privacy_accepted_at',
    ];

    protected $casts = [
        'privacy_accepted_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

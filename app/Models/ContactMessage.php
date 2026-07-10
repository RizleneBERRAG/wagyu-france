<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
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
}

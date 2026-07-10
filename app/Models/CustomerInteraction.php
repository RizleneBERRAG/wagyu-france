<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerInteraction extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'title',
        'body',
        'happened_at',
        'due_at',
        'completed_at',
    ];

    protected $casts = [
        'happened_at' => 'datetime',
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return [
            'note' => 'Note interne',
            'call' => 'Appel',
            'email' => 'Email',
            'meeting' => 'Rendez-vous',
            'follow_up' => 'Relance',
        ][$this->type] ?? ucfirst($this->type);
    }
}

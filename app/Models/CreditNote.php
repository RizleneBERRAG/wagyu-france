<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CreditNote extends Model
{
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'number',
        'invoice_number',
        'reason',
        'amount_ht',
        'vat_rate',
        'vat_amount',
        'amount_ttc',
        'snapshot',
        'issued_at',
        'sent_at',
    ];

    protected $casts = [
        'amount_ht' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'amount_ttc' => 'decimal:2',
        'snapshot' => 'array',
        'issued_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}

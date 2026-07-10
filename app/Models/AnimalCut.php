<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalCut extends Model
{
    protected $fillable = [
        'animal_batch_id',
        'slug',
        'name',
        'description',
        'price_per_kg',
        'available_kg',
        'min_quantity_kg',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'available_kg' => 'decimal:2',
        'min_quantity_kg' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function animalBatch(): BelongsTo
    {
        return $this->belongsTo(AnimalBatch::class);
    }
}

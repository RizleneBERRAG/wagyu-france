<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnimalBatch extends Model
{
    public const STATUSES = [
        'draft' => 'Brouillon',
        'open' => 'Réserve ouverte',
        'ready' => 'Seuil atteint',
        'cutting' => 'En découpe',
        'closed' => 'Clôturé',
    ];

    protected $fillable = [
        'reference',
        'name',
        'status',
        'launch_threshold_percent',
        'is_active',
        'opens_at',
        'cutting_planned_at',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'launch_threshold_percent' => 'integer',
        'is_active' => 'boolean',
        'opens_at' => 'datetime',
        'cutting_planned_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function cuts(): HasMany
    {
        return $this->hasMany(AnimalCut::class)->orderBy('sort_order')->orderBy('name');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}

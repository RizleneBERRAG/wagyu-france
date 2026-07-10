<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'reference',
        'badge',
        'category_label',
        'categories',
        'description',
        'cooking',
        'character',
        'price_per_kg',
        'stock_kg',
        'low_stock_threshold',
        'min_quantity_kg',
        'image_path',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'categories' => 'array',
        'price_per_kg' => 'decimal:2',
        'stock_kg' => 'decimal:2',
        'low_stock_threshold' => 'decimal:2',
        'min_quantity_kg' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }

    public function getImageUrlAttribute(): string
    {
        return asset($this->image_path ?: 'assets/images/wagyu/marbrage-showcase.jpg');
    }

    public function getIsLowStockAttribute(): bool
    {
        return (float) $this->stock_kg <= (float) $this->low_stock_threshold;
    }
}

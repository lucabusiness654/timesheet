<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $primaryKey = 'product_item_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'price' => 'decimal:2',
        'is_bestseller' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function filters(): HasMany
    {
        return $this->hasMany(ProductFilter::class, 'product_item_id');
    }

    public function scopeWithFilters($query, array $filters)
    {
        foreach ($filters as $type => $values) {
            $query->whereHas('filters', function ($q) use ($type, $values) {
                $q->where('filter_type', $type)
                  ->whereIn('filter_value', (array)$values);
            });
        }
        return $query;
    }
}
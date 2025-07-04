<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    protected $fillable = ['filter_type', 'filter_value', 'numeric_value'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_item_id');
    }
}
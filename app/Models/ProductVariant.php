<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_name',
        'variant_sku',
        'price_adjustment',
        'stock_quantity',
        'image',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->product->base_price + $this->price_adjustment;
    }
}

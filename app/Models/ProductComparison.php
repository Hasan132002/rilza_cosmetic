<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComparison extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    /**
     * Get the user that owns the comparison
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

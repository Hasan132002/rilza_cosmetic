<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_code',
        'discount_amount',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Helper Methods
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->product->final_price * $item->quantity;
        });
    }

    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    public function getSubtotalAttribute()
    {
        return $this->total;
    }

    public function getFinalTotalAttribute()
    {
        return max(0, $this->total - $this->discount_amount);
    }
}

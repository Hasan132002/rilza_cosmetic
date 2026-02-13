<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlashSale extends Model
{
    protected $fillable = [
        'title',
        'discount_percentage',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_product');
    }

    // Check if flash sale is currently active
    public function isCurrentlyActive()
    {
        if (!$this->is_active) return false;

        $now = Carbon::now();
        return $now->between($this->starts_at, $this->ends_at);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now);
    }
}

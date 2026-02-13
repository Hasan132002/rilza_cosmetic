<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductB2BPricing extends Model
{
    protected $table = 'product_b2b_pricing';

    protected $fillable = [
        'product_id',
        'wholesale_price',
        'minimum_order_quantity',
        'bulk_tier_1_qty',
        'bulk_tier_1_price',
        'bulk_tier_2_qty',
        'bulk_tier_2_price',
        'bulk_tier_3_qty',
        'bulk_tier_3_price',
        'is_available_for_b2b',
    ];

    protected $casts = [
        'wholesale_price' => 'decimal:2',
        'bulk_tier_1_price' => 'decimal:2',
        'bulk_tier_2_price' => 'decimal:2',
        'bulk_tier_3_price' => 'decimal:2',
        'is_available_for_b2b' => 'boolean',
    ];

    /**
     * Get the product that owns this pricing
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the price for a given quantity considering bulk discounts
     */
    public function getPriceForQuantity($quantity)
    {
        // Check bulk tier 3 (highest quantity)
        if ($this->bulk_tier_3_qty && $quantity >= $this->bulk_tier_3_qty && $this->bulk_tier_3_price) {
            return $this->bulk_tier_3_price;
        }

        // Check bulk tier 2
        if ($this->bulk_tier_2_qty && $quantity >= $this->bulk_tier_2_qty && $this->bulk_tier_2_price) {
            return $this->bulk_tier_2_price;
        }

        // Check bulk tier 1
        if ($this->bulk_tier_1_qty && $quantity >= $this->bulk_tier_1_qty && $this->bulk_tier_1_price) {
            return $this->bulk_tier_1_price;
        }

        // Return base wholesale price
        return $this->wholesale_price;
    }

    /**
     * Get all bulk tiers as array
     */
    public function getBulkTiers()
    {
        $tiers = [];

        if ($this->bulk_tier_1_qty && $this->bulk_tier_1_price) {
            $tiers[] = [
                'quantity' => $this->bulk_tier_1_qty,
                'price' => $this->bulk_tier_1_price,
                'label' => "{$this->bulk_tier_1_qty}+ units",
            ];
        }

        if ($this->bulk_tier_2_qty && $this->bulk_tier_2_price) {
            $tiers[] = [
                'quantity' => $this->bulk_tier_2_qty,
                'price' => $this->bulk_tier_2_price,
                'label' => "{$this->bulk_tier_2_qty}+ units",
            ];
        }

        if ($this->bulk_tier_3_qty && $this->bulk_tier_3_price) {
            $tiers[] = [
                'quantity' => $this->bulk_tier_3_qty,
                'price' => $this->bulk_tier_3_price,
                'label' => "{$this->bulk_tier_3_qty}+ units",
            ];
        }

        return $tiers;
    }

    /**
     * Calculate savings compared to base wholesale price
     */
    public function calculateSavings($quantity)
    {
        $regularTotal = $this->wholesale_price * $quantity;
        $discountedPrice = $this->getPriceForQuantity($quantity);
        $discountedTotal = $discountedPrice * $quantity;

        return [
            'savings_amount' => $regularTotal - $discountedTotal,
            'savings_percentage' => $regularTotal > 0 ? (($regularTotal - $discountedTotal) / $regularTotal) * 100 : 0,
            'regular_total' => $regularTotal,
            'discounted_total' => $discountedTotal,
        ];
    }
}

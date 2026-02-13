<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'long_description',
        'ingredients',
        'how_to_use',
        'skin_type',
        'base_price',
        'discount_price',
        'discount_percentage',
        'stock_quantity',
        'low_stock_threshold',
        'is_featured',
        'is_bestseller',
        'is_new_arrival',
        'views_count',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function badges()
    {
        return $this->belongsToMany(ProductBadge::class, 'badge_product');
    }

    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_product');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'product_id')->where('is_approved', true);
    }

    public function b2bPricing()
    {
        return $this->hasOne(ProductB2BPricing::class);
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return round($this->approvedReviews()->avg('rating'), 1) ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->base_price;
    }

    public function getIsOnSaleAttribute()
    {
        return !is_null($this->discount_price);
    }

    public function getIsLowStockAttribute()
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Get wholesale price for a given quantity (B2B)
     */
    public function getWholesalePriceForQuantity($quantity)
    {
        if (!$this->b2bPricing || !$this->b2bPricing->is_available_for_b2b) {
            return $this->final_price;
        }

        return $this->b2bPricing->getPriceForQuantity($quantity);
    }

    /**
     * Check if product is available for B2B
     */
    public function isAvailableForB2B()
    {
        return $this->b2bPricing && $this->b2bPricing->is_available_for_b2b;
    }

    /**
     * Get minimum order quantity for B2B
     */
    public function getB2BMinimumQuantity()
    {
        return $this->b2bPricing ? $this->b2bPricing->minimum_order_quantity : 1;
    }
}

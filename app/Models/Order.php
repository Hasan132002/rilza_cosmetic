<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'total_amount',
        'payment_method',
        'order_status',
        'tracking_number',
        'notes',
        'delivered_at',
        'is_b2b_order',
        'purchase_order_number',
        'business_discount_percentage',
        'sales_rep_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivered_at' => 'datetime',
        'is_b2b_order' => 'boolean',
        'business_discount_percentage' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function salesRep()
    {
        return $this->belongsTo(User::class, 'sales_rep_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeB2B($query)
    {
        return $query->where('is_b2b_order', true);
    }

    public function scopeB2C($query)
    {
        return $query->where('is_b2b_order', false);
    }

    // Helpers
    public static function generateOrderNumber()
    {
        return 'RIZ-' . strtoupper(uniqid());
    }
}

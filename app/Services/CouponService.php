<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    /**
     * Validate and get coupon
     */
    public function validateCoupon(string $code, float $orderTotal)
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code'];
        }

        if (!$coupon->isValid($orderTotal)) {
            if (!$coupon->is_active) {
                return ['valid' => false, 'message' => 'This coupon is no longer active'];
            }
            if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                return ['valid' => false, 'message' => 'Coupon usage limit reached'];
            }
            if ($coupon->min_order_amount && $orderTotal < $coupon->min_order_amount) {
                return ['valid' => false, 'message' => 'Minimum order amount not met (Rs ' . number_format($coupon->min_order_amount, 0) . ' required)'];
            }
            return ['valid' => false, 'message' => 'Coupon is not valid'];
        }

        $discount = $coupon->calculateDiscount($orderTotal);

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'message' => 'Coupon applied! You saved Rs ' . number_format($discount, 0)
        ];
    }

    /**
     * Apply coupon to order
     */
    public function applyCoupon(Coupon $coupon)
    {
        $coupon->increment('used_count');
    }
}

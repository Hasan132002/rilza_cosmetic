<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 1000,
                'max_discount_amount' => 500,
                'usage_limit' => 100,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'SAVE500',
                'type' => 'flat',
                'value' => 500,
                'min_order_amount' => 2500,
                'max_discount_amount' => null,
                'usage_limit' => 50,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'FLASH20',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 1500,
                'max_discount_amount' => 1000,
                'usage_limit' => 30,
                'valid_from' => now(),
                'valid_until' => now()->addDays(7),
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'flat',
                'value' => 200,
                'min_order_amount' => 800,
                'max_discount_amount' => null,
                'usage_limit' => null,
                'valid_from' => now(),
                'valid_until' => null,
                'is_active' => true,
            ],
            [
                'code' => 'VIP15',
                'type' => 'percentage',
                'value' => 15,
                'min_order_amount' => 3000,
                'max_discount_amount' => 1500,
                'usage_limit' => 20,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}

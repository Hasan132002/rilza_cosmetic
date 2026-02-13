<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductB2BPricing;

class AddB2BPricingToAllProducts extends Seeder
{
    public function run(): void
    {
        echo "Adding B2B pricing to all products...\n\n";

        $products = Product::all();
        $count = 0;

        foreach ($products as $product) {
            // Calculate wholesale price (20-30% less than retail)
            $discountPercentage = rand(20, 30);
            $wholesalePrice = $product->base_price * (1 - $discountPercentage / 100);

            // Calculate bulk tier prices
            $tier1Price = $wholesalePrice * 0.95; // 5% off wholesale
            $tier2Price = $wholesalePrice * 0.88; // 12% off wholesale
            $tier3Price = $wholesalePrice * 0.80; // 20% off wholesale

            // Random MOQ between 10-50
            $moq = [10, 15, 20, 25, 30, 50][array_rand([10, 15, 20, 25, 30, 50])];

            // Create or update B2B pricing
            ProductB2BPricing::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'wholesale_price' => round($wholesalePrice, 2),
                    'minimum_order_quantity' => $moq,
                    'bulk_tier_1_qty' => 50,
                    'bulk_tier_1_price' => round($tier1Price, 2),
                    'bulk_tier_2_qty' => 100,
                    'bulk_tier_2_price' => round($tier2Price, 2),
                    'bulk_tier_3_qty' => 200,
                    'bulk_tier_3_price' => round($tier3Price, 2),
                    'is_available_for_b2b' => true,
                ]
            );

            echo "✅ {$product->name}\n";
            echo "   Retail: Rs " . number_format($product->base_price, 0) . "\n";
            echo "   Wholesale: Rs " . number_format($wholesalePrice, 0) . " ({$discountPercentage}% off)\n";
            echo "   MOQ: {$moq} units\n";
            echo "   Tier 1 (50+): Rs " . number_format($tier1Price, 0) . "\n";
            echo "   Tier 2 (100+): Rs " . number_format($tier2Price, 0) . "\n";
            echo "   Tier 3 (200+): Rs " . number_format($tier3Price, 0) . "\n\n";

            $count++;
        }

        echo "🎉 B2B pricing added to {$count} products!\n";
        echo "✅ All products now have wholesale pricing, MOQ, and bulk tiers.\n\n";
    }
}

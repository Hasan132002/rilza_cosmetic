<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::role('customer')->get();
        $products = Product::limit(20)->get();

        if ($customers->isEmpty()) {
            echo "⚠️  No customers found. Creating test reviews without user assignment.\n";
        }

        $reviews = [
            ['rating' => 5, 'comment' => 'Absolutely love this product! Best cosmetics I\'ve ever used. Highly recommended!'],
            ['rating' => 5, 'comment' => 'Amazing quality! The product exceeded my expectations. Will definitely buy again.'],
            ['rating' => 4, 'comment' => 'Great product! Good quality and fast delivery. Very satisfied with my purchase.'],
            ['rating' => 5, 'comment' => 'Perfect! Exactly what I was looking for. The color and quality are superb.'],
            ['rating' => 4, 'comment' => 'Really good product. Works well and lasts long. Worth the price!'],
            ['rating' => 5, 'comment' => 'Excellent! This has become my favorite beauty product. Can\'t live without it now.'],
            ['rating' => 3, 'comment' => 'Good product but expected more. It\'s okay for the price.'],
            ['rating' => 5, 'comment' => 'Outstanding quality! The packaging was beautiful and product is amazing.'],
            ['rating' => 4, 'comment' => 'Very happy with this purchase. Good value for money. Recommended!'],
            ['rating' => 5, 'comment' => 'Love it! Perfect color match and stays on all day. Impressed!'],
            ['rating' => 5, 'comment' => 'Best purchase ever! Amazing quality and delivery was super fast.'],
            ['rating' => 4, 'comment' => 'Nice product! Does what it claims. Will purchase again.'],
            ['rating' => 5, 'comment' => 'Fantastic! Better than expensive brands. Rizla is amazing!'],
            ['rating' => 3, 'comment' => 'It\'s alright. Not bad but not exceptional either.'],
            ['rating' => 5, 'comment' => 'Absolutely perfect! Matches my skin tone perfectly. Love Rizla!'],
        ];

        $created = 0;
        $approved = 0;

        foreach ($products as $product) {
            // Create 2-3 reviews per product
            $reviewCount = rand(2, 3);

            for ($i = 0; $i < $reviewCount && $created < 50; $i++) {
                $reviewData = $reviews[array_rand($reviews)];
                $isApproved = rand(1, 10) > 2; // 80% approved, 20% pending

                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $customers->isNotEmpty() ? $customers->random()->id : null,
                    'rating' => $reviewData['rating'],
                    'review' => $reviewData['comment'],
                    'is_approved' => $isApproved,
                ]);

                $created++;
                if ($isApproved) $approved++;
            }
        }

        echo "✅ Created {$created} product reviews\n";
        echo "✅ Approved: {$approved}\n";
        echo "✅ Pending: " . ($created - $approved) . "\n";
        echo "\n🎉 Review Seeder Complete!\n";
    }
}

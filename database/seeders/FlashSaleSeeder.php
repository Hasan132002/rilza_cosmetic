<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashSale;
use App\Models\Product;
use Carbon\Carbon;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Create active flash sale
        $activeFlashSale = FlashSale::create([
            'title' => 'Weekend Beauty Sale - 40% OFF',
            'discount_percentage' => 40,
            'starts_at' => Carbon::now()->subDays(1),
            'ends_at' => Carbon::now()->addDays(3),
            'is_active' => true,
        ]);

        // Attach 10 random products to this flash sale
        $products = Product::inRandomOrder()->limit(10)->get();
        $activeFlashSale->products()->attach($products->pluck('id'));

        echo "✅ Created active flash sale: {$activeFlashSale->name} with {$products->count()} products\n";

        // Create upcoming flash sale
        $upcomingFlashSale = FlashSale::create([
            'title' => 'Summer Skincare Bonanza - 50% OFF',
            'discount_percentage' => 50,
            'starts_at' => Carbon::now()->addDays(5),
            'ends_at' => Carbon::now()->addDays(10),
            'is_active' => true,
        ]);

        $moreProducts = Product::inRandomOrder()->limit(8)->get();
        $upcomingFlashSale->products()->attach($moreProducts->pluck('id'));

        echo "✅ Created upcoming flash sale: {$upcomingFlashSale->name} with {$moreProducts->count()} products\n";

        // Create expired flash sale
        $expiredFlashSale = FlashSale::create([
            'title' => 'New Year Clearance - 60% OFF',
            'discount_percentage' => 60,
            'starts_at' => Carbon::now()->subDays(15),
            'ends_at' => Carbon::now()->subDays(8),
            'is_active' => false,
        ]);

        $expiredProducts = Product::inRandomOrder()->limit(5)->get();
        $expiredFlashSale->products()->attach($expiredProducts->pluck('id'));

        echo "✅ Created expired flash sale: {$expiredFlashSale->name} with {$expiredProducts->count()} products\n";

        echo "\n🎉 Flash Sale Seeder Complete! Created 3 flash sales with products.\n";
    }
}

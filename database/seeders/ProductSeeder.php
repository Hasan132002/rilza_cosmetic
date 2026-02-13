<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductBadge;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate products and related tables to start fresh
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::table('badge_product')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = Category::all()->keyBy('name');
        $badges = ProductBadge::all()->keyBy('slug');

        $products = [
            // MAKEUP - Lipsticks (3 products)
            ['category' => 'Lipsticks', 'name' => 'Matte Luxe Lipstick - Rose Pink', 'sku' => 'RC-LIP-001', 'short_description' => 'Long-lasting matte finish', 'base_price' => 850, 'discount_price' => 699, 'stock_quantity' => 50, 'skin_type' => 'all', 'is_featured' => true, 'is_new_arrival' => true, 'badges' => ['new', 'bestseller']],
            ['category' => 'Lipsticks', 'name' => 'Glossy Shine - Coral Dream', 'sku' => 'RC-LIP-002', 'short_description' => 'High-shine glossy finish', 'base_price' => 750, 'stock_quantity' => 40, 'skin_type' => 'all', 'is_bestseller' => true, 'badges' => ['bestseller']],
            ['category' => 'Lipsticks', 'name' => 'Velvet Matte - Berry Red', 'sku' => 'RC-LIP-003', 'short_description' => 'Rich berry shade', 'base_price' => 850, 'discount_price' => 650, 'stock_quantity' => 35, 'skin_type' => 'all', 'is_featured' => true, 'badges' => ['bestseller']],

            // MAKEUP - Foundations (3 products)
            ['category' => 'Foundations', 'name' => 'Flawless Finish - Ivory', 'sku' => 'RC-FND-001', 'short_description' => 'Full coverage foundation', 'base_price' => 1500, 'discount_price' => 1299, 'stock_quantity' => 30, 'skin_type' => 'oily', 'is_featured' => true, 'badges' => ['new']],
            ['category' => 'Foundations', 'name' => 'Dewy Glow - Beige', 'sku' => 'RC-FND-002', 'short_description' => 'Radiant glowing finish', 'base_price' => 1650, 'stock_quantity' => 25, 'skin_type' => 'dry', 'badges' => []],
            ['category' => 'Foundations', 'name' => 'HD Foundation - Natural', 'sku' => 'RC-FND-003', 'short_description' => 'Camera-ready finish', 'base_price' => 1400, 'stock_quantity' => 28, 'skin_type' => 'combination', 'badges' => []],

            // MAKEUP - Eyeshadows (3 products)
            ['category' => 'Eyeshadows', 'name' => 'Glamour Palette - Nude', 'sku' => 'RC-EYE-001', 'short_description' => '12-shade eyeshadow palette', 'base_price' => 2500, 'discount_price' => 1999, 'stock_quantity' => 35, 'skin_type' => 'all', 'is_featured' => true, 'is_bestseller' => true, 'badges' => ['bestseller', 'limited-edition']],
            ['category' => 'Eyeshadows', 'name' => 'Smokey Eyes Palette', 'sku' => 'RC-EYE-002', 'short_description' => '10 dramatic shades', 'base_price' => 2200, 'discount_price' => 1899, 'stock_quantity' => 22, 'skin_type' => 'all', 'is_new_arrival' => true, 'badges' => ['new', 'limited-edition']],
            ['category' => 'Eyeshadows', 'name' => 'Sunset Glow Palette', 'sku' => 'RC-EYE-003', 'short_description' => 'Warm sunset shades', 'base_price' => 2300, 'stock_quantity' => 28, 'skin_type' => 'all', 'badges' => []],

            // MAKEUP - Mascaras (3 products)
            ['category' => 'Mascaras', 'name' => 'Volume Max - Black', 'sku' => 'RC-MSC-001', 'short_description' => 'Dramatic volume & length', 'base_price' => 550, 'stock_quantity' => 80, 'skin_type' => 'all', 'is_bestseller' => true, 'badges' => ['bestseller']],
            ['category' => 'Mascaras', 'name' => 'Curl Perfect Mascara', 'sku' => 'RC-MSC-002', 'short_description' => 'Lifts and curls lashes', 'base_price' => 600, 'stock_quantity' => 65, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Mascaras', 'name' => 'Waterproof Mascara - Black', 'sku' => 'RC-MSC-003', 'short_description' => 'Smudge-proof all day', 'base_price' => 650, 'stock_quantity' => 55, 'skin_type' => 'all', 'badges' => ['new']],

            // MAKEUP - Blush (3 products)
            ['category' => 'Blush', 'name' => 'Cream Blush - Peachy', 'sku' => 'RC-BLH-001', 'short_description' => 'Creamy blendable formula', 'base_price' => 700, 'stock_quantity' => 38, 'skin_type' => 'dry', 'badges' => ['new']],
            ['category' => 'Blush', 'name' => 'Powder Blush - Rose Pink', 'sku' => 'RC-BLH-002', 'short_description' => 'Natural rosy glow', 'base_price' => 650, 'stock_quantity' => 45, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Blush', 'name' => 'Shimmer Blush - Coral', 'sku' => 'RC-BLH-003', 'short_description' => 'Subtle shimmer finish', 'base_price' => 750, 'discount_price' => 599, 'stock_quantity' => 32, 'skin_type' => 'all', 'badges' => ['bestseller']],

            // SKINCARE - Moisturizers (3 products)
            ['category' => 'Moisturizers', 'name' => 'Hydrating Day Cream SPF 30', 'sku' => 'RC-MST-001', 'short_description' => '24h hydration + sun protection', 'base_price' => 1200, 'stock_quantity' => 60, 'skin_type' => 'dry', 'is_new_arrival' => true, 'badges' => ['new', 'organic']],
            ['category' => 'Moisturizers', 'name' => 'Oil-Free Gel Moisturizer', 'sku' => 'RC-MST-002', 'short_description' => 'Lightweight gel formula', 'base_price' => 950, 'stock_quantity' => 45, 'skin_type' => 'oily', 'badges' => ['vegan']],
            ['category' => 'Moisturizers', 'name' => 'Night Repair Cream', 'sku' => 'RC-MST-003', 'short_description' => 'Overnight intensive care', 'base_price' => 1350, 'stock_quantity' => 38, 'skin_type' => 'dry', 'badges' => ['organic']],

            // SKINCARE - Serums (3 products)
            ['category' => 'Serums', 'name' => 'Vitamin C Brightening Serum', 'sku' => 'RC-SRM-001', 'short_description' => 'Brightens & evens skin tone', 'base_price' => 1800, 'discount_price' => 1499, 'stock_quantity' => 40, 'skin_type' => 'all', 'is_featured' => true, 'is_bestseller' => true, 'badges' => ['bestseller', 'organic']],
            ['category' => 'Serums', 'name' => 'Hyaluronic Acid Serum', 'sku' => 'RC-SRM-002', 'short_description' => 'Ultra hydration boost', 'base_price' => 1600, 'discount_price' => 1399, 'stock_quantity' => 32, 'skin_type' => 'dry', 'is_bestseller' => true, 'badges' => ['bestseller']],
            ['category' => 'Serums', 'name' => 'Retinol Night Serum', 'sku' => 'RC-SRM-003', 'short_description' => 'Anti-aging powerhouse', 'base_price' => 1900, 'stock_quantity' => 28, 'skin_type' => 'all', 'badges' => ['new']],

            // SKINCARE - Cleansers (3 products)
            ['category' => 'Cleansers', 'name' => 'Gentle Foaming Face Wash', 'sku' => 'RC-CLN-001', 'short_description' => 'Deep cleansing formula', 'base_price' => 750, 'stock_quantity' => 55, 'skin_type' => 'combination', 'is_new_arrival' => true, 'badges' => ['new', 'vegan']],
            ['category' => 'Cleansers', 'name' => 'Micellar Water', 'sku' => 'RC-CLN-002', 'short_description' => 'Gentle makeup remover', 'base_price' => 650, 'stock_quantity' => 65, 'skin_type' => 'sensitive', 'badges' => ['vegan']],
            ['category' => 'Cleansers', 'name' => 'Charcoal Face Wash', 'sku' => 'RC-CLN-003', 'short_description' => 'Deep pore cleansing', 'base_price' => 800, 'stock_quantity' => 48, 'skin_type' => 'oily', 'badges' => ['organic']],

            // SKINCARE - Toners (3 products)
            ['category' => 'Toners', 'name' => 'Rose Water Toner', 'sku' => 'RC-TNR-001', 'short_description' => 'Soothing hydrating toner', 'base_price' => 550, 'stock_quantity' => 50, 'skin_type' => 'sensitive', 'badges' => ['organic', 'vegan']],
            ['category' => 'Toners', 'name' => 'Witch Hazel Toner', 'sku' => 'RC-TNR-002', 'short_description' => 'Pore minimizing formula', 'base_price' => 600, 'stock_quantity' => 42, 'skin_type' => 'oily', 'badges' => []],
            ['category' => 'Toners', 'name' => 'Green Tea Toner', 'sku' => 'RC-TNR-003', 'short_description' => 'Antioxidant protection', 'base_price' => 650, 'discount_price' => 499, 'stock_quantity' => 38, 'skin_type' => 'all', 'badges' => ['organic']],

            // SKINCARE - Face Masks (3 products)
            ['category' => 'Face Masks', 'name' => 'Charcoal Detox Mask', 'sku' => 'RC-MSK-001', 'short_description' => 'Deep cleansing clay mask', 'base_price' => 850, 'discount_price' => 699, 'stock_quantity' => 40, 'skin_type' => 'oily', 'is_bestseller' => true, 'badges' => ['bestseller']],
            ['category' => 'Face Masks', 'name' => 'Hydrating Sheet Mask', 'sku' => 'RC-MSK-002', 'short_description' => 'Instant moisture boost', 'base_price' => 250, 'stock_quantity' => 100, 'skin_type' => 'dry', 'badges' => []],
            ['category' => 'Face Masks', 'name' => 'Gold Radiance Mask', 'sku' => 'RC-MSK-003', 'short_description' => 'Luxurious golden glow', 'base_price' => 1200, 'discount_price' => 999, 'stock_quantity' => 25, 'skin_type' => 'all', 'badges' => ['limited-edition']],

            // HAIRCARE - Shampoos (3 products)
            ['category' => 'Shampoos', 'name' => 'Keratin Repair Shampoo', 'sku' => 'RC-SHP-001', 'short_description' => 'Strengthens damaged hair', 'base_price' => 650, 'stock_quantity' => 70, 'skin_type' => 'all', 'is_new_arrival' => true, 'badges' => ['new', 'vegan']],
            ['category' => 'Shampoos', 'name' => 'Volume Boost Shampoo', 'sku' => 'RC-SHP-002', 'short_description' => 'Fuller thicker hair', 'base_price' => 600, 'stock_quantity' => 58, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Shampoos', 'name' => 'Anti-Dandruff Shampoo', 'sku' => 'RC-SHP-003', 'short_description' => 'Flake-free scalp', 'base_price' => 700, 'stock_quantity' => 52, 'skin_type' => 'all', 'badges' => ['organic']],

            // HAIRCARE - Conditioners (3 products)
            ['category' => 'Conditioners', 'name' => 'Deep Conditioning Treatment', 'sku' => 'RC-CND-001', 'short_description' => 'Intensive moisture repair', 'base_price' => 750, 'stock_quantity' => 60, 'skin_type' => 'all', 'badges' => ['vegan']],
            ['category' => 'Conditioners', 'name' => 'Smoothing Conditioner', 'sku' => 'RC-CND-002', 'short_description' => 'Silky smooth results', 'base_price' => 680, 'stock_quantity' => 52, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Conditioners', 'name' => 'Color Protect Conditioner', 'sku' => 'RC-CND-003', 'short_description' => 'Locks in hair color', 'base_price' => 850, 'discount_price' => 699, 'stock_quantity' => 44, 'skin_type' => 'all', 'badges' => ['new']],

            // HAIRCARE - Hair Oils (3 products)
            ['category' => 'Hair Oils', 'name' => 'Argan Miracle Oil', 'sku' => 'RC-OIL-001', 'short_description' => '100% pure Argan oil', 'base_price' => 1100, 'discount_price' => 899, 'stock_quantity' => 35, 'skin_type' => 'all', 'is_featured' => true, 'badges' => ['organic', 'bestseller']],
            ['category' => 'Hair Oils', 'name' => 'Coconut Hair Oil', 'sku' => 'RC-OIL-002', 'short_description' => 'Natural coconut nourishment', 'base_price' => 450, 'stock_quantity' => 75, 'skin_type' => 'all', 'badges' => ['organic']],
            ['category' => 'Hair Oils', 'name' => 'Almond Oil - Strengthening', 'sku' => 'RC-OIL-003', 'short_description' => 'Strengthens hair roots', 'base_price' => 500, 'stock_quantity' => 68, 'skin_type' => 'all', 'badges' => ['vegan']],

            // HAIRCARE - Hair Masks (3 products)
            ['category' => 'Hair Masks', 'name' => 'Protein Repair Mask', 'sku' => 'RC-HMK-001', 'short_description' => 'Weekly deep treatment', 'base_price' => 950, 'stock_quantity' => 30, 'skin_type' => 'all', 'badges' => ['organic']],
            ['category' => 'Hair Masks', 'name' => 'Moisture Intense Mask', 'sku' => 'RC-HMK-002', 'short_description' => 'Ultra-hydrating formula', 'base_price' => 900, 'stock_quantity' => 35, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Hair Masks', 'name' => 'Damage Control Mask', 'sku' => 'RC-HMK-003', 'short_description' => 'Repairs split ends', 'base_price' => 1050, 'discount_price' => 849, 'stock_quantity' => 28, 'skin_type' => 'all', 'badges' => ['new']],

            // FRAGRANCES - Perfumes (3 products)
            ['category' => 'Perfumes', 'name' => 'Eternal Rose EDP', 'sku' => 'RC-PRF-001', 'short_description' => 'Luxurious floral fragrance', 'base_price' => 3500, 'discount_price' => 2999, 'stock_quantity' => 20, 'skin_type' => 'all', 'is_featured' => true, 'badges' => ['limited-edition']],
            ['category' => 'Perfumes', 'name' => 'Oriental Nights Perfume', 'sku' => 'RC-PRF-002', 'short_description' => 'Mysterious oriental scent', 'base_price' => 3200, 'stock_quantity' => 18, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Perfumes', 'name' => 'Citrus Bloom EDP', 'sku' => 'RC-PRF-003', 'short_description' => 'Fresh citrus notes', 'base_price' => 3000, 'stock_quantity' => 22, 'skin_type' => 'all', 'badges' => ['new']],

            // FRAGRANCES - Body Sprays (3 products)
            ['category' => 'Body Sprays', 'name' => 'Fresh Floral Mist', 'sku' => 'RC-SPR-001', 'short_description' => 'Light refreshing fragrance', 'base_price' => 450, 'stock_quantity' => 90, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Body Sprays', 'name' => 'Tropical Paradise Spray', 'sku' => 'RC-SPR-002', 'short_description' => 'Exotic tropical scent', 'base_price' => 500, 'stock_quantity' => 78, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Body Sprays', 'name' => 'Vanilla Dreams Mist', 'sku' => 'RC-SPR-003', 'short_description' => 'Sweet vanilla notes', 'base_price' => 480, 'discount_price' => 399, 'stock_quantity' => 85, 'skin_type' => 'all', 'badges' => ['bestseller']],

            // FRAGRANCES - Roll-ons (3 products)
            ['category' => 'Roll-ons', 'name' => 'Lavender Roll-on', 'sku' => 'RC-RLL-001', 'short_description' => 'Calming lavender scent', 'base_price' => 350, 'stock_quantity' => 95, 'skin_type' => 'all', 'badges' => ['organic']],
            ['category' => 'Roll-ons', 'name' => 'Jasmine Roll-on', 'sku' => 'RC-RLL-002', 'short_description' => 'Romantic jasmine aroma', 'base_price' => 380, 'stock_quantity' => 88, 'skin_type' => 'all', 'badges' => []],
            ['category' => 'Roll-ons', 'name' => 'Musk Roll-on', 'sku' => 'RC-RLL-003', 'short_description' => 'Long-lasting musk', 'base_price' => 400, 'discount_price' => 319, 'stock_quantity' => 92, 'skin_type' => 'all', 'badges' => ['new']],
        ];

        foreach ($products as $productData) {
            $category = $categories[$productData['category']] ?? null;
            if (!$category) continue;

            $productBadges = $productData['badges'] ?? [];
            unset($productData['badges'], $productData['category']);

            $product = Product::create(array_merge($productData, [
                'category_id' => $category->id,
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'long_description' => 'Premium quality cosmetic product from Rizla Cosmetics. Dermatologically tested and safe for daily use.',
                'ingredients' => 'Natural and safe ingredients. Free from harmful chemicals.',
                'how_to_use' => 'Apply as directed on the product packaging.',
                'discount_percentage' => $productData['discount_percentage'] ??
                    (isset($productData['discount_price']) ? round((($productData['base_price'] - $productData['discount_price']) / $productData['base_price']) * 100) : null),
                'is_featured' => $productData['is_featured'] ?? false,
                'is_bestseller' => $productData['is_bestseller'] ?? false,
                'is_new_arrival' => $productData['is_new_arrival'] ?? false,
                'is_active' => true,
                'low_stock_threshold' => 10,
            ]));

            foreach ($productBadges as $badgeSlug) {
                if (isset($badges[$badgeSlug])) {
                    $product->badges()->attach($badges[$badgeSlug]->id);
                }
            }
        }
    }
}

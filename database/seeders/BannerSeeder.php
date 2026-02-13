<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Spring Collection 2026',
                'description' => 'Discover our fresh new makeup collection for the season',
                'image_path' => 'banners/banner1.jpg', // User should add actual banner images
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Premium Skincare',
                'description' => 'Nourish your skin with our organic skincare range',
                'image_path' => 'banners/banner2.jpg',
                'button_text' => 'Explore',
                'button_link' => '/shop?category=skincare',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Up to 30% Off',
                'description' => 'Limited time offer on selected items',
                'image_path' => 'banners/banner3.jpg',
                'button_text' => 'Shop Sale',
                'button_link' => '/shop',
                'display_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        // Note: Add actual banner images to storage/app/public/banners/
        // Or update image_path values after uploading banners through admin panel
    }
}

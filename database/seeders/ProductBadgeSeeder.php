<?php

namespace Database\Seeders;

use App\Models\ProductBadge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'New',
                'slug' => 'new',
                'color_code' => '#10B981', // Green
                'icon' => 'sparkles',
                'is_active' => true,
            ],
            [
                'name' => 'Bestseller',
                'slug' => 'bestseller',
                'color_code' => '#F59E0B', // Amber
                'icon' => 'fire',
                'is_active' => true,
            ],
            [
                'name' => 'Limited Edition',
                'slug' => 'limited-edition',
                'color_code' => '#8B5CF6', // Purple
                'icon' => 'star',
                'is_active' => true,
            ],
            [
                'name' => 'Organic',
                'slug' => 'organic',
                'color_code' => '#059669', // Emerald
                'icon' => 'leaf',
                'is_active' => true,
            ],
            [
                'name' => 'Vegan',
                'slug' => 'vegan',
                'color_code' => '#14B8A6', // Teal
                'icon' => 'heart',
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badge) {
            ProductBadge::create($badge);
        }
    }
}

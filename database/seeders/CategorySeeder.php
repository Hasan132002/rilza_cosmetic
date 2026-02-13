<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makeup',
                'description' => 'Complete makeup collection for all your beauty needs',
                'is_active' => true,
                'sort_order' => 1,
                'subcategories' => ['Lipsticks', 'Foundations', 'Eyeshadows', 'Mascaras', 'Blush']
            ],
            [
                'name' => 'Skincare',
                'description' => 'Premium skincare products for healthy glowing skin',
                'is_active' => true,
                'sort_order' => 2,
                'subcategories' => ['Moisturizers', 'Serums', 'Cleansers', 'Toners', 'Face Masks']
            ],
            [
                'name' => 'Haircare',
                'description' => 'Hair products for beautiful and healthy hair',
                'is_active' => true,
                'sort_order' => 3,
                'subcategories' => ['Shampoos', 'Conditioners', 'Hair Oils', 'Hair Masks']
            ],
            [
                'name' => 'Fragrances',
                'description' => 'Captivating fragrances for every occasion',
                'is_active' => true,
                'sort_order' => 4,
                'subcategories' => ['Perfumes', 'Body Sprays', 'Roll-ons']
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'];
            unset($categoryData['subcategories']);

            $parent = \App\Models\Category::create(array_merge($categoryData, [
                'slug' => \Illuminate\Support\Str::slug($categoryData['name'])
            ]));

            foreach ($subcategories as $index => $subName) {
                \App\Models\Category::create([
                    'parent_id' => $parent->id,
                    'name' => $subName,
                    'slug' => \Illuminate\Support\Str::slug($subName),
                    'description' => $subName . ' products',
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }
}

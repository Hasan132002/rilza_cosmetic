<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::create([
            'message' => '✨ New Spring Collection is Here! Discover our latest beauty essentials and skincare innovations.',
            'link_url' => '/shop',
            'link_text' => 'Shop Now',
            'background_color' => '#ec4899',
            'text_color' => '#ffffff',
            'is_active' => true,
        ]);

        Announcement::create([
            'message' => '🎉 Special Offer: Get 20% off on all orders this weekend! Use code WEEKEND20 at checkout.',
            'link_url' => '/shop',
            'link_text' => 'View Products',
            'background_color' => '#8b5cf6',
            'text_color' => '#ffffff',
            'is_active' => true,
        ]);
    }
}

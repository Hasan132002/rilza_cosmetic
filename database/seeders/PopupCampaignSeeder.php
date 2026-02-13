<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PopupCampaign;

class PopupCampaignSeeder extends Seeder
{
    public function run(): void
    {
        $popups = [
            [
                'name' => 'Welcome Discount Popup',
                'type' => 'discount',
                'title' => 'Welcome to Rizla Cosmetics! 🎉',
                'description' => 'Get 10% OFF on your first order. Use code below at checkout!',
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
                'image' => null,
                'coupon_code' => 'WELCOME10',
                'delay_seconds' => 5,
                'show_on_exit' => false,
                'display_frequency' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Newsletter Subscription',
                'type' => 'newsletter',
                'title' => 'Join Our Beauty Community! 💄',
                'description' => 'Subscribe to get exclusive beauty tips, new product launches, and special offers!',
                'button_text' => null,
                'button_link' => null,
                'image' => null,
                'coupon_code' => null,
                'delay_seconds' => 10,
                'show_on_exit' => false,
                'display_frequency' => 7,
                'is_active' => false, // Disabled so both don't show
            ],
            [
                'name' => 'Exit Intent - Last Chance',
                'type' => 'discount',
                'title' => 'Wait! Don\'t Leave Empty Handed! 🛍️',
                'description' => 'Take 15% OFF your order before you go!',
                'button_text' => 'Claim Discount',
                'button_link' => '/shop',
                'image' => null,
                'coupon_code' => 'STAYWITH15',
                'delay_seconds' => 0,
                'show_on_exit' => true,
                'display_frequency' => 14,
                'is_active' => false, // Disabled for now
            ],
            [
                'name' => 'Flash Sale Announcement',
                'type' => 'announcement',
                'title' => '🔥 Flash Sale is LIVE! 🔥',
                'description' => 'Up to 50% OFF on selected products. Limited time only!',
                'button_text' => 'Shop Flash Sale',
                'button_link' => '/shop?flash_sale=1',
                'image' => null,
                'coupon_code' => null,
                'delay_seconds' => 3,
                'show_on_exit' => false,
                'display_frequency' => 1,
                'is_active' => false, // Disabled - enable when needed
            ],
        ];

        foreach ($popups as $popup) {
            PopupCampaign::create($popup);
            echo "✅ Created popup: {$popup['name']} (Type: {$popup['type']})\n";
        }

        echo "\n🎉 Popup Campaign Seeder Complete! Created " . count($popups) . " popups.\n";
        echo "💡 Activate them from Admin → Marketing → Popup Campaigns\n\n";
    }
}

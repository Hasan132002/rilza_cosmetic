<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Rizla Cosmetics', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Premium Beauty Products', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Your trusted source for premium cosmetics and beauty products', 'group' => 'general'],
            ['key' => 'site_currency', 'value' => 'PKR', 'group' => 'general'],

            // SEO Settings
            ['key' => 'seo_title', 'value' => 'Rizla Cosmetics - Premium Beauty Products', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'Shop premium beauty products at Rizla Cosmetics. Discover our wide range of cosmetics, skincare, and beauty essentials.', 'group' => 'seo'],
            ['key' => 'seo_keywords', 'value' => 'cosmetics, beauty products, makeup, skincare, lipstick, foundation', 'group' => 'seo'],
            ['key' => 'seo_google_analytics', 'value' => '', 'group' => 'seo'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/rizlacosmetics', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/rizlacosmetics', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/rizlacosmetics', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@rizlacosmetics', 'group' => 'social'],

            // Contact Info
            ['key' => 'contact_email', 'value' => 'info@rizlacosmetics.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+92 300 1234567', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Karachi, Pakistan', 'group' => 'contact'],

            // WhatsApp
            ['key' => 'whatsapp_enabled', 'value' => '1', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_number', 'value' => '+923001234567', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_message', 'value' => 'Hi! I would like to know more about your products.', 'group' => 'whatsapp'],

            // Instagram Feed
            ['key' => 'instagram_access_token', 'value' => '', 'group' => 'social'],
            ['key' => 'instagram_feed_enabled', 'value' => '0', 'group' => 'social'],
            ['key' => 'instagram_feed_limit', 'value' => '8', 'group' => 'social'],

            // Abandoned Cart
            ['key' => 'abandoned_cart_enabled', 'value' => '1', 'group' => 'features'],
            ['key' => 'abandoned_cart_hours', 'value' => '24', 'group' => 'features'],
            ['key' => 'abandoned_cart_coupon', 'value' => 'COMEBACK10', 'group' => 'features'],

            // Low Stock Alerts
            ['key' => 'low_stock_threshold', 'value' => '10', 'group' => 'inventory'],
            ['key' => 'low_stock_alert_enabled', 'value' => '1', 'group' => 'inventory'],
            ['key' => 'low_stock_alert_email', 'value' => 'admin@rizla.com', 'group' => 'inventory'],

            // Features
            ['key' => 'wishlist_enabled', 'value' => '1', 'group' => 'features'],
            ['key' => 'comparison_enabled', 'value' => '1', 'group' => 'features'],
            ['key' => 'reviews_enabled', 'value' => '1', 'group' => 'features'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

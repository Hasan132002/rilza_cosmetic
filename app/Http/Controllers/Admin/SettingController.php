<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        // Handle all settings including boolean checkboxes
        $booleanSettings = [
            'show_instagram_feed',
            'show_newsletter',
            'show_announcement',
            'show_blog',
            'show_wishlist',
            'show_comparison',
            'require_login_for_checkout',
            'allow_guest_checkout',
        ];

        foreach ($request->settings as $key => $value) {
            // Determine group from key prefix
            $group = 'general';

            if (str_starts_with($key, 'site_')) {
                $group = 'general';
            } elseif (str_starts_with($key, 'seo_')) {
                $group = 'seo';
            } elseif (str_starts_with($key, 'social_')) {
                $group = 'social';
            } elseif (str_starts_with($key, 'contact_')) {
                $group = 'contact';
            } elseif (str_starts_with($key, 'whatsapp_')) {
                $group = 'whatsapp';
            } elseif (str_starts_with($key, 'show_')) {
                $group = 'features';
                $type = 'boolean';
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        // Handle boolean settings that are unchecked (not in request)
        foreach ($booleanSettings as $boolKey) {
            if (!isset($request->settings[$boolKey])) {
                $boolGroup = 'features';
                if (str_starts_with($boolKey, 'require_') || str_starts_with($boolKey, 'allow_')) {
                    $boolGroup = 'checkout';
                }
                Setting::updateOrCreate(
                    ['key' => $boolKey],
                    ['value' => '0', 'group' => $boolGroup]
                );
            }
        }

        // Clear all settings cache
        Cache::flush();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}

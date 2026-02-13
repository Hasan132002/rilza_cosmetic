<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Settings</h1>
            <p class="text-gray-600 mt-1">Manage your website settings</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ activeTab: 'general' }">
                <!-- Settings Tabs -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-4 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Settings Groups</h3>
                        <nav class="space-y-2">
                            <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fas fa-cog mr-3"></i>
                                <span class="font-medium">General</span>
                            </button>
                            <button type="button" @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fas fa-search mr-3"></i>
                                <span class="font-medium">SEO</span>
                            </button>
                            <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fas fa-share-alt mr-3"></i>
                                <span class="font-medium">Social Media</span>
                            </button>
                            <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fas fa-envelope mr-3"></i>
                                <span class="font-medium">Contact Info</span>
                            </button>
                            <button type="button" @click="activeTab = 'whatsapp'" :class="activeTab === 'whatsapp' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fab fa-whatsapp mr-3"></i>
                                <span class="font-medium">WhatsApp</span>
                            </button>
                            <button type="button" @click="activeTab = 'features'" :class="activeTab === 'features' ? 'bg-pink-50 text-pink-600 border-pink-300' : 'text-gray-700 border-gray-200'" class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all flex items-center">
                                <i class="fas fa-toggle-on mr-3"></i>
                                <span class="font-medium">Features</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Settings Forms -->
                <div class="lg:col-span-2">
                    <!-- General Settings -->
                    <div x-show="activeTab === 'general'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">General Settings</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                                <input type="text" name="settings[site_name]" value="{{ $settings->get('general')?->where('key', 'site_name')->first()?->value ?? 'Rizla Cosmetics' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Tagline</label>
                                <input type="text" name="settings[site_tagline]" value="{{ $settings->get('general')?->where('key', 'site_tagline')->first()?->value ?? 'Premium Beauty Products' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                                <textarea name="settings[site_description]" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ $settings->get('general')?->where('key', 'site_description')->first()?->value ?? 'Your trusted source for premium cosmetics and beauty products' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select name="settings[site_currency]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    <option value="PKR" {{ ($settings->get('general')?->where('key', 'site_currency')->first()?->value ?? 'PKR') == 'PKR' ? 'selected' : '' }}>Pakistani Rupee (PKR)</option>
                                    <option value="USD" {{ ($settings->get('general')?->where('key', 'site_currency')->first()?->value ?? 'PKR') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                    <option value="EUR" {{ ($settings->get('general')?->where('key', 'site_currency')->first()?->value ?? 'PKR') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div x-show="activeTab === 'seo'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">SEO Settings</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input type="text" name="settings[seo_title]" value="{{ $settings->get('seo')?->where('key', 'seo_title')->first()?->value ?? 'Rizla Cosmetics - Premium Beauty Products' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="settings[seo_description]" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ $settings->get('seo')?->where('key', 'seo_description')->first()?->value ?? 'Shop premium beauty products at Rizla Cosmetics. Discover our wide range of cosmetics, skincare, and beauty essentials.' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="settings[seo_keywords]" value="{{ $settings->get('seo')?->where('key', 'seo_keywords')->first()?->value ?? 'cosmetics, beauty products, makeup, skincare, lipstick, foundation' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                <p class="text-xs text-gray-500 mt-1">Separate keywords with commas</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                                <input type="text" name="settings[seo_google_analytics]" value="{{ $settings->get('seo')?->where('key', 'seo_google_analytics')->first()?->value ?? '' }}" placeholder="G-XXXXXXXXXX" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Settings -->
                    <div x-show="activeTab === 'social'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Social Media Links</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fab fa-facebook mr-2 text-blue-600"></i>Facebook</label>
                                <input type="url" name="settings[social_facebook]" value="{{ $settings->get('social')?->where('key', 'social_facebook')->first()?->value ?? '' }}" placeholder="https://facebook.com/yourpage" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fab fa-instagram mr-2 text-pink-600"></i>Instagram</label>
                                <input type="url" name="settings[social_instagram]" value="{{ $settings->get('social')?->where('key', 'social_instagram')->first()?->value ?? '' }}" placeholder="https://instagram.com/yourprofile" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fab fa-twitter mr-2 text-blue-400"></i>Twitter</label>
                                <input type="url" name="settings[social_twitter]" value="{{ $settings->get('social')?->where('key', 'social_twitter')->first()?->value ?? '' }}" placeholder="https://twitter.com/yourhandle" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fab fa-youtube mr-2 text-red-600"></i>YouTube</label>
                                <input type="url" name="settings[social_youtube]" value="{{ $settings->get('social')?->where('key', 'social_youtube')->first()?->value ?? '' }}" placeholder="https://youtube.com/yourchannel" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fab fa-tiktok mr-2 text-gray-800"></i>TikTok</label>
                                <input type="url" name="settings[social_tiktok]" value="{{ $settings->get('social')?->where('key', 'social_tiktok')->first()?->value ?? '' }}" placeholder="https://tiktok.com/@yourprofile" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Settings -->
                    <div x-show="activeTab === 'contact'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Contact Information</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="settings[contact_email]" value="{{ $settings->get('contact')?->where('key', 'contact_email')->first()?->value ?? 'info@rizlacosmetics.com' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="settings[contact_phone]" value="{{ $settings->get('contact')?->where('key', 'contact_phone')->first()?->value ?? '+92 300 1234567' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="settings[contact_address]" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ $settings->get('contact')?->where('key', 'contact_address')->first()?->value ?? 'Karachi, Pakistan' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Settings -->
                    <div x-show="activeTab === 'whatsapp'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">WhatsApp Integration</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="settings[whatsapp_enabled]" value="1" {{ ($settings->get('whatsapp')?->where('key', 'whatsapp_enabled')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    <span class="ml-2 text-sm text-gray-700">Enable WhatsApp Chat Button</span>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                                <input type="text" name="settings[whatsapp_number]" value="{{ $settings->get('whatsapp')?->where('key', 'whatsapp_number')->first()?->value ?? '+923001234567' }}" placeholder="+923001234567" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                <p class="text-xs text-gray-500 mt-1">Include country code, no spaces or dashes</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Welcome Message</label>
                                <textarea name="settings[whatsapp_message]" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ $settings->get('whatsapp')?->where('key', 'whatsapp_message')->first()?->value ?? 'Hi! I would like to know more about your products.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Features Visibility Settings -->
                    <div x-show="activeTab === 'features'" class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Frontend Features Visibility</h3>
                        <p class="text-sm text-gray-600 mb-6">Control which features are visible on your frontend website. Unchecked features will be hidden from customers.</p>

                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_instagram_feed]" value="1" {{ ($settings->get('features')?->where('key', 'show_instagram_feed')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Instagram Feed</span>
                                        <p class="text-xs text-gray-500">Display Instagram feed on homepage</p>
                                    </div>
                                </label>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_newsletter]" value="1" {{ ($settings->get('features')?->where('key', 'show_newsletter')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Newsletter Subscription</span>
                                        <p class="text-xs text-gray-500">Show newsletter signup form in footer</p>
                                    </div>
                                </label>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_announcement]" value="1" {{ ($settings->get('features')?->where('key', 'show_announcement')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Announcement Bar</span>
                                        <p class="text-xs text-gray-500">Display top announcement bar with promotions</p>
                                    </div>
                                </label>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_blog]" value="1" {{ ($settings->get('features')?->where('key', 'show_blog')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Blog Section</span>
                                        <p class="text-xs text-gray-500">Show blog posts and articles section</p>
                                    </div>
                                </label>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_wishlist]" value="1" {{ ($settings->get('features')?->where('key', 'show_wishlist')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Wishlist Feature</span>
                                        <p class="text-xs text-gray-500">Enable wishlist functionality for customers</p>
                                    </div>
                                </label>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[show_comparison]" value="1" {{ ($settings->get('features')?->where('key', 'show_comparison')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Product Comparison</span>
                                        <p class="text-xs text-gray-500">Allow customers to compare products side by side</p>
                                    </div>
                                </label>
                            </div>

                            <!-- CHECKOUT SETTINGS -->
                            <div class="mt-6 mb-4">
                                <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-shopping-cart mr-2 text-pink-600"></i>
                                    Checkout Settings
                                </h4>
                            </div>

                            <div class="border-2 border-pink-200 bg-pink-50 rounded-lg p-4 hover:bg-pink-100 transition-colors">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="settings[require_login_for_checkout]" value="1" {{ ($settings->get('checkout')?->where('key', 'require_login_for_checkout')->first()?->value ?? '1') == '1' ? 'checked' : '' }} class="rounded border-pink-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500 mt-1 w-5 h-5">
                                    <div class="ml-3">
                                        <span class="text-sm font-bold text-pink-900">🔐 Require Login for Checkout</span>
                                        <p class="text-xs text-pink-700 mt-1">
                                            <strong>Checked:</strong> Customers MUST login/register before checkout<br>
                                            <strong>Unchecked:</strong> Guests can checkout without login
                                        </p>
                                        <div class="mt-2 p-2 bg-white rounded border border-pink-200">
                                            <p class="text-xs text-gray-600">
                                                <i class="fas fa-info-circle text-pink-600 mr-1"></i>
                                                <strong>Current:</strong> <span class="font-semibold">{{ ($settings->get('checkout')?->where('key', 'require_login_for_checkout')->first()?->value ?? '1') == '1' ? 'Login Required ✓' : 'Guest Checkout Allowed ✗' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="ml-3 text-sm text-blue-800">
                                    <strong>Note:</strong> Disabling features will hide them from the frontend but won't delete any data. You can re-enable them anytime.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-md font-medium">
                    <i class="fas fa-save mr-2"></i> Save All Settings
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

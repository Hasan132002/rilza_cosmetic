<x-admin-layout>
    <x-slot name="header">
        Create Product
    </x-slot>

    <div class="max-w-6xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Products</span>
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>

                        <div class="space-y-4">
                            <!-- Product Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- SKU & Category -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        SKU <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="sku" value="{{ old('sku') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" required
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Short Description
                                </label>
                                <textarea name="short_description" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">{{ old('short_description') }}</textarea>
                            </div>

                            <!-- Long Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Description
                                </label>
                                <textarea name="long_description" rows="6"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">{{ old('long_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Cosmetics Specific Fields -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Cosmetics Details</h3>

                        <div class="space-y-4">
                            <!-- Ingredients -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ingredients
                                </label>
                                <textarea name="ingredients" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200"
                                          placeholder="e.g., Castor Oil, Beeswax, Carnauba Wax, Vitamin E...">{{ old('ingredients') }}</textarea>
                            </div>

                            <!-- How to Use -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    How to Use
                                </label>
                                <textarea name="how_to_use" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200"
                                          placeholder="Application instructions...">{{ old('how_to_use') }}</textarea>
                            </div>

                            <!-- Skin Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Skin Type <span class="text-red-500">*</span>
                                </label>
                                <select name="skin_type" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                                    <option value="all">All Skin Types</option>
                                    <option value="dry">Dry Skin</option>
                                    <option value="oily">Oily Skin</option>
                                    <option value="combination">Combination Skin</option>
                                    <option value="sensitive">Sensitive Skin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pricing & Stock</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Base Price <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="base_price" value="{{ old('base_price') }}" step="0.01" required
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Discount Price
                                </label>
                                <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Stock Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Low Stock Threshold
                                </label>
                                <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 10) }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Product Images</h3>
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                        <p class="mt-2 text-xs text-gray-500">Upload multiple images. First image will be the primary image.</p>
                    </div>

                    <!-- Product Variants -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Product Variants</h3>
                            <button type="button" onclick="addVariant()" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Variant</span>
                            </button>
                        </div>

                        <!-- Variants Container -->
                        <div id="variants-container" class="space-y-4"></div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                            <i class="fas fa-info-circle mr-1"></i>
                            Add product variants like different colors, sizes, or styles. Price adjustment is added to base price.
                        </p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Product Flags -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Product Flags</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_bestseller" value="1" class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Bestseller</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_new_arrival" value="1" class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">New Arrival</span>
                            </label>
                        </div>
                    </div>

                    <!-- Badges -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Badges</h3>
                        <div class="space-y-2">
                            @foreach($badges as $badge)
                            <label class="flex items-center p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="checkbox" name="badge_ids[]" value="{{ $badge->id }}" class="rounded border-gray-300 text-pink-600">
                                <span class="ml-2 px-2 py-1 text-xs font-medium rounded" style="background-color: {{ $badge->color_code }}20; color: {{ $badge->color_code }}">
                                    {{ $badge->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- B2B Wholesale Pricing -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-800 rounded-lg shadow-lg p-6 border-2 border-purple-200 dark:border-purple-900">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <i class="fas fa-store text-purple-600 mr-2"></i>
                                B2B Wholesale Pricing
                            </h3>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available_for_b2b" value="1" checked class="rounded border-gray-300 text-purple-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Available for B2B</span>
                            </label>
                        </div>

                        <div class="space-y-4">
                            <!-- Wholesale Base Price -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Wholesale Price (Rs) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" step="0.01" name="b2b_wholesale_price" value="{{ old('b2b_wholesale_price') }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                           placeholder="0.00">
                                    <p class="text-xs text-gray-500 mt-1">Base price for B2B customers</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Minimum Order Quantity (MOQ)
                                    </label>
                                    <input type="number" name="b2b_moq" value="{{ old('b2b_moq', 10) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                           placeholder="10">
                                    <p class="text-xs text-gray-500 mt-1">Minimum units per order</p>
                                </div>
                            </div>

                            <!-- Bulk Pricing Tiers -->
                            <div class="border-t border-purple-200 dark:border-purple-800 pt-4">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Bulk Discount Tiers (Optional)</h4>

                                <!-- Tier 1 -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 1 - Quantity (e.g., 50)
                                        </label>
                                        <input type="number" name="bulk_tier_1_qty" value="{{ old('bulk_tier_1_qty') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="50">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 1 - Price (Rs)
                                        </label>
                                        <input type="number" step="0.01" name="bulk_tier_1_price" value="{{ old('bulk_tier_1_price') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Tier 2 -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 2 - Quantity (e.g., 100)
                                        </label>
                                        <input type="number" name="bulk_tier_2_qty" value="{{ old('bulk_tier_2_qty') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 2 - Price (Rs)
                                        </label>
                                        <input type="number" step="0.01" name="bulk_tier_2_price" value="{{ old('bulk_tier_2_price') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Tier 3 -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 3 - Quantity (e.g., 200)
                                        </label>
                                        <input type="number" name="bulk_tier_3_qty" value="{{ old('bulk_tier_3_qty') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Tier 3 - Price (Rs)
                                        </label>
                                        <input type="number" step="0.01" name="bulk_tier_3_price" value="{{ old('bulk_tier_3_price') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-gray-200"
                                               placeholder="0.00">
                                    </div>
                                </div>

                                <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <p class="text-xs text-blue-700 dark:text-blue-300">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Tip:</strong> Set lower prices for higher quantities to encourage bulk orders. Example: 50+ units @ Rs 90, 100+ @ Rs 85, 200+ @ Rs 80
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">SEO</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Title</label>
                                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-gray-200">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md">
                    Create Product
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let variantCount = 0;

        function addVariant() {
            variantCount++;
            const container = document.getElementById('variants-container');
            const variantHtml = `
                <div class="variant-item bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border-2 border-dashed border-gray-300 dark:border-gray-600" id="variant-${variantCount}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                            <i class="fas fa-palette mr-2 text-purple-600"></i>New Variant #${variantCount}
                        </h4>
                        <button type="button" onclick="removeVariant(${variantCount})" class="text-red-600 hover:text-red-800 dark:text-red-400">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Variant Name <span class="text-red-500">*</span></label>
                            <input type="text" name="variants[${variantCount}][variant_name]" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-200"
                                   placeholder="e.g., Red, Large, Matte Finish">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Variant SKU <span class="text-red-500">*</span></label>
                            <input type="text" name="variants[${variantCount}][variant_sku]" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-200"
                                   placeholder="e.g., PROD-RED">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Adjustment</label>
                            <input type="number" name="variants[${variantCount}][price_adjustment]" value="0" step="0.01"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-200"
                                   placeholder="0.00">
                            <p class="text-xs text-gray-500 mt-1">Amount to add/subtract from base price</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity <span class="text-red-500">*</span></label>
                            <input type="number" name="variants[${variantCount}][stock_quantity]" value="0" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-200">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Variant Image</label>
                            <input type="file" name="variants[${variantCount}][image]" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-800 dark:text-gray-200">
                            <p class="text-xs text-gray-500 mt-1">Optional image specific to this variant</p>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', variantHtml);
        }

        function removeVariant(id) {
            const element = document.getElementById(`variant-${id}`);
            if (element) {
                element.remove();
            }
        }
    </script>
    @endpush
</x-admin-layout>

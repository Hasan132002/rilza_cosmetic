<x-frontend-layout :title="$product->name">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-pink-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shop') }}" class="hover:text-pink-600">Shop</a>
            <span class="mx-2">/</span>
            <a href="{{ route('category', $product->category->slug) }}" class="hover:text-pink-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
            <!-- Product Images -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                    @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-96 object-cover rounded-lg mb-4">
                    @endif

                    <!-- Thumbnail Gallery -->
                    @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-4">
                    @foreach($product->badges as $badge)
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded mr-2 mb-2" style="background-color: {{ $badge->color_code }}; color: white;">
                        {{ $badge->name }}
                    </span>
                    @endforeach
                </div>

                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $product->name }}</h1>

                @auth
                    @if(auth()->user()->isB2BApproved() && $product->isAvailableForB2B())
                        <!-- B2B Pricing Display -->
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border-2 border-green-200">
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold">
                                    <i class="fas fa-briefcase mr-2"></i>Business Pricing
                                </span>
                                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-bold">
                                    <i class="fas fa-box mr-2"></i>MOQ: {{ $product->b2bPricing->minimum_order_quantity }} units
                                </span>
                            </div>

                            <div class="flex items-center space-x-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Market Price</p>
                                    <span class="text-xl text-gray-400 line-through">Rs {{ number_format($product->final_price, 0) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Your Wholesale Price</p>
                                    <span class="text-4xl font-bold text-green-600">Rs {{ number_format($product->b2bPricing->wholesale_price, 0) }}</span>
                                </div>
                                <div class="bg-red-500 text-white px-4 py-3 rounded-xl">
                                    <p class="text-xs mb-1">You Save</p>
                                    <p class="text-2xl font-bold">{{ round((($product->final_price - $product->b2bPricing->wholesale_price) / $product->final_price) * 100) }}%</p>
                                </div>
                            </div>

                            <!-- Bulk Pricing Tiers -->
                            @if($product->b2bPricing->getBulkTiers())
                            <div class="mt-6">
                                <button onclick="toggleBulkPricing()" class="text-purple-600 hover:text-purple-800 font-semibold flex items-center gap-2">
                                    <i class="fas fa-chart-line"></i>
                                    <span>View Bulk Pricing Tiers</span>
                                    <i class="fas fa-chevron-down" id="bulk-pricing-icon"></i>
                                </button>

                                <div id="bulk-pricing-table" class="hidden mt-4 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg">
                                    <h4 class="font-bold text-lg mb-3 text-gray-900 dark:text-gray-100">
                                        <i class="fas fa-layer-group text-purple-600 mr-2"></i>Volume Discounts
                                    </h4>
                                    <div class="overflow-x-auto">
                                        <table class="w-full">
                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Quantity</th>
                                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Price per Unit</th>
                                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">You Save</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                                    <td class="px-4 py-3 text-sm">{{ $product->b2bPricing->minimum_order_quantity }}+ units</td>
                                                    <td class="px-4 py-3 text-sm font-bold text-green-600">Rs {{ number_format($product->b2bPricing->wholesale_price, 0) }}</td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">Base wholesale price</td>
                                                </tr>
                                                @foreach($product->b2bPricing->getBulkTiers() as $tier)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                                    <td class="px-4 py-3 text-sm font-semibold">{{ $tier['label'] }}</td>
                                                    <td class="px-4 py-3 text-sm font-bold text-green-600">Rs {{ number_format($tier['price'], 0) }}</td>
                                                    <td class="px-4 py-3 text-sm">
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-bold">
                                                            {{ round((($product->b2bPricing->wholesale_price - $tier['price']) / $product->b2bPricing->wholesale_price) * 100) }}% off
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Savings Calculator -->
                                    <div class="mt-6 bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4">
                                        <h5 class="font-bold text-sm mb-3 text-purple-900 dark:text-purple-100">
                                            <i class="fas fa-calculator mr-2"></i>Calculate Your Savings
                                        </h5>
                                        <div class="flex items-end gap-3">
                                            <div class="flex-1">
                                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Order Quantity</label>
                                                <input type="number" id="savings-calc-qty" min="{{ $product->b2bPricing->minimum_order_quantity }}" value="{{ $product->b2bPricing->minimum_order_quantity }}" class="w-full px-3 py-2 border-2 border-purple-300 rounded-lg focus:border-purple-500">
                                            </div>
                                            <button onclick="calculateSavings({{ $product->id }})" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold">
                                                Calculate
                                            </button>
                                        </div>
                                        <div id="savings-result" class="mt-3 hidden">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">Your Cost</p>
                                                    <p class="text-lg font-bold text-green-600">Rs <span id="savings-cost">0</span></p>
                                                </div>
                                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">You Save</p>
                                                    <p class="text-lg font-bold text-red-600">Rs <span id="savings-amount">0</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- B2C Pricing Display -->
                        <div class="flex items-center space-x-4 mb-6">
                            @if($product->is_on_sale)
                            <span class="text-3xl font-bold text-pink-600">Rs {{ number_format($product->discount_price, 0) }}</span>
                            <span class="text-xl text-gray-400 line-through">Rs {{ number_format($product->base_price, 0) }}</span>
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @else
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rs {{ number_format($product->base_price, 0) }}</span>
                            @endif
                        </div>
                    @endif
                @else
                    <!-- Guest Pricing Display -->
                    <div class="flex items-center space-x-4 mb-6">
                        @if($product->is_on_sale)
                        <span class="text-3xl font-bold text-pink-600">Rs {{ number_format($product->discount_price, 0) }}</span>
                        <span class="text-xl text-gray-400 line-through">Rs {{ number_format($product->base_price, 0) }}</span>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            -{{ $product->discount_percentage }}%
                        </span>
                        @else
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rs {{ number_format($product->base_price, 0) }}</span>
                        @endif
                    </div>
                @endauth

                @if($product->short_description)
                <p class="text-gray-700 dark:text-gray-300 mb-6 text-lg">{{ $product->short_description }}</p>
                @endif

                <!-- Stock Status with Low Stock Alert -->
                <div class="mb-6">
                    @if($product->stock_quantity > 0)
                        @if($product->is_low_stock)
                        <!-- Low Stock Alert - Prominent Display -->
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-2 border-orange-400 dark:border-orange-600 rounded-xl p-4 mb-4 animate-pulse">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center animate-bounce">
                                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-orange-800 dark:text-orange-300 font-bold text-lg mb-1">
                                        <i class="fas fa-fire animate-pulse text-red-500"></i> Hurry! Low Stock Alert
                                    </h4>
                                    <p class="text-orange-700 dark:text-orange-400 font-semibold text-base">
                                        Only <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $product->stock_quantity }}</span> left in stock!
                                    </p>
                                    <p class="text-orange-600 dark:text-orange-500 text-sm mt-1">
                                        Order now before it's gone! 🔥
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Regular In Stock Display -->
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400 font-medium bg-green-50 dark:bg-green-900/20 px-4 py-2 rounded-lg">
                            <i class="fas fa-check-circle text-lg"></i>
                            <span>In Stock ({{ $product->stock_quantity }} available)</span>
                        </div>
                        @endif
                    @else
                    <!-- Out of Stock Display -->
                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400 font-medium bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg">
                        <i class="fas fa-times-circle text-lg"></i>
                        <span>Out of Stock</span>
                    </div>
                    @endif
                </div>

                <!-- Skin Type -->
                <div class="mb-6">
                    <span class="text-gray-700 dark:text-gray-300">
                        <strong>Suitable for:</strong> {{ ucfirst(str_replace('_', ' ', $product->skin_type)) }}
                    </span>
                </div>

                <!-- Add to Cart -->
                <div class="mb-8">
                    <button onclick="addToCartAjax({{ $product->id }}, 1)"
                            data-product-id="{{ $product->id }}"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg transition-all flex items-center space-x-2 hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="btn-text">Add to Cart</span>
                        <i class="fas fa-spinner fa-spin btn-spinner hidden"></i>
                    </button>
                </div>

                <!-- Product Details Tabs -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div x-data="{ tab: 'description' }">
                        <!-- Tabs -->
                        <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700 mb-6">
                            <button @click="tab = 'description'"
                                    :class="tab === 'description' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-600 dark:text-gray-400'"
                                    class="pb-3 border-b-2 font-medium">
                                Description
                            </button>
                            @if($product->ingredients)
                            <button @click="tab = 'ingredients'"
                                    :class="tab === 'ingredients' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-600 dark:text-gray-400'"
                                    class="pb-3 border-b-2 font-medium">
                                Ingredients
                            </button>
                            @endif
                            @if($product->how_to_use)
                            <button @click="tab = 'usage'"
                                    :class="tab === 'usage' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-600 dark:text-gray-400'"
                                    class="pb-3 border-b-2 font-medium">
                                How to Use
                            </button>
                            @endif
                        </div>

                        <!-- Tab Content -->
                        <div x-show="tab === 'description'" class="text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($product->long_description ?? $product->short_description)) !!}
                        </div>

                        @if($product->ingredients)
                        <div x-show="tab === 'ingredients'" class="text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($product->ingredients)) !!}
                        </div>
                        @endif

                        @if($product->how_to_use)
                        <div x-show="tab === 'usage'" class="text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($product->how_to_use)) !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <section class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                @include('frontend.components.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
        @endif
    </div>

    @push('scripts')
    <script>
        function toggleBulkPricing() {
            const table = document.getElementById('bulk-pricing-table');
            const icon = document.getElementById('bulk-pricing-icon');

            if (table.classList.contains('hidden')) {
                table.classList.remove('hidden');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                table.classList.add('hidden');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        function calculateSavings(productId) {
            const quantity = parseInt(document.getElementById('savings-calc-qty').value);
            const resultDiv = document.getElementById('savings-result');

            if (!quantity || quantity < 1) {
                alert('Please enter a valid quantity');
                return;
            }

            // Make AJAX request to calculate savings
            fetch(`/api/products/${productId}/calculate-b2b-savings`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('savings-cost').textContent = data.discounted_total.toLocaleString();
                    document.getElementById('savings-amount').textContent = data.savings_amount.toLocaleString();
                    resultDiv.classList.remove('hidden');
                } else {
                    alert(data.message || 'Error calculating savings');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to calculate savings');
            });
        }
    </script>
    @endpush
</x-frontend-layout>

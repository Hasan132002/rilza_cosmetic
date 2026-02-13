<div class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover-lift group relative product-hover-effect">
    <a href="{{ route('product', $product->slug) }}">
        <!-- Product Image -->
        <div class="relative h-72 bg-gradient-to-br from-pink-50 to-purple-50 overflow-hidden product-image-wrapper">
            @if($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-2">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-image text-6xl text-gray-300"></i>
            </div>
            @endif

            <!-- Sparkle Effect on Hover -->
            <div class="sparkle-container absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="sparkle sparkle-1"></div>
                <div class="sparkle sparkle-2"></div>
                <div class="sparkle sparkle-3"></div>
            </div>

            <!-- Badges -->
            <div class="absolute top-4 left-4 space-y-2">
                @foreach($product->badges as $badge)
                <span class="badge-animate block px-3 py-1.5 text-xs font-bold rounded-full shadow-lg backdrop-blur-sm" style="background-color: {{ $badge->color_code }}; color: white;">
                    <i class="fas fa-{{ $badge->icon ?? 'star' }} mr-1"></i>{{ $badge->name }}
                </span>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                @auth
                <button onclick="addToWishlistAjax({{ $product->id }}, event)"
                        class="wishlist-btn w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all"
                        data-product-id="{{ $product->id }}">
                    <i class="fas fa-heart wishlist-icon"></i>
                </button>
                @else
                <a href="{{ route('login') }}" class="w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all" title="Login to add to wishlist">
                    <i class="fas fa-heart"></i>
                </a>
                @endauth
                <button onclick="openQuickView({{ $product->id }}, event)"
                        class="w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all"
                        title="Quick View">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- Out of Stock Overlay -->
            @if($product->stock_quantity == 0)
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center">
                <span class="bg-red-500 text-white px-6 py-3 rounded-full font-bold shadow-xl">
                    <i class="fas fa-times-circle mr-2"></i>{{ __('messages.Out of Stock') }}
                </span>
            </div>
            @endif

            <!-- Sale Badge with Pulse Animation -->
            @if($product->is_on_sale && $product->discount_percentage)
            <div class="absolute bottom-4 right-4">
                <div class="bg-red-500 text-white w-16 h-16 rounded-full flex flex-col items-center justify-center shadow-xl font-bold sale-badge-pulse">
                    <span class="text-xs">SAVE</span>
                    <span class="text-lg">{{ $product->discount_percentage }}%</span>
                </div>
            </div>
            @endif

            <!-- Low Stock Ribbon Banner -->
            @if($product->stock_quantity > 0 && $product->is_low_stock)
            <div class="absolute top-1/2 -right-2 transform -translate-y-1/2 rotate-45 origin-center">
                <div class="bg-gradient-to-r from-orange-600 via-red-600 to-orange-600 text-white px-12 py-2 shadow-2xl">
                    <div class="flex items-center gap-2 text-xs font-bold whitespace-nowrap animate-pulse">
                        <i class="fas fa-bolt"></i>
                        <span>ONLY {{ $product->stock_quantity }}</span>
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="p-6">
            <p class="text-xs text-pink-600 font-semibold mb-2 uppercase tracking-wide">{{ $product->category->name }}</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors line-clamp-2">
                {{ $product->name }}
            </h3>

            @if($product->short_description)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $product->short_description }}</p>
            @endif

            <!-- Price -->
            <div class="flex flex-col mb-4">
                @auth
                    @if(auth()->user()->isB2BApproved() && $product->isAvailableForB2B())
                        <!-- B2B Pricing Display -->
                        <div class="space-y-2">
                            <!-- Market Price (Crossed Out) -->
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-400 line-through">Market: Rs {{ number_format($product->final_price, 0) }}</span>
                            </div>

                            <!-- Wholesale Price (Highlighted) -->
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-green-600 animate-price-drop">Rs {{ number_format($product->b2bPricing->wholesale_price, 0) }}</span>
                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs font-bold">Wholesale</span>
                            </div>

                            <!-- MOQ Badge -->
                            <div class="inline-flex items-center gap-1 bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-box"></i>
                                <span>MOQ: {{ $product->b2bPricing->minimum_order_quantity }} units</span>
                            </div>
                        </div>
                    @else
                        <!-- B2C Pricing Display -->
                        <div class="price-animate">
                            @if($product->is_on_sale)
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-pink-600 animate-price-drop">Rs {{ number_format($product->discount_price, 0) }}</span>
                                <span class="text-sm text-gray-400 line-through">Rs {{ number_format($product->base_price, 0) }}</span>
                            </div>
                            @else
                            <span class="text-2xl font-bold text-gray-900">Rs {{ number_format($product->base_price, 0) }}</span>
                            @endif
                        </div>
                    @endif
                @else
                    <!-- Guest/B2C Pricing Display -->
                    <div class="price-animate">
                        @if($product->is_on_sale)
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-pink-600 animate-price-drop">Rs {{ number_format($product->discount_price, 0) }}</span>
                            <span class="text-sm text-gray-400 line-through">Rs {{ number_format($product->base_price, 0) }}</span>
                        </div>
                        @else
                        <span class="text-2xl font-bold text-gray-900">Rs {{ number_format($product->base_price, 0) }}</span>
                        @endif
                    </div>
                @endauth

                <!-- Enhanced Stock Indicator with Pulse and Badge -->
                <div class="mt-2">
                    @if($product->stock_quantity > 0 && $product->is_low_stock)
                    <div class="flex items-center gap-1 bg-gradient-to-r from-orange-500 to-red-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg animate-pulse">
                        <i class="fas fa-fire"></i>
                        <span>{{ __('messages.Only :count left!', ['count' => $product->stock_quantity]) }}</span>
                    </div>
                    @elseif($product->stock_quantity > 0)
                    <span class="text-xs text-green-600 font-semibold flex items-center gap-1">
                        <i class="fas fa-check-circle"></i> {{ __('messages.In Stock') }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Add to Cart Button with Bounce Animation -->
            <button onclick="addToCartAjax({{ $product->id }}, 1)" class="add-to-cart-btn w-full gradient-pink text-white py-3 rounded-xl font-bold hover:shadow-xl transition-all transform hover:scale-105 hover:-translate-y-1 flex items-center justify-center gap-2 relative overflow-hidden" data-product-id="{{ $product->id }}">
                <span class="btn-icon"><i class="fas fa-shopping-cart"></i></span>
                <span class="btn-text">{{ __('messages.Add to Cart') }}</span>
                <span class="btn-spinner hidden">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                <span class="btn-success hidden">
                    <i class="fas fa-check-circle"></i> Added!
                </span>
            </button>
        </div>
    </a>
</div>

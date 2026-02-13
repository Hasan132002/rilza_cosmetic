<x-frontend-layout title="Offers & Discounts">
    <!-- Header Section -->
    <section class="gradient-pink text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-20 w-72 h-72 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    <i class="fas fa-tags mr-3"></i>Special Offers
                </h1>
                <p class="text-xl text-pink-100">Amazing deals and discounts just for you!</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <!-- Active Coupons -->
        @if($coupons->count() > 0)
        <section class="mb-16" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <i class="fas fa-ticket-alt text-pink-600 mr-2"></i>Active Coupon Codes
                </h2>
                <p class="text-gray-600">Copy these codes and use them at checkout!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($coupons as $coupon)
                <div class="border-2 border-dashed border-pink-300 rounded-2xl p-6 hover:border-pink-500 transition-all hover:shadow-xl" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-full font-bold text-lg mb-3">
                                <i class="fas fa-percent"></i>
                                @if($coupon->discount_type === 'percentage')
                                    {{ $coupon->discount_value }}% OFF
                                @else
                                    Rs {{ number_format($coupon->discount_value) }} OFF
                                @endif
                            </div>
                            <h3 class="font-bold text-xl mb-2">{{ $coupon->name }}</h3>
                            @if($coupon->description)
                            <p class="text-gray-600 text-sm mb-3">{{ $coupon->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="flex items-center justify-between">
                            <div class="font-mono font-bold text-xl text-pink-600">{{ $coupon->code }}</div>
                            <button onclick="copyCoupon('{{ $coupon->code }}')"
                                    class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors text-sm font-semibold">
                                <i class="fas fa-copy mr-1"></i>Copy
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        @if($coupon->min_purchase_amount)
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart w-5 text-pink-500"></i>
                            <span>Min purchase: Rs {{ number_format($coupon->min_purchase_amount) }}</span>
                        </div>
                        @endif
                        @if($coupon->max_discount_amount)
                        <div class="flex items-center">
                            <i class="fas fa-hand-holding-usd w-5 text-pink-500"></i>
                            <span>Max discount: Rs {{ number_format($coupon->max_discount_amount) }}</span>
                        </div>
                        @endif
                        @if($coupon->usage_limit_per_user)
                        <div class="flex items-center">
                            <i class="fas fa-user w-5 text-pink-500"></i>
                            <span>{{ $coupon->usage_limit_per_user }} use per customer</span>
                        </div>
                        @endif
                        @if($coupon->valid_until)
                        <div class="flex items-center">
                            <i class="fas fa-clock w-5 text-pink-500"></i>
                            <span>Valid until: {{ $coupon->valid_until->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Flash Sales -->
        @if($flashSales->count() > 0)
        <section class="mb-16" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>Flash Sales
                </h2>
                <p class="text-gray-600">Limited time offers - Hurry up!</p>
            </div>

            @foreach($flashSales as $sale)
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-3xl p-8 mb-8 border-2 border-yellow-200" data-aos="fade-up">
                <div class="flex flex-col md:flex-row items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ $sale->name }}</h3>
                        @if($sale->description)
                        <p class="text-gray-600">{{ $sale->description }}</p>
                        @endif
                    </div>
                    <div class="text-center mt-4 md:mt-0">
                        <div class="bg-red-600 text-white px-6 py-3 rounded-full font-bold text-xl">
                            <i class="fas fa-fire mr-2"></i>{{ $sale->discount_percentage }}% OFF
                        </div>
                        <div class="text-sm text-gray-600 mt-2">
                            Ends: {{ $sale->end_time->format('M d, Y h:i A') }}
                        </div>
                    </div>
                </div>

                @if($sale->products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($sale->products as $product)
                    <a href="{{ route('product', $product->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all transform hover:scale-105">
                        @if($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold text-sm mb-2 line-clamp-2">{{ $product->name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="text-pink-600 font-bold">Rs {{ number_format($product->final_price) }}</span>
                                @if($product->is_on_sale)
                                <span class="text-gray-400 line-through text-sm">Rs {{ number_format($product->base_price) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </section>
        @endif

        <!-- Discounted Products -->
        @if($discountedProducts->count() > 0)
        <section class="mb-16" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <i class="fas fa-star text-pink-600 mr-2"></i>Products on Sale
                </h2>
                <p class="text-gray-600">Don't miss these amazing discounts!</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($discountedProducts as $product)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:scale-105" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('product', $product->slug) }}" class="block relative">
                        @if($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-64 object-cover">
                        @endif

                        <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full font-bold text-sm">
                            -{{ $product->discount_percentage }}%
                        </div>

                        @if($product->badges->count() > 0)
                        <div class="absolute top-4 left-4 space-y-2">
                            @foreach($product->badges as $badge)
                            <span class="block bg-{{ $badge->color }}-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $badge->name }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </a>

                    <div class="p-5">
                        <div class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</div>
                        <h3 class="font-bold text-lg mb-3 line-clamp-2">
                            <a href="{{ route('product', $product->slug) }}" class="hover:text-pink-600 transition-colors">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-pink-600 font-bold text-xl">
                                    Rs {{ number_format($product->final_price) }}
                                </div>
                                <div class="text-gray-400 line-through text-sm">
                                    Rs {{ number_format($product->base_price) }}
                                </div>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-full hover:shadow-lg transition-all">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('shop') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all transform hover:scale-105">
                    View All Products <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </section>
        @endif

        <!-- Bestsellers on Sale -->
        @if($bestsellersOnSale->count() > 0)
        <section data-aos="fade-up">
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-3xl p-8 text-white">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        <i class="fas fa-fire mr-2"></i>Bestsellers on Sale
                    </h2>
                    <p class="text-pink-100">Our most popular products at discounted prices!</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($bestsellersOnSale as $product)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:scale-105">
                        <a href="{{ route('product', $product->slug) }}" class="block relative">
                            @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-56 object-cover">
                            @endif

                            <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full font-bold text-sm">
                                -{{ $product->discount_percentage }}%
                            </div>
                        </a>

                        <div class="p-5 text-gray-800">
                            <h3 class="font-bold text-lg mb-3 line-clamp-2">
                                <a href="{{ route('product', $product->slug) }}" class="hover:text-pink-600 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-pink-600 font-bold text-xl">
                                        Rs {{ number_format($product->final_price) }}
                                    </div>
                                    <div class="text-gray-400 line-through text-sm">
                                        Rs {{ number_format($product->base_price) }}
                                    </div>
                                </div>
                                <div class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i>Bestseller
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- No Offers Message -->
        @if($coupons->count() === 0 && $flashSales->count() === 0 && $discountedProducts->count() === 0)
        <div class="text-center py-16" data-aos="fade-up">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                <i class="fas fa-tags text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold mb-3">No Active Offers Right Now</h3>
            <p class="text-gray-600 mb-6">Check back soon for amazing deals and discounts!</p>
            <a href="{{ route('shop') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all">
                Continue Shopping <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function copyCoupon(code) {
            navigator.clipboard.writeText(code).then(() => {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Coupon code copied!';
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }).catch(err => {
                alert('Failed to copy coupon code: ' + err);
            });
        }
    </script>
    @endpush
</x-frontend-layout>

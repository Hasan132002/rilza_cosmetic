<x-frontend-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Wishlist</h1>
                <p class="text-gray-600 mt-2">Your favorite products saved for later</p>
            </div>

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300" data-wishlist-id="{{ $item->id }}">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden group">
                                <a href="{{ route('product', $item->product->slug) }}">
                                    @if($item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </a>

                                <!-- Remove Button -->
                                <button onclick="removeFromWishlist({{ $item->id }})"
                                        class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-red-500 hover:text-white transition-all duration-300 group/btn">
                                    <i class="fas fa-times text-lg"></i>
                                </button>

                                <!-- Stock Status -->
                                @if($item->product->stock_quantity == 0)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Out of Stock
                                        </span>
                                    </div>
                                @elseif($item->product->stock_quantity <= 10)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Low Stock
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Category -->
                                <p class="text-xs text-gray-500 mb-2">{{ $item->product->category->name }}</p>

                                <!-- Product Name -->
                                <a href="{{ route('product', $item->product->slug) }}" class="block">
                                    <h3 class="font-semibold text-gray-900 mb-2 hover:text-pink-600 transition-colors line-clamp-2">
                                        {{ $item->product->name }}
                                    </h3>
                                </a>

                                <!-- Price -->
                                <div class="flex items-center gap-2 mb-4">
                                    @if($item->product->discount_price)
                                        <span class="text-xl font-bold text-pink-600">PKR {{ number_format($item->product->discount_price, 0) }}</span>
                                        <span class="text-sm text-gray-500 line-through">PKR {{ number_format($item->product->price, 0) }}</span>
                                    @else
                                        <span class="text-xl font-bold text-gray-900">PKR {{ number_format($item->product->price, 0) }}</span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button -->
                                @if($item->product->stock_quantity > 0)
                                    <button onclick="addToCartAjax({{ $item->product->id }}, 1)"
                                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center gap-2"
                                            data-product-id="{{ $item->product->id }}">
                                        <i class="fas fa-shopping-cart btn-icon"></i>
                                        <span class="btn-text">Add to Cart</span>
                                        <i class="fas fa-spinner fa-spin btn-spinner hidden"></i>
                                    </button>
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg font-medium cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty Wishlist -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Your wishlist is empty</h2>
                    <p class="text-gray-600 mb-6">Start adding products you love!</p>
                    <a href="{{ route('shop') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function removeFromWishlist(id) {
            if (!confirm('Remove this product from your wishlist?')) {
                return;
            }

            fetch(`/wishlist/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the product card with animation
                    const card = document.querySelector(`[data-wishlist-id="${id}"]`);
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.remove();

                        // Check if wishlist is empty
                        const remainingItems = document.querySelectorAll('[data-wishlist-id]');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart!');
                } else {
                    alert(data.message || 'Failed to add product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    </script>
    @endpush
</x-frontend-layout>

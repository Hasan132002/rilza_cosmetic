<x-frontend-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Compare Products</h1>
                    <p class="text-gray-600 mt-2">Compare up to 4 products side by side</p>
                </div>
                @if($comparisons->count() > 0)
                    <button onclick="clearComparison()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-trash mr-2"></i> Clear All
                    </button>
                @endif
            </div>

            @if($comparisons->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                    <table class="w-full">
                        <!-- Product Images -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50 w-48">Product</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4 text-center">
                                    <div class="relative">
                                        @if($comparison->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $comparison->product->images->first()->image_path) }}"
                                                 alt="{{ $comparison->product->name }}"
                                                 class="w-full h-48 object-cover rounded-lg">
                                        @endif
                                        <button onclick="removeFromComparison({{ $comparison->id }})"
                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Product Name -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50">Name</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4">
                                    <a href="{{ route('product', $comparison->product->slug) }}" class="text-pink-600 hover:text-pink-800 font-semibold">
                                        {{ $comparison->product->name }}
                                    </a>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Price -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50">Price</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4">
                                    @if($comparison->product->discount_price)
                                        <div class="text-xl font-bold text-pink-600">PKR {{ number_format($comparison->product->discount_price, 0) }}</div>
                                        <div class="text-sm text-gray-500 line-through">PKR {{ number_format($comparison->product->price, 0) }}</div>
                                    @else
                                        <div class="text-xl font-bold text-gray-900">PKR {{ number_format($comparison->product->price, 0) }}</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Category -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50">Category</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4">{{ $comparison->product->category->name }}</td>
                            @endforeach
                        </tr>

                        <!-- Stock -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50">Stock</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4">
                                    @if($comparison->product->stock_quantity > 0)
                                        <span class="text-green-600 font-semibold">In Stock ({{ $comparison->product->stock_quantity }})</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Out of Stock</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- Description -->
                        <tr class="border-b">
                            <td class="p-4 font-semibold bg-gray-50">Description</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4 text-sm text-gray-700">{{ Str::limit($comparison->product->description, 100) }}</td>
                            @endforeach
                        </tr>

                        <!-- Add to Cart -->
                        <tr>
                            <td class="p-4 font-semibold bg-gray-50">Action</td>
                            @foreach($comparisons as $comparison)
                                <td class="p-4">
                                    @if($comparison->product->stock_quantity > 0)
                                        <button onclick="addToCart({{ $comparison->product->id }})"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-lg font-medium">
                                            Add to Cart
                                        </button>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            @else
                <!-- Empty Comparison -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-balance-scale text-gray-300 text-6xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">No products to compare</h2>
                    <p class="text-gray-600 mb-6">Start adding products to compare features side by side</p>
                    <a href="{{ route('shop') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium">
                        <i class="fas fa-shopping-bag mr-2"></i> Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function removeFromComparison(id) {
            fetch(`/compare/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function clearComparison() {
            if (!confirm('Clear all comparisons?')) return;

            fetch('/compare/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
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
                    alert(data.message || 'Failed to add product');
                }
            });
        }
    </script>
    @endpush
</x-frontend-layout>

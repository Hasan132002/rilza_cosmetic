<x-frontend-layout title="Shop">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-2">Shop All Products</h1>
            <p class="text-gray-600 dark:text-gray-400">Explore our complete collection of premium cosmetics</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filters</h3>

                    <!-- Categories Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Categories</h4>
                        <div class="space-y-2">
                            <a href="{{ route('shop') }}" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('category', $category->slug) }}" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Price Range</h4>
                        <div class="space-y-2">
                            <a href="?max_price=500" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Under Rs 500</a>
                            <a href="?min_price=500&max_price=1000" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Rs 500 - Rs 1,000</a>
                            <a href="?min_price=1000&max_price=2000" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Rs 1,000 - Rs 2,000</a>
                            <a href="?min_price=2000" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Above Rs 2,000</a>
                        </div>
                    </div>

                    <!-- Skin Type -->
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Skin Type</h4>
                        <div class="space-y-2">
                            <a href="?skin_type=dry" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Dry Skin</a>
                            <a href="?skin_type=oily" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Oily Skin</a>
                            <a href="?skin_type=combination" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Combination</a>
                            <a href="?skin_type=sensitive" class="block text-sm text-gray-600 dark:text-gray-400 hover:text-pink-600">Sensitive Skin</a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Results Count -->
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-gray-600 dark:text-gray-400">
                        Showing <span class="font-semibold">{{ $products->count() }}</span> of <span class="font-semibold">{{ $products->total() }}</span> products
                    </p>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                    @include('frontend.components.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                {{ $products->links() }}
                @else
                <div class="text-center py-16">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No products found</h3>
                    <p class="text-gray-600 dark:text-gray-400">Try adjusting your filters or browse all products</p>
                    <a href="{{ route('shop') }}" class="mt-4 inline-block bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg">
                        View All Products
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-frontend-layout>

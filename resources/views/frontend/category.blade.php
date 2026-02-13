<x-frontend-layout :title="$category->name">
    <!-- Category Header -->
    <section class="gradient-pink text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $category->name }}</h1>
            <p class="text-xl text-pink-100 max-w-2xl mx-auto">{{ $category->description }}</p>
            <div class="mt-6">
                <i class="fas fa-sparkles text-3xl animate-pulse"></i>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-gray-600">
                    <i class="fas fa-box-open mr-2"></i>
                    Showing <span class="font-bold text-pink-600">{{ $products->count() }}</span> of <span class="font-bold">{{ $products->total() }}</span> products
                </p>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $index => $product)
                <div data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    @include('frontend.components.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <i class="fas fa-box-open text-8xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No products in this category yet</h3>
                <a href="{{ route('shop') }}" class="gradient-pink text-white px-8 py-3 rounded-full font-semibold inline-flex items-center gap-2 hover:shadow-xl transition-all">
                    <i class="fas fa-shopping-bag"></i> Browse All Products
                </a>
            </div>
            @endif
        </div>
    </section>
</x-frontend-layout>

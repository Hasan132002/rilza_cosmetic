<x-frontend-layout title="Blog">
    <!-- Hero Section -->
    <section class="relative gradient-pink text-white py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Beauty Blog</h1>
                <p class="text-xl text-pink-100">
                    Tips, trends, and tutorials for your beauty journey
                </p>
            </div>
        </div>

        <!-- Decorative Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L1440 0V100C1440 100 1080 50 720 50C360 50 0 100 0 100V0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $index => $blog)
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover-lift group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <!-- Featured Image -->
                    <a href="{{ route('blog.show', $blog->slug) }}" class="block overflow-hidden">
                        @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}"
                             alt="{{ $blog->title }}"
                             class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-56 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-pink-300"></i>
                        </div>
                        @endif
                    </a>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Meta -->
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-user mr-2 text-pink-500"></i>
                            <span>{{ $blog->author->name }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar mr-2 text-pink-500"></i>
                            <span>{{ $blog->published_at->format('M d, Y') }}</span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-pink-600 transition-colors">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                {{ $blog->title }}
                            </a>
                        </h2>

                        <!-- Excerpt -->
                        @if($blog->excerpt)
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $blog->excerpt }}
                        </p>
                        @else
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($blog->content), 150) }}
                        </p>
                        @endif

                        <!-- Read More -->
                        <a href="{{ route('blog.show', $blog->slug) }}"
                           class="text-pink-600 font-semibold hover:text-pink-700 inline-flex items-center">
                            Read More <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-20" data-aos="fade-up">
                <div class="w-32 h-32 gradient-pink rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-blog text-5xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">No Blog Posts Yet</h3>
                <p class="text-xl text-gray-600 mb-8">Check back soon for beauty tips and tutorials!</p>
                <a href="{{ route('shop') }}" class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-8 py-3 rounded-full font-semibold hover:shadow-xl transition-all inline-flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-4">Subscribe to Our Newsletter</h2>
                <p class="text-xl text-gray-600 mb-8">Get beauty tips, exclusive offers, and new blog posts delivered to your inbox</p>
                <form class="flex flex-col sm:flex-row gap-4 justify-center">
                    <input type="email"
                           placeholder="Enter your email"
                           class="px-6 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none flex-1 max-w-md">
                    <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-8 py-3 rounded-full font-semibold hover:shadow-xl transition-all">
                        <i class="fas fa-paper-plane mr-2"></i> Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-frontend-layout>

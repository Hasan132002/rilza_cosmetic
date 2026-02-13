<x-frontend-layout :title="$blog->meta_title ?? $blog->title">
    @if($blog->meta_description)
    <x-slot name="meta_description">{{ $blog->meta_description }}</x-slot>
    @endif

    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4 border-b">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-pink-600">
                    <i class="fas fa-home"></i>
                </a>
                <span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-pink-600">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ Str::limit($blog->title, 50) }}</span>
            </nav>
        </div>
    </div>

    <!-- Blog Post -->
    <article class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Title & Meta -->
                <div class="mb-8" data-aos="fade-up">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">{{ $blog->title }}</h1>

                    <!-- Author & Date -->
                    <div class="flex items-center text-gray-600 mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 gradient-pink rounded-full flex items-center justify-center text-white font-bold mr-3">
                                {{ strtoupper(substr($blog->author->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $blog->author->name }}</p>
                                <p class="text-sm">{{ $blog->published_at->format('F d, Y') }} • {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($blog->featured_image)
                <div class="mb-10" data-aos="fade-up">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}"
                         alt="{{ $blog->title }}"
                         class="w-full rounded-2xl shadow-xl">
                </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none" data-aos="fade-up" data-aos-delay="100">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <!-- Share Buttons -->
                <div class="mt-12 pt-8 border-t border-gray-200" data-aos="fade-up">
                    <h3 class="text-xl font-bold mb-4">Share this post</h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
                           target="_blank"
                           class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                           target="_blank"
                           class="w-12 h-12 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                           target="_blank"
                           class="w-12 h-12 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . route('blog.show', $blog->slug)) }}"
                           target="_blank"
                           class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedBlogs->count() > 0)
    <section class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12" data-aos="fade-up">
                    Related Posts
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedBlogs as $index => $relatedBlog)
                    <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover-lift group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Featured Image -->
                        <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="block overflow-hidden">
                            @if($relatedBlog->featured_image)
                            <img src="{{ asset('storage/' . $relatedBlog->featured_image) }}"
                                 alt="{{ $relatedBlog->title }}"
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                <i class="fas fa-image text-5xl text-pink-300"></i>
                            </div>
                            @endif
                        </a>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta -->
                            <div class="text-sm text-gray-500 mb-3">
                                <i class="fas fa-calendar mr-1 text-pink-500"></i>
                                {{ $relatedBlog->published_at->format('M d, Y') }}
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-pink-600 transition-colors line-clamp-2">
                                <a href="{{ route('blog.show', $relatedBlog->slug) }}">
                                    {{ $relatedBlog->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            @if($relatedBlog->excerpt)
                            <p class="text-gray-600 mb-4 line-clamp-2">
                                {{ $relatedBlog->excerpt }}
                            </p>
                            @endif

                            <!-- Read More -->
                            <a href="{{ route('blog.show', $relatedBlog->slug) }}"
                               class="text-pink-600 font-semibold hover:text-pink-700 inline-flex items-center">
                                Read More <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-6">Discover Our Products</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Explore our collection of premium beauty products
                </p>
                <a href="{{ route('shop') }}"
                   class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-10 py-4 rounded-full font-bold text-lg hover:shadow-xl transition-all inline-flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                </a>
            </div>
        </div>
    </section>
</x-frontend-layout>

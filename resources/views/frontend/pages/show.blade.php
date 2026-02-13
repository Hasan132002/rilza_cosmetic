<x-frontend-layout :title="$page->meta_title ?? $page->title" :description="$page->meta_description">
    <!-- Hero Section -->
    <div class="py-16 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">{{ $page->title }}</h1>
                <div class="flex items-center justify-center space-x-2 text-gray-600">
                    <a href="{{ route('home') }}" class="hover:text-pink-600 transition-colors">Home</a>
                    <span>/</span>
                    <span class="text-pink-600">{{ $page->title }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12" data-aos="fade-up" data-aos-delay="100">
                    <!-- Content -->
                    <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-pink-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-blockquote:border-pink-500 prose-blockquote:text-gray-700 prose-img:rounded-xl prose-img:shadow-md">
                        {!! $page->content !!}
                    </div>

                    <!-- Page Meta Info -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div>
                                <i class="far fa-clock mr-2"></i>
                                Last updated: {{ $page->updated_at->format('F d, Y') }}
                            </div>
                            <div>
                                <a href="{{ route('contact') }}" class="text-pink-600 hover:text-pink-700 transition-colors">
                                    <i class="far fa-question-circle mr-2"></i>
                                    Have questions? Contact us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-12 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-8 md:p-12 text-center text-white shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">Ready to Shop?</h3>
                    <p class="text-lg mb-6 opacity-90">Discover our amazing collection of beauty products</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('shop') }}" class="bg-white text-pink-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all shadow-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Browse Products
                        </a>
                        <a href="{{ route('home') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-pink-600 transition-all">
                            <i class="fas fa-home mr-2"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>

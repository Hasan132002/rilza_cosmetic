<x-frontend-layout title="Home">
    <!-- Banner Slider with Animations -->
    @if($banners->count() > 0)
    <section class="relative overflow-hidden -mt-20 pt-20">
        <!-- Canvas Background Animation -->
        <canvas id="particles-canvas" class="absolute inset-0 pointer-events-none z-0"></canvas>

        <div class="swiper banner-slider relative z-10">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <div class="relative h-[450px] md:h-[550px] bg-gradient-to-br from-pink-500 via-purple-500 to-pink-600 overflow-hidden">
                        <!-- Animated SVG Shapes -->
                        <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="grad{{ $loop->index }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:rgb(236,72,153);stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:rgb(168,85,247);stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <circle cx="10%" cy="20%" r="100" fill="url(#grad{{ $loop->index }})" class="animate-float" />
                            <circle cx="90%" cy="80%" r="150" fill="url(#grad{{ $loop->index }})" class="animate-float-delayed" style="animation-delay: 1s;" />
                            <path d="M100,200 Q250,50 400,200 T700,200" stroke="white" stroke-width="3" fill="none" opacity="0.3" class="animate-pulse" />
                        </svg>

                        <!-- Banner Image -->
                        <img src="{{ asset('storage/' . $banner->image_path) }}"
                             alt="{{ $banner->title }}"
                             class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-70">

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>

                        <!-- Content -->
                        <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center relative z-20">
                            <div class="max-w-2xl text-white" data-aos="fade-right" data-aos-duration="1000">
                                <div class="inline-block mb-4 px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-sm font-semibold">
                                    <i class="fas fa-sparkles mr-2"></i>New Collection
                                </div>
                                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight animate-slide-up">
                                    {{ $banner->title }}
                                </h1>
                                @if($banner->description)
                                <p class="text-lg md:text-xl mb-8 text-pink-50 animate-slide-up" style="animation-delay: 0.2s;">
                                    {{ $banner->description }}
                                </p>
                                @endif
                                @if($banner->button_text && $banner->button_link)
                                <a href="{{ $banner->button_link }}"
                                   class="inline-flex items-center gap-3 bg-white text-pink-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-pink-50 hover:shadow-2xl transition-all transform hover:scale-105 animate-slide-up group"
                                   style="animation-delay: 0.4s;">
                                    {{ $banner->button_text }}
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Decorative Floating Elements -->
                        <div class="absolute top-1/4 right-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-bounce" style="animation-delay: 0.5s;"></div>
                        <div class="absolute bottom-1/4 right-1/4 w-32 h-32 bg-purple-300/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($banners->count() > 1)
            <div class="swiper-pagination !bottom-6"></div>
            <div class="swiper-button-next !text-white hover:scale-110 transition-transform"></div>
            <div class="swiper-button-prev !text-white hover:scale-110 transition-transform"></div>
            @endif
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0 z-20">
            <svg class="w-full h-16 md:h-24" viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,50 Q360,10 720,50 T1440,50 L1440,100 L0,100 Z" fill="white" class="animate-wave"/>
            </svg>
        </div>
    </section>
    @else
    <!-- Default Hero if no banners -->
    <section class="relative gradient-pink text-white py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 right-20 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 left-20 w-96 h-96 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Unleash Your <span class="italic">Natural Beauty</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-pink-100">
                    Premium cosmetics crafted for confidence & radiance
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('shop') }}" class="bg-white text-pink-600 px-10 py-4 rounded-full font-bold text-lg hover:bg-pink-50 hover:shadow-2xl transition-all transform hover:scale-105 inline-flex items-center justify-center">
                        <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                    </a>
                    <a href="#categories" class="border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-pink-600 transition-all transform hover:scale-105 inline-flex items-center justify-center">
                        <i class="fas fa-arrow-down mr-2"></i> Explore
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L1440 0V100C1440 100 1080 50 720 50C360 50 0 100 0 100V0Z" fill="white"/>
            </svg>
        </div>
    </section>
    @endif

    <!-- Features -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center" data-aos="fade-up">
                    <div class="w-20 h-20 gradient-pink rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-truck text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('messages.Free Shipping') }}</h3>
                    <p class="text-gray-600">On orders above Rs 2,000</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 gradient-purple rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-certificate text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">100% Authentic</h3>
                    <p class="text-gray-600">Genuine products guaranteed</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 gradient-blue rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">24/7 Support</h3>
                    <p class="text-gray-600">We're here to help you</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ __('messages.Categories') }}</h2>
                <p class="text-xl text-gray-600">Discover our curated collections</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($categories as $index => $category)
                <a href="{{ route('category', $category->slug) }}" class="group hover-lift" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden relative">
                        <div class="h-64 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center overflow-hidden">
                            @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                            <i class="fas fa-sparkles text-6xl text-pink-300"></i>
                            @endif
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-pink-600 transition-colors">{{ $category->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                            <div class="mt-4">
                                <span class="text-pink-600 font-semibold group-hover:underline">Explore <i class="fas fa-arrow-right ml-1"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trending Now - Product Carousel -->
    @if($bestsellers->count() > 0)
    <section class="py-20 bg-white overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-fire mr-2"></i>{{ __('messages.Trending Now') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ __('messages.Best Sellers') }}</h2>
                <p class="text-xl text-gray-600">Our most-loved products flying off the shelves</p>
            </div>

            <div class="swiper trending-slider" data-aos="fade-up">
                <div class="swiper-wrapper">
                    @foreach($bestsellers as $product)
                    <div class="swiper-slide">
                        @include('frontend.components.product-card', ['product' => $product])
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-12"></div>
            </div>
        </div>
    </section>
    @endif

    <!-- Shop by Concern -->
    <section class="py-20 bg-gradient-to-br from-purple-50 via-pink-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Shop by Concern</h2>
                <p class="text-xl text-gray-600">Find solutions tailored to your skin needs</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="concern-card group" data-aos="zoom-in">
                    <a href="{{ route('shop', ['concern' => 'acne']) }}" class="block bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 gradient-pink rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-virus text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-center group-hover:text-pink-600 transition-colors">Acne Control</h3>
                        <p class="text-gray-600 text-center">Clear, healthy skin solutions</p>
                    </a>
                </div>

                <div class="concern-card group" data-aos="zoom-in" data-aos-delay="100">
                    <a href="{{ route('shop', ['concern' => 'dryness']) }}" class="block bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 gradient-purple rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-droplet text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-center group-hover:text-purple-600 transition-colors">Hydration</h3>
                        <p class="text-gray-600 text-center">Deep moisture & nourishment</p>
                    </a>
                </div>

                <div class="concern-card group" data-aos="zoom-in" data-aos-delay="200">
                    <a href="{{ route('shop', ['concern' => 'aging']) }}" class="block bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-spa text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-center group-hover:text-amber-600 transition-colors">Anti-Aging</h3>
                        <p class="text-gray-600 text-center">Youthful, radiant skin</p>
                    </a>
                </div>

                <div class="concern-card group" data-aos="zoom-in" data-aos-delay="300">
                    <a href="{{ route('shop', ['concern' => 'brightening']) }}" class="block bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-sun text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-center group-hover:text-yellow-600 transition-colors">Brightening</h3>
                        <p class="text-gray-600 text-center">Even tone & luminosity</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Featured Products</h2>
                <p class="text-xl text-gray-600">Handpicked favorites just for you</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $index => $product)
                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    @include('frontend.components.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Customer Reviews -->
    <section class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-2 bg-white/50 backdrop-blur-sm text-pink-600 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-heart mr-2"></i>LOVED BY THOUSANDS
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">What Our Customers Say</h2>
                <p class="text-xl text-gray-600">Real reviews from real beauty enthusiasts</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="review-card bg-white rounded-3xl p-8 shadow-xl" data-aos="fade-up">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 gradient-pink rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                            A
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Ayesha Khan</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"The Vitamin C serum transformed my skin! Noticeable brightening within 2 weeks. Absolutely love Rizla products!"</p>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Verified Purchase
                    </div>
                </div>

                <div class="review-card bg-white rounded-3xl p-8 shadow-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 gradient-purple rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                            S
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Sara Ahmed</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Best lipstick formula ever! Long-lasting, comfortable, and the colors are stunning. My go-to brand now!"</p>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Verified Purchase
                    </div>
                </div>

                <div class="review-card bg-white rounded-3xl p-8 shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                            F
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Fatima Ali</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Amazing quality at affordable prices! The foundation matches perfectly and lasts all day. Highly recommend!"</p>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Verified Purchase
                    </div>
                </div>
            </div>

            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-3 gradient-pink text-white px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105">
                    Shop Bestsellers <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Beauty Tips -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-lightbulb mr-2"></i>EXPERT ADVICE
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Beauty Tips & Tricks</h2>
                <p class="text-xl text-gray-600">Professional secrets for your daily routine</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="tip-card group" data-aos="flip-left">
                    <div class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all">
                        <div class="h-48 bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-sparkles text-6xl text-white"></i>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold mb-4 group-hover:text-pink-600 transition-colors">Morning Skincare Routine</h3>
                            <p class="text-gray-600 mb-4">Start your day right with cleanse, tone, moisturize + SPF. Your skin will thank you!</p>
                            <a href="#" class="text-pink-600 font-semibold hover:underline inline-flex items-center">
                                Learn More <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="tip-card group" data-aos="flip-left" data-aos-delay="100">
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all">
                        <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-moon text-6xl text-white"></i>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold mb-4 group-hover:text-purple-600 transition-colors">Night Care Essentials</h3>
                            <p class="text-gray-600 mb-4">Let your skin repair overnight with serums and rich night creams for maximum results.</p>
                            <a href="#" class="text-purple-600 font-semibold hover:underline inline-flex items-center">
                                Learn More <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="tip-card group" data-aos="flip-left" data-aos-delay="200">
                    <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all">
                        <div class="h-48 bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                            <i class="fas fa-magic text-6xl text-white"></i>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold mb-4 group-hover:text-amber-600 transition-colors">Makeup Must-Haves</h3>
                            <p class="text-gray-600 mb-4">Master the basics: primer, foundation, concealer, and setting spray for flawless makeup.</p>
                            <a href="#" class="text-amber-600 font-semibold hover:underline inline-flex items-center">
                                Learn More <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-20 gradient-purple text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="zoom-in">
            <i class="fas fa-star text-6xl mb-6 animate-pulse"></i>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Glow?</h2>
            <p class="text-xl md:text-2xl mb-10 text-purple-100 max-w-2xl mx-auto">
                Join thousands of beauty enthusiasts who trust Rizla for their daily glow
            </p>
            <a href="{{ route('shop') }}" class="bg-white text-purple-600 px-12 py-5 rounded-full font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-110 inline-flex items-center">
                <i class="fas fa-gem mr-3"></i> Browse Collection
            </a>
        </div>
    </section>

    <!-- Trending Product Showcase -->
    @if($featuredProducts->count() > 0)
    @php
        $trendingProduct = $featuredProducts->first();
    @endphp

    @endif

    <!-- M·A·C Lipglass Showcase Section -->
    @if($featuredProducts->count() > 0)
    @php
        $lipglossProduct = $featuredProducts->first();
        $productImages = $lipglossProduct->images->take(5);
    @endphp
    <section class="relative py-32 overflow-hidden bg-white hidden lg:block">
        <!-- Angled Pink Background (45% width, right side) -->
        <div id="trending-bg" class="absolute right-0 top-0 h-full w-[45%] bg-pink-400 transition-colors duration-500"
             style="clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left: Content -->
                <div class="z-10" data-aos="fade-right">
                    <!-- Trending Now Header -->
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3" style="font-family: 'Poppins', sans-serif;">
                        Trending Now:
                    </h3>

                    <!-- Product Title with Text Shadow -->
                    <h1 id="trending-title" class="text-6xl md:text-7xl font-bold text-pink-500 mb-8 uppercase leading-tight transition-colors duration-500"
                        style="font-family: 'Playfair Display', serif; text-shadow: 3px 2px 0px rgba(55, 52, 67, 0.9);">
                        {{ $lipglossProduct->name }}
                    </h1>

                    <!-- Tagline with Highlighted Words -->
                    <h2 class="text-2xl uppercase tracking-wide mb-2" style="font-family: 'Poppins', sans-serif;">
                        Create a <span class="bg-pink-200 px-2 py-1">shine</span>
                    </h2>
                    <h2 class="text-2xl uppercase tracking-wide mb-10" style="font-family: 'Poppins', sans-serif;">
                        that <span class="bg-pink-200 px-2 py-1">lasts</span>
                    </h2>

                    <!-- Product Description -->
                    <p class="text-gray-700 mb-10 max-w-md leading-relaxed text-base" style="font-family: 'Poppins', sans-serif;">
                        {{ $lipglossProduct->short_description ?? 'Experience the ultimate shine with our premium lipgloss formula. Long-lasting, comfortable wear that enhances your natural beauty with a brilliant, mirror-like finish.' }}
                    </p>

                    <!-- Color Swatches (6 exact colors) -->
                    <div class="mb-10">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase mb-4 tracking-wide" style="font-family: 'Poppins', sans-serif;">
                            Available Shades:
                        </h4>
                        <div class="flex gap-3">
                            <button onclick="changeColor1()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #dc8289;"
                                    title="Rose Blush"
                                    aria-label="Change to Rose Blush color">
                            </button>
                            <button onclick="changeColor2()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #fc7675;"
                                    title="Coral Dream"
                                    aria-label="Change to Coral Dream color">
                            </button>
                            <button onclick="changeColor3()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #fed4d5;"
                                    title="Soft Pink"
                                    aria-label="Change to Soft Pink color">
                            </button>
                            <button onclick="changeColor4()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #ed7c67;"
                                    title="Peachy Nude"
                                    aria-label="Change to Peachy Nude color">
                            </button>
                            <button onclick="changeColor5()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #ff4f73;"
                                    title="Hot Pink"
                                    aria-label="Change to Hot Pink color">
                            </button>
                            <button onclick="changeColor6()"
                                    class="w-10 h-10 rounded-full border-3 border-white shadow-lg hover:scale-125 transition-transform duration-300 focus:ring-4 focus:ring-pink-300"
                                    style="background-color: #96051f;"
                                    title="Deep Berry"
                                    aria-label="Change to Deep Berry color">
                            </button>
                        </div>
                    </div>

                    <!-- Mini Circular Images Carousel -->
                    @if($productImages->count() > 1)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 uppercase mb-4 tracking-wide" style="font-family: 'Poppins', sans-serif;">
                            View Gallery:
                        </h4>
                        <div class="flex gap-3">
                            @foreach($productImages as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 alt="{{ $lipglossProduct->name }}"
                                 class="w-14 h-14 rounded-full object-cover cursor-pointer hover:scale-125 transition-transform duration-300 shadow-md border-2 border-white hover:border-pink-300"
                                 onclick="swapTrendingImage(this)"
                                 role="button"
                                 tabindex="0"
                                 onkeypress="if(event.key==='Enter') swapTrendingImage(this)">
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Rizla Description -->
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <p class="text-gray-600 text-sm uppercase tracking-wider leading-relaxed" style="font-family: 'Poppins', sans-serif;">
                            <span class="font-bold text-pink-600">Rizla Cosmetics</span> - Premium Beauty<br>
                            Crafted for those who demand excellence
                        </p>
                    </div>
                </div>

                <!-- Right: Product Image -->
                <div class="relative z-0 flex items-center justify-center" data-aos="fade-left">
                    <!-- Large Circular Product Image -->
                    <div class="relative">
                        <img id="trending-main-img"
                             src="https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT1M_640x600_0.jpg"
                             alt="M·A·C Lipglass"
                             class="w-[360px] h-[360px] rounded-full object-cover shadow-2xl transition-transform duration-500 hover:scale-105"
                             style="box-shadow: 0 25px 50px rgba(236, 72, 153, 0.4);">

                        <!-- Decorative Ring -->
                        <div class="absolute inset-0 rounded-full border-4 border-white opacity-50 animate-pulse"></div>
                    </div>

                    <!-- Vertical Rotated Text -->
                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2">
                        <h2 class="text-white text-4xl font-bold uppercase whitespace-nowrap tracking-widest"
                            style="font-family: 'Playfair Display', serif;
                                   transform: rotate(90deg) translateX(50%);
                                   transform-origin: right center;
                                   opacity: 0.6;
                                   text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                            Bring your vision to life
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute bottom-10 left-10 w-32 h-32 bg-pink-200 rounded-full blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute top-10 right-1/4 w-24 h-24 bg-purple-200 rounded-full blur-2xl opacity-40 animate-bounce" style="animation-delay: 0.5s;"></div>
    </section>
    @endif

    <!-- New Arrivals -->
    @if($newArrivals->count() > 0)
    <section class="py-20 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-2 bg-pink-100 text-pink-600 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-bolt mr-2"></i>JUST ARRIVED
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">New Arrivals</h2>
                <p class="text-xl text-gray-600">Fresh picks to elevate your beauty routine</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($newArrivals as $index => $product)
                <div data-aos="flip-left" data-aos-delay="{{ $index * 100 }}">
                    @include('frontend.components.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Instagram Gallery -->
    <section class="py-20 bg-gradient-to-br from-purple-50 via-pink-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-2 bg-white/50 backdrop-blur-sm text-pink-600 rounded-full text-sm font-semibold mb-4">
                    <i class="fab fa-instagram mr-2"></i>FOLLOW US
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">#RizlaBeauty</h2>
                <p class="text-xl text-gray-600">Join our beauty community on Instagram</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in">
                    <div class="w-full h-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>234
                            <i class="fas fa-comment ml-4 mr-2"></i>12
                        </div>
                    </div>
                </div>

                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>189
                            <i class="fas fa-comment ml-4 mr-2"></i>8
                        </div>
                    </div>
                </div>

                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-full h-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>312
                            <i class="fas fa-comment ml-4 mr-2"></i>15
                        </div>
                    </div>
                </div>

                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-full h-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>278
                            <i class="fas fa-comment ml-4 mr-2"></i>19
                        </div>
                    </div>
                </div>

                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>425
                            <i class="fas fa-comment ml-4 mr-2"></i>24
                        </div>
                    </div>
                </div>

                <div class="instagram-item group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="500">
                    <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <div class="text-white">
                            <i class="fas fa-heart mr-2"></i>356
                            <i class="fas fa-comment ml-4 mr-2"></i>21
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12" data-aos="fade-up">
                <a href="https://instagram.com/rizlacosmetics" target="_blank" class="inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105">
                    <i class="fab fa-instagram text-2xl"></i>
                    Follow @RizlaCosmetics
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Why Choose Rizla?</h2>
                <p class="text-xl text-gray-600">Your beauty, our passion</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-box text-center" data-aos="fade-up">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 gradient-pink rounded-3xl flex items-center justify-center transform rotate-6 hover:rotate-0 transition-transform">
                            <i class="fas fa-award text-4xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-white text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Premium Quality</h3>
                    <p class="text-gray-600">Dermatologically tested products with the finest ingredients for your skin</p>
                </div>

                <div class="feature-box text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 gradient-purple rounded-3xl flex items-center justify-center transform rotate-6 hover:rotate-0 transition-transform">
                            <i class="fas fa-tag text-4xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-percent text-white text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Affordable Prices</h3>
                    <p class="text-gray-600">Luxury beauty shouldn't break the bank. Quality at prices you'll love</p>
                </div>

                <div class="feature-box text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-3xl flex items-center justify-center transform rotate-6 hover:rotate-0 transition-transform">
                            <i class="fas fa-leaf text-4xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Safe & Natural</h3>
                    <p class="text-gray-600">Free from harmful chemicals. Cruelty-free & vegan options available</p>
                </div>

                <div class="feature-box text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-cyan-600 rounded-3xl flex items-center justify-center transform rotate-6 hover:rotate-0 transition-transform">
                            <i class="fas fa-shipping-fast text-4xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Fast Delivery</h3>
                    <p class="text-gray-600">Quick dispatch and doorstep delivery. Your beauty wait ends here</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto gradient-pink rounded-3xl shadow-2xl p-12 text-white text-center relative overflow-hidden" data-aos="zoom-in">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                <div class="relative z-10">
                    <i class="fas fa-envelope-open-text text-5xl mb-6"></i>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Stay in the Loop!</h2>
                    <p class="text-lg mb-8 text-pink-100">Subscribe for exclusive offers, beauty tips & new arrivals</p>
                    <form id="newsletter-form" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                        @csrf
                        <input type="email" name="email" id="newsletter-email" placeholder="Enter your email" required
                               class="flex-1 px-6 py-4 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/50">
                        <button type="submit" class="bg-white text-pink-600 px-8 py-4 rounded-full font-bold hover:bg-pink-50 transition-all shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>Subscribe
                        </button>
                    </form>
                    <p id="newsletter-message" class="mt-4 text-sm hidden"></p>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <style>
        /* Hero Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(-5deg); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes wave {
            0% { d: path("M0,50 Q360,10 720,50 T1440,50 L1440,100 L0,100 Z"); }
            50% { d: path("M0,50 Q360,90 720,50 T1440,50 L1440,100 L0,100 Z"); }
            100% { d: path("M0,50 Q360,10 720,50 T1440,50 L1440,100 L0,100 Z"); }
        }

        /* Product Card Animations */
        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
            50% { opacity: 1; transform: scale(1) rotate(180deg); }
        }
        @keyframes badge-pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(236, 72, 153, 0); }
        }
        @keyframes sale-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        @keyframes price-drop {
            0% { transform: translateY(-20px); opacity: 0; }
            50% { transform: translateY(5px); }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes cart-bounce {
            0%, 100% { transform: translateY(0); }
            25% { transform: translateY(-10px); }
            50% { transform: translateY(-5px); }
            75% { transform: translateY(-7px); }
        }
        @keyframes confetti {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(-200px) rotate(360deg); opacity: 0; }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        /* Apply Animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 8s ease-in-out infinite; }
        .animate-slide-up { animation: slide-up 0.8s ease-out forwards; opacity: 0; }
        .animate-wave { animation: wave 8s ease-in-out infinite; }
        .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }

        /* Product Card Hover Effects */
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
        }

        /* Sparkle Effects */
        .sparkle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(45deg, #fff, #ffc0cb);
            border-radius: 50%;
            animation: sparkle 1.5s ease-in-out infinite;
        }
        .sparkle-1 {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }
        .sparkle-2 {
            top: 60%;
            right: 20%;
            animation-delay: 0.5s;
        }
        .sparkle-3 {
            bottom: 20%;
            left: 40%;
            animation-delay: 1s;
        }

        /* Badge Animation */
        .badge-animate {
            animation: badge-pulse 2s ease-in-out infinite;
        }

        /* Sale Badge Pulse */
        .sale-badge-pulse {
            animation: sale-pulse 1.5s ease-in-out infinite;
        }

        /* Price Drop Animation */
        .animate-price-drop {
            animation: price-drop 0.6s ease-out;
        }

        /* Stock Indicator Pulse */
        .stock-indicator-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Add to Cart Button Effects */
        .add-to-cart-btn:active {
            animation: cart-bounce 0.6s ease;
        }
        .add-to-cart-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .add-to-cart-btn:hover::before {
            left: 100%;
        }

        /* Confetti Effect */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #ec4899;
            animation: confetti 1s ease-out forwards;
            pointer-events: none;
            z-index: 9999;
        }

        /* Concern Cards Hover */
        .concern-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        /* Review Cards Animation */
        .review-card {
            transition: all 0.3s ease;
        }
        .review-card:hover {
            transform: translateY(-5px) rotate(-1deg);
            box-shadow: 0 20px 40px rgba(168, 85, 247, 0.3);
        }

        /* Tip Cards Hover */
        .tip-card:hover {
            transform: scale(1.05) rotate(2deg);
        }

        /* Instagram Items Hover */
        .instagram-item {
            transition: all 0.3s ease;
        }
        .instagram-item:hover {
            transform: scale(1.05) rotate(-2deg);
            box-shadow: 0 15px 30px rgba(236, 72, 153, 0.4);
        }

        /* Feature Box Rotation */
        .feature-box:hover .w-24 {
            animation: float 2s ease-in-out infinite;
        }

        /* Loading Shimmer Effect */
        .shimmer-effect {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Hover Lift Effect */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
        }
    </style>

    <script>
        // Canvas Particle Animation
        const canvas = document.getElementById('particles-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let particles = [];

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = 550;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 3 + 1;
                    this.speedX = Math.random() * 1 - 0.5;
                    this.speedY = Math.random() * 1 - 0.5;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }

                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    if (this.x > canvas.width) this.x = 0;
                    if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    if (this.y < 0) this.y = canvas.height;
                }

                draw() {
                    ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity})`;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function init() {
                particles = [];
                for (let i = 0; i < 50; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                requestAnimationFrame(animate);
            }

            init();
            animate();
        }

        // Banner Slider
        @if($banners->count() > 1)
        new Swiper('.banner-slider', {
            loop: true,
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        @endif

        // Trending Products Carousel
        @if($bestsellers->count() > 0)
        new Swiper('.trending-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
        @endif

        // Newsletter Subscription
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('newsletter-email').value;
            const messageEl = document.getElementById('newsletter-message');
            const button = this.querySelector('button');
            const buttonText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Subscribing...';

            fetch('{{ route("newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                messageEl.classList.remove('hidden', 'text-red-200', 'text-green-200');
                if (data.success || data.message) {
                    messageEl.textContent = data.message || 'Successfully subscribed!';
                    messageEl.classList.add('text-green-200');
                    this.reset();
                } else {
                    messageEl.textContent = data.errors?.email?.[0] || 'Subscription failed';
                    messageEl.classList.add('text-red-200');
                }
                messageEl.classList.remove('hidden');
            })
            .catch(error => {
                messageEl.textContent = 'An error occurred. Please try again.';
                messageEl.classList.add('text-red-200');
                messageEl.classList.remove('hidden');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = buttonText;
            });
        });

        // Confetti Effect on Add to Cart
        function createConfetti(button) {
            const colors = ['#ec4899', '#a855f7', '#f97316', '#eab308', '#10b981'];
            const rect = button.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            for (let i = 0; i < 20; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = centerX + 'px';
                confetti.style.top = centerY + 'px';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.transform = `translate(${(Math.random() - 0.5) * 200}px, ${(Math.random() - 0.5) * 200}px) rotate(${Math.random() * 360}deg)`;
                document.body.appendChild(confetti);

                setTimeout(() => confetti.remove(), 1000);
            }
        }

        // Enhanced Add to Cart with Animations
        window.addToCartAjax = function(productId, quantity) {
            const button = document.querySelector(`[data-product-id="${productId}"]`);
            const btnText = button.querySelector('.btn-text');
            const btnIcon = button.querySelector('.btn-icon');
            const btnSpinner = button.querySelector('.btn-spinner');
            const btnSuccess = button.querySelector('.btn-success');

            // Hide text and icon, show spinner
            btnText.classList.add('hidden');
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            button.disabled = true;

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    btnSpinner.classList.add('hidden');
                    btnSuccess.classList.remove('hidden');
                    button.classList.add('bg-green-500');

                    // Create confetti effect
                    createConfetti(button);

                    // Bounce animation
                    button.style.animation = 'cart-bounce 0.6s ease';

                    // Update cart count if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count) {
                        cartCount.textContent = data.cart_count;
                        cartCount.style.animation = 'cart-bounce 0.6s ease';
                    }

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        btnSuccess.classList.add('hidden');
                        btnText.classList.remove('hidden');
                        btnIcon.classList.remove('hidden');
                        button.classList.remove('bg-green-500');
                        button.disabled = false;
                        button.style.animation = '';
                    }, 2000);
                } else {
                    // Show error
                    alert(data.message || 'Failed to add to cart');
                    btnSpinner.classList.add('hidden');
                    btnText.classList.remove('hidden');
                    btnIcon.classList.remove('hidden');
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
                btnSpinner.classList.add('hidden');
                btnText.classList.remove('hidden');
                btnIcon.classList.remove('hidden');
                button.disabled = false;
            });
        };

        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Product Card Sparkle on Hover
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Initialize AOS with custom settings
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic',
            });
        }

        // M·A·C Lipglass Showcase - Color Change Functions
        const imageRoots = {
            color1: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT1M_640x600_',
            color2: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT18_640x600_',
            color3: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT07_640x600_',
            color4: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT1A_640x600_',
            color5: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT27_640x600_',
            color6: 'https://www.maccosmetics.com/media/export/cms/products/640x600/mac_sku_S3HT32_640x600_'
        };

        function changeColor1() {
            updateTrending('#dc8289', '#dc8289', imageRoots.color1);
        }

        function changeColor2() {
            updateTrending('#fc7675', '#fc7675', imageRoots.color2);
        }

        function changeColor3() {
            updateTrending('#fed4d5', '#fed4d5', imageRoots.color3);
        }

        function changeColor4() {
            updateTrending('#ed7c67', '#ed7c67', imageRoots.color4);
        }

        function changeColor5() {
            updateTrending('#ff4f73', '#ff4f73', imageRoots.color5);
        }

        function changeColor6() {
            updateTrending('#96051f', '#96051f', imageRoots.color6);
        }

        // Update background, title color, and images
        function updateTrending(bgColor, titleColor, imageRoot) {
            const background = document.getElementById('trending-bg');
            const title = document.getElementById('trending-title');
            const mainImg = document.getElementById('trending-main-img');

            if (background) {
                background.style.backgroundColor = bgColor;
            }

            if (title) {
                title.style.color = titleColor;
            }

            if (mainImg && imageRoot) {
                mainImg.src = imageRoot + '0.jpg';
            }

            // Update mini gallery images
            const miniImgs = document.querySelectorAll('.trending-mini-img');
            miniImgs.forEach((img, index) => {
                if (imageRoot) {
                    img.src = imageRoot + index + '.jpg';
                }
            });
        }

        // Swap main trending image when mini image is clicked
        function swapTrendingImage(element) {
            const mainImg = document.getElementById('trending-main-img');

            if (mainImg && element && element.src) {
                // Add fade effect
                mainImg.style.opacity = '0';

                setTimeout(() => {
                    mainImg.src = element.src;
                    mainImg.style.opacity = '1';
                }, 300);

                // Add bounce animation to clicked thumbnail
                element.style.transform = 'scale(1.25)';
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 300);
            }
        }

        // Add transition styles to main image
        const trendingMainImg = document.getElementById('trending-main-img');
        if (trendingMainImg) {
            trendingMainImg.style.transition = 'opacity 0.3s ease-in-out, transform 0.5s ease';
        }
    </script>
    @endpush
</x-frontend-layout>

@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}"
      class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ config('app.name') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $metaDescription ?? 'Rizla Cosmetics - Premium Beauty & Cosmetics Products. Shop Makeup, Skincare, Haircare & Fragrances.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'cosmetics, makeup, skincare, beauty products, rizla cosmetics' }}">
    <meta name="author" content="Rizla Cosmetics">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $title }} - {{ config('app.name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Premium Beauty Products' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }} - {{ config('app.name') }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Premium Beauty Products' }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Swiper Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- International Tel Input -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/css/intlTelInput.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); }
        .gradient-purple { background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); }
        .hover-lift { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 25px 50px -12px rgba(236, 72, 153, 0.25); }
        .product-card:hover img { transform: scale(1.1); }
        .product-card img { transition: transform 0.5s ease; }

        /* Wishlist Icon Animation */
        .wishlist-icon {
            transition: all 0.3s ease;
        }

        .wishlist-icon.text-red-500 {
            animation: heartBeat 0.6s ease-in-out;
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            10%, 30% { transform: scale(0.9); }
            50% { transform: scale(1.1); }
        }

        /* Quick View Modal Animations */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        /* Dark Mode Styles */
        .dark body { background: linear-gradient(to bottom right, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .dark { color-scheme: dark; }
        .dark .bg-white { background-color: #1f2937; }
        .dark .text-gray-700 { color: #d1d5db; }
        .dark .text-gray-600 { color: #9ca3af; }
        .dark .text-gray-900 { color: #f3f4f6; }
        .dark .bg-gradient-to-br { background: linear-gradient(to bottom right, #1a1a2e 0%, #16213e 100%); }

        /* Mega Menu Enhancements */
        .border-gradient-to-r {
            border-image: linear-gradient(to right, #ec4899, #a855f7) 1;
        }

        @media (min-width: 1024px) {
            .max-w-6xl {
                max-width: 80rem;
            }
        }

        /* Cart Icon Bounce Animation */
        @keyframes bounceCustom {
            0%, 100% { transform: scale(1) translateY(0); }
            25% { transform: scale(1.2) translateY(-8px); }
            50% { transform: scale(0.9) translateY(0); }
            75% { transform: scale(1.1) translateY(-4px); }
        }

        .animate-bounce-custom {
            animation: bounceCustom 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Page Transitions */
        .page-transition {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* RTL Support for Urdu */
        html[dir="rtl"] {
            direction: rtl;
            text-align: right;
        }

        html[dir="rtl"] body {
            text-align: right;
        }

        html[dir="rtl"] .text-left {
            text-align: right !important;
        }

        html[dir="rtl"] .text-right {
            text-align: left !important;
        }

        /* RTL Margin/Padding Reversals */
        html[dir="rtl"] .ml-2 { margin-left: 0; margin-right: 0.5rem; }
        html[dir="rtl"] .mr-2 { margin-right: 0; margin-left: 0.5rem; }
        html[dir="rtl"] .ml-3 { margin-left: 0; margin-right: 0.75rem; }
        html[dir="rtl"] .mr-3 { margin-right: 0; margin-left: 0.75rem; }
        html[dir="rtl"] .ml-4 { margin-left: 0; margin-right: 1rem; }
        html[dir="rtl"] .mr-4 { margin-right: 0; margin-left: 1rem; }

        html[dir="rtl"] .pl-2 { padding-left: 0; padding-right: 0.5rem; }
        html[dir="rtl"] .pr-2 { padding-right: 0; padding-left: 0.5rem; }
        html[dir="rtl"] .pl-4 { padding-left: 0; padding-right: 1rem; }
        html[dir="rtl"] .pr-4 { padding-right: 0; padding-left: 1rem; }

        /* RTL Float */
        html[dir="rtl"] .float-left { float: right; }
        html[dir="rtl"] .float-right { float: left; }

        /* RTL Flex Direction */
        html[dir="rtl"] .flex-row { flex-direction: row-reverse; }

        /* RTL Border Radius */
        html[dir="rtl"] .rounded-l { border-radius: 0 0.25rem 0.25rem 0; }
        html[dir="rtl"] .rounded-r { border-radius: 0.25rem 0 0 0.25rem; }

        /* Link hover animations */
        a {
            transition: all 0.3s ease;
        }

        /* Button press effect */
        button:active:not(:disabled) {
            transform: scale(0.95);
        }

        /* Image load animation */
        img {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Skeleton shimmer effect */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
    </style>

    <script>
        // Initialize theme before page renders
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-colors duration-300">
    <!-- Top Announcement Bar -->
    @if(isset($announcement) && $announcement)
    <div class="w-full text-center py-3 px-4 text-sm font-semibold relative overflow-hidden z-50"
         style="background-color: {{ $announcement->background_color }}; color: {{ $announcement->text_color }};">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, currentColor 10px, currentColor 11px);"></div>
        </div>

        <div class="container mx-auto flex items-center justify-center gap-3 relative z-10">
            <i class="fas fa-bullhorn animate-pulse"></i>
            <span>{{ $announcement->message }}</span>
            @if($announcement->link_url && $announcement->link_text)
            <a href="{{ $announcement->link_url }}" class="underline font-bold hover:opacity-80 transition-all hover:scale-105 inline-flex items-center gap-1">
                {{ $announcement->link_text }} <i class="fas fa-arrow-right text-xs"></i>
            </a>
            @endif
        </div>
    </div>
    @else
    <!-- Default Top Bar -->
    <div class="w-full gradient-pink text-white text-center py-3 px-4 text-sm font-semibold z-50">
        <div class="container mx-auto flex items-center justify-center gap-3">
            <i class="fas fa-gift animate-bounce"></i>
            <span>Welcome to Rizla Cosmetics - Premium Beauty Products</span>
            <a href="{{ route('shop') }}" class="underline font-bold hover:opacity-80 transition-all">
                Shop Now <i class="fas fa-arrow-right text-xs ml-1"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-md transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 gradient-pink rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all">
                        <i class="fas fa-gem text-2xl text-white"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Rizla</span>
                        <p class="text-xs text-gray-500 -mt-1">Cosmetics</p>
                    </div>
                </a>

                <!-- Navigation with Mega Menu -->
                <nav class="hidden lg:flex items-center space-x-8" x-data="{ megaMenuOpen: false }">
                    <a href="{{ route('home') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors">{{ __('messages.Home') }}</a>

                    <!-- Shop Mega Menu -->
                    <div class="relative"
                         @mouseenter="megaMenuOpen = true"
                         @mouseleave="megaMenuOpen = false">
                        <a href="#" @click.prevent="megaMenuOpen = !megaMenuOpen"
                           class="font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors flex items-center gap-1 cursor-pointer">
                            {{ __('messages.Shop') }} <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{ 'rotate-180': megaMenuOpen }"></i>
                        </a>

                        <!-- Multi-Level Mega Menu Dropdown -->
                        <div x-show="megaMenuOpen"
                             x-cloak
                             @click.away="megaMenuOpen = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-1/2 -translate-x-1/2 mt-2 w-screen max-w-6xl z-50">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-100 dark:border-gray-700">
                                @php
                                    $parentCategories = \App\Models\Category::active()->parent()->with(['children' => function($query) {
                                        $query->active()->orderBy('sort_order')->withCount('products');
                                    }])->orderBy('sort_order')->get();

                                    // Define icons for each subcategory
                                    $categoryIcons = [
                                        // Makeup
                                        'Lipsticks' => 'fa-kiss',
                                        'Foundations' => 'fa-paint-roller',
                                        'Eyeshadows' => 'fa-eye',
                                        'Mascaras' => 'fa-eye-dropper',
                                        'Blush' => 'fa-palette',
                                        // Skincare
                                        'Serums' => 'fa-droplet',
                                        'Moisturizers' => 'fa-hand-holding-droplet',
                                        'Cleansers' => 'fa-soap',
                                        'Toners' => 'fa-spray-can',
                                        'Face Masks' => 'fa-mask',
                                        // Haircare
                                        'Shampoos' => 'fa-pump-soap',
                                        'Conditioners' => 'fa-bottle-droplet',
                                        'Hair Oils' => 'fa-oil-can',
                                        'Hair Masks' => 'fa-hot-tub-person',
                                        // Fragrances
                                        'Perfumes' => 'fa-spray-can-sparkles',
                                        'Body Sprays' => 'fa-wind',
                                        'Roll-ons' => 'fa-vial',
                                    ];
                                @endphp

                                <div class="grid grid-cols-4 gap-8">
                                    @foreach($parentCategories as $parent)
                                    <div class="space-y-4">
                                        <!-- Parent Category Header -->
                                        <div class="pb-3 border-b-2 border-gradient-to-r from-pink-500 to-purple-500">
                                            <a href="{{ route('category', $parent->slug) }}"
                                               class="group flex items-center justify-between">
                                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider group-hover:text-pink-600 transition-colors">
                                                    {{ $parent->name }}
                                                </h3>
                                                <i class="fas fa-arrow-right text-xs text-pink-500 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-1"></i>
                                            </a>
                                        </div>

                                        <!-- Subcategories List -->
                                        <div class="space-y-2">
                                            @foreach($parent->children as $subcategory)
                                            <a href="{{ route('category', $subcategory->slug) }}"
                                               class="group flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 dark:hover:from-pink-900/20 dark:hover:to-purple-900/20 transition-all duration-300">
                                                <!-- Icon -->
                                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 group-hover:bg-gradient-to-r group-hover:from-pink-500 group-hover:to-purple-500 transition-all duration-300">
                                                    <i class="fas {{ $categoryIcons[$subcategory->name] ?? 'fa-tag' }} text-sm text-gray-600 dark:text-gray-300 group-hover:text-white transition-colors"></i>
                                                </div>

                                                <!-- Subcategory Name & Count -->
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">
                                                        {{ $subcategory->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                                        {{ $subcategory->products_count }} {{ $subcategory->products_count == 1 ? 'item' : 'items' }}
                                                    </div>
                                                </div>

                                                <!-- Arrow on hover -->
                                                <i class="fas fa-chevron-right text-xs text-pink-500 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-1"></i>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Footer -->
                                <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 flex justify-between items-center">
                                    <a href="{{ route('shop') }}" class="text-pink-600 dark:text-pink-400 font-bold hover:underline flex items-center gap-2 group">
                                        <span>{{ __('messages.View All Products') }}</span>
                                        <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                    <a href="{{ route('offers') }}" class="gradient-pink text-white px-6 py-2.5 rounded-full font-bold hover:shadow-xl transition-all transform hover:scale-105">
                                        <i class="fas fa-tags mr-2"></i>{{ __('messages.Special Offers') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('blog.index') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors">{{ __('messages.Blog') }}</a>
                    <a href="{{ route('about') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors">{{ __('messages.About') }}</a>
                    <a href="{{ route('contact') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors">{{ __('messages.Contact') }}</a>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-gray-700 dark:text-gray-300 text-2xl" x-data @click="$dispatch('toggle-mobile-menu')">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Right Icons -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="hidden md:block text-gray-600 dark:text-gray-300 hover:text-pink-600 transition-colors" title="Toggle Theme">
                        <i class="fas fa-moon text-xl"></i>
                    </button>

                    <button class="hidden md:block text-gray-600 dark:text-gray-300 hover:text-pink-600 transition-colors" title="Search">
                        <i class="fas fa-search text-xl"></i>
                    </button>

                    <!-- Language Switcher -->
                    <div class="hidden md:block relative" x-data="{ langOpen: false }">
                        <button @click="langOpen = !langOpen" @click.away="langOpen = false"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-globe text-lg"></i>
                            <span class="text-sm font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Language Dropdown -->
                        <div x-show="langOpen" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-xl shadow-2xl py-2 z-50 border border-gray-200 dark:border-gray-700">
                            <a href="{{ route('language.switch', 'en') }}"
                               class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-pink-50 dark:hover:bg-gray-700 transition-colors {{ app()->getLocale() == 'en' ? 'text-pink-600 bg-pink-50 dark:bg-gray-700 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-flag-usa"></i>
                                <span>English</span>
                                @if(app()->getLocale() == 'en')
                                <i class="fas fa-check ml-auto text-pink-600"></i>
                                @endif
                            </a>
                            <a href="{{ route('language.switch', 'ur') }}"
                               class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-pink-50 dark:hover:bg-gray-700 transition-colors {{ app()->getLocale() == 'ur' ? 'text-pink-600 bg-pink-50 dark:bg-gray-700 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-flag"></i>
                                <span>اردو (Urdu)</span>
                                @if(app()->getLocale() == 'ur')
                                <i class="fas fa-check ml-auto text-pink-600"></i>
                                @endif
                            </a>
                        </div>
                    </div>

                    @auth
                    <!-- Account Dropdown -->
                    <div class="hidden md:block relative" x-data="{ accountOpen: false }">
                        <button @click="accountOpen = !accountOpen" @click.away="accountOpen = false" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-pink-600 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="accountOpen" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl py-2 z-50 border border-gray-200 dark:border-gray-700">
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 hover:text-pink-600 transition-colors">
                                <i class="fas fa-tachometer-alt w-5 mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 hover:text-pink-600 transition-colors">
                                <i class="fas fa-shopping-bag w-5 mr-2"></i>My Orders
                            </a>
                            <a href="{{ route('account.addresses.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 hover:text-pink-600 transition-colors">
                                <i class="fas fa-map-marker-alt w-5 mr-2"></i>Addresses
                            </a>
                            <a href="{{ route('account.reviews') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 hover:text-pink-600 transition-colors">
                                <i class="fas fa-star w-5 mr-2"></i>My Reviews
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-700 hover:text-pink-600 transition-colors">
                                <i class="fas fa-user-edit w-5 mr-2"></i>Edit Profile
                            </a>
                            <div class="border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5 mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="hidden md:block text-gray-600 hover:text-pink-600 transition-colors">
                        <i class="fas fa-sign-in-alt text-xl"></i>
                    </a>
                    @endauth
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="relative group">
                        <i class="fas fa-heart text-xl text-gray-700 dark:text-gray-300 group-hover:text-pink-600 transition-colors"></i>
                        <span id="wishlist-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold shadow-lg hidden">
                            0
                        </span>
                    </a>
                    @endauth

                    <button onclick="toggleCartSidebar()" class="relative group cursor-pointer">
                        <i class="fas fa-shopping-bag text-2xl text-gray-700 dark:text-gray-300 group-hover:text-pink-600 transition-colors"></i>
                        <span class="cart-badge absolute -top-2 -right-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center font-bold shadow-lg">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div x-data="{ mobileMenuOpen: false }"
         @toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen">
        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen"
             x-cloak
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenuOpen"
             x-cloak
             class="fixed top-0 left-0 h-full w-80 bg-white dark:bg-gray-900 shadow-2xl z-50 lg:hidden overflow-y-auto"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">

            <!-- Mobile Menu Header -->
            <div class="gradient-pink text-white p-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-gem text-2xl"></i>
                    <span class="text-xl font-bold">Rizla Cosmetics</span>
                </div>
                <button @click="mobileMenuOpen = false" class="text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu Items -->
            <nav class="p-6 space-y-1">
                <a href="{{ route('home') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-home w-6 mr-3"></i>{{ __('messages.Home') }}
                </a>
                <a href="{{ route('shop') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-shopping-bag w-6 mr-3"></i>{{ __('messages.Shop') }}
                </a>

                <!-- Mobile Categories -->
                <div x-data="{ categoriesOpen: false }">
                    <button @click="categoriesOpen = !categoriesOpen" class="w-full text-left py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors flex items-center justify-between">
                        <span><i class="fas fa-th w-6 mr-3"></i>{{ __('messages.Categories') }}</span>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="{ 'rotate-180': categoriesOpen }"></i>
                    </button>
                    <div x-show="categoriesOpen" x-cloak class="ml-6 mt-2 space-y-3">
                        @php
                            $mobileCategories = \App\Models\Category::active()->parent()->with(['children' => function($query) {
                                $query->active()->orderBy('sort_order');
                            }])->orderBy('sort_order')->get();
                        @endphp
                        @foreach($mobileCategories as $cat)
                        <div x-data="{ subOpen: false }">
                            <!-- Parent Category -->
                            <button @click="subOpen = !subOpen" class="w-full text-left py-2 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-pink-600 flex items-center justify-between">
                                <span>{{ $cat->name }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': subOpen }"></i>
                            </button>
                            <!-- Subcategories -->
                            <div x-show="subOpen" x-cloak class="ml-4 mt-1 space-y-1">
                                @foreach($cat->children as $subcat)
                                <a href="{{ route('category', $subcat->slug) }}" class="block py-1.5 px-3 text-xs text-gray-600 dark:text-gray-400 hover:text-pink-600">
                                    <i class="fas fa-angle-right mr-2"></i>{{ $subcat->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('blog.index') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-blog w-6 mr-3"></i>{{ __('messages.Blog') }}
                </a>
                <a href="{{ route('offers') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-tags w-6 mr-3"></i>{{ __('messages.Offers') }}
                </a>
                <a href="{{ route('track-order') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-truck w-6 mr-3"></i>{{ __('messages.Track Order') }}
                </a>
                <a href="{{ route('about') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-info-circle w-6 mr-3"></i>{{ __('messages.About') }}
                </a>
                <a href="{{ route('contact') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                    <i class="fas fa-envelope w-6 mr-3"></i>{{ __('messages.Contact') }}
                </a>

                @auth
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                    <a href="{{ route('account.dashboard') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                        <i class="fas fa-tachometer-alt w-6 mr-3"></i>{{ __('messages.My Account') }}
                    </a>
                    <a href="{{ route('account.orders') }}" class="block py-3 px-4 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-pink-50 dark:hover:bg-gray-800 hover:text-pink-600 transition-colors">
                        <i class="fas fa-shopping-bag w-6 mr-3"></i>{{ __('messages.My Orders') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-3 px-4 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-800 transition-colors">
                            <i class="fas fa-sign-out-alt w-6 mr-3"></i>{{ __('messages.Logout') }}
                        </button>
                    </form>
                </div>
                @else
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                    <a href="{{ route('login') }}" class="block py-3 px-4 rounded-lg gradient-pink text-white font-bold text-center hover:shadow-lg transition-all">
                        <i class="fas fa-sign-in-alt mr-2"></i>{{ __('messages.Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="block mt-2 py-3 px-4 rounded-lg border-2 border-pink-600 text-pink-600 dark:text-pink-400 font-bold text-center hover:bg-pink-50 dark:hover:bg-gray-800 transition-all">
                        <i class="fas fa-user-plus mr-2"></i>{{ __('messages.Sign Up') }}
                    </a>
                    <a href="{{ route('business.register') }}" class="block mt-2 py-3 px-4 rounded-lg border-2 border-purple-600 text-purple-600 dark:text-purple-400 font-bold text-center hover:bg-purple-50 dark:hover:bg-gray-800 transition-all">
                        <i class="fas fa-building mr-2"></i>Register as Business
                    </a>
                </div>
                @endauth
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="gradient-pink dark:from-gray-900 dark:to-gray-800 text-white relative overflow-hidden transition-colors duration-300">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div data-aos="fade-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <i class="fas fa-gem text-3xl"></i>
                        <h3 class="text-2xl font-bold">Rizla</h3>
                    </div>
                    <p class="text-pink-100 mb-6">{{ __('messages.Premium beauty & cosmetics for your perfect look. Quality products, trusted by thousands.') }}</p>
                    <div class="flex space-x-4">
                        @php
                            $facebookUrl = \App\Models\Setting::get('social_facebook', '#');
                            $instagramUrl = \App\Models\Setting::get('social_instagram', '#');
                            $twitterUrl = \App\Models\Setting::get('social_twitter', '#');
                            $tiktokUrl = \App\Models\Setting::get('social_tiktok', '#');
                        @endphp
                        @if($facebookUrl !== '#')
                        <a href="{{ $facebookUrl }}" target="_blank" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($instagramUrl !== '#')
                        <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($twitterUrl !== '#')
                        <a href="{{ $twitterUrl }}" target="_blank" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        @if($tiktokUrl !== '#')
                        <a href="{{ $tiktokUrl }}" target="_blank" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="100">
                    <h4 class="font-bold text-lg mb-6">{{ __('messages.Quick Links') }}</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.Shop All') }}</a></li>
                        <li><a href="{{ route('about') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.About Us') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.Contact') }}</a></li>
                        <li><a href="{{ route('faq') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.FAQs') }}</a></li>
                        <li><a href="{{ route('track-order') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.Track Order') }}</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('messages.Blog') }}</a></li>
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-delay="200">
                    <h4 class="font-bold text-lg mb-6">{{ __('messages.Customer Service') }}</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shipping') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-shipping-fast mr-2"></i>{{ __('messages.Shipping Info') }}</a></li>
                        <li><a href="{{ route('returns') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-undo mr-2"></i>{{ __('messages.Returns & Exchanges') }}</a></li>
                        <li><a href="{{ route('customer-service') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-headset mr-2"></i>{{ __('messages.Customer Support') }}</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-shield-alt mr-2"></i>{{ __('messages.Privacy Policy') }}</a></li>
                        <li><a href="{{ route('terms') }}" class="text-pink-100 hover:text-white flex items-center transition-colors"><i class="fas fa-file-contract mr-2"></i>{{ __('messages.Terms & Conditions') }}</a></li>
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-delay="300">
                    <h4 class="font-bold text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <div>
                                <p class="text-sm text-pink-100">Email</p>
                                <p class="font-medium">info@rizla.com</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-3"></i>
                            <div>
                                <p class="text-sm text-pink-100">Phone</p>
                                <p class="font-medium">+92 300 1234567</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/20 mt-12 pt-8 text-center">
                <p class="text-pink-100">&copy; {{ date('Y') }} <span class="font-semibold">Rizla Cosmetics</span>. All rights reserved. Made with <i class="fas fa-heart text-red-400"></i></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
    <script>
        AOS.init({ duration: 1000, easing: 'ease-out-cubic', once: true });

        // Initialize International Tel Input on all phone inputs
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInputs = document.querySelectorAll('input[type="tel"], input[name="phone"]');
            phoneInputs.forEach(function(input) {
                window.intlTelInput(input, {
                    initialCountry: "pk",
                    preferredCountries: ["pk", "ae", "sa", "in"],
                    separateDialCode: true,
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
                });
            });
        });
    </script>

    <!-- WhatsApp Floating Button Component -->
    <x-whatsapp-button />

    <!-- Popup Campaigns -->
    <x-popup-campaigns />

    <!-- Cart Sidebar Component -->
    <x-cart-sidebar />

    <!-- Quick View Modal Component -->
    <x-quick-view-modal />

    <!-- AJAX Wishlist & Cart Scripts -->
    <script>
        // Wishlist Functions
        async function addToWishlistAjax(productId, event = null) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const btn = document.querySelector(`[data-product-id="${productId}"]`);
            if (!btn) return;

            const icon = btn.querySelector('.wishlist-icon');
            const isInWishlist = icon?.classList.contains('text-red-500');

            if (isInWishlist) {
                // Remove from wishlist
                removeFromWishlistAjax(productId, event);
                return;
            }

            try {
                const response = await fetch('{{ route("wishlist.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (response.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                if (data.success || data.in_wishlist) {
                    // Update button state with animation
                    if (icon) {
                        icon.classList.add('text-red-500', 'fill-current');
                    }
                    btn.classList.add('text-red-500');
                    updateWishlistBadge(data.wishlist_count);
                    showNotification(data.message || 'Added to wishlist!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to add to wishlist', 'error');
            }
        }

        async function removeFromWishlistAjax(productId, event = null) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            try {
                const response = await fetch(`{{ route("wishlist.remove", ":id") }}`.replace(':id', productId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update button state
                    const btn = document.querySelector(`[data-product-id="${productId}"]`);
                    if (btn) {
                        const icon = btn.querySelector('.wishlist-icon');
                        if (icon) {
                            icon.classList.remove('text-red-500', 'fill-current');
                        }
                        btn.classList.remove('text-red-500');
                    }

                    // Update modal if open
                    const modalBtn = document.getElementById('qv-wishlist-btn');
                    if (modalBtn) {
                        const icon = modalBtn.querySelector('.wishlist-modal-icon');
                        modalBtn.classList.remove('bg-pink-500', 'text-white');
                        modalBtn.classList.add('bg-gray-200', 'dark:bg-gray-700');
                        if (icon) {
                            icon.classList.remove('text-pink-500', 'fill-current');
                        }
                    }

                    updateWishlistBadge(data.wishlist_count);
                    showNotification(data.message || 'Removed from wishlist', 'success');
                } else {
                    showNotification(data.message || 'Failed to remove from wishlist', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to remove from wishlist', 'error');
            }
        }

        function updateWishlistBadge(count) {
            const badge = document.getElementById('wishlist-count');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        }

        // Initialize wishlist badges and check status on page load
        document.addEventListener('DOMContentLoaded', function() {
            @auth
            // First, update the wishlist count
            fetch('{{ route("wishlist.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: 0 }) // Dummy product_id to get count
            })
            .then(response => response.json())
            .then(data => {
                if (data.wishlist_count > 0) {
                    updateWishlistBadge(data.wishlist_count);
                }
            })
            .catch(error => console.error('Error fetching wishlist count:', error));

            // Performance: Skip individual product checks on page load
            // Hearts will update when user clicks them
            @endauth
        });

        async function checkProductWishlistStatus(productId) {
            @auth
            try {
                const response = await fetch('{{ route("wishlist.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();
                if (data.in_wishlist) {
                    const btn = document.querySelector(`[data-product-id="${productId}"]`);
                    if (btn) {
                        const icon = btn.querySelector('.wishlist-icon');
                        if (icon) {
                            icon.classList.add('text-red-500', 'fill-current');
                            btn.classList.add('text-red-500');
                        }
                    }
                }
            } catch (error) {
                console.error('Error checking wishlist status:', error);
            }
            @endauth
        }

        // Quick View Functions
        let currentQuickViewProductId = null;

        async function openQuickView(productId, event = null) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            currentQuickViewProductId = productId;

            const modal = document.getElementById('quick-view-modal');
            if (!modal) return;

            modal.style.display = 'flex';
            modal.classList.remove('hidden');

            // Show loader, hide content
            document.getElementById('quick-view-loader')?.classList.remove('hidden');
            document.getElementById('quick-view-body')?.classList.add('hidden');

            try {
                const response = await fetch(`/api/product/${productId}`);
                const data = await response.json();

                if (data.success && data.product) {
                    const product = data.product;
                    const title = document.getElementById('qv-title');
                    const category = document.getElementById('qv-category');
                    const description = document.getElementById('qv-description');

                    if (title) title.textContent = product.name;
                    if (category) category.textContent = product.category?.name || '';
                    if (description) description.textContent = product.short_description || product.long_description || '';

                    const priceContainer = document.getElementById('qv-price');
                    if (priceContainer) {
                        const currentPrice = product.discount_price || product.base_price;
                        priceContainer.innerHTML = `<span class="text-3xl font-bold text-pink-600 dark:text-pink-400">Rs ${currentPrice.toLocaleString()}</span>`;

                        if (product.is_on_sale && product.discount_price < product.base_price) {
                            priceContainer.innerHTML += `<span class="text-lg text-gray-400 line-through ml-2">Rs ${product.base_price.toLocaleString()}</span>`;
                            const discountPct = document.getElementById('qv-discount-pct');
                            const saleBadge = document.getElementById('qv-sale-badge');
                            if (discountPct) discountPct.textContent = `${product.discount_percentage}%`;
                            if (saleBadge) saleBadge.classList.remove('hidden');
                        }
                    }

                    const mainImage = document.getElementById('qv-main-image');
                    if (mainImage) {
                        const imgPath = product.primary_image || product.images?.[0]?.image_path;
                        if (imgPath) mainImage.src = `/storage/${imgPath}`;
                    }

                    // Update view full details link
                    const viewFullBtn = document.getElementById('qv-view-full-btn');
                    if (viewFullBtn) viewFullBtn.href = `/product/${product.slug}`;

                    document.getElementById('quick-view-loader')?.classList.add('hidden');
                    document.getElementById('quick-view-body')?.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading product:', error);
                showNotification('Failed to load product details', 'error');
                closeQuickView();
            }
        }

        function closeQuickView() {
            const modal = document.getElementById('quick-view-modal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }
        }

        function addToCartFromModal() {
            if (!currentQuickViewProductId) return;
            const qty = parseInt(document.getElementById('qv-quantity')?.value || 1);
            const btn = document.getElementById('qv-add-to-cart-btn');

            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: currentQuickViewProductId,
                    quantity: qty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartSidebar(data);
                    updateHeaderCartBadge(data.cart_count);
                    showNotification(data.message, 'success');
                    closeQuickView();
                    setTimeout(() => toggleCartSidebar(), 300);
                } else {
                    showNotification(data.message || 'Failed to add to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to add to cart', 'error');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-shopping-cart"></i><span>Add to Cart</span>';
                }
            });
        }

        function addToWishlistFromModal() {
            if (!currentQuickViewProductId) return;
            addToWishlistAjax(currentQuickViewProductId);
        }

        function increaseQuantity() {
            const input = document.getElementById('qv-quantity');
            if (input) input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantity() {
            const input = document.getElementById('qv-quantity');
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Cart Functions with Enhanced Animations
        function addToCartAjax(productId, quantity = 1) {
            // Find the button - try event first, then fallback to querySelector
            let btn;
            try {
                btn = event && event.target ? event.target.closest('button') : null;
            } catch (e) {
                btn = null;
            }
            if (!btn) {
                btn = document.querySelector(`button[data-product-id="${productId}"]`);
            }
            if (!btn) {
                console.error('Add to cart button not found for product:', productId);
            }

            const btnText = btn.querySelector('.btn-text');
            const btnSpinner = btn.querySelector('.btn-spinner');
            const btnIcon = btn.querySelector('.btn-icon');

            // Disable button and show loading state
            btn.disabled = true;
            if (btnText) btnText.classList.add('hidden');
            if (btnSpinner) btnSpinner.classList.remove('hidden');

            // Add loading animation to button
            btn.classList.add('scale-95', 'opacity-75');

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => {
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // Not JSON response - might be a redirect or error page
                    console.error('Non-JSON response from cart.add:', response.status, response.statusText);
                    throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                }
            })
            .then(data => {
                if (data && data.success) {
                    // Animate button success
                    btn.classList.remove('scale-95', 'opacity-75');
                    btn.classList.add('scale-110');
                    setTimeout(() => btn.classList.remove('scale-110'), 200);

                    // Cart icon bounce animation
                    animateCartIcon();

                    // Update cart sidebar
                    updateCartSidebar(data);
                    updateHeaderCartBadge(data.cart_count);

                    // Show success toast (use our new toast system)
                    if (window.toastSuccess) {
                        toastSuccess(data.message || 'Product added to cart!');
                    }

                    // Confetti effect
                    createConfetti(btn);

                    // Open cart sidebar
                    setTimeout(() => {
                        toggleCartSidebar();
                    }, 300);
                } else {
                    // Check if MOQ validation failed
                    if (data.moq) {
                        // Show MOQ-specific error with quantity input
                        showMOQError(data.message, data.moq, productId);
                    } else {
                        if (window.toastError) {
                            toastError(data.message || 'Failed to add to cart');
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (window.toastError) {
                    toastError('Failed to add to cart. Please try again.');
                }
            })
            .finally(() => {
                // Re-enable button and restore text
                btn.disabled = false;
                btn.classList.remove('scale-95', 'opacity-75');
                if (btnText) btnText.classList.remove('hidden');
                if (btnSpinner) btnSpinner.classList.add('hidden');
            });
        }

        // Show MOQ Error Modal
        function showMOQError(message, moq, productId) {
            // Create modal HTML
            const modalHTML = `
                <div id="moq-error-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform scale-95 animate-scale-in">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-box text-3xl text-orange-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Minimum Order Quantity</h3>
                            <p class="text-gray-600 dark:text-gray-400">${message}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-between mb-3">
                                <label class="font-semibold text-gray-900 dark:text-gray-100">Quantity:</label>
                                <div class="flex items-center gap-2">
                                    <button onclick="decrementMOQQty(${moq})" class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-300">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" id="moq-quantity-input" value="${moq}" min="${moq}" class="w-20 text-center px-3 py-2 border-2 border-purple-300 rounded-lg font-bold">
                                    <button onclick="incrementMOQQty()" class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-300">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 text-center">Minimum: ${moq} units</p>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="closeMOQModal()" class="flex-1 px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300">
                                Cancel
                            </button>
                            <button onclick="addToCartWithMOQ(${productId})" class="flex-1 px-4 py-3 gradient-purple text-white rounded-xl font-semibold hover:shadow-lg">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('moq-error-modal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        function incrementMOQQty() {
            const input = document.getElementById('moq-quantity-input');
            if (input) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementMOQQty(moq) {
            const input = document.getElementById('moq-quantity-input');
            if (input && parseInt(input.value) > moq) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function closeMOQModal() {
            const modal = document.getElementById('moq-error-modal');
            if (modal) {
                modal.remove();
            }
        }

        function addToCartWithMOQ(productId) {
            const input = document.getElementById('moq-quantity-input');
            const quantity = input ? parseInt(input.value) : 1;
            closeMOQModal();
            addToCartAjax(productId, quantity);
        }

        // Animate cart icon in header with bounce effect
        function animateCartIcon() {
            const cartIcons = document.querySelectorAll('.cart-icon-header');
            cartIcons.forEach(icon => {
                icon.classList.add('animate-bounce-custom');
                setTimeout(() => {
                    icon.classList.remove('animate-bounce-custom');
                }, 600);
            });
        }

        // Create confetti effect at button position
        function createConfetti(button) {
            if (!button) return;
            const rect = button.getBoundingClientRect();
            const colors = ['#ec4899', '#f472b6', '#fb923c', '#fbbf24'];

            for (let i = 0; i < 15; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.left = rect.left + rect.width / 2 + 'px';
                confetti.style.top = rect.top + rect.height / 2 + 'px';
                confetti.style.width = '8px';
                confetti.style.height = '8px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.borderRadius = '50%';
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';

                document.body.appendChild(confetti);

                const angle = (Math.PI * 2 * i) / 15;
                const velocity = 50 + Math.random() * 50;
                const vx = Math.cos(angle) * velocity;
                const vy = Math.sin(angle) * velocity;

                let posX = 0, posY = 0, opacity = 1;
                const animate = () => {
                    posX += vx * 0.016;
                    posY += vy * 0.016 + 30 * 0.016;
                    opacity -= 0.016;

                    confetti.style.transform = `translate(${posX}px, ${posY}px)`;
                    confetti.style.opacity = opacity;

                    if (opacity > 0) {
                        requestAnimationFrame(animate);
                    } else {
                        confetti.remove();
                    }
                };
                animate();
            }
        }

        function updateHeaderCartBadge(count) {
            const badges = document.querySelectorAll('.cart-badge');
            badges.forEach(badge => {
                badge.textContent = count;
                if (count === 0) {
                    badge.classList.add('hidden');
                } else {
                    badge.classList.remove('hidden');
                }
            });
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-24 right-6 px-6 py-4 rounded-xl shadow-2xl z-[60] animation-slide-in flex items-center gap-3 max-w-sm ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle'
            };

            notification.innerHTML = `
                <i class="fas ${icons[type]} text-lg flex-shrink-0"></i>
                <span class="font-semibold">${message}</span>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Initialize cart sidebar on page load
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any initialization code here
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animation-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animation-slide-in.opacity-0 {
            animation: slideOut 0.3s ease-in forwards;
        }

        @keyframes slideOut {
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }
    </style>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-[9999] space-y-3 max-w-sm w-full pointer-events-none"></div>

    <!-- Toast Notification Styles -->
    <style>
        .toast-notification {
            pointer-events: auto;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toast-notification.removing {
            animation: slideOutRight 0.3s ease-in-out forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(400px);
            }
        }

        .toast-progress {
            height: 4px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            transform-origin: left;
            animation: progressBar 5s linear forwards;
        }

        @keyframes progressBar {
            from {
                transform: scaleX(1);
            }
            to {
                transform: scaleX(0);
            }
        }

        .toast-icon {
            animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes iconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>

    <!-- Toast Notification JavaScript -->
    <script>
        // Toast Notification System
        window.showToast = function(message, type = 'success', duration = 5000) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toastId = 'toast-' + Date.now();

            // Toast configuration
            const config = {
                success: {
                    bg: 'bg-gradient-to-r from-green-500 to-emerald-600',
                    icon: 'fas fa-check-circle',
                    iconBg: 'bg-green-600',
                    progressBg: 'bg-green-300'
                },
                error: {
                    bg: 'bg-gradient-to-r from-red-500 to-rose-600',
                    icon: 'fas fa-times-circle',
                    iconBg: 'bg-red-600',
                    progressBg: 'bg-red-300'
                },
                warning: {
                    bg: 'bg-gradient-to-r from-yellow-500 to-amber-600',
                    icon: 'fas fa-exclamation-triangle',
                    iconBg: 'bg-yellow-600',
                    progressBg: 'bg-yellow-300'
                },
                info: {
                    bg: 'bg-gradient-to-r from-blue-500 to-indigo-600',
                    icon: 'fas fa-info-circle',
                    iconBg: 'bg-blue-600',
                    progressBg: 'bg-blue-300'
                }
            };

            const style = config[type] || config.success;

            // Create toast element
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `toast-notification ${style.bg} text-white rounded-lg shadow-2xl overflow-hidden relative`;
            toast.innerHTML = `
                <div class="flex items-start gap-3 p-4 pr-12">
                    <div class="toast-icon flex-shrink-0 w-10 h-10 ${style.iconBg} rounded-full flex items-center justify-center shadow-lg">
                        <i class="${style.icon} text-lg"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-medium leading-relaxed">${message}</p>
                    </div>
                    <button onclick="removeToast('${toastId}')" class="absolute top-3 right-3 text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                <div class="toast-progress ${style.progressBg}"></div>
            `;

            container.appendChild(toast);

            // Auto remove after duration
            setTimeout(() => {
                removeToast(toastId);
            }, duration);
        };

        // Remove toast function
        window.removeToast = function(toastId) {
            const toast = document.getElementById(toastId);
            if (!toast) return;

            toast.classList.add('removing');

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        };

        // Success shortcut
        window.toastSuccess = function(message, duration = 5000) {
            showToast(message, 'success', duration);
        };

        // Error shortcut
        window.toastError = function(message, duration = 5000) {
            showToast(message, 'error', duration);
        };

        // Warning shortcut
        window.toastWarning = function(message, duration = 5000) {
            showToast(message, 'warning', duration);
        };

        // Info shortcut
        window.toastInfo = function(message, duration = 5000) {
            showToast(message, 'info', duration);
        };

        // Show Laravel session messages as toasts on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                toastSuccess("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastError("{{ session('error') }}");
            @endif

            @if(session('warning'))
                toastWarning("{{ session('warning') }}");
            @endif

            @if(session('info'))
                toastInfo("{{ session('info') }}");
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastError("{{ $error }}");
                @endforeach
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>

<aside class="w-72 gradient-pink text-white flex-shrink-0 hidden md:flex md:flex-col shadow-2xl" x-data="{ activeMenu: '{{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'products' : '' }}' }">
    <!-- Logo -->
    <div class="flex items-center justify-center h-24 border-b border-white/10">
        <div class="flex items-center space-x-3 animate-float">
            <i class="fas fa-gem text-3xl"></i>
            <div>
                <span class="text-2xl font-bold tracking-wide">Rizla</span>
                <p class="text-xs text-pink-100 -mt-1">Cosmetics Admin</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">
        <!-- Dashboard -->
        @if(auth()->user()->hasRole('super_admin'))
        <a href="{{ route('admin.super.dashboard') }}"
           class="flex items-center px-4 py-3.5 mb-2 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.super.dashboard') ? 'bg-white/20 text-white shadow-lg transform scale-105' : 'text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6' }}">
            <i class="fas fa-crown w-5 mr-3 text-lg"></i>
            <span class="font-medium">Super Dashboard</span>
        </a>
        @else
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-4 py-3.5 mb-2 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-lg transform scale-105' : 'text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6' }}">
            <i class="fas fa-tachometer-alt w-5 mr-3 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        @endif

        @can('view_products')
        <!-- Products Section -->
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'products' ? '' : 'products'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-box-open w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Products</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'products' }"></i>
            </button>
            <div x-show="activeMenu === 'products'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-list mr-3 w-4"></i>All Products
                </a>
                <a href="{{ route('admin.products.create') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-plus-circle mr-3 w-4"></i>Add New
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-tags mr-3 w-4"></i>Categories
                </a>
                <a href="{{ route('admin.inventory.bulk-update') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-file-upload mr-3 w-4"></i>Bulk Inventory
                </a>
            </div>
        </div>
        @endcan

        @can('view_orders')
        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3.5 mb-2 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6 transition-all duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
            <i class="fas fa-shopping-bag w-5 mr-3 text-lg"></i>
            <span class="font-medium">Orders</span>
            <span class="ml-auto bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full">0</span>
        </a>
        @endcan

        @can('manage_coupons')
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'offers' ? '' : 'offers'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300">
                <div class="flex items-center">
                    <i class="fas fa-percentage w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Offers</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'offers' }"></i>
            </button>
            <div x-show="activeMenu === 'offers'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-ticket-alt mr-3 w-4"></i>Coupons
                </a>
                <a href="{{ route('admin.flash-sales.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-bolt mr-3 w-4"></i>Flash Sales
                </a>
            </div>
        </div>
        @endcan

        @can('manage_banners')
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'cms' ? '' : 'cms'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.banners.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.blogs.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-file-alt w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Content</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'cms' }"></i>
            </button>
            <div x-show="activeMenu === 'cms'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.banners.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-image mr-3 w-4"></i>Banners
                </a>
                <a href="{{ route('admin.pages.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-file mr-3 w-4"></i>Pages
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-blog mr-3 w-4"></i>Blog
                </a>
            </div>
        </div>
        @endcan

        @can('manage_email_campaigns')
        <a href="{{ route('admin.newsletter-subscribers.index') }}" class="flex items-center px-4 py-3.5 mb-2 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6 transition-all duration-300 {{ request()->routeIs('admin.newsletter-subscribers.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
            <i class="fas fa-envelope-open-text w-5 mr-3 text-lg"></i>
            <span class="font-medium">Newsletter</span>
        </a>
        @endcan

        @canany(['manage_popups', 'view_abandoned_carts', 'view_orders'])
        <!-- Marketing Section -->
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'marketing' ? '' : 'marketing'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.popup-campaigns.*') || request()->routeIs('admin.abandoned-carts.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-bullhorn w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Marketing</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'marketing' }"></i>
            </button>
            <div x-show="activeMenu === 'marketing'" x-collapse class="ml-8 mt-2 space-y-1">
                @can('manage_popups')
                <a href="{{ route('admin.popup-campaigns.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-window-maximize mr-3 w-4"></i>Popup Campaigns
                </a>
                @endcan
                @canany(['view_abandoned_carts', 'view_orders'])
                <a href="{{ route('admin.abandoned-carts.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-shopping-cart mr-3 w-4"></i>Abandoned Carts
                    @php
                        $abandonedCount = \App\Models\AbandonedCart::where('reminder_sent', false)->count();
                    @endphp
                    @if($abandonedCount > 0)
                    <span class="ml-auto bg-orange-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full">{{ $abandonedCount }}</span>
                    @endif
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        @can('view_products')
        <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-4 py-3.5 mb-2 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6 transition-all duration-300 {{ request()->routeIs('admin.reviews.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
            <i class="fas fa-star w-5 mr-3 text-lg"></i>
            <span class="font-medium">Product Reviews</span>
            @php
                $pendingReviews = \App\Models\Review::where('is_approved', 0)->orWhereNull('is_approved')->count();
            @endphp
            @if($pendingReviews > 0)
            <span class="ml-auto bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full">{{ $pendingReviews }}</span>
            @endif
        </a>
        @endcan

        @can('view_products')
        <a href="{{ route('admin.inventory-logs.index') }}" class="flex items-center px-4 py-3.5 mb-2 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white hover:pl-6 transition-all duration-300 {{ request()->routeIs('admin.inventory-logs.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
            <i class="fas fa-boxes w-5 mr-3 text-lg"></i>
            <span class="font-medium">Inventory Logs</span>
        </a>
        @endcan

        @can('view_reports')
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'reports' ? '' : 'reports'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-chart-line w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Reports</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'reports' }"></i>
            </button>
            <div x-show="activeMenu === 'reports'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.reports.sales') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-dollar-sign mr-3 w-4"></i>Sales Report
                </a>
                <a href="{{ route('admin.reports.orders') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-receipt mr-3 w-4"></i>Order Report
                </a>
                <a href="{{ route('admin.reports.products') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-box mr-3 w-4"></i>Product Report
                </a>
                <a href="{{ route('admin.reports.customers') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-users mr-3 w-4"></i>Customer Report
                </a>

                @can('view_b2b_reports')
                <div class="border-t border-white/10 my-2"></div>
                <a href="{{ route('admin.reports.b2b-analytics') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all {{ request()->routeIs('admin.reports.b2b-analytics') ? 'bg-white/20 text-white' : '' }}">
                    <i class="fas fa-briefcase mr-3 w-4"></i>B2B Analytics
                </a>
                @endcan
            </div>
        </div>
        @endcan

        @canany(['manage_b2b_customers', 'approve_b2b_registrations', 'view_b2b_reports'])
        <!-- B2B Management Section -->
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'b2b' ? '' : 'b2b'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.b2b.*') || request()->routeIs('admin.reports.b2b-analytics') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-briefcase w-5 mr-3 text-lg"></i>
                    <span class="font-medium">B2B Management</span>
                    @php
                        $pendingB2BCount = \App\Models\BusinessProfile::where('status', 'pending')->count();
                    @endphp
                    @if($pendingB2BCount > 0)
                        <span class="ml-2 bg-yellow-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded-full animate-pulse">{{ $pendingB2BCount }}</span>
                    @endif
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'b2b' }"></i>
            </button>
            <div x-show="activeMenu === 'b2b'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.b2b.pending') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all relative">
                    <i class="fas fa-clock mr-3 w-4"></i>Pending Approvals
                    @if($pendingB2BCount > 0)
                        <span class="ml-auto bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full">{{ $pendingB2BCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.b2b.approved') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-check-circle mr-3 w-4"></i>Approved Businesses
                </a>
                <a href="{{ route('admin.b2b.rejected') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-times-circle mr-3 w-4"></i>Rejected Applications
                </a>
                <a href="{{ route('admin.orders.index') }}?filter=b2b" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-shopping-bag mr-3 w-4"></i>B2B Orders
                </a>
                <a href="{{ route('admin.reports.b2b-analytics') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-chart-line mr-3 w-4"></i>B2B Analytics
                </a>
            </div>
        </div>
        @endcanany

        @can('manage_users')
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'users' ? '' : 'users'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.activity-logs.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-users-cog w-5 mr-3 text-lg"></i>
                    <span class="font-medium">User Management</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'users' }"></i>
            </button>
            <div x-show="activeMenu === 'users'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-user mr-3 w-4"></i>All Users
                </a>
                <a href="{{ route('admin.b2b.pending') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all relative">
                    <i class="fas fa-building mr-3 w-4"></i>B2B Registrations
                    @php
                        $pendingB2B = \App\Models\BusinessProfile::where('status', 'pending')->count();
                    @endphp
                    @if($pendingB2B > 0)
                        <span class="ml-auto bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingB2B }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-shield-alt mr-3 w-4"></i>Roles & Permissions
                </a>
                <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-history mr-3 w-4"></i>Activity Logs
                </a>
            </div>
        </div>
        @endcan

        @can('manage_settings')
        <div class="mb-2">
            <button @click="activeMenu = activeMenu === 'settings' ? '' : 'settings'"
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-pink-50 hover:bg-white/10 hover:text-white transition-all duration-300 {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.translations.*') ? 'bg-white/10' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-cog w-5 mr-3 text-lg"></i>
                    <span class="font-medium">Settings</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': activeMenu === 'settings' }"></i>
            </button>
            <div x-show="activeMenu === 'settings'" x-collapse class="ml-8 mt-2 space-y-1">
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-sliders-h mr-3 w-4"></i>General Settings
                </a>
                <a href="{{ route('admin.translations.index') }}" class="flex items-center px-4 py-2.5 text-sm text-pink-50 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-language mr-3 w-4"></i>Translations
                </a>
            </div>
        </div>
        @endcan
    </nav>

    <!-- User Info -->
    <div class="p-5 border-t border-white/10 bg-black/10">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 gradient-purple rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-pink-100 truncate">
                    @foreach(auth()->user()->roles as $role)
                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }
</style>

<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Welcome Card -->
    <div class="gradient-pink text-white rounded-2xl shadow-2xl p-8 mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-3xl font-bold mb-2"><i class="fas fa-sparkles mr-2"></i>Welcome back, {{ auth()->user()->name }}!</h3>
                <p class="text-pink-100">Here's your store overview for today</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Products</p>
                    <p class="text-4xl font-bold gradient-pink bg-clip-text text-transparent">{{ $stats['total_products'] }}</p>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-check-circle mr-1"></i>{{ $stats['active_products'] }} Active</p>
                </div>
                <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-box-open text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                    <p class="text-4xl font-bold gradient-blue bg-clip-text text-transparent">{{ $stats['total_orders'] }}</p>
                    <p class="text-xs text-yellow-600 mt-2"><i class="fas fa-clock mr-1"></i>{{ $stats['pending_orders'] }} Pending</p>
                </div>
                <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-shopping-bag text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                    <p class="text-4xl font-bold gradient-pink bg-clip-text text-transparent">Rs {{ number_format($stats['total_revenue'], 0) }}</p>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i>Today: Rs {{ number_format($stats['todays_revenue'], 0) }}</p>
                </div>
                <div class="w-16 h-16 gradient-orange rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-coins text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Customers</p>
                    <p class="text-4xl font-bold gradient-purple bg-clip-text text-transparent">{{ $stats['total_customers'] }}</p>
                    <p class="text-xs text-blue-600 mt-2"><i class="fas fa-user-plus mr-1"></i>Growing daily</p>
                </div>
                <div class="w-16 h-16 gradient-pink rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-users text-3xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-shopping-cart text-pink-600 mr-3"></i>Recent Orders
            </h3>

            <div class="space-y-4">
                @forelse($recent_orders as $order)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 gradient-blue rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-pink-600">Rs {{ number_format($order->total_amount, 0) }}</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">{{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8"><i class="fas fa-inbox text-4xl mb-2"></i><br>No orders yet</p>
                @endforelse
            </div>

            @if($recent_orders->count() > 0)
            <a href="{{ route('admin.orders.index') }}" class="block text-center mt-6 text-pink-600 font-semibold hover:text-pink-700">
                View All Orders <i class="fas fa-arrow-right ml-1"></i>
            </a>
            @endif
        </div>

        <!-- Low Stock & Bestsellers -->
        <div class="space-y-6">
            <!-- Low Stock Alert -->
            @if($low_stock_products->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-exclamation-triangle text-orange-500 mr-3"></i>Low Stock Alert
                </h3>

                <div class="space-y-3">
                    @foreach($low_stock_products as $product)
                    <div class="flex items-center justify-between p-3 {{ $product->stock_quantity <= 5 ? 'bg-red-50 border-l-4 border-red-500' : 'bg-orange-50 border-l-4 border-orange-500' }} rounded-xl">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600">{{ $product->category->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-bell mr-1"></i>Threshold: {{ $product->low_stock_threshold }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full {{ $product->stock_quantity <= 5 ? 'bg-red-500' : 'bg-orange-500' }} text-white text-sm font-bold">
                                {{ $product->stock_quantity }} left
                            </span>
                            @if($product->stock_quantity <= 5)
                            <p class="text-xs text-red-600 font-semibold mt-1">Critical!</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.products.index') }}?low_stock=1" class="block text-center mt-4 text-orange-600 font-semibold hover:text-orange-700">
                    View All Low Stock Products <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif

            <!-- Bestsellers -->
            <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-fire text-pink-600 mr-3"></i>Bestsellers
                </h3>

                <div class="space-y-3">
                    @forelse($bestsellers as $product)
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:shadow-md transition-shadow">
                        @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-12 h-12 rounded-lg object-cover shadow-md">
                        @endif
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $product->name }}</p>
                            <p class="text-xs text-pink-600">Rs {{ number_format($product->final_price, 0) }}</p>
                        </div>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No bestsellers yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" data-aos="fade-up">
        <a href="{{ route('admin.products.create') }}" class="gradient-pink text-white p-6 rounded-2xl hover-lift text-center">
            <i class="fas fa-plus-circle text-4xl mb-3"></i>
            <p class="font-bold">Add Product</p>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="gradient-blue text-white p-6 rounded-2xl hover-lift text-center">
            <i class="fas fa-shopping-bag text-4xl mb-3"></i>
            <p class="font-bold">View Orders</p>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="gradient-purple text-white p-6 rounded-2xl hover-lift text-center">
            <i class="fas fa-tags text-4xl mb-3"></i>
            <p class="font-bold">Manage Categories</p>
        </a>
        <a href="#" class="gradient-orange text-white p-6 rounded-2xl hover-lift text-center">
            <i class="fas fa-chart-bar text-4xl mb-3"></i>
            <p class="font-bold">View Reports</p>
        </a>
    </div>
</x-admin-layout>

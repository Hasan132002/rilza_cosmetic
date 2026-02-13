<x-frontend-layout title="My Account">
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8" data-aos="fade-down">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">My Account</h1>
                <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="w-16 h-16 gradient-pink rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Pending Orders</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                        </div>
                        <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Spent</p>
                            <p class="text-3xl font-bold text-gray-900">Rs. {{ number_format($stats['total_spent']) }}</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-wallet text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Account Menu -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="w-16 h-16 gradient-pink rounded-xl flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            <a href="{{ route('account.dashboard') }}" class="flex items-center px-4 py-3 bg-pink-50 text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-shopping-bag w-5 mr-3"></i>
                                My Orders
                            </a>
                            <a href="{{ route('account.addresses.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-map-marker-alt w-5 mr-3"></i>
                                Addresses
                            </a>
                            <a href="{{ route('account.reviews') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-star w-5 mr-3"></i>
                                My Reviews
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-user-edit w-5 mr-3"></i>
                                Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-all">
                                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Recent Orders</h2>
                            <a href="{{ route('account.orders') }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @if($recent_orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_orders as $order)
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-pink-300 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-bold text-gray-900">Order #{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                                        @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                                        @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm">{{ $order->items_count ?? $order->items->count() }} item(s)</p>
                                        <p class="text-lg font-bold text-gray-900">Rs. {{ number_format($order->total_amount) }}</p>
                                    </div>
                                    <a href="{{ route('account.order.details', $order) }}" class="gradient-pink text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                                        View Details
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg mb-4">No orders yet</p>
                            <a href="{{ route('shop') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold inline-block hover:shadow-lg transition-all">
                                Start Shopping
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>

<x-frontend-layout title="My Orders">
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8" data-aos="fade-down">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">My Orders</h1>
                <p class="text-gray-600">Track and manage your orders</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
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
                            <a href="{{ route('account.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 bg-pink-50 text-pink-600 rounded-xl font-medium transition-all">
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

                <!-- Orders List -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                        @if($orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-xl p-6 hover:border-pink-300 hover:shadow-lg transition-all">
                                <!-- Order Header -->
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 pb-4 border-b border-gray-200">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Order #{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-calendar mr-2"></i>Placed on {{ $order->created_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                    <span class="mt-3 md:mt-0 inline-flex px-4 py-2 rounded-full text-sm font-semibold
                                        @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                                        @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>

                                <!-- Order Items -->
                                <div class="space-y-3 mb-4">
                                    @foreach($order->items->take(2) as $item)
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $item->product->featured_image_url }}" alt="{{ $item->product->name }}"
                                             class="w-16 h-16 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × Rs. {{ number_format($item->price) }}</p>
                                        </div>
                                        <p class="font-bold text-gray-900">Rs. {{ number_format($item->quantity * $item->price) }}</p>
                                    </div>
                                    @endforeach

                                    @if($order->items->count() > 2)
                                    <p class="text-sm text-gray-600 italic">
                                        + {{ $order->items->count() - 2 }} more item(s)
                                    </p>
                                    @endif
                                </div>

                                <!-- Order Footer -->
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between pt-4 border-t border-gray-200">
                                    <div>
                                        <p class="text-gray-600">Total Amount</p>
                                        <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format($order->total_amount) }}</p>
                                    </div>
                                    <a href="{{ route('account.order.details', $order) }}" class="mt-3 md:mt-0 gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all text-center">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                        @endif

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

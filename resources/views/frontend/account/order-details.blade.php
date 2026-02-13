<x-frontend-layout title="Order Details">
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8" data-aos="fade-down">
                <div class="flex items-center space-x-4 mb-4">
                    <a href="{{ route('account.orders') }}" class="text-gray-600 hover:text-pink-600 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold
                    @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                    @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Items List -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 last:border-0">
                                <img src="{{ $item->product->featured_image_url }}" alt="{{ $item->product->name }}"
                                     class="w-20 h-20 object-cover rounded-xl">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-600">Price: Rs. {{ number_format($item->price) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-gray-900">Rs. {{ number_format($item->quantity * $item->price) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right" data-aos-delay="100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Timeline</h2>
                        <div class="relative">
                            @foreach($order->statusHistory->sortByDesc('created_at') as $history)
                            <div class="flex items-start space-x-4 mb-6 last:mb-0">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        @if($history->status === 'pending') bg-yellow-100 text-yellow-600
                                        @elseif($history->status === 'processing') bg-blue-100 text-blue-600
                                        @elseif($history->status === 'shipped') bg-purple-100 text-purple-600
                                        @elseif($history->status === 'delivered') bg-green-100 text-green-600
                                        @elseif($history->status === 'cancelled') bg-red-100 text-red-600
                                        @endif">
                                        <i class="fas
                                            @if($history->status === 'pending') fa-clock
                                            @elseif($history->status === 'processing') fa-cog
                                            @elseif($history->status === 'shipped') fa-shipping-fast
                                            @elseif($history->status === 'delivered') fa-check-circle
                                            @elseif($history->status === 'cancelled') fa-times-circle
                                            @endif"></i>
                                    </div>
                                    @if(!$loop->last)
                                    <div class="absolute top-12 left-1/2 transform -translate-x-1/2 w-0.5 h-16 bg-gray-200"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $history->status) }}</h3>
                                    <p class="text-sm text-gray-600">{{ $history->created_at->format('M d, Y h:i A') }}</p>
                                    @if($history->notes)
                                    <p class="text-sm text-gray-700 mt-1">{{ $history->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-map-marker-alt text-pink-600 mr-2"></i>Shipping Address
                        </h3>
                        <div class="text-gray-700 space-y-1">
                            <p class="font-semibold">{{ $order->shipping_name }}</p>
                            <p>{{ $order->shipping_phone }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                            <p>{{ $order->shipping_postal_code }}</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-credit-card text-pink-600 mr-2"></i>Payment Method
                        </h3>
                        <p class="text-gray-700 font-medium">{{ strtoupper($order->payment_method) }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Status:
                            <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-orange-600' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-receipt text-pink-600 mr-2"></i>Order Summary
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span class="font-medium">Rs. {{ number_format($order->subtotal) }}</span>
                            </div>

                            @if($order->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span class="font-medium">- Rs. {{ number_format($order->discount_amount) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between text-gray-700">
                                <span>Shipping</span>
                                <span class="font-medium">
                                    @if($order->shipping_cost > 0)
                                        Rs. {{ number_format($order->shipping_cost) }}
                                    @else
                                        Free
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between text-gray-700 pt-3 border-t border-gray-200">
                                <span>Tax</span>
                                <span class="font-medium">Rs. {{ number_format($order->tax_amount) }}</span>
                            </div>

                            <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t-2 border-gray-300">
                                <span>Total</span>
                                <span>Rs. {{ number_format($order->total_amount) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="300">
                        <a href="{{ route('shop') }}" class="w-full gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all text-center block">
                            <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>

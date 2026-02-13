<x-frontend-layout title="Order Confirmed">
    <div class="py-16 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <!-- Success Message -->
                <div class="bg-white rounded-3xl shadow-2xl p-12 text-center mb-8" data-aos="zoom-in">
                    <div class="w-24 h-24 gradient-pink rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl animate-bounce">
                        <i class="fas fa-check text-5xl text-white"></i>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
                    <p class="text-xl text-gray-600 mb-6">Thank you for your purchase, {{ $order->customer_name }}! 💖</p>

                    <div class="inline-block bg-gradient-to-r from-pink-100 to-purple-100 px-8 py-4 rounded-2xl mb-6">
                        <p class="text-sm text-gray-600 mb-1">Order Number</p>
                        <p class="text-2xl font-bold text-pink-600">{{ $order->order_number }}</p>
                    </div>

                    <p class="text-gray-600">
                        <i class="fas fa-envelope mr-2"></i>
                        A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>
                    </p>
                </div>

                <!-- Order Details -->
                <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-up">
                    <h3 class="text-2xl font-bold mb-6 flex items-center">
                        <i class="fas fa-box text-pink-600 mr-3"></i>
                        Order Details
                    </h3>

                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                            @if($item->product && $item->product->primaryImage)
                            <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                 class="w-20 h-20 object-cover rounded-xl shadow-md">
                            @endif
                            <div class="flex-1">
                                <p class="font-bold">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-pink-600">Rs {{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="border-t-2 border-gray-200 pt-6 space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold">Rs {{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-600">
                            <span><i class="fas fa-tag mr-2"></i>Discount ({{ $order->coupon_code }})</span>
                            <span class="font-semibold">- Rs {{ number_format($order->discount_amount, 0) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery</span>
                            <span class="font-semibold text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold text-gray-900">
                            <span>Total</span>
                            <span class="text-pink-600">Rs {{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>

                    <!-- Delivery Info -->
                    <div class="mt-8 p-6 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl">
                        <h4 class="font-bold mb-3 flex items-center">
                            <i class="fas fa-truck text-pink-600 mr-2"></i>
                            Delivery Address
                        </h4>
                        <p class="text-gray-700">{{ $order->shipping_address }}</p>
                        <p class="text-gray-700">{{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}</p>
                        <p class="text-gray-700 mt-2"><i class="fas fa-phone mr-2"></i>{{ $order->customer_phone }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('shop') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-4 rounded-xl font-bold text-center transition-all flex items-center justify-center">
                            <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                        </a>
                        <a href="{{ route('track-order') }}"
                           class="gradient-purple text-white py-4 rounded-xl font-bold text-center hover:shadow-xl transition-all flex items-center justify-center">
                            <i class="fas fa-truck mr-2"></i>Track Order
                        </a>
                        <a href="{{ route('account.orders') }}"
                           class="gradient-pink text-white py-4 rounded-xl font-bold text-center hover:shadow-xl transition-all flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i>My Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>

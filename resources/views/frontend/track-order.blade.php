<x-frontend-layout title="Track Your Order">
    <!-- Header Section -->
    <section class="gradient-pink text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-20 w-72 h-72 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    <i class="fas fa-shipping-fast mr-3"></i>Track Your Order
                </h1>
                <p class="text-xl text-pink-100">Enter your order details to check the status</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8" data-aos="fade-up">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if(!isset($order))
        <!-- Track Order Form -->
        <div class="max-w-2xl mx-auto" data-aos="fade-up">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full mb-4">
                        <i class="fas fa-search text-3xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold mb-2">Find Your Order</h2>
                    <p class="text-gray-600">Enter your order number and email address</p>
                </div>

                <form action="{{ route('track-order.track') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="order_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-hashtag mr-1 text-pink-600"></i>Order Number
                        </label>
                        <input type="text"
                               id="order_number"
                               name="order_number"
                               value="{{ old('order_number') }}"
                               placeholder="e.g., RIZ-ABC123XYZ"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('order_number') border-red-500 @enderror"
                               required>
                        @error('order_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1 text-pink-600"></i>Email Address
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="your@email.com"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>Track Order
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-center text-gray-600 text-sm mb-4">Need help?</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('contact') }}" class="text-pink-600 hover:text-pink-700 font-semibold text-sm">
                            <i class="fas fa-phone mr-1"></i>Contact Us
                        </a>
                        <a href="{{ route('faq') }}" class="text-pink-600 hover:text-pink-700 font-semibold text-sm">
                            <i class="fas fa-question-circle mr-1"></i>FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Order Details -->
        <div class="max-w-5xl mx-auto">
            <!-- Order Header -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-8" data-aos="fade-up">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Order #{{ $order->order_number }}</h2>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="inline-flex items-center px-6 py-3 rounded-full font-bold text-lg
                            @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 rounded-2xl p-6">
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Customer</div>
                        <div class="font-semibold">{{ $order->customer_name }}</div>
                        <div class="text-sm text-gray-600">{{ $order->customer_email }}</div>
                        <div class="text-sm text-gray-600">{{ $order->customer_phone }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Shipping Address</div>
                        <div class="font-semibold">{{ $order->shipping_address }}</div>
                        <div class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Order Total</div>
                        <div class="font-bold text-2xl text-pink-600">Rs {{ number_format($order->total_amount, 2) }}</div>
                        <div class="text-sm text-gray-600">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                </div>

                @if($order->tracking_number)
                <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-shipping-fast text-xl mr-3"></i>
                        <div>
                            <div class="font-semibold">Tracking Number</div>
                            <div class="font-mono">{{ $order->tracking_number }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-8" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-2xl font-bold mb-6">
                    <i class="fas fa-history text-pink-600 mr-2"></i>Order Timeline
                </h3>

                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-8 top-8 bottom-8 w-0.5 bg-gray-200"></div>

                    <!-- Timeline Items -->
                    <div class="space-y-8">
                        @php
                            $statuses = [
                                'pending' => ['icon' => 'fa-clock', 'color' => 'yellow'],
                                'processing' => ['icon' => 'fa-cog', 'color' => 'blue'],
                                'shipped' => ['icon' => 'fa-truck', 'color' => 'purple'],
                                'delivered' => ['icon' => 'fa-check-circle', 'color' => 'green'],
                            ];

                            $currentStatusIndex = array_search($order->order_status, array_keys($statuses));
                        @endphp

                        @foreach($statuses as $status => $details)
                            @php
                                $statusIndex = array_search($status, array_keys($statuses));
                                $isPassed = $statusIndex <= $currentStatusIndex;
                                $statusHistory = $order->statusHistory->firstWhere('status', $status);
                            @endphp

                            <div class="relative flex items-start gap-6">
                                <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center z-10
                                    {{ $isPassed ? 'bg-' . $details['color'] . '-500' : 'bg-gray-200' }}">
                                    <i class="fas {{ $details['icon'] }} text-2xl {{ $isPassed ? 'text-white' : 'text-gray-400' }}"></i>
                                </div>

                                <div class="flex-1 {{ $isPassed ? '' : 'opacity-50' }}">
                                    <div class="font-bold text-lg mb-1">{{ ucfirst($status) }}</div>
                                    @if($statusHistory)
                                        <div class="text-sm text-gray-600">
                                            {{ $statusHistory->created_at->format('F d, Y h:i A') }}
                                        </div>
                                        @if($statusHistory->notes)
                                            <div class="text-sm text-gray-600 mt-1">{{ $statusHistory->notes }}</div>
                                        @endif
                                    @else
                                        <div class="text-sm text-gray-400">Pending</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if($order->order_status === 'cancelled')
                            <div class="relative flex items-start gap-6">
                                <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center z-10 bg-red-500">
                                    <i class="fas fa-times-circle text-2xl text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-lg mb-1">Cancelled</div>
                                    @php $cancelHistory = $order->statusHistory->firstWhere('status', 'cancelled'); @endphp
                                    @if($cancelHistory)
                                        <div class="text-sm text-gray-600">
                                            {{ $cancelHistory->created_at->format('F d, Y h:i A') }}
                                        </div>
                                        @if($cancelHistory->notes)
                                            <div class="text-sm text-gray-600 mt-1">{{ $cancelHistory->notes }}</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-8" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-2xl font-bold mb-6">
                    <i class="fas fa-box text-pink-600 mr-2"></i>Order Items
                </h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-6 border-b border-gray-100 pb-4 last:border-0">
                        @if($item->product && $item->product->images->first())
                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                             alt="{{ $item->product_name }}"
                             class="w-24 h-24 object-cover rounded-xl">
                        @else
                        <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                        @endif

                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-1">{{ $item->product_name }}</h4>
                            <div class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</div>
                            <div class="text-sm text-gray-600">Unit Price: Rs {{ number_format($item->unit_price, 2) }}</div>
                        </div>

                        <div class="text-right">
                            <div class="font-bold text-xl text-pink-600">
                                Rs {{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t-2 border-gray-200">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rs {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between items-center mb-3 text-green-600">
                        <span>Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                        <span class="font-semibold">-Rs {{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center text-xl font-bold">
                        <span>Total</span>
                        <span class="text-pink-600">Rs {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('track-order') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-search mr-2"></i>Track Another Order
                </a>
                <a href="{{ route('shop') }}" class="inline-block bg-gray-200 text-gray-700 px-8 py-3 rounded-full font-bold hover:bg-gray-300 transition-all ml-4">
                    <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                </a>
            </div>
        </div>
        @endif
    </div>
</x-frontend-layout>

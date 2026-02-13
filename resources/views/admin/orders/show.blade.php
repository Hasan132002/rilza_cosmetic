<x-admin-layout>
    <x-slot name="header">
        Order Details
    </x-slot>

    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-down">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Orders</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-right">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Order {{ $order->order_number }}</h2>
                        <p class="text-gray-600 mt-1"><i class="fas fa-calendar mr-2"></i>{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg flex items-center gap-2 transition-all">
                            <i class="fas fa-print"></i>
                            <span>Print Invoice</span>
                        </a>
                        @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'packed' => 'bg-purple-100 text-purple-800',
                            'shipped' => 'bg-indigo-100 text-indigo-800',
                            'out_for_delivery' => 'bg-cyan-100 text-cyan-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusColors[$order->order_status] }}">
                            {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <h3 class="text-xl font-bold mb-4">Order Items</h3>
                <div class="space-y-4 mb-6">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        @if($item->product && $item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             class="w-20 h-20 object-cover rounded-lg shadow-md">
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                            @if($item->variant_name)
                            <p class="text-sm text-pink-600"><i class="fas fa-palette mr-1"></i>{{ $item->variant_name }}</p>
                            @endif
                            <p class="text-sm text-gray-600 mt-1">Qty: {{ $item->quantity }} × Rs {{ number_format($item->price, 0) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-pink-600">Rs {{ number_format($item->subtotal, 0) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Totals -->
                <div class="border-t-2 border-gray-200 pt-6 space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold">Rs {{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery</span>
                        <span class="font-semibold text-green-600">FREE</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold">
                        <span>Total</span>
                        <span class="text-pink-600">Rs {{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Shipping Info -->
            <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-right" data-aos-delay="100">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-user-circle text-pink-600 mr-3"></i>
                    Customer & Shipping Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Customer Info -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3">Customer Details</h4>
                        <div class="space-y-2 text-gray-600">
                            <p><i class="fas fa-user w-5 mr-2"></i>{{ $order->customer_name }}</p>
                            <p><i class="fas fa-envelope w-5 mr-2"></i>{{ $order->customer_email }}</p>
                            <p><i class="fas fa-phone w-5 mr-2"></i>{{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3">Shipping Address</h4>
                        <div class="text-gray-600">
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Update Status Form -->
            @can('edit_orders')
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6" data-aos="fade-left">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-edit text-pink-600 mr-2"></i>
                    Update Status
                </h3>

                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Status</label>
                        <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200">
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="packed" {{ $order->order_status == 'packed' ? 'selected' : '' }}>Packed</option>
                            <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tracking Number</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full gradient-pink text-white py-3 rounded-xl font-bold hover:shadow-xl transition-all">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
            </div>
            @endcan

            <!-- Order Timeline -->
            <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-history text-pink-600 mr-2"></i>
                    Status History
                </h3>

                <div class="space-y-4">
                    @foreach($order->statusHistory as $history)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 gradient-pink rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $history->status)) }}</p>
                            <p class="text-sm text-gray-500">{{ $history->created_at->format('M d, Y - h:i A') }}</p>
                            @if($history->notes)
                            <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

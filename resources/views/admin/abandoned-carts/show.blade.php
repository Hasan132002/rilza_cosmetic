<x-admin-layout>
    <x-slot name="header">
        Abandoned Cart Details
    </x-slot>

    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-down">
        <a href="{{ route('admin.abandoned-carts.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Abandoned Carts</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cart Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8" data-aos="fade-right">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Cart #{{ $cart->id }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            <i class="fas fa-calendar mr-2"></i>Abandoned {{ $cart->abandoned_at ? $cart->abandoned_at->format('M d, Y - h:i A') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        @if($cart->reminder_sent)
                        <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-check-circle mr-1"></i>Reminder Sent
                        </span>
                        @else
                        <span class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <i class="fas fa-clock mr-1"></i>Reminder Pending
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Cart Items -->
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Cart Items</h3>
                @if($cart->cart_data && is_array($cart->cart_data) && count($cart->cart_data) > 0)
                <div class="space-y-4 mb-6">
                    @foreach($cart->cart_data as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        @if(isset($item['image']))
                        <img src="{{ $item['image'] }}" class="w-20 h-20 object-cover rounded-lg shadow-md" alt="{{ $item['name'] ?? 'Product' }}">
                        @else
                        <div class="w-20 h-20 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $item['name'] ?? 'Unknown Product' }}</p>
                            @if(isset($item['sku']))
                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $item['sku'] }}</p>
                            @endif
                            @if(isset($item['variant']))
                            <p class="text-sm text-pink-600 dark:text-pink-400"><i class="fas fa-palette mr-1"></i>{{ $item['variant'] }}</p>
                            @endif
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Qty: {{ $item['quantity'] ?? 1 }} × Rs {{ number_format($item['price'] ?? 0, 0) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-pink-600">Rs {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>No items in cart</p>
                </div>
                @endif

                <!-- Cart Total -->
                <div class="border-t-2 border-gray-200 dark:border-gray-600 pt-6 space-y-3">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Subtotal</span>
                        <span class="font-semibold">Rs {{ number_format($cart->total_amount ?? 0, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Delivery</span>
                        <span class="font-semibold text-green-600">FREE</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold">
                        <span class="text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-pink-600">Rs {{ number_format($cart->total_amount ?? 0, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6" data-aos="fade-left">
                <h3 class="text-xl font-bold mb-4 flex items-center text-gray-900 dark:text-gray-100">
                    <i class="fas fa-user-circle text-pink-600 mr-3"></i>
                    Customer Information
                </h3>

                <div class="space-y-4">
                    @if($cart->user)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $cart->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <a href="mailto:{{ $cart->user->email }}" class="font-semibold text-blue-600 hover:text-blue-800">
                            {{ $cart->user->email }}
                        </a>
                    </div>
                    @if($cart->user->phone)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $cart->user->phone }}</p>
                    </div>
                    @endif
                    @else
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <i class="fas fa-user-slash mr-2"></i>Guest User
                        </p>
                        @if($cart->email)
                        <p class="text-sm mt-2">
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <a href="mailto:{{ $cart->email }}" class="font-semibold text-blue-600 hover:text-blue-800">
                                {{ $cart->email }}
                            </a>
                        </p>
                        @endif
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Session: {{ Str::limit($cart->session_id, 20) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Cart Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                <h3 class="text-xl font-bold mb-4 flex items-center text-gray-900 dark:text-gray-100">
                    <i class="fas fa-chart-bar text-pink-600 mr-3"></i>
                    Statistics
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-box w-5 mr-2"></i>Items Count
                        </span>
                        <span class="font-bold text-gray-900 dark:text-gray-100">
                            {{ is_array($cart->cart_data) ? count($cart->cart_data) : 0 }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-money-bill-wave w-5 mr-2"></i>Cart Value
                        </span>
                        <span class="font-bold text-pink-600">
                            Rs {{ number_format($cart->total_amount ?? 0, 0) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-clock w-5 mr-2"></i>Time Ago
                        </span>
                        <span class="font-bold text-gray-900 dark:text-gray-100">
                            {{ $cart->abandoned_at ? $cart->abandoned_at->diffForHumans() : 'N/A' }}
                        </span>
                    </div>

                    @if($cart->reminder_sent && $cart->reminder_sent_at)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-envelope w-5 mr-2"></i>Reminder Sent
                        </span>
                        <span class="font-bold text-green-600">
                            {{ $cart->reminder_sent_at->format('M d, Y') }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if(!$cart->reminder_sent && $cart->email)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="200">
                <h3 class="text-xl font-bold mb-4 flex items-center text-gray-900 dark:text-gray-100">
                    <i class="fas fa-paper-plane text-pink-600 mr-3"></i>
                    Actions
                </h3>

                <form action="{{ route('admin.abandoned-carts.send-reminder', $cart) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white py-3 rounded-xl font-bold shadow-md transition-all">
                        <i class="fas fa-envelope mr-2"></i>Send Reminder Email
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>

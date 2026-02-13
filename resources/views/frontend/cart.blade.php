<x-frontend-layout title="Shopping Cart">
    <div class="py-12 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12" data-aos="fade-down">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Shopping Cart</h1>
                <p class="text-gray-600"><i class="fas fa-shopping-cart mr-2"></i>{{ $cart->item_count }} items in your cart</p>
            </div>

            @if($cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-6 pb-6 mb-6 border-b border-gray-200 last:border-0">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->product->primaryImage)
                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-24 h-24 object-cover rounded-xl shadow-md">
                                @else
                                <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-gray-300"></i>
                                </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $item->product->category->name }}</p>
                                @if($item->variant)
                                <p class="text-sm text-pink-600"><i class="fas fa-palette mr-1"></i>{{ $item->variant->variant_name }}</p>
                                @endif

                                <!-- Quantity Control -->
                                <div class="flex items-center gap-3 mt-4">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="decrementQty({{ $item->id }})"
                                                class="w-8 h-8 bg-gray-200 rounded-lg hover:bg-pink-500 hover:text-white transition-all">
                                            <i class="fas fa-minus text-sm"></i>
                                        </button>
                                        <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1"
                                               class="w-16 text-center border border-gray-300 rounded-lg py-1"
                                               onchange="this.form.submit()">
                                        <button type="button" onclick="incrementQty({{ $item->id }})"
                                                class="w-8 h-8 bg-gray-200 rounded-lg hover:bg-pink-500 hover:text-white transition-all">
                                            <i class="fas fa-plus text-sm"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-4">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="text-right">
                                <p class="text-2xl font-bold text-pink-600">Rs {{ number_format($item->product->final_price * $item->quantity, 0) }}</p>
                                <p class="text-sm text-gray-500">Rs {{ number_format($item->product->final_price, 0) }} each</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24" data-aos="fade-left">
                        <h3 class="text-2xl font-bold mb-6">Order Summary</h3>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold">Rs {{ number_format($cart->total, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="font-semibold text-green-600">FREE</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-xl font-bold">
                                <span>Total</span>
                                <span class="text-pink-600">Rs {{ number_format($cart->total, 0) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}"
                           class="w-full gradient-pink text-white py-4 rounded-xl font-bold text-center block hover:shadow-2xl transition-all transform hover:scale-105">
                            <i class="fas fa-lock mr-2"></i>Proceed to Checkout
                        </a>

                        <a href="{{ route('shop') }}" class="w-full text-center block mt-4 text-gray-600 hover:text-pink-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            @else
            <!-- Empty Cart -->
            <div class="text-center py-20" data-aos="zoom-in">
                <div class="max-w-md mx-auto bg-white rounded-3xl shadow-xl p-12">
                    <i class="fas fa-shopping-cart text-8xl text-gray-300 mb-6"></i>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Your Cart is Empty!</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('shop') }}" class="gradient-pink text-white px-10 py-4 rounded-full font-bold inline-flex items-center gap-2 hover:shadow-2xl transition-all transform hover:scale-105">
                        <i class="fas fa-shopping-bag"></i>Start Shopping
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function incrementQty(id) {
            let input = document.getElementById('qty-' + id);
            input.value = parseInt(input.value) + 1;
            input.form.submit();
        }

        function decrementQty(id) {
            let input = document.getElementById('qty-' + id);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                input.form.submit();
            }
        }
    </script>
</x-frontend-layout>

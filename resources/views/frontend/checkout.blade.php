<x-frontend-layout title="Checkout">
    <div class="py-12 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12" data-aos="fade-down">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Secure Checkout</h1>
                <p class="text-gray-600"><i class="fas fa-lock mr-2"></i>Your information is safe with us</p>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-right">
                            <h3 class="text-2xl font-bold mb-6 flex items-center">
                                <i class="fas fa-user-circle text-pink-600 mr-3"></i>
                                Customer Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="phone" value="{{ old('phone', $defaultAddress->phone ?? auth()->user()->phone ?? '') }}" required
                                           placeholder="+92 300 1234567"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="mt-8">
                                <h3 class="text-2xl font-bold mb-6 flex items-center">
                                    <i class="fas fa-map-marker-alt text-pink-600 mr-3"></i>
                                    Shipping Address
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Address Line 1 -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Address Line 1 <span class="text-red-500">*</span>
                                            <span class="text-xs text-gray-500 font-normal">(House/Flat No., Street Name)</span>
                                        </label>
                                        <input type="text" name="address_line_1" value="{{ old('address_line_1', $defaultAddress->address_line_1 ?? '') }}" required
                                               placeholder="House/Flat No., Street Name"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                        @error('address_line_1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Address Line 2 -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Address Line 2
                                            <span class="text-xs text-gray-500 font-normal">(Area, Landmark)</span>
                                        </label>
                                        <input type="text" name="address_line_2" value="{{ old('address_line_2', $defaultAddress->address_line_2 ?? '') }}"
                                               placeholder="Area, Landmark"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                        @error('address_line_2')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- City -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            City <span class="text-red-500">*</span>
                                        </label>
                                        <select name="city" required
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                            <option value="">Select City</option>
                                            <option value="Karachi" {{ old('city', $defaultAddress->city ?? '') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                            <option value="Lahore" {{ old('city', $defaultAddress->city ?? '') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                            <option value="Islamabad" {{ old('city', $defaultAddress->city ?? '') == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                            <option value="Rawalpindi" {{ old('city', $defaultAddress->city ?? '') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                            <option value="Faisalabad" {{ old('city', $defaultAddress->city ?? '') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                            <option value="Multan" {{ old('city', $defaultAddress->city ?? '') == 'Multan' ? 'selected' : '' }}>Multan</option>
                                            <option value="Peshawar" {{ old('city', $defaultAddress->city ?? '') == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                            <option value="Quetta" {{ old('city', $defaultAddress->city ?? '') == 'Quetta' ? 'selected' : '' }}>Quetta</option>
                                        </select>
                                        @error('city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- State/Province -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            State/Province
                                        </label>
                                        <select name="state"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                            <option value="">Select State/Province</option>
                                            <option value="Sindh" {{ old('state', $defaultAddress->state ?? '') == 'Sindh' ? 'selected' : '' }}>Sindh</option>
                                            <option value="Punjab" {{ old('state', $defaultAddress->state ?? '') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                            <option value="KPK" {{ old('state', $defaultAddress->state ?? '') == 'KPK' ? 'selected' : '' }}>KPK</option>
                                            <option value="Balochistan" {{ old('state', $defaultAddress->state ?? '') == 'Balochistan' ? 'selected' : '' }}>Balochistan</option>
                                        </select>
                                        @error('state')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Postal Code -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Postal Code <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="postal_code" value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}" required
                                               placeholder="75500"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                        @error('postal_code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            @auth
                                @if(auth()->user()->isB2BApproved())
                                <!-- B2B Purchase Order Number -->
                                <div class="mt-8">
                                    <h3 class="text-2xl font-bold mb-6 flex items-center">
                                        <i class="fas fa-file-invoice text-purple-600 mr-3"></i>
                                        Business Order Details
                                    </h3>

                                    <div class="bg-purple-50 dark:bg-purple-900/20 border-2 border-purple-200 rounded-xl p-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <span class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold">
                                                <i class="fas fa-briefcase mr-2"></i>Business Order
                                            </span>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                Purchase Order (PO) Number
                                                <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                                            </label>
                                            <input type="text" name="purchase_order_number" value="{{ old('purchase_order_number') }}"
                                                   placeholder="e.g., PO-2024-001"
                                                   class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                                            <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Enter your company's PO number for reference on invoices and shipping documents.
                                            </p>
                                            @error('purchase_order_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endauth

                            <!-- Payment Method -->
                            <div class="mt-8">
                                <h3 class="text-2xl font-bold mb-6 flex items-center">
                                    <i class="fas fa-credit-card text-pink-600 mr-3"></i>
                                    Payment Method
                                </h3>

                                <div class="gradient-pink text-white p-6 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-money-bill-wave text-3xl"></i>
                                        <div>
                                            <p class="font-bold text-lg">Cash on Delivery</p>
                                            <p class="text-sm text-pink-100">Pay when you receive your order</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-24" data-aos="fade-left">
                            @auth
                                @if(auth()->user()->isB2BApproved())
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 rounded-xl mb-6 text-center">
                                    <i class="fas fa-briefcase text-2xl mb-2"></i>
                                    <p class="font-bold">Business Order</p>
                                    <p class="text-xs text-purple-100">Wholesale Pricing Applied</p>
                                </div>
                                @endif
                            @endauth
                            <h3 class="text-2xl font-bold mb-6">Order Summary</h3>

                            <!-- Items -->
                            <div class="space-y-4 mb-6">
                                @foreach($cart->items as $item)
                                <div class="flex gap-3">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->product->primaryImage)
                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                             class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-sm">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                        <p class="text-sm font-bold text-pink-600">Rs {{ number_format($item->subtotal, 0) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Coupon Section -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <div id="coupon-form" class="{{ $cart->coupon_code ? 'hidden' : '' }}">
                                    <label class="block text-sm font-semibold mb-2">Have a coupon?</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="coupon-code-input" placeholder="Enter coupon code"
                                               class="flex-1 px-4 py-2 border-2 rounded-xl focus:border-pink-500 uppercase">
                                        <button type="button" onclick="applyCoupon()"
                                                class="gradient-pink text-white px-6 py-2 rounded-xl font-bold hover-lift">
                                            Apply
                                        </button>
                                    </div>
                                    <p id="coupon-error" class="text-red-600 text-sm mt-2 hidden"></p>
                                </div>

                                <div id="coupon-applied" class="{{ $cart->coupon_code ? '' : 'hidden' }} bg-green-50 p-4 rounded-xl">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-green-800"><i class="fas fa-tag mr-2"></i>Coupon Applied</p>
                                            <p class="text-sm text-green-600">Code: <span id="applied-coupon-code" class="font-mono font-bold">{{ $cart->coupon_code }}</span></p>
                                        </div>
                                        <button type="button" onclick="removeCoupon()" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="border-t border-gray-200 pt-6 space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-semibold">Rs <span id="subtotal">{{ number_format($cart->total, 0) }}</span></span>
                                </div>
                                @if($cart->discount_amount > 0)
                                <div id="discount-row" class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span class="font-semibold">- Rs <span id="discount-amount">{{ number_format($cart->discount_amount, 0) }}</span></span>
                                </div>
                                @else
                                <div id="discount-row" class="hidden flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span class="font-semibold">- Rs <span id="discount-amount">0</span></span>
                                </div>
                                @endif
                                <div class="flex justify-between text-gray-600">
                                    <span>Delivery</span>
                                    <span class="font-semibold text-green-600">FREE</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between text-2xl font-bold">
                                    <span>Total</span>
                                    <span class="text-pink-600">Rs <span id="final-total">{{ number_format($cart->final_total, 0) }}</span></span>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full mt-8 gradient-purple text-white py-4 rounded-xl font-bold hover:shadow-2xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                Place Order
                            </button>

                            <div class="mt-6 p-4 bg-green-50 rounded-xl text-center">
                                <i class="fas fa-shield-alt text-green-600 text-2xl mb-2"></i>
                                <p class="text-sm text-green-800 font-semibold">Safe & Secure Checkout</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function applyCoupon() {
            const code = document.getElementById('coupon-code-input').value.trim();
            const errorEl = document.getElementById('coupon-error');

            if (!code) {
                errorEl.textContent = 'Please enter a coupon code';
                errorEl.classList.remove('hidden');
                return;
            }

            errorEl.classList.add('hidden');

            fetch('{{ route("checkout.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coupon_code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show applied coupon
                    document.getElementById('coupon-form').classList.add('hidden');
                    document.getElementById('coupon-applied').classList.remove('hidden');
                    document.getElementById('applied-coupon-code').textContent = code.toUpperCase();

                    // Update totals
                    document.getElementById('discount-amount').textContent = formatNumber(data.discount);
                    document.getElementById('discount-row').classList.remove('hidden');
                    document.getElementById('final-total').textContent = formatNumber(data.final_total);

                    // Show success message
                    showNotification(data.message, 'success');
                } else {
                    errorEl.textContent = data.message;
                    errorEl.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorEl.textContent = 'Failed to apply coupon';
                errorEl.classList.remove('hidden');
            });
        }

        function removeCoupon() {
            fetch('{{ route("checkout.remove-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide applied coupon
                    document.getElementById('coupon-form').classList.remove('hidden');
                    document.getElementById('coupon-applied').classList.add('hidden');
                    document.getElementById('coupon-code-input').value = '';

                    // Reset totals
                    const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace(/,/g, ''));
                    document.getElementById('discount-row').classList.add('hidden');
                    document.getElementById('final-total').textContent = formatNumber(subtotal);

                    showNotification(data.message, 'info');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function showNotification(message, type) {
            // Simple notification - you can enhance this
            alert(message);
        }
    </script>
    @endpush
</x-frontend-layout>

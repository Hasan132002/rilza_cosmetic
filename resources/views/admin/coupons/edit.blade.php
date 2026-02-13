<x-admin-layout>
    <x-slot name="header">Edit Coupon</x-slot>

    <div class="max-w-4xl">
        <div class="mb-6"><a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-gray-900"><i class="fas fa-arrow-left mr-2"></i>Back</a></div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Coupon Code</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Type</label>
                        <select name="type" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="flat" {{ $coupon->type == 'flat' ? 'selected' : '' }}>Flat Amount</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Value</label>
                        <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Min Order Amount</label>
                        <input type="number" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" step="0.01" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Max Discount</label>
                        <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" step="0.01" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Usage Limit</label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        <p class="text-xs text-gray-500 mt-1">Used: {{ $coupon->used_count }} times</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Valid From</label>
                        <input type="datetime-local" name="valid_from" value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Valid Until</label>
                        <input type="datetime-local" name="valid_until" value="{{ old('valid_until', $coupon->valid_until?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600">
                            <span class="ml-2 text-sm font-semibold">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 border rounded-xl">Cancel</a>
                    <button type="submit" class="gradient-pink text-white px-8 py-3 rounded-xl font-bold hover-lift"><i class="fas fa-save mr-2"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">Create Coupon</x-slot>

    <div class="max-w-4xl">
        <div class="mb-6"><a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-gray-900"><i class="fas fa-arrow-left mr-2"></i>Back</a></div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Coupon Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        @error('code')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                            <option value="percentage">Percentage</option>
                            <option value="flat">Flat Amount</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Value <span class="text-red-500">*</span></label>
                        <input type="number" name="value" value="{{ old('value') }}" step="0.01" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Min Order Amount</label>
                        <input type="number" name="min_order_amount" value="{{ old('min_order_amount') }}" step="0.01" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Max Discount Amount</label>
                        <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount') }}" step="0.01" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Usage Limit</label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Valid From</label>
                        <input type="datetime-local" name="valid_from" value="{{ old('valid_from') }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Valid Until</label>
                        <input type="datetime-local" name="valid_until" value="{{ old('valid_until') }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                    </div>

                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-pink-600">
                            <span class="ml-2 text-sm font-semibold">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 border rounded-xl">Cancel</a>
                    <button type="submit" class="gradient-pink text-white px-8 py-3 rounded-xl font-bold hover-lift"><i class="fas fa-save mr-2"></i>Create</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

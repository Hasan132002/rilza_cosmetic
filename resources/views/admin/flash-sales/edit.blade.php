<x-admin-layout>
    <x-slot name="header">
        Edit Flash Sale
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Edit Flash Sale</h3>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('admin.flash-sales.update', $flashSale) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Flash Sale Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $flashSale->title) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                           placeholder="e.g., Weekend Mega Sale">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Percentage -->
                <div class="mb-6">
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Discount Percentage (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="discount_percentage"
                           id="discount_percentage"
                           value="{{ old('discount_percentage', $flashSale->discount_percentage) }}"
                           min="1"
                           max="99"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                    @error('discount_percentage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Start Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               name="starts_at"
                               id="starts_at"
                               value="{{ old('starts_at', $flashSale->starts_at->format('Y-m-d\TH:i')) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('starts_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            End Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               name="ends_at"
                               id="ends_at"
                               value="{{ old('ends_at', $flashSale->ends_at->format('Y-m-d\TH:i')) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('ends_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Products Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Select Products <span class="text-red-500">*</span>
                    </label>
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 max-h-96 overflow-y-auto dark:bg-gray-700">
                        @php
                            $selectedProducts = old('products', $flashSale->products->pluck('id')->toArray());
                        @endphp
                        @forelse($products as $product)
                            <div class="flex items-center mb-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-600 rounded">
                                <input type="checkbox"
                                       name="products[]"
                                       value="{{ $product->id }}"
                                       id="product_{{ $product->id }}"
                                       {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}
                                       class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <label for="product_{{ $product->id }}" class="ml-3 flex-1 cursor-pointer">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                        (PKR {{ number_format($product->base_price, 2) }})
                                    </span>
                                </label>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No products available</p>
                        @endforelse
                    </div>
                    @error('products')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $flashSale->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Make this flash sale active
                        </span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.flash-sales.index') }}"
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all">
                        Update Flash Sale
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

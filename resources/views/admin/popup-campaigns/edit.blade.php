<x-admin-layout>
    <x-slot name="header">
        Edit Popup Campaign
    </x-slot>

    <div class="max-w-4xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.popup-campaigns.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Popup Campaigns</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.popup-campaigns.update', $popup) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Campaign Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $popup->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200"
                               placeholder="e.g., Summer Sale Popup">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Internal name for identifying this campaign</p>
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                            <option value="discount" {{ old('type', $popup->type) == 'discount' ? 'selected' : '' }}>Discount</option>
                            <option value="newsletter" {{ old('type', $popup->type) == 'newsletter' ? 'selected' : '' }}>Newsletter</option>
                            <option value="exit_intent" {{ old('type', $popup->type) == 'exit_intent' ? 'selected' : '' }}>Exit Intent</option>
                            <option value="announcement" {{ old('type', $popup->type) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                        </select>
                        @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display Frequency -->
                    <div>
                        <label for="display_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Frequency (hours)
                        </label>
                        <input type="number" name="display_frequency" id="display_frequency" value="{{ old('display_frequency', $popup->display_frequency) }}" min="1"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        @error('display_frequency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">How often to show popup to same user</p>
                    </div>

                    <!-- Title -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Popup Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $popup->title) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200"
                               placeholder="e.g., Get 20% Off Your First Order!">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200"
                                  placeholder="Enter the popup message here...">{{ old('description', $popup->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Button Text
                        </label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $popup->button_text) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        @error('button_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button Link -->
                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Button Link
                        </label>
                        <input type="url" name="button_link" id="button_link" value="{{ old('button_link', $popup->button_link) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200"
                               placeholder="https://...">
                        @error('button_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Coupon Code -->
                    <div>
                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Coupon Code
                        </label>
                        <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $popup->coupon_code) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200"
                               placeholder="e.g., SAVE20">
                        @error('coupon_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Delay Seconds -->
                    <div>
                        <label for="delay_seconds" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Delay (seconds)
                        </label>
                        <input type="number" name="delay_seconds" id="delay_seconds" value="{{ old('delay_seconds', $popup->delay_seconds) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        @error('delay_seconds')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Time before showing popup</p>
                    </div>

                    <!-- Current Image -->
                    @if($popup->image)
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Current Image
                        </label>
                        <img src="{{ asset('storage/' . $popup->image) }}" alt="{{ $popup->name }}" class="w-48 h-48 object-cover rounded-lg shadow-md">
                    </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ $popup->image ? 'Change Image' : 'Upload Image' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Optional image for popup (Max 2MB - JPG, PNG, WebP)</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkboxes -->
                    <div class="col-span-2 border-t border-gray-200 dark:border-gray-700 pt-6 mt-2">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Display Options</h4>
                    </div>

                    <div class="col-span-2 space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_exit" value="1" {{ old('show_on_exit', $popup->show_on_exit) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Show on Exit Intent</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $popup->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.popup-campaigns.index') }}"
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all">
                        <i class="fas fa-save mr-2"></i>Update Popup Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

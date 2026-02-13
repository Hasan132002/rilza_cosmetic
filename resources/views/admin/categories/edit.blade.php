<x-admin-layout>
    <x-slot name="header">
        Edit Category
    </x-slot>

    <div class="max-w-4xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Categories</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Parent Category
                        </label>
                        <select name="parent_id" id="parent_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                            <option value="">None (Main Category)</option>
                            @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <!-- Current Image -->
                    @if($category->image)
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Current Image
                        </label>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category Image {{ $category->image ? '(Upload new to replace)' : '' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max size: 2MB</p>
                    </div>

                    <!-- SEO Section -->
                    <div class="col-span-2 border-t border-gray-200 dark:border-gray-700 pt-6 mt-2">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">SEO Settings</h4>
                    </div>

                    <!-- Meta Title -->
                    <div class="col-span-2">
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Title
                        </label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $category->meta_title) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Meta Description -->
                    <div class="col-span-2">
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Description
                        </label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

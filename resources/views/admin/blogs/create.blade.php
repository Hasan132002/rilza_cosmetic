<x-admin-layout>
    <x-slot name="header">
        Create Blog Post
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Create New Blog Post</h3>
            <a href="{{ route('admin.blogs.index') }}"
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <i class="fas fa-arrow-left mr-2"></i>Back to Blog Posts
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug <span class="text-gray-500 text-xs">(Optional - auto-generated from title)</span>
                        </label>
                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Excerpt
                        </label>
                        <textarea name="excerpt"
                                  id="excerpt"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">{{ old('excerpt') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Short description displayed in blog listings</p>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content"
                                  id="content"
                                  rows="15"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Featured Image
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                <span class="text-sm">Choose Image</span>
                                <input type="file"
                                       name="featured_image"
                                       id="featured_image"
                                       accept="image/*"
                                       class="hidden"
                                       onchange="previewImage(this)">
                            </label>
                            <span id="file-name" class="text-sm text-gray-500">No file chosen</span>
                        </div>
                        <div id="image-preview" class="mt-4 hidden">
                            <img src="" alt="Preview" class="w-full max-w-md rounded-lg shadow">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Recommended size: 1200x600px. Max size: 2MB</p>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publishing Options -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Publishing Options</h4>

                        <div class="space-y-4">
                            <!-- Published Toggle -->
                            <div class="flex items-center">
                                <input type="checkbox"
                                       name="is_published"
                                       id="is_published"
                                       value="1"
                                       {{ old('is_published') ? 'checked' : '' }}
                                       class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <label for="is_published" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Publish this post immediately
                                </label>
                            </div>

                            <!-- Published Date -->
                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Published Date <span class="text-gray-500 text-xs">(Optional - defaults to now)</span>
                                </label>
                                <input type="datetime-local"
                                       name="published_at"
                                       id="published_at"
                                       value="{{ old('published_at') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                @error('published_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SEO Meta -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO Meta</h4>

                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title
                                </label>
                                <input type="text"
                                       name="meta_title"
                                       id="meta_title"
                                       value="{{ old('meta_title') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Description
                                </label>
                                <textarea name="meta_description"
                                          id="meta_description"
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <a href="{{ route('admin.blogs.index') }}"
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Create Post</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input) {
            const fileName = input.files[0]?.name || 'No file chosen';
            document.getElementById('file-name').textContent = fileName;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-admin-layout>

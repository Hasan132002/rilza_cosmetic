<x-admin-layout>
    <x-slot name="header">Edit Banner</x-slot>

    <div class="max-w-4xl">
        <div class="mb-6"><a href="{{ route('admin.banners.index') }}" class="text-gray-600 hover:text-gray-900"><i class="fas fa-arrow-left mr-2"></i>Back</a></div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">{{ old('description', $banner->description) }}</textarea>
                        @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Banner Image</label>

                        <!-- Current Image -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-48 object-cover rounded-xl shadow-lg">
                        </div>

                        <!-- Replace Image -->
                        <input type="file" name="image" id="imageInput" accept="image/*" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i>Leave empty to keep current image. Recommended size: 1920x600px</p>
                        @error('image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror

                        <!-- New Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-semibold mb-2">New Image Preview:</p>
                            <img id="previewImg" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-xl shadow-lg">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Button Text</label>
                        <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        @error('button_text')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Button Link</label>
                        <input type="url" name="button_link" value="{{ old('button_link', $banner->button_link) }}" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        @error('button_link')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold mb-2">Display Order <span class="text-red-500">*</span></label>
                        <input type="number" name="display_order" value="{{ old('display_order', $banner->display_order) }}" required min="0" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-sort mr-1"></i>Lower numbers appear first</p>
                        @error('display_order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600">
                            <span class="ml-2 text-sm font-semibold">Active (Show on homepage)</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.banners.index') }}" class="px-6 py-3 border rounded-xl">Cancel</a>
                    <button type="submit" class="gradient-pink text-white px-8 py-3 rounded-xl font-bold hover-lift"><i class="fas fa-save mr-2"></i>Update Banner</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image Preview
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-admin-layout>

<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.translations.index') }}" class="text-gray-600 hover:text-pink-600 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Translation
                </h1>
            </div>
            <p class="text-gray-600">Create a new translation key for both English and Urdu</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.translations.store') }}" method="POST">
                @csrf

                <!-- Group & Key Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Group -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-layer-group mr-1 text-purple-600"></i>Translation Group
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="group" value="{{ old('group') }}" list="existing-groups" placeholder="e.g., messages, frontend, validation" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('group') border-red-500 @enderror">
                        <datalist id="existing-groups">
                            @foreach($groups as $group)
                                <option value="{{ $group }}">
                            @endforeach
                        </datalist>
                        @error('group')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Group name for organizing translations (e.g., messages, frontend)</p>
                    </div>

                    <!-- Key -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-purple-600"></i>Translation Key
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="key" value="{{ old('key') }}" placeholder="e.g., welcome_message, add_to_cart" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('key') border-red-500 @enderror">
                        @error('key')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Unique identifier for this translation (use snake_case)</p>
                    </div>
                </div>

                <!-- English Translation -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-flag-usa mr-1 text-blue-600"></i>English Translation
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="value_en" rows="4" placeholder="Enter English translation..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('value_en') border-red-500 @enderror">{{ old('value_en') }}</textarea>
                    @error('value_en')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">The English version of this translation</p>
                </div>

                <!-- Urdu Translation -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-flag mr-1 text-green-600"></i>Urdu Translation (اردو ترجمہ)
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="value_ur" rows="4" dir="rtl" placeholder="اردو ترجمہ درج کریں..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('value_ur') border-red-500 @enderror">{{ old('value_ur') }}</textarea>
                    @error('value_ur')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">اس ترجمے کا اردو ورژن</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.translations.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-semibold">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 gradient-pink text-white rounded-lg hover:shadow-xl transition-all transform hover:scale-105 font-semibold">
                        <i class="fas fa-save mr-2"></i>Create Translation
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Translation Guidelines
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Use descriptive keys</p>
                        <p class="text-sm text-gray-600">Example: welcome_message, add_to_cart_button</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Organize by groups</p>
                        <p class="text-sm text-gray-600">frontend, messages, validation, emails, etc.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Keep translations consistent</p>
                        <p class="text-sm text-gray-600">Use similar tone and style across all translations</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Test thoroughly</p>
                        <p class="text-sm text-gray-600">Check both English and Urdu versions on frontend</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

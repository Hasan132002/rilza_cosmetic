<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.translations.index') }}" class="text-gray-600 hover:text-pink-600 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                    <i class="fas fa-edit mr-2"></i>Edit Translation
                </h1>
            </div>
            <p class="text-gray-600">Update translation for both English and Urdu</p>
        </div>

        <!-- Current Translation Info -->
        <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm font-semibold text-gray-600">Group</p>
                    <p class="text-lg font-bold text-purple-800">{{ $translation->group }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600">Key</p>
                    <p class="text-lg font-bold text-purple-800 font-mono">{{ $translation->key }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600">Last Updated</p>
                    <p class="text-lg font-bold text-purple-800">{{ $translation->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.translations.update', $translation) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Group & Key Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Group -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-layer-group mr-1 text-purple-600"></i>Translation Group
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="group" value="{{ old('group', $translation->group) }}" list="existing-groups" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('group') border-red-500 @enderror">
                        <datalist id="existing-groups">
                            @foreach($groups as $group)
                                <option value="{{ $group }}">
                            @endforeach
                        </datalist>
                        @error('group')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Group name for organizing translations</p>
                    </div>

                    <!-- Key -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-purple-600"></i>Translation Key
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="key" value="{{ old('key', $translation->key) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('key') border-red-500 @enderror">
                        @error('key')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Unique identifier for this translation</p>
                    </div>
                </div>

                <!-- English Translation -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-flag-usa mr-1 text-blue-600"></i>English Translation
                        <span class="text-red-500">*</span>
                    </label>
                    @php
                        $enValue = old('value_en');
                        if (!$enValue) {
                            if ($translation->locale === 'en') {
                                $enValue = $translation->value;
                            } elseif ($pairedTranslation) {
                                $enValue = $pairedTranslation->value;
                            }
                        }
                    @endphp
                    <textarea name="value_en" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('value_en') border-red-500 @enderror">{{ $enValue }}</textarea>
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
                    @php
                        $urValue = old('value_ur');
                        if (!$urValue) {
                            if ($translation->locale === 'ur') {
                                $urValue = $translation->value;
                            } elseif ($pairedTranslation) {
                                $urValue = $pairedTranslation->value;
                            }
                        }
                    @endphp
                    <textarea name="value_ur" rows="4" dir="rtl" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500 @error('value_ur') border-red-500 @enderror">{{ $urValue }}</textarea>
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
                        <i class="fas fa-save mr-2"></i>Update Translation
                    </button>
                </div>
            </form>
        </div>

        <!-- Usage Example -->
        <div class="mt-6 bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-code mr-2 text-blue-600"></i>Usage in Blade Templates
            </h3>
            <div class="bg-gray-900 rounded-lg p-4 font-mono text-sm text-green-400">
                <code>{{ "{{ __('$translation->group.$translation->key') }}" }}</code>
            </div>
            <p class="text-gray-600 text-sm mt-3">
                <i class="fas fa-info-circle mr-1"></i>
                Use this code in your blade templates to display this translation. It will automatically show the correct language based on user preferences.
            </p>
        </div>
    </div>
</x-admin-layout>

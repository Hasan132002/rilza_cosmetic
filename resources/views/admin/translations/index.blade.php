<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                    <i class="fas fa-language mr-2"></i>Translation Management
                </h1>
                <p class="text-gray-600 mt-1">Manage translations for English and Urdu languages</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-2">
                <form action="{{ route('admin.translations.import') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-file-import mr-2"></i>Import from Files
                    </button>
                </form>
                <form action="{{ route('admin.translations.sync') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-sync mr-2"></i>Sync to Files
                    </button>
                </form>
                <a href="{{ route('admin.translations.create') }}" class="px-6 py-2 gradient-pink text-white rounded-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>Add Translation
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 animate-slide-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate-slide-in">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" action="{{ route('admin.translations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Search
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search key or value..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Locale Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-globe mr-1"></i>Locale
                    </label>
                    <select name="locale" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="">All Locales</option>
                        <option value="en" {{ request('locale') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ur" {{ request('locale') == 'ur' ? 'selected' : '' }}>Urdu</option>
                    </select>
                </div>

                <!-- Group Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-layer-group mr-1"></i>Group
                    </label>
                    <select name="group" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="">All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 gradient-pink text-white rounded-lg hover:shadow-xl transition-all">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.translations.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Translations Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="gradient-pink text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Group</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Key</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Locale</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Value</th>
                            <th class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($translations as $translation)
                            <tr class="hover:bg-pink-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                        {{ $translation->group }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono text-sm text-gray-900">{{ $translation->key }}</td>
                                <td class="px-6 py-4">
                                    @if($translation->locale == 'en')
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-flag-usa mr-1"></i>EN
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-flag mr-1"></i>UR
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700 max-w-md truncate" dir="{{ $translation->locale == 'ur' ? 'rtl' : 'ltr' }}">
                                    {{ Str::limit($translation->value, 100) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.translations.edit', $translation) }}" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all transform hover:scale-105" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.translations.destroy', $translation) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this translation? Both English and Urdu versions will be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all transform hover:scale-105" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-language text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg font-medium">No translations found</p>
                                        <p class="text-gray-400 text-sm mt-2">Try adjusting your filters or add a new translation</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($translations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $translations->links() }}
                </div>
            @endif
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Translations</p>
                        <p class="text-3xl font-bold mt-1">{{ \App\Models\Translation::count() }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-language text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Translation Groups</p>
                        <p class="text-3xl font-bold mt-1">{{ \App\Models\Translation::distinct('group')->count('group') }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-layer-group text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-sm font-medium">Unique Keys</p>
                        <p class="text-3xl font-bold mt-1">{{ \App\Models\Translation::distinct('key', 'group')->count() }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-key text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

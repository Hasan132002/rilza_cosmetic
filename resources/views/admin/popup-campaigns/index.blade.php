<x-admin-layout>
    <x-slot name="header">
        Popup Campaigns
    </x-slot>

    <!-- Header with Add Button & Stats -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">All Popup Campaigns</h3>
            @can('create_popup_campaigns')
            <a href="{{ route('admin.popup-campaigns.create') }}"
               class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 shadow-md transition-all">
                <i class="fas fa-plus-circle"></i>
                <span>Add New Popup</span>
            </a>
            @endcan
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Popups</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $popups->total() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-window-restore text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Active</p>
                        <p class="text-2xl font-bold text-green-600">{{ $activeCount ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Discount</p>
                        <p class="text-2xl font-bold text-pink-600">{{ $discountCount ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-percentage text-pink-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Newsletter</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $newsletterCount ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.popup-campaigns.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name or title..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
            </div>
            <div>
                <select name="type" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                    <option value="">All Types</option>
                    <option value="discount" {{ request('type') == 'discount' ? 'selected' : '' }}>Discount</option>
                    <option value="newsletter" {{ request('type') == 'newsletter' ? 'selected' : '' }}>Newsletter</option>
                    <option value="exit_intent" {{ request('type') == 'exit_intent' ? 'selected' : '' }}>Exit Intent</option>
                    <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all">
                    <i class="fas fa-search mr-1"></i>
                    Search
                </button>
                @if(request('search') || request('type'))
                <a href="{{ route('admin.popup-campaigns.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Popup Campaigns Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Coupon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Delay</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($popups as $popup)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $popup->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($popup->image)
                        <img src="{{ asset('storage/' . $popup->image) }}" alt="{{ $popup->name }}" class="h-12 w-12 rounded object-cover">
                        @else
                        <div class="h-12 w-12 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $popup->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                        $typeColors = [
                            'discount' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                            'newsletter' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'exit_intent' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                            'announcement' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeColors[$popup->type] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $popup->type)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ Str::limit($popup->title, 30) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($popup->coupon_code)
                        <span class="font-mono text-xs font-bold text-pink-600 bg-pink-50 dark:bg-pink-900/20 px-2 py-1 rounded">{{ $popup->coupon_code }}</span>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $popup->delay_seconds }}s
                        @if($popup->show_on_exit)
                        <span class="ml-1 text-xs text-purple-600">+ Exit</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($popup->is_active)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Active
                        </span>
                        @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        @can('edit_popup_campaigns')
                        <a href="{{ route('admin.popup-campaigns.edit', $popup) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete_popup_campaigns')
                        <form action="{{ route('admin.popup-campaigns.destroy', $popup) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this popup campaign?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-window-restore text-6xl mb-4"></i>
                            <p class="text-lg font-medium">No popup campaigns found</p>
                            <p class="text-sm mt-1">Get started by creating your first popup campaign</p>
                            @can('create_popup_campaigns')
                            <a href="{{ route('admin.popup-campaigns.create') }}" class="mt-4 bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg">
                                Create Popup Campaign
                            </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($popups->hasPages())
    <div class="mt-6">
        {{ $popups->links() }}
    </div>
    @endif
</x-admin-layout>

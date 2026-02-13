<x-admin-layout>
    <x-slot name="header">
        Abandoned Carts
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Abandoned</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalAbandoned ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Value</p>
                    <p class="text-3xl font-bold text-purple-600">Rs {{ number_format($totalValue ?? 0, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Reminders Sent</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $remindersSent ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Avg Cart Value</p>
                    <p class="text-3xl font-bold text-pink-600">Rs {{ number_format($avgCartValue ?? 0, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-pink-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.abandoned-carts.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by email or session ID..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
            </div>
            <div>
                <select name="reminder_status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200">
                    <option value="">All Status</option>
                    <option value="sent" {{ request('reminder_status') == 'sent' ? 'selected' : '' }}>Reminder Sent</option>
                    <option value="pending" {{ request('reminder_status') == 'pending' ? 'selected' : '' }}>Reminder Pending</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all">
                    <i class="fas fa-search mr-1"></i>
                    Search
                </button>
                @if(request('search') || request('reminder_status'))
                <a href="{{ route('admin.abandoned-carts.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Abandoned Carts Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden" data-aos="fade-up">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cart Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Abandoned At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reminder</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($abandonedCarts as $cart)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        #{{ $cart->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($cart->user)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($cart->user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $cart->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">User #{{ $cart->user_id }}</p>
                            </div>
                        </div>
                        @else
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-user-slash mr-1"></i>Guest
                            <p class="text-xs">{{ Str::limit($cart->session_id, 20) }}</p>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($cart->email)
                        <a href="mailto:{{ $cart->email }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            <i class="fas fa-envelope mr-1"></i>{{ $cart->email }}
                        </a>
                        @else
                        <span class="text-sm text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                        @if($cart->cart_data && is_array($cart->cart_data))
                        <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200 rounded-full text-xs font-semibold">
                            {{ count($cart->cart_data) }} items
                        </span>
                        @else
                        <span class="text-gray-400">0 items</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                        Rs {{ number_format($cart->total_amount ?? 0, 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>{{ $cart->abandoned_at ? $cart->abandoned_at->diffForHumans() : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($cart->reminder_sent)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-check-circle mr-1"></i>Sent
                        </span>
                        @if($cart->reminder_sent_at)
                        <p class="text-xs text-gray-500 mt-1">{{ $cart->reminder_sent_at->format('M d, Y') }}</p>
                        @endif
                        @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.abandoned-carts.show', $cart) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-shopping-cart text-6xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium">No abandoned carts found</p>
                            <p class="text-sm mt-1">All carts have been completed or no abandonments yet</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($abandonedCarts->hasPages())
    <div class="mt-6">
        {{ $abandonedCarts->links() }}
    </div>
    @endif
</x-admin-layout>

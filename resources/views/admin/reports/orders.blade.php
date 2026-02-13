<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Order Report</h1>
                <p class="text-gray-600 mt-1">View and export order data</p>
            </div>
            <a href="{{ route('admin.reports.export.orders', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-file-excel mr-2"></i> Export to Excel
            </a>
        </div>

        <!-- Status Summary -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            @foreach(['pending' => 'text-yellow-600', 'processing' => 'text-blue-600', 'shipped' => 'text-purple-600', 'delivered' => 'text-green-600', 'cancelled' => 'text-red-600'] as $status => $color)
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-500 text-sm">{{ ucfirst($status) }}</p>
                    <h3 class="text-xl font-bold {{ $color }} mt-1">
                        {{ $statusCounts->get($status)?->count ?? 0 }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        PKR {{ number_format($statusCounts->get($status)?->total ?? 0, 0) }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.reports.orders') }}" class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-md">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-pink-600 hover:text-pink-800 font-medium">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->items->count() }} items
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    PKR {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($order->order_status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->order_status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->order_status == 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->order_status == 'delivered') bg-green-100 text-green-800
                                        @elseif($order->order_status == 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

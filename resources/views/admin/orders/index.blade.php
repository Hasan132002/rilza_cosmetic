<x-admin-layout>
    <x-slot name="header">
        Orders Management
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $orders->total() }}</p>
                </div>
                <div class="w-14 h-14 gradient-blue rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-shopping-bag text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600">0</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Shipped</p>
                    <p class="text-3xl font-bold text-blue-600">0</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-truck text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Delivered</p>
                    <p class="text-3xl font-bold text-green-600">0</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold">All Orders</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Order #</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Items</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-pink-600">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold">{{ $order->customer_name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->customer_email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900">{{ $order->items->count() }} items</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-lg">Rs {{ number_format($order->total_amount, 0) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'packed' => 'bg-purple-100 text-purple-800',
                                'shipped' => 'bg-indigo-100 text-indigo-800',
                                'out_for_delivery' => 'bg-cyan-100 text-cyan-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-pink-600 hover:text-pink-800 font-semibold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-xl font-semibold text-gray-500">No orders yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="p-6 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>

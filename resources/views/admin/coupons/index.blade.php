<x-admin-layout>
    <x-slot name="header">Coupons</x-slot>

    <div class="flex justify-between mb-6" data-aos="fade-down">
        <h3 class="text-2xl font-bold">Manage Coupons</h3>
        <a href="{{ route('admin.coupons.create') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-bold hover-lift">
            <i class="fas fa-plus-circle mr-2"></i>Create Coupon
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6" data-aos="fade-in">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Code</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Value</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Usage</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Valid Until</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><span class="font-mono font-bold text-pink-600">{{ $coupon->code }}</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">{{ ucfirst($coupon->type) }}</span></td>
                    <td class="px-6 py-4 font-semibold">{{ $coupon->type == 'percentage' ? $coupon->value . '%' : 'Rs ' . number_format($coupon->value, 0) }}</td>
                    <td class="px-6 py-4">{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $coupon->valid_until ? $coupon->valid_until->format('M d, Y') : 'No expiry' }}</td>
                    <td class="px-6 py-4">
                        @if($coupon->is_active)
                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                        @else
                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-16 text-center text-gray-500">No coupons yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($coupons->hasPages())
    <div class="mt-6">{{ $coupons->links() }}</div>
    @endif
</x-admin-layout>

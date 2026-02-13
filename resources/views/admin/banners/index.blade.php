<x-admin-layout>
    <x-slot name="header">Banners</x-slot>

    <div class="flex justify-between mb-6" data-aos="fade-down">
        <h3 class="text-2xl font-bold">Manage Banners</h3>
        <a href="{{ route('admin.banners.create') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-bold hover-lift">
            <i class="fas fa-plus-circle mr-2"></i>Create Banner
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
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Image</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Button Text</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Display Order</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="h-16 w-24 object-cover rounded-lg shadow-sm">
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $banner->title }}</span>
                        @if($banner->description)
                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($banner->description, 50) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($banner->button_text)
                        <span class="text-sm text-gray-700">{{ $banner->button_text }}</span>
                        @else
                        <span class="text-xs text-gray-400 italic">No button</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800 font-semibold">{{ $banner->display_order }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($banner->is_active)
                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                        @else
                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Delete this banner?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-16 text-center text-gray-500">No banners yet. Create your first banner to get started!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($banners->hasPages())
    <div class="mt-6">{{ $banners->links() }}</div>
    @endif
</x-admin-layout>

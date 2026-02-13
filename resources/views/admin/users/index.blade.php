<x-admin-layout>
    <x-slot name="header">User Management</x-slot>

    <div class="space-y-6">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl shadow-md" data-aos="fade-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl shadow-md" data-aos="fade-down">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Filters & Actions -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form method="GET" class="flex flex-col md:flex-row gap-4 flex-1">
                    <!-- Search -->
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <select name="role" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>

                    @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="gradient-purple text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all text-center">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                    @endif
                </form>

                <a href="{{ route('admin.users.create') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover-lift text-center">
                    <i class="fas fa-plus-circle mr-2"></i>Add New User
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="gradient-pink text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">ID</th>
                            <th class="px-6 py-4 text-left font-semibold">Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Email</th>
                            <th class="px-6 py-4 text-left font-semibold">Role</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Created At</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-pink-50 transition-all">
                            <td class="px-6 py-4 text-gray-900 font-medium">#{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 gradient-pink rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                    @if($role->name === 'super_admin') bg-purple-100 text-purple-800
                                    @elseif($role->name === 'admin') bg-pink-100 text-pink-800
                                    @elseif($role->name === 'staff') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active ?? true)
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                                @else
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg">No users found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>

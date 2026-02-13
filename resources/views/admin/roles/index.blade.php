<x-admin-layout>
    <x-slot name="header">Roles & Permissions</x-slot>

    <div class="space-y-6">
        <!-- Success/Error Messages -->
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

        <!-- Header Actions -->
        <div class="flex justify-end" data-aos="fade-up">
            <a href="{{ route('admin.roles.create') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover-lift">
                <i class="fas fa-plus-circle mr-2"></i>Create New Role
            </a>
        </div>

        <!-- Roles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($roles as $role)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover-lift" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="gradient-pink p-6">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <i class="fas fa-shield-alt text-3xl mb-2"></i>
                            <h3 class="text-xl font-bold capitalize">{{ str_replace('_', ' ', $role->name) }}</h3>
                        </div>
                        @if($role->name === 'super_admin')
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-crown mr-1"></i>System
                        </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-pink-50 rounded-xl p-4 text-center">
                            <div class="text-3xl font-bold text-pink-600">{{ $role->permissions_count }}</div>
                            <div class="text-sm text-gray-600 mt-1">Permissions</div>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $role->users_count }}</div>
                            <div class="text-sm text-gray-600 mt-1">Users</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-all">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        @if($role->name !== 'super_admin')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                              onsubmit="return confirm('Are you sure? This will affect {{ $role->users_count }} user(s).')"
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-admin-layout>

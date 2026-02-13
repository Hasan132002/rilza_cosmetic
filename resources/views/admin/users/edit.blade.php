<x-admin-layout>
    <x-slot name="header">Edit User</x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-up">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-pink-600 mr-2"></i>Full Name
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-pink-600 mr-2"></i>Email Address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pink-600 mr-2"></i>Password (Leave blank to keep current)
                    </label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pink-600 mr-2"></i>Confirm Password
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-shield-alt text-pink-600 mr-2"></i>Role
                    </label>
                    <select id="role" name="role" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all @error('role') border-red-500 @enderror">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on text-pink-600 mr-2"></i>Status
                    </label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active ?? 1) == '1' ? 'checked' : '' }}
                                   class="w-5 h-5 text-pink-600 focus:ring-pink-500">
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', $user->is_active ?? 1) == '0' ? 'checked' : '' }}
                                   class="w-5 h-5 text-pink-600 focus:ring-pink-500">
                            <span class="ml-2 text-gray-700">Inactive</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Permissions (Optional) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-key text-pink-600 mr-2"></i>Additional Permissions (Optional)
                    </label>
                    <p class="text-sm text-gray-600 mb-3">Select specific permissions in addition to role permissions</p>
                    <div class="grid grid-cols-2 gap-4 max-h-60 overflow-y-auto border border-gray-200 rounded-xl p-4">
                        @foreach($permissions as $module => $perms)
                            <div class="col-span-2">
                                <h4 class="font-semibold text-gray-800 text-sm uppercase mb-2 border-b pb-1">{{ ucfirst($module) }}</h4>
                            </div>
                            @foreach($perms as $permission)
                                <label class="flex items-center cursor-pointer hover:bg-pink-50 p-2 rounded-lg transition-colors">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           {{ in_array($permission->name, old('permissions', $userPermissions)) ? 'checked' : '' }}
                                           class="w-4 h-4 text-pink-600 focus:ring-pink-500 rounded">
                                    <span class="ml-2 text-sm text-gray-700">{{ str_replace('_', ' ', $permission->name) }}</span>
                                </label>
                            @endforeach
                        @endforeach
                    </div>
                    @error('permissions')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover-lift">
                        <i class="fas fa-save mr-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

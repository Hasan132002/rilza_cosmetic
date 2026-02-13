<x-admin-layout>
    <x-slot name="header">Create New Role</x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-up">
            <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6">
                @csrf

                <!-- Role Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-shield-alt text-pink-600 mr-2"></i>Role Name
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           placeholder="e.g., content_manager"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Use lowercase with underscores (e.g., content_manager)</p>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        <i class="fas fa-key text-pink-600 mr-2"></i>Permissions
                    </label>
                    @error('permissions')
                        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="space-y-6">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="group_{{ $group }}"
                                       onclick="toggleGroup('{{ $group }}')"
                                       class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <label for="group_{{ $group }}" class="ml-2 font-bold text-gray-900 capitalize">
                                    {{ $group }} All
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($groupPermissions as $permission)
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-pink-50 transition-all cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           class="group-{{ $group }} w-5 h-5 text-pink-600 rounded focus:ring-pink-500"
                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">
                                        {{ str_replace('_', ' ', $permission->name) }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.roles.index') }}" class="px-6 py-3 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover-lift">
                        <i class="fas fa-save mr-2"></i>Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleGroup(group) {
            const checkbox = document.getElementById('group_' + group);
            const groupCheckboxes = document.querySelectorAll('.group-' + group);
            groupCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }

        // Update group checkbox when individual checkboxes change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[name="permissions[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const groupName = this.className.match(/group-(\w+)/)[1];
                    const groupCheckboxes = document.querySelectorAll('.group-' + groupName);
                    const groupCheckbox = document.getElementById('group_' + groupName);
                    const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
                    groupCheckbox.checked = allChecked;
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>

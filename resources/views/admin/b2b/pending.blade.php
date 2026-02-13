<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pending B2B Registrations</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Review and approve business applications</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.b2b.approved') }}" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                    <i class="fas fa-check-circle mr-2"></i>Approved
                </a>
                <a href="{{ route('admin.b2b.rejected') }}" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                    <i class="fas fa-times-circle mr-2"></i>Rejected
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 m-6">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    <p class="ml-3 text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                    <p class="ml-3 text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($profiles->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-pink-500 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Contact Person</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Business Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Applied On</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($profiles as $profile)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($profile->company_name, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $profile->company_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-envelope mr-1"></i>{{ $profile->company_email }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-phone mr-1"></i>{{ $profile->company_phone }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $profile->user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $profile->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $profile->getBusinessTypeLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div>{{ $profile->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $profile->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.b2b.show', $profile->id) }}"
                                           class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <form action="{{ route('admin.b2b.approve', $profile->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to approve this B2B registration?')"
                                                    class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                {{ $profiles->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">No Pending Applications</h3>
                <p class="text-gray-500 dark:text-gray-400">All B2B registrations have been processed</p>
            </div>
        @endif
    </div>
</x-admin-layout>

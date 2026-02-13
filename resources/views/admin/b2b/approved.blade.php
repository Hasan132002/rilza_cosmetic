<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Approved B2B Customers</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage approved business accounts</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.b2b.pending') }}" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-clock mr-2"></i>Pending
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

        @if($profiles->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-green-500 to-teal-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Contact Person</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Business Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Sales Rep</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Approved On</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($profiles as $profile)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($profile->company_name, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $profile->company_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $profile->company_city }}
                                            </div>
                                            @if($profile->tax_id_number)
                                                <div class="text-xs text-gray-400">
                                                    Tax ID: {{ $profile->tax_id_number }}
                                                </div>
                                            @endif
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
                                <td class="px-6 py-4">
                                    @if($profile->salesRep)
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold mr-2">
                                                {{ substr($profile->salesRep->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $profile->salesRep->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div>{{ $profile->approved_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $profile->approved_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.b2b.show', $profile->id) }}"
                                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm inline-block">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </a>
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
                <i class="fas fa-user-check text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">No Approved Customers</h3>
                <p class="text-gray-500 dark:text-gray-400">Approved B2B customers will appear here</p>
            </div>
        @endif
    </div>
</x-admin-layout>

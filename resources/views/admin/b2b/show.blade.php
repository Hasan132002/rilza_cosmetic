<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">B2B Application Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $profile->company_name }}</p>
            </div>
            <div>
                <a href="{{ route('admin.b2b.pending') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <div class="flex">
                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                <p class="ml-3 text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                <p class="ml-3 text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Application Status</h3>
                    @if($profile->status === 'pending')
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
                            <i class="fas fa-clock mr-2"></i>Pending Review
                        </span>
                    @elseif($profile->status === 'approved')
                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>Approved
                        </span>
                    @else
                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-semibold">
                            <i class="fas fa-times-circle mr-2"></i>Rejected
                        </span>
                    @endif
                </div>

                @if($profile->status === 'pending')
                    <div class="flex space-x-4">
                        <form action="{{ route('admin.b2b.approve', $profile->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to approve this B2B registration? The customer will be able to login and place orders.')"
                                    class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                <i class="fas fa-check-circle mr-2"></i>Approve Application
                            </button>
                        </form>
                        <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                                class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                            <i class="fas fa-times-circle mr-2"></i>Reject
                        </button>
                    </div>
                @endif

                @if($profile->status === 'approved' && $profile->approvedBy)
                    <div class="mt-4 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-700">
                            <strong>Approved by:</strong> {{ $profile->approvedBy->name }}<br>
                            <strong>Date:</strong> {{ $profile->approved_at->format('M d, Y g:i A') }}
                        </p>
                    </div>
                @endif

                @if($profile->status === 'rejected' && $profile->rejection_reason)
                    <div class="mt-4 p-4 bg-red-50 rounded-lg">
                        <p class="text-sm text-red-700 font-semibold mb-2">Rejection Reason:</p>
                        <p class="text-sm text-red-600">{{ $profile->rejection_reason }}</p>
                    </div>
                @endif
            </div>

            <!-- Company Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                    <i class="fas fa-building mr-3 text-purple-600"></i>Company Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Company Name</label>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $profile->company_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Business Type</label>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $profile->getBusinessTypeLabel() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Registration Number</label>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $profile->business_registration_number ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Tax ID (NTN/STRN)</label>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $profile->tax_id_number ?: 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Address</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $profile->company_address }}, {{ $profile->company_city }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Phone</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $profile->company_phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $profile->company_email }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Person Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                    <i class="fas fa-user mr-3 text-pink-600"></i>Contact Person
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Full Name</label>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $profile->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $profile->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Account Created</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $profile->user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email Verified</label>
                        <p class="text-gray-900 dark:text-gray-100">
                            @if($profile->user->email_verified_at)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                            @else
                                <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i>Not Verified</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sales Rep Assignment -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-user-tie mr-2 text-blue-600"></i>Sales Representative
                </h3>
                <form action="{{ route('admin.b2b.show', $profile->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Assign Sales Rep</label>
                        <select name="sales_rep_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">None</option>
                            @foreach($salesReps as $rep)
                                <option value="{{ $rep->id }}" {{ $profile->sales_rep_id == $rep->id ? 'selected' : '' }}>
                                    {{ $rep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </form>
            </div>

            <!-- Admin Notes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>Admin Notes
                </h3>
                <form action="{{ route('admin.b2b.show', $profile->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <textarea name="admin_notes" rows="5"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                  placeholder="Add internal notes...">{{ $profile->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Notes
                    </button>
                </form>
            </div>

            <!-- Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-history mr-2 text-gray-600"></i>Timeline
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Application Submitted</p>
                            <p class="text-xs text-gray-500">{{ $profile->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                    @if($profile->approved_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Approved</p>
                                <p class="text-xs text-gray-500">{{ $profile->approved_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Reject Application</h3>
            <form action="{{ route('admin.b2b.reject', $profile->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Reason for Rejection <span class="text-red-500">*</span>
                    </label>
                    <textarea name="rejection_reason" rows="5" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                              placeholder="Provide a detailed reason for rejecting this application..."></textarea>
                    <p class="text-xs text-gray-500 mt-2">This reason will be sent to the applicant via email.</p>
                </div>
                <div class="flex space-x-4">
                    <button type="button"
                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        Reject Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

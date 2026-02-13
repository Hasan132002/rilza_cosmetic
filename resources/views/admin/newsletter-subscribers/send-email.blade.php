<x-admin-layout>
    <x-slot name="header">
        Send Email to Subscribers
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Subscribers</span>
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Send Bulk Email</h3>

            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-blue-800">
                        This email will be sent to <strong>{{ number_format($subscribersCount) }}</strong> active subscribers.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.newsletter-subscribers.send-bulk-email') }}" method="POST">
                @csrf

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email Subject <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="subject"
                           id="subject"
                           value="{{ old('subject') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                           placeholder="e.g., Flash Sale - 50% Off Everything!">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email Message <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message"
                              id="message"
                              rows="10"
                              required
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                              placeholder="Write your email message here...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        Tip: Use HTML tags for formatting (e.g., &lt;strong&gt;, &lt;a href=""&gt;, &lt;p&gt;)
                    </p>
                </div>

                <!-- Preview Box -->
                <div class="mb-6 border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-900">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Preview:</h4>
                    <div id="preview" class="text-gray-600 dark:text-gray-400 min-h-[100px]">
                        Your message will appear here...
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.newsletter-subscribers.index') }}"
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to send this email to {{ number_format($subscribersCount) }} subscribers?')"
                            class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2 rounded-lg shadow-md transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email to All Subscribers
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Live preview
        document.getElementById('message').addEventListener('input', function() {
            document.getElementById('preview').innerHTML = this.value || 'Your message will appear here...';
        });
    </script>
</x-admin-layout>

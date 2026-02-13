<x-frontend-layout title="Business Registration">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #fdf2f8 0%, #fae8ff 100%);">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-pink text-transparent bg-clip-text mb-4">
                    Register Your Business
                </h1>
                <p class="text-gray-600 text-lg">
                    Join Rizla Cosmetics B2B Program and unlock exclusive wholesale pricing
                </p>
            </div>

            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center space-x-4">
                        <!-- Step 1 -->
                        <div class="flex items-center">
                            <div class="step-indicator active w-10 h-10 rounded-full flex items-center justify-center text-white font-bold gradient-pink">
                                1
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700">Personal</span>
                        </div>
                        <div class="w-16 h-1 bg-gray-300">
                            <div class="progress-bar h-full gradient-pink" style="width: 0%"></div>
                        </div>
                        <!-- Step 2 -->
                        <div class="flex items-center">
                            <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center text-gray-400 font-bold bg-gray-200">
                                2
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Business</span>
                        </div>
                        <div class="w-16 h-1 bg-gray-300">
                            <div class="progress-bar h-full gradient-pink" style="width: 0%"></div>
                        </div>
                        <!-- Step 3 -->
                        <div class="flex items-center">
                            <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center text-gray-400 font-bold bg-gray-200">
                                3
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                            <div class="ml-3">
                                <h3 class="text-red-800 font-semibold">Please correct the following errors:</h3>
                                <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('business.register.submit') }}" id="b2b-registration-form">
                    @csrf

                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-user mr-3 text-pink-600"></i>
                            Personal Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Enter your full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="your@email.com">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="+92 300 1234567">
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Min. 8 characters">
                            </div>

                            <!-- Confirm Password -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Re-enter password">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" class="next-step px-8 py-3 gradient-pink text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                Next Step <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Business Information -->
                    <div class="form-step hidden" id="step-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-building mr-3 text-purple-600"></i>
                            Business Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Company Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Your Company Ltd.">
                            </div>

                            <!-- Business Type -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Business Type <span class="text-red-500">*</span>
                                </label>
                                <select name="business_type" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all">
                                    <option value="">Select business type</option>
                                    <option value="small_business" {{ old('business_type') == 'small_business' ? 'selected' : '' }}>Small Business</option>
                                    <option value="distributor" {{ old('business_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                    <option value="retailer" {{ old('business_type') == 'retailer' ? 'selected' : '' }}>Retailer</option>
                                    <option value="wholesaler" {{ old('business_type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                </select>
                            </div>

                            <!-- Business Registration Number -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Business Registration Number
                                </label>
                                <input type="text" name="business_registration_number" value="{{ old('business_registration_number') }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Registration #">
                            </div>

                            <!-- Tax ID Number -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tax ID Number (NTN/STRN)
                                </label>
                                <input type="text" name="tax_id_number" value="{{ old('tax_id_number') }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="Tax ID">
                            </div>

                            <!-- Company Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Company Phone <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="company_phone" value="{{ old('company_phone') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="+92 21 1234567">
                            </div>

                            <!-- Company Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Company Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="company_email" value="{{ old('company_email') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="contact@company.com">
                            </div>

                            <!-- Company Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Company Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="company_address" rows="3" required
                                          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                          placeholder="Street address, Building, Floor">{{ old('company_address') }}</textarea>
                            </div>

                            <!-- Company City -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company_city" value="{{ old('company_city') }}" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all"
                                       placeholder="City name">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" class="prev-step px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i> Previous
                            </button>
                            <button type="button" class="next-step px-8 py-3 gradient-pink text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                Next Step <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Review & Submit -->
                    <div class="form-step hidden" id="step-3">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-600"></i>
                            Review Your Information
                        </h2>

                        <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-6 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Full Name</p>
                                    <p class="text-gray-800 review-name"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Email</p>
                                    <p class="text-gray-800 review-email"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Company Name</p>
                                    <p class="text-gray-800 review-company"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold">Business Type</p>
                                    <p class="text-gray-800 review-type"></p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-600 font-semibold">Company Address</p>
                                    <p class="text-gray-800 review-address"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                            <div class="flex">
                                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                                <div class="ml-3">
                                    <h4 class="text-blue-800 font-semibold">What happens next?</h4>
                                    <ul class="mt-2 text-blue-700 text-sm space-y-1">
                                        <li>• Your application will be reviewed by our team</li>
                                        <li>• You'll receive an email notification within 24-48 hours</li>
                                        <li>• Once approved, you can login and start ordering at wholesale prices</li>
                                        <li>• Enjoy exclusive B2B benefits including bulk discounts</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start mb-6">
                            <input type="checkbox" id="terms" required class="mt-1 w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                            <label for="terms" class="ml-3 text-sm text-gray-700">
                                I agree to the <a href="#" class="text-pink-600 hover:underline">Terms & Conditions</a> and
                                <a href="#" class="text-pink-600 hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" class="prev-step px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i> Previous
                            </button>
                            <button type="submit" class="px-8 py-3 gradient-pink text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Application
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Already have account -->
            <div class="text-center mt-8">
                <p class="text-gray-600">
                    Already have a B2B account?
                    <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:underline">Login here</a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.form-step');
            const stepIndicators = document.querySelectorAll('.step-indicator');
            const progressBars = document.querySelectorAll('.progress-bar');
            let currentStep = 0;

            // Next button handlers
            document.querySelectorAll('.next-step').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (validateStep(currentStep)) {
                        moveToStep(currentStep + 1);
                    }
                });
            });

            // Previous button handlers
            document.querySelectorAll('.prev-step').forEach(btn => {
                btn.addEventListener('click', function() {
                    moveToStep(currentStep - 1);
                });
            });

            function moveToStep(step) {
                if (step < 0 || step >= steps.length) return;

                // Hide current step
                steps[currentStep].classList.remove('active');
                steps[currentStep].classList.add('hidden');

                // Show new step
                steps[step].classList.remove('hidden');
                steps[step].classList.add('active');

                // Update indicators
                updateIndicators(step);

                // Update review if going to step 3
                if (step === 2) {
                    updateReview();
                }

                currentStep = step;
            }

            function updateIndicators(step) {
                stepIndicators.forEach((indicator, index) => {
                    if (index <= step) {
                        indicator.classList.add('gradient-pink', 'text-white');
                        indicator.classList.remove('bg-gray-200', 'text-gray-400');
                    } else {
                        indicator.classList.remove('gradient-pink', 'text-white');
                        indicator.classList.add('bg-gray-200', 'text-gray-400');
                    }
                });

                progressBars.forEach((bar, index) => {
                    if (index < step) {
                        bar.style.width = '100%';
                    } else {
                        bar.style.width = '0%';
                    }
                });
            }

            function validateStep(step) {
                const currentStepEl = steps[step];
                const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
                let valid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.classList.add('border-red-500');
                        setTimeout(() => input.classList.remove('border-red-500'), 2000);
                    }
                });

                if (!valid) {
                    alert('Please fill in all required fields');
                }

                return valid;
            }

            function updateReview() {
                document.querySelector('.review-name').textContent = document.querySelector('[name="name"]').value;
                document.querySelector('.review-email').textContent = document.querySelector('[name="email"]').value;
                document.querySelector('.review-company').textContent = document.querySelector('[name="company_name"]').value;

                const typeSelect = document.querySelector('[name="business_type"]');
                document.querySelector('.review-type').textContent = typeSelect.options[typeSelect.selectedIndex].text;

                const address = document.querySelector('[name="company_address"]').value + ', ' +
                               document.querySelector('[name="company_city"]').value;
                document.querySelector('.review-address').textContent = address;
            }
        });
    </script>
    @endpush
</x-frontend-layout>

<x-frontend-layout title="Add New Address">
    <!-- Header Section -->
    <section class="gradient-pink text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-20 w-72 h-72 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    <i class="fas fa-plus-circle mr-3"></i>Add New Address
                </h1>
                <p class="text-xl text-pink-100">Save a new delivery address</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12" data-aos="fade-up">
                <form action="{{ route('account.addresses.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="label" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1 text-pink-600"></i>Address Label (Optional)
                            </label>
                            <input type="text"
                                   id="label"
                                   name="label"
                                   value="{{ old('label') }}"
                                   placeholder="e.g., Home, Office, Parents House"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('label') border-red-500 @enderror">
                            @error('label')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-pink-600"></i>Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="full_name"
                                   name="full_name"
                                   value="{{ old('full_name') }}"
                                   placeholder="John Doe"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('full_name') border-red-500 @enderror"
                                   required>
                            @error('full_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone mr-1 text-pink-600"></i>Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+92 300 1234567"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('phone') border-red-500 @enderror"
                                   required>
                            @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address_line_1" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-pink-600"></i>Address Line 1 <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 font-normal">(House/Flat No., Street Name)</span>
                            </label>
                            <input type="text"
                                   id="address_line_1"
                                   name="address_line_1"
                                   value="{{ old('address_line_1') }}"
                                   placeholder="House/Flat No., Street Name"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('address_line_1') border-red-500 @enderror"
                                   required>
                            @error('address_line_1')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address_line_2" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-pink-600"></i>Address Line 2
                                <span class="text-xs text-gray-500 font-normal">(Area, Landmark) - Optional</span>
                            </label>
                            <input type="text"
                                   id="address_line_2"
                                   name="address_line_2"
                                   value="{{ old('address_line_2') }}"
                                   placeholder="Area, Landmark"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('address_line_2') border-red-500 @enderror">
                            @error('address_line_2')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-city mr-1 text-pink-600"></i>City <span class="text-red-500">*</span>
                            </label>
                            <select id="city"
                                    name="city"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('city') border-red-500 @enderror"
                                    required>
                                <option value="">Select City</option>
                                <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan</option>
                                <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta</option>
                            </select>
                            @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map mr-1 text-pink-600"></i>State/Province (Optional)
                            </label>
                            <select id="state"
                                    name="state"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('state') border-red-500 @enderror">
                                <option value="">Select State/Province</option>
                                <option value="Sindh" {{ old('state') == 'Sindh' ? 'selected' : '' }}>Sindh</option>
                                <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="KPK" {{ old('state') == 'KPK' ? 'selected' : '' }}>KPK</option>
                                <option value="Balochistan" {{ old('state') == 'Balochistan' ? 'selected' : '' }}>Balochistan</option>
                            </select>
                            @error('state')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-mail-bulk mr-1 text-pink-600"></i>Postal Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="postal_code"
                                   name="postal_code"
                                   value="{{ old('postal_code') }}"
                                   placeholder="75500"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 transition-all @error('postal_code') border-red-500 @enderror"
                                   required>
                            @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       name="is_default"
                                       value="1"
                                       {{ old('is_default') ? 'checked' : '' }}
                                       class="w-5 h-5 text-pink-600 border-2 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 font-semibold">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>Set as default address
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Save Address
                        </button>
                        <a href="{{ route('account.addresses.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-4 rounded-xl font-bold text-lg hover:bg-gray-300 transition-all text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-frontend-layout>

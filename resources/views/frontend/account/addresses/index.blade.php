<x-frontend-layout title="My Addresses">
    <!-- Header Section -->
    <section class="gradient-pink text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-20 w-72 h-72 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    <i class="fas fa-map-marker-alt mr-3"></i>My Addresses
                </h1>
                <p class="text-xl text-pink-100">Manage your saved delivery addresses</p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8" data-aos="fade-up">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="max-w-5xl mx-auto">
            <!-- Add New Address Button -->
            <div class="mb-8 text-center" data-aos="fade-up">
                <a href="{{ route('account.addresses.create') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Add New Address
                </a>
            </div>

            @if($addresses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all {{ $address->is_default ? 'border-2 border-pink-500' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                @if($address->label)
                                <div class="inline-flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold mb-2">
                                    <i class="fas fa-tag mr-1"></i>{{ $address->label }}
                                </div>
                                @endif

                                @if($address->is_default)
                                <div class="inline-flex items-center bg-gradient-to-r from-pink-500 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold mb-2 ml-2">
                                    <i class="fas fa-star mr-1"></i>Default
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="font-bold text-lg">{{ $address->full_name }}</div>
                            <div class="text-gray-600">
                                <i class="fas fa-phone w-5 text-pink-500"></i>{{ $address->phone }}
                            </div>
                            <div class="text-gray-700">
                                <i class="fas fa-map-marker-alt w-5 text-pink-500"></i>
                                <span>{{ $address->address_line_1 }}</span>
                            </div>
                            @if($address->address_line_2)
                            <div class="text-gray-700 pl-6">
                                {{ $address->address_line_2 }}
                            </div>
                            @endif
                            <div class="text-gray-700 pl-6">
                                {{ $address->city }}@if($address->state), {{ $address->state }}@endif - {{ $address->postal_code }}
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200">
                            <a href="{{ route('account.addresses.edit', $address->id) }}" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-center font-semibold">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>

                            @if(!$address->is_default)
                            <form action="{{ route('account.addresses.set-default', $address->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors font-semibold">
                                    <i class="fas fa-star mr-1"></i>Set Default
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('account.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16" data-aos="fade-up">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <i class="fas fa-map-marker-alt text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3">No Saved Addresses</h3>
                <p class="text-gray-600 mb-6">Add your delivery addresses for faster checkout</p>
                <a href="{{ route('account.addresses.create') }}" class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all">
                    <i class="fas fa-plus mr-2"></i>Add Your First Address
                </a>
            </div>
            @endif

            <!-- Back to Account -->
            <div class="mt-12 text-center" data-aos="fade-up">
                <a href="{{ route('account.dashboard') }}" class="inline-block text-pink-600 hover:text-pink-700 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Back to My Account
                </a>
            </div>
        </div>
    </div>
</x-frontend-layout>

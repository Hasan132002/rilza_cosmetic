<x-frontend-layout title="My Reviews">
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8" data-aos="fade-down">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">My Reviews</h1>
                <p class="text-gray-600">Manage your product reviews</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Account Menu -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="w-16 h-16 gradient-pink rounded-xl flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            <a href="{{ route('account.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-shopping-bag w-5 mr-3"></i>
                                My Orders
                            </a>
                            <a href="{{ route('account.addresses.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-map-marker-alt w-5 mr-3"></i>
                                Addresses
                            </a>
                            <a href="{{ route('account.reviews') }}" class="flex items-center px-4 py-3 bg-pink-50 text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-star w-5 mr-3"></i>
                                My Reviews
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl font-medium transition-all">
                                <i class="fas fa-user-edit w-5 mr-3"></i>
                                Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-all">
                                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">My Product Reviews</h2>

                        @if($reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                            <div class="border border-gray-200 rounded-xl p-6 hover:border-pink-300 hover:shadow-md transition-all">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4">
                                        @if($review->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $review->product->images->first()->image_path) }}"
                                             alt="{{ $review->product->name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                        @else
                                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-1">
                                                <a href="{{ route('product', $review->product->slug) }}" class="hover:text-pink-600">
                                                    {{ $review->product->name }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                                            </div>
                                            <div class="flex items-center space-x-3 text-sm">
                                                @if($review->is_verified_purchase)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Verified Purchase
                                                </span>
                                                @endif
                                                @if($review->is_approved)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    <i class="fas fa-check mr-1"></i>Approved
                                                </span>
                                                @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>Pending Approval
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>

                                @if($review->title)
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $review->title }}</h4>
                                @endif
                                <p class="text-gray-700 leading-relaxed">{{ $review->review }}</p>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($reviews->hasPages())
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                        @endif

                        @else
                        <div class="text-center py-12">
                            <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg mb-4">You haven't written any reviews yet</p>
                            <a href="{{ route('shop') }}" class="gradient-pink text-white px-6 py-3 rounded-xl font-semibold inline-block hover:shadow-lg transition-all">
                                Shop Now
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>

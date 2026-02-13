<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up - Rizla Cosmetics</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        h1 { font-family: 'Playfair Display', serif; }
        .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); }
        .gradient-purple { background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-50 via-purple-50 to-pink-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-16 h-16 gradient-pink rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all">
                    <i class="fas fa-gem text-3xl text-white"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Rizla</h1>
                    <p class="text-sm text-gray-600">Cosmetics</p>
                </div>
            </a>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Create Account</h2>
            <p class="text-gray-600 text-center mb-8">Join Rizla Cosmetics family</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-pink-600 mr-2"></i>Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-pink-600 mr-2"></i>Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pink-600 mr-2"></i>Password
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pink-600 mr-2"></i>Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                </div>

                <!-- Register Button -->
                <button type="submit" class="w-full gradient-purple text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2 mb-6">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>

                <!-- Terms -->
                <p class="text-xs text-gray-500 text-center">
                    By signing up, you agree to our
                    <a href="{{ route('terms') }}" class="text-pink-600 hover:underline">Terms & Conditions</a> and
                    <a href="{{ route('privacy') }}" class="text-pink-600 hover:underline">Privacy Policy</a>
                </p>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-bold">
                        Login <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>

        <!-- Benefits -->
        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4">
                <i class="fas fa-truck text-2xl text-pink-600 mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">Free Shipping</p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4">
                <i class="fas fa-gift text-2xl text-purple-600 mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">Special Offers</p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4">
                <i class="fas fa-headset text-2xl text-pink-600 mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">24/7 Support</p>
            </div>
        </div>
    </div>
</body>
</html>

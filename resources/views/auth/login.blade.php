<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Rizla Cosmetics</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        h1 { font-family: 'Playfair Display', serif; }
        .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); }
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

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Welcome Back!</h2>
            <p class="text-gray-600 text-center mb-8">Login to continue shopping</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-pink-600 mr-2"></i>Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pink-600 mr-2"></i>Password
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-pink-600 hover:text-pink-700 font-semibold">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full gradient-pink text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Login to Account
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-700 font-bold">
                        Sign Up <i class="fas fa-arrow-right ml-1"></i>
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

        <!-- Footer Note -->
        <p class="text-center text-sm text-gray-600 mt-6">
            <i class="fas fa-shield-alt text-pink-600 mr-2"></i>Your data is secure with us
        </p>
    </div>
</body>
</html>

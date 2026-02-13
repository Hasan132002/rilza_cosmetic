<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rizla Cosmetics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4">
                <i class="fas fa-crown text-pink-500 text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Rizla Cosmetics</h2>
            <p class="text-pink-100 text-lg">Admin Panel Login</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <div>
                            <p class="text-sm text-red-700 font-medium">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-pink-500"></i>Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                        placeholder="admin@rizlacosmetics.com"
                    >
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-pink-500"></i>Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                        placeholder="Enter your password"
                    >
                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full gradient-bg text-white font-semibold py-3 px-4 rounded-lg hover:opacity-90 transition duration-200 shadow-lg"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Admin Panel
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Admin access only. Customers should use the
                    <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                        customer login
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-pink-100 text-sm">
                &copy; {{ date('Y') }} Rizla Cosmetics. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

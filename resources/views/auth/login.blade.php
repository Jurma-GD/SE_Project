<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusEats</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .campuseats-hero {
            background: linear-gradient(135deg, #724e2c 0%, #563517 50%, #8b6340 100%);
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .vendor-card-post {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
        }
        .scale-hover {
            transition: transform 0.3s ease;
        }
        .scale-hover:hover {
            transform: scale(1.02);
        }
        .campuseats-gradient {
            background: linear-gradient(135deg, #724e2c 0%, #563517 100%);
        }
    </style>
</head>
<body class="campuseats-hero min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Title -->
            <div class="text-center">
                <div class="float-animation inline-block">
                    <div class="text-7xl mb-4">🍽️</div>
                </div>
                <h2 class="mt-2 text-5xl font-extrabold text-white" style="font-weight: 800; text-shadow: 0 0 20px rgba(255,255,255,0.5);">
                    CampusEats
                </h2>
                <p class="mt-3 text-xl text-white/90 font-semibold">
                    Your Campus Food Hub
                </p>
                <p class="mt-2 text-sm text-white/80">
                    Sign in to browse menus or manage your vendor account
                </p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6 vendor-card-post rounded-xl p-8 shadow-2xl" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">📧 Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               style="--tw-ring-color: #724e2c;"
                               placeholder="Enter your email" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">🔒 Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               style="--tw-ring-color: #724e2c;"
                               placeholder="Enter your password">
                    </div>
                </div>

                @error('email')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <p class="text-red-800 text-sm font-medium">{{ $message }}</p>
                    </div>
                @enderror

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 border-gray-300 rounded"
                               style="accent-color: #724e2c;">
                        <label for="remember" class="ml-2 block text-sm font-medium text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="campuseats-gradient group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-bold rounded-lg text-white hover:shadow-2xl focus:outline-none transition-all transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white/80 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Sign In to CampusEats
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="font-bold transition-colors" style="color: #724e2c;">
                        Don't have an account? <span class="underline">Join CampusEats</span> 🚀
                    </a>
                </div>
            </form>

            <!-- Footer Text -->
            <p class="text-center text-white/70 text-sm">
                © 2026 CampusEats. Delicious food, delivered to your campus.
            </p>
        </div>
    </div>
</body>
</html>

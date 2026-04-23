<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CampusEats</title>
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
                    Create an account to get started
                </p>
            </div>

            <!-- Register Form -->
            <form class="space-y-6 vendor-card-post rounded-xl p-8 shadow-2xl" action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">👤 Full Name</label>
                        <input id="name" name="name" type="text" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               placeholder="Enter your full name"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">📧 Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               placeholder="Enter your email"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">🔒 Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               placeholder="Create a password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">🔒 Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               placeholder="Confirm your password">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-bold text-gray-900 mb-2">🎓 I am a</label>
                        <select id="role" name="role" required
                                class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:border-transparent transition-all text-gray-700">
                            <option value="">Select role</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                            <option value="vendor" {{ old('role') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="vendorFields" class="space-y-5" style="display: {{ old('role') === 'vendor' ? 'block' : 'none' }};">
                        <div>
                            <label for="vendor_name" class="block text-sm font-bold text-gray-900 mb-2">🏪 Vendor Name</label>
                            <input id="vendor_name" name="vendor_name" type="text"
                                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Your stall or shop name"
                                   value="{{ old('vendor_name') }}">
                            @error('vendor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-bold text-gray-900 mb-2">📍 Location in School</label>
                            <input id="location" name="location" type="text"
                                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="e.g. Main Building, Ground Floor"
                                   value="{{ old('location') }}">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_info" class="block text-sm font-bold text-gray-900 mb-2">📞 Contact Info <span class="font-normal text-gray-500">(Optional)</span></label>
                            <input id="contact_info" name="contact_info" type="text"
                                   class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Phone number or contact details"
                                   value="{{ old('contact_info') }}">
                            @error('contact_info')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-900 mb-2">📝 Description <span class="font-normal text-gray-500">(Optional)</span></label>
                            <textarea id="description" name="description" rows="3"
                                      class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-all resize-none"
                                      placeholder="Tell students about your stall...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="campuseats-gradient group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-bold rounded-lg text-white hover:shadow-2xl focus:outline-none transition-all transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white/80 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                            </svg>
                        </span>
                        Create Account
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="font-bold transition-colors" style="color: #724e2c;">
                        Already have an account? <span class="underline">Sign in</span>
                    </a>
                </div>
            </form>

            <!-- Footer Text -->
            <p class="text-center text-white/70 text-sm">
                © 2026 CampusEats. Delicious food, delivered to your campus.
            </p>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const vendorFields = document.getElementById('vendorFields');
            vendorFields.style.display = this.value === 'vendor' ? 'block' : 'none';
        });
    </script>
</body>
</html>

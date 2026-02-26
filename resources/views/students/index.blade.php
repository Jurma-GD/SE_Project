<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Vendors - CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 to-yellow-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-2 border-orange-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="campuseats-logo text-3xl">🍽️ CampusEats</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isStudent())
                            <a href="{{ route('orders.my') }}" class="nav-link">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    My Orders
                                </span>
                            </a>
                        @endif
                        <span class="text-gray-700 font-semibold">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="nav-link">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Join CampusEats
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center animate-fade-in">
                <h2 class="text-5xl font-extrabold sm:text-6xl mb-4">
                    Hungry? We've Got You! 🎉
                </h2>
                <p class="mt-4 text-xl text-orange-100 font-medium">
                    Browse campus vendor menus, order ahead, and skip the wait!
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mt-8 max-w-2xl mx-auto animate-slide-in-right">
                <form action="{{ route('search') }}" method="GET" class="flex gap-3">
                    <input type="text" name="q" placeholder="🔍 Search for your favorite food..."
                           class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium shadow-lg"
                           value="{{ request('q') }}">
                    <button type="submit" class="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold hover:bg-orange-50 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($vendors->isEmpty())
            <div class="text-center py-16 animate-fade-in">
                <div class="inline-block p-8 bg-white rounded-2xl shadow-xl">
                    <svg class="mx-auto h-16 w-16 text-orange-400 animate-bounce-gentle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-bold text-gray-900">No vendors available right now</h3>
                    <p class="mt-2 text-gray-600">Check back soon for delicious options!</p>
                </div>
            </div>
        @else
            <div class="mb-8 flex items-center justify-between">
                <h3 class="text-3xl font-extrabold text-gray-900">
                    🏪 Available Vendors
                    <span class="text-orange-600">({{ $vendors->count() }})</span>
                </h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($vendors as $vendor)
                    @php
                        // Vendor-specific colors and emojis
                        $vendorStyles = [
                            'Kwago' => ['bg' => 'F59E0B', 'emoji' => '🦉'],
                            'Canteen' => ['bg' => '10B981', 'emoji' => '🍴'],
                        ];
                        $style = $vendorStyles[$vendor->vendor_name] ?? ['bg' => 'FF6B35', 'emoji' => '🏪'];
                    @endphp
                    <div class="vendor-card animate-fade-in overflow-hidden">
                        <!-- Vendor Image -->
                        <div class="relative h-48 overflow-hidden" style="background: linear-gradient(135deg, #{{ $style['bg'] }}22 0%, #{{ $style['bg'] }}66 100%);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-9xl mb-2">{{ $style['emoji'] }}</div>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-success animate-bounce-gentle shadow-lg">
                                    {{ $vendor->menuItems->count() }} items
                                </span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h4 class="text-2xl font-extrabold text-white">{{ $vendor->vendor_name }}</h4>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 flex items-center font-medium">
                                        <svg class="h-5 w-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $vendor->location }}
                                    </p>
                                </div>
                            </div>

                            @if($vendor->description)
                                <p class="text-gray-700 mb-4 font-medium">{{ Str::limit($vendor->description, 100) }}</p>
                            @endif

                            @if($vendor->contact_info)
                                <p class="text-sm text-gray-600 mb-4 flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $vendor->contact_info }}
                                </p>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('vendors.show', $vendor) }}" 
                                   class="btn-primary w-full text-center block">
                                    View Full Menu →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-orange-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="campuseats-logo text-2xl mb-2">🍽️ CampusEats</p>
                <p class="text-gray-600 text-sm font-medium">
                    © 2026 CampusEats. Your campus food hub - Fresh, Fast, Delicious!
                </p>
            </div>
        </div>
    </footer>
</body>
</html>

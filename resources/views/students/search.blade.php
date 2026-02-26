<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 to-yellow-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-2 border-orange-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="campuseats-logo text-3xl">🍽️ CampusEats</a>
                    <a href="{{ route('home') }}" class="nav-link">
                        Browse Vendors
                    </a>
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

    <!-- Header -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="animate-fade-in">
                <h1 class="text-4xl font-extrabold mb-4">Search Results 🔍</h1>
                
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="max-w-4xl">
                    <div class="flex gap-3 mb-4">
                        <input type="text" name="q" placeholder="🔍 Search for your favorite food..."
                               class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium shadow-lg"
                               value="{{ request('q') }}">
                        <button type="submit" class="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold hover:bg-orange-50 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                            Search
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="flex gap-3 flex-wrap">
                        <select name="vendor_id" class="px-4 py-2 rounded-lg text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">All Vendors</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->vendor_name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="availability" class="px-4 py-2 rounded-lg text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">All Items</option>
                            <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>
                                Available Only
                            </option>
                            <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>
                                Unavailable Only
                            </option>
                        </select>

                        @if(request()->hasAny(['q', 'vendor_id', 'availability']))
                            <a href="{{ route('search') }}" class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-medium transition">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Summary -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                Found {{ $menuItems->count() }} item(s)
                @if(request('q'))
                    for "<span class="text-orange-600">{{ request('q') }}</span>"
                @endif
            </h2>
            @if(request('vendor_id'))
                @php
                    $selectedVendor = $vendors->find(request('vendor_id'));
                @endphp
                @if($selectedVendor)
                    <p class="text-gray-600 mt-1">
                        Filtered by vendor: <span class="font-semibold">{{ $selectedVendor->vendor_name }}</span>
                    </p>
                @endif
            @endif
            @if(request('availability'))
                <p class="text-gray-600 mt-1">
                    Showing: <span class="font-semibold">{{ ucfirst(request('availability')) }} items</span>
                </p>
            @endif
        </div>

        @if($menuItems->isEmpty())
            <div class="text-center py-16 animate-fade-in">
                <div class="inline-block p-8 bg-white rounded-2xl shadow-xl">
                    <svg class="mx-auto h-16 w-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-xl font-bold text-gray-900">No items found</h3>
                    <p class="mt-2 text-gray-600">Try adjusting your search or filters</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block btn-primary">
                        Browse All Vendors
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menuItems as $item)
                    @php
                        // Generate a consistent color based on category
                        $colors = [
                            'Rice Meals' => ['bg' => 'FFB84D', 'text' => 'FFFFFF'],
                            'Breakfast' => ['bg' => '4ECDC4', 'text' => 'FFFFFF'],
                            'Main Dishes' => ['bg' => 'FF6B6B', 'text' => 'FFFFFF'],
                            'Noodles & Pasta' => ['bg' => 'F7B731', 'text' => 'FFFFFF'],
                            'Snacks' => ['bg' => '5F27CD', 'text' => 'FFFFFF'],
                            'Beverages' => ['bg' => '00D2D3', 'text' => 'FFFFFF'],
                            'Desserts' => ['bg' => 'FF9FF3', 'text' => 'FFFFFF'],
                        ];
                        $categoryColor = $colors[$item->category] ?? ['bg' => 'FF6B35', 'text' => 'FFFFFF'];
                        
                        // Food emojis by category
                        $emojis = [
                            'Rice Meals' => '🍛',
                            'Breakfast' => '🍳',
                            'Main Dishes' => '🍖',
                            'Noodles & Pasta' => '🍜',
                            'Snacks' => '🥟',
                            'Beverages' => '🥤',
                            'Desserts' => '🍨',
                        ];
                        $emoji = $emojis[$item->category] ?? '🍽️';
                    @endphp
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 animate-fade-in {{ !$item->is_available ? 'opacity-60' : '' }}">
                        <!-- Item Image -->
                        <div class="relative h-48 overflow-hidden" style="background: linear-gradient(135deg, #{{ $categoryColor['bg'] }}22 0%, #{{ $categoryColor['bg'] }}44 100%);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-8xl mb-2">{{ $emoji }}</div>
                                    <div class="text-sm font-semibold text-gray-600">{{ $item->category }}</div>
                                </div>
                            </div>
                            @if(!$item->is_available)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="px-4 py-2 bg-red-500 text-white text-lg font-bold rounded-full">
                                        SOLD OUT
                                    </span>
                                </div>
                            @else
                                <div class="absolute top-3 right-3">
                                    <span class="badge badge-success shadow-lg">
                                        AVAILABLE
                                    </span>
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h3 class="text-xl font-bold text-white">{{ $item->name }}</h3>
                            </div>
                        </div>

                        <!-- Item Body -->
                        <div class="p-6">
                            <!-- Vendor Information -->
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 font-semibold">From</p>
                                        <p class="text-lg font-bold text-orange-600">{{ $item->vendor->vendor_name }}</p>
                                    </div>
                                    <a href="{{ route('vendors.show', $item->vendor) }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold">
                                        View Vendor →
                                    </a>
                                </div>
                                <p class="text-sm text-gray-600 flex items-center mt-1">
                                    <svg class="h-4 w-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $item->vendor->location }}
                                </p>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">{{ $item->description }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-3xl font-bold text-orange-600">₱{{ number_format($item->price, 2) }}</span>
                            </div>

                            @if($item->is_available)
                                <a href="{{ route('vendors.show', $item->vendor) }}" class="block text-center btn-primary">
                                    Order Now
                                </a>
                            @else
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg text-center font-semibold">
                                    Currently Unavailable
                                </div>
                            @endif

                            <p class="text-xs text-gray-500 mt-3 text-center">
                                Last updated: {{ $item->updated_at->diffForHumans() }}
                            </p>
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

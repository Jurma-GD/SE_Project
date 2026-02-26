<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items - CampusEats</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-4 border-indigo-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">🍽️ CampusEats</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('vendor.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                            Dashboard
                        </a>
                        <a href="{{ route('vendor.menu-items.index') }}" class="text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 text-sm font-medium">
                            Menu Items
                        </a>
                        <a href="{{ route('vendor.orders') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                            Orders
                        </a>
                        <a href="{{ route('vendor.profile') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold">Menu Items</h2>
                    <p class="mt-1 text-indigo-100">Manage your menu offerings</p>
                </div>
                <a href="{{ route('vendor.menu-items.create') }}" 
                   class="bg-white text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Item
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-pulse">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Items</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $menuItems->total() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Available</p>
                        <p class="text-3xl font-bold text-green-600">{{ $menuItems->where('is_available', true)->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500 transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Unavailable</p>
                        <p class="text-3xl font-bold text-red-600">{{ $menuItems->where('is_available', false)->count() }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Categories</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $menuItems->pluck('category')->unique()->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Items Grid -->
        @if($menuItems->count() > 0)
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
                        $categoryColor = $colors[$item->category] ?? ['bg' => '6366F1', 'text' => 'FFFFFF'];
                        
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
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 border border-gray-200">
                        <!-- Item Image -->
                        <div class="relative h-48 overflow-hidden" style="background: linear-gradient(135deg, #{{ $categoryColor['bg'] }}22 0%, #{{ $categoryColor['bg'] }}44 100%);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-8xl mb-2">{{ $emoji }}</div>
                                    <div class="text-sm font-semibold text-gray-600">{{ $item->category }}</div>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 rounded-full text-xs font-bold shadow-lg {{ $item->is_available ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $item->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                            @if($item->category)
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-white bg-opacity-90 text-indigo-600 text-xs rounded-full font-bold">
                                        {{ $item->category }}
                                    </span>
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h3 class="text-xl font-bold text-white">{{ $item->name }}</h3>
                            </div>
                        </div>

                        <!-- Item Body -->
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">{{ $item->description }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-3xl font-bold text-indigo-600">₱{{ number_format($item->price, 2) }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button onclick="toggleAvailability({{ $item->id }}, {{ $item->is_available ? 'false' : 'true' }})" 
                                        class="flex-1 {{ $item->is_available ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-lg font-medium transition transform hover:scale-105 text-sm">
                                    {{ $item->is_available ? 'Mark Unavailable' : 'Mark Available' }}
                                </button>
                                <a href="{{ route('vendor.menu-items.edit', $item) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition transform hover:scale-105 text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('vendor.menu-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition transform hover:scale-105 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $menuItems->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-2xl font-semibold text-gray-900">No menu items yet</h3>
                <p class="mt-2 text-gray-600">Get started by adding your first menu item!</p>
                <a href="{{ route('vendor.menu-items.create') }}" 
                   class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-lg transition transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Your First Item
                </a>
            </div>
        @endif
    </div>

    <script>
        function toggleAvailability(itemId, newStatus) {
            fetch(`/vendor/menu-items/${itemId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_available: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>

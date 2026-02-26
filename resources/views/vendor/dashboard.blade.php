<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard - CampusEats</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold text-indigo-600">🍽️ Vendor Dashboard</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('vendor.dashboard') }}" class="text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('vendor.menu-items.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Menu Items
                        </a>
                        <a href="{{ route('vendor.profile') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h2 class="text-3xl font-bold text-gray-900">Welcome, {{ $vendor->vendor_name }}!</h2>
            <p class="mt-1 text-sm text-gray-600">Manage your menu and orders from here</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Menu Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Menu Items</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $totalItems }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('vendor.menu-items.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Manage items →
                    </a>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Orders</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $pendingOrders }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('vendor.orders') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                        View orders →
                    </a>
                </div>
            </div>

            <!-- Vendor Location -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Your Location</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $vendor->location }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('vendor.profile') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                        Update profile →
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('vendor.menu-items.create') }}" 
                   class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Menu Item
                </a>
                <a href="{{ route('vendor.menu-items.index') }}" 
                   class="flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    View All Items
                </a>
                <a href="{{ route('vendor.orders') }}" 
                   class="flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Manage Orders
                </a>
                <a href="{{ route('vendor.profile') }}" 
                   class="flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Vendor Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vendor Information</h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <span class="text-sm font-medium text-gray-500 w-32">Vendor Name:</span>
                    <span class="text-sm text-gray-900">{{ $vendor->vendor_name }}</span>
                </div>
                <div class="flex items-start">
                    <span class="text-sm font-medium text-gray-500 w-32">Location:</span>
                    <span class="text-sm text-gray-900">{{ $vendor->location }}</span>
                </div>
                @if($vendor->contact_info)
                    <div class="flex items-start">
                        <span class="text-sm font-medium text-gray-500 w-32">Contact:</span>
                        <span class="text-sm text-gray-900">{{ $vendor->contact_info }}</span>
                    </div>
                @endif
                @if($vendor->description)
                    <div class="flex items-start">
                        <span class="text-sm font-medium text-gray-500 w-32">Description:</span>
                        <span class="text-sm text-gray-900">{{ $vendor->description }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 text-sm">
                © 2026 CampusEats. Manage your menu and orders efficiently.
            </p>
        </div>
    </footer>
</body>
</html>

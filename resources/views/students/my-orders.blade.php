<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - CampusEats</title>
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
                        <span class="text-gray-700 font-semibold">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="nav-link">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="animate-fade-in">
                <h1 class="text-4xl font-extrabold mb-2">My Orders 📦</h1>
                <p class="text-orange-100 text-lg">Track your food orders and pickup notifications</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-fade-in">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-md animate-fade-in">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Ready Orders Notification -->
        @php
            $readyOrders = $orders->where('status', 'ready');
        @endphp

        @if($readyOrders->count() > 0)
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-2xl p-6 mb-8 animate-bounce-gentle border-4 border-green-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white rounded-full p-3">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">{{ $readyOrders->count() }} Order(s) Ready for Pickup! 🎉</h3>
                            <p class="text-green-100 text-lg">Your food is ready! Check the details below.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Status Filter Tabs -->
        <div class="bg-white rounded-xl shadow-md p-2 mb-6 inline-flex space-x-2">
            <button onclick="filterOrders('all')" id="filter-all" class="filter-btn filter-btn-active">
                All Orders ({{ $orders->count() }})
            </button>
            <button onclick="filterOrders('pending')" id="filter-pending" class="filter-btn">
                Pending ({{ $orders->where('status', 'pending')->count() }})
            </button>
            <button onclick="filterOrders('ready')" id="filter-ready" class="filter-btn">
                Ready ({{ $orders->where('status', 'ready')->count() }})
            </button>
            <button onclick="filterOrders('completed')" id="filter-completed" class="filter-btn">
                Completed ({{ $orders->where('status', 'completed')->count() }})
            </button>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-16 animate-fade-in">
                <div class="inline-block p-8 bg-white rounded-2xl shadow-xl">
                    <svg class="mx-auto h-16 w-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-xl font-bold text-gray-900">No orders yet</h3>
                    <p class="mt-2 text-gray-600">Start browsing vendors to place your first order!</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block btn-primary">
                        Browse Vendors
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="order-card status-{{ $order->status }} bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in
                        {{ $order->status === 'ready' ? 'border-4 border-green-400 ring-4 ring-green-200' : '' }}">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-2xl font-bold text-gray-900">
                                            Order #{{ $order->order_number }}
                                        </h3>
                                        <span class="badge 
                                            @if($order->status === 'pending') badge-warning
                                            @elseif($order->status === 'ready') badge-success animate-pulse
                                            @elseif($order->status === 'completed') badge-info
                                            @else badge-secondary
                                            @endif">
                                            @if($order->status === 'pending') ⏳ Preparing
                                            @elseif($order->status === 'ready') ✅ Ready for Pickup
                                            @elseif($order->status === 'completed') 🎉 Completed
                                            @else {{ ucfirst($order->status) }}
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">
                                        Placed on {{ $order->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-orange-600">₱{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <!-- Vendor Information -->
                            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 font-semibold">Vendor</p>
                                        <p class="text-xl font-bold text-gray-900">{{ $order->vendor->vendor_name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 font-semibold flex items-center justify-end">
                                            <svg class="h-5 w-5 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Pickup Location
                                        </p>
                                        <p class="text-lg font-bold text-orange-600">{{ $order->vendor->location }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-600 mb-3">Order Items</h4>
                                <div class="space-y-2">
                                    @foreach($order->orderItems as $item)
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800">
                                                    <span class="text-orange-600">{{ $item->quantity }}x</span> {{ $item->item_name }}
                                                </p>
                                                <p class="text-sm text-gray-600">₱{{ number_format($item->price_at_order, 2) }} each</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-gray-800">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-gray-600 font-semibold">Notes:</p>
                                    <p class="text-gray-800">{{ $order->notes }}</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex gap-3 mt-4">
                                <a href="{{ route('orders.show', $order) }}" class="btn-secondary flex-1 text-center">
                                    View Details
                                </a>
                                @if($order->status === 'ready')
                                    <a href="{{ route('vendors.show', $order->vendor) }}" class="btn-primary flex-1 text-center">
                                        View Vendor Location
                                    </a>
                                @endif
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

    <script>
        function filterOrders(status) {
            // Update button states
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('filter-btn-active');
            });
            document.getElementById(`filter-${status}`).classList.add('filter-btn-active');

            // Filter order cards
            document.querySelectorAll('.order-card').forEach(card => {
                if (status === 'all') {
                    card.style.display = 'block';
                } else {
                    if (card.classList.contains(`status-${status}`)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - CampusEats</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <a href="{{ route('vendor.menu-items.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                            Menu Items
                        </a>
                        <a href="{{ route('vendor.orders') }}" class="text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 text-sm font-medium">
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
            <h2 class="text-3xl font-bold">Order Queue</h2>
            <p class="mt-1 text-indigo-100">Manage incoming orders</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="bg-white rounded-xl shadow-md p-2 mb-6 flex space-x-2">
            <a href="{{ route('vendor.orders') }}" 
               class="flex-1 text-center px-4 py-3 rounded-lg font-semibold transition {{ !request('status') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                All Orders
            </a>
            <a href="{{ route('vendor.orders', ['status' => 'pending']) }}" 
               class="flex-1 text-center px-4 py-3 rounded-lg font-semibold transition {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Pending
            </a>
            <a href="{{ route('vendor.orders', ['status' => 'ready']) }}" 
               class="flex-1 text-center px-4 py-3 rounded-lg font-semibold transition {{ request('status') == 'ready' ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Ready
            </a>
            <a href="{{ route('vendor.orders', ['status' => 'completed']) }}" 
               class="flex-1 text-center px-4 py-3 rounded-lg font-semibold transition {{ request('status') == 'completed' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Completed
            </a>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 {{ 
                        $order->status === 'pending' ? 'border-yellow-500' : 
                        ($order->status === 'ready' ? 'border-green-500' : 'border-blue-500') 
                    }}">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="font-medium">Customer:</span> {{ $order->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $order->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-bold {{ 
                                        $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-2xl font-bold text-indigo-600 mt-2">₱{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Order Items:</h4>
                                <div class="space-y-2">
                                    @foreach($order->orderItems as $item)
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center">
                                                <span class="bg-indigo-100 text-indigo-800 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm mr-3">
                                                    {{ $item->quantity }}x
                                                </span>
                                                <span class="text-gray-900 font-medium">{{ $item->item_name }}</span>
                                            </div>
                                            <span class="text-gray-700 font-semibold">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4">
                                    <p class="text-sm text-blue-800"><strong>Note:</strong> {{ $order->notes }}</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-3">
                                @if($order->status === 'pending')
                                    <form action="{{ route('vendor.orders.ready', $order) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105">
                                            Mark as Ready
                                        </button>
                                    </form>
                                @endif

                                @if($order->status === 'ready')
                                    <form action="{{ route('vendor.orders.complete', $order) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif

                                @if($order->status === 'completed')
                                    <div class="flex-1 bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-semibold text-center">
                                        Order Completed ✓
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h3 class="mt-4 text-2xl font-semibold text-gray-900">No orders found</h3>
                <p class="mt-2 text-gray-600">
                    @if(request('status'))
                        No {{ request('status') }} orders at the moment.
                    @else
                        You don't have any orders yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</body>
</html>

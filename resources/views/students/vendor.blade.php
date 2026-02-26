<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vendor->vendor_name }} - CampusEats</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-4 border-indigo-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        🍽️ CampusEats
                    </a>
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                        ← Back to Vendors
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isStudent())
                            <a href="{{ route('orders.my') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                My Orders
                            </a>
                        @endif
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            Join CampusEats
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Vendor Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-3">{{ $vendor->vendor_name }}</h1>
                    <div class="space-y-2">
                        <p class="text-indigo-100 flex items-center text-lg">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $vendor->location }}
                        </p>
                        @if($vendor->contact_info)
                            <p class="text-indigo-100 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $vendor->contact_info }}
                            </p>
                        @endif
                        @if($vendor->description)
                            <p class="text-indigo-100 mt-3">{{ $vendor->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-6 text-center backdrop-blur-sm">
                    <p class="text-sm text-indigo-100 mb-1">Total Items</p>
                    <p class="text-4xl font-bold">{{ $vendor->menuItems->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-pulse">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-md">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-md">
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($vendor->menuItems->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-2xl font-semibold text-gray-900">No menu items available</h3>
                <p class="mt-2 text-gray-600">This vendor hasn't added any items yet. Check back soon!</p>
            </div>
        @else
            <!-- Shopping Cart Summary (Sticky) -->
            <div id="cart-summary" class="hidden fixed bottom-4 right-4 bg-white rounded-xl shadow-2xl p-6 w-80 border-4 border-indigo-500 z-50">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Your Order</h3>
                <div id="cart-items" class="space-y-2 mb-4 max-h-60 overflow-y-auto"></div>
                <div class="border-t-2 border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span id="cart-total" class="text-2xl font-bold text-indigo-600">₱0.00</span>
                    </div>
                    <button onclick="proceedToCheckout()" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                        Place Order
                    </button>
                    <button onclick="clearCart()" class="w-full mt-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition">
                        Clear Cart
                    </button>
                </div>
            </div>

            <!-- Menu Items by Category -->
            @php
                $groupedItems = $vendor->menuItems->groupBy('category');
            @endphp

            @foreach($groupedItems as $category => $items)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-3 border-b-4 border-indigo-500">
                        {{ $category ?: 'Other Items' }}
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($items as $item)
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
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 border border-gray-200 {{ !$item->is_available ? 'opacity-60' : '' }}">
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
                                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
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
                                    <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">{{ $item->description }}</p>
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-3xl font-bold text-indigo-600">₱{{ number_format($item->price, 2) }}</span>
                                    </div>

                                    @if($item->is_available)
                                        @auth
                                            @if(auth()->user()->isStudent())
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="decrementQuantity({{ $item->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-10 h-10 rounded-lg font-bold transition">
                                                        -
                                                    </button>
                                                    <input type="number" id="qty-{{ $item->id }}" value="0" min="0" max="99" 
                                                           class="w-16 text-center border-2 border-gray-300 rounded-lg py-2 font-bold"
                                                           onchange="updateQuantity({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})">
                                                    <button onclick="incrementQuantity({{ $item->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-10 h-10 rounded-lg font-bold transition">
                                                        +
                                                    </button>
                                                    <button onclick="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})" 
                                                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                                Login to Order
                                            </a>
                                        @endauth
                                    @else
                                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg text-center font-semibold">
                                            Currently Unavailable
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        let cart = [];

        function incrementQuantity(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 0;
            if (currentValue < 99) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 0;
            if (currentValue > 0) {
                input.value = currentValue - 1;
            }
        }

        function updateQuantity(itemId, itemName, price) {
            const qty = parseInt(document.getElementById(`qty-${itemId}`).value) || 0;
            if (qty > 0) {
                addToCart(itemId, itemName, price);
            }
        }

        function addToCart(itemId, itemName, price) {
            const qty = parseInt(document.getElementById(`qty-${itemId}`).value) || 0;
            
            if (qty <= 0) {
                alert('Please select a quantity greater than 0');
                return;
            }

            // Check if item already in cart
            const existingIndex = cart.findIndex(item => item.id === itemId);
            
            if (existingIndex >= 0) {
                cart[existingIndex].quantity = qty;
            } else {
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: price,
                    quantity: qty
                });
            }

            updateCartDisplay();
        }

        function updateCartDisplay() {
            const cartSummary = document.getElementById('cart-summary');
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            if (cart.length === 0) {
                cartSummary.classList.add('hidden');
                return;
            }

            cartSummary.classList.remove('hidden');

            let total = 0;
            let html = '';

            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                html += `
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex-1">
                            <span class="font-semibold">${item.quantity}x</span> ${item.name}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-indigo-600">₱${itemTotal.toFixed(2)}</span>
                            <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });

            cartItems.innerHTML = html;
            cartTotal.textContent = `₱${total.toFixed(2)}`;
        }

        function removeFromCart(index) {
            const item = cart[index];
            document.getElementById(`qty-${item.id}`).value = 0;
            cart.splice(index, 1);
            updateCartDisplay();
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                cart.forEach(item => {
                    document.getElementById(`qty-${item.id}`).value = 0;
                });
                cart = [];
                updateCartDisplay();
            }
        }

        function proceedToCheckout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            @guest
                window.location.href = '{{ route("login") }}';
                return;
            @endguest

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("orders.store") }}';

            // CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfInput);

            // Vendor ID
            const vendorInput = document.createElement('input');
            vendorInput.type = 'hidden';
            vendorInput.name = 'vendor_id';
            vendorInput.value = '{{ $vendor->id }}';
            form.appendChild(vendorInput);

            // Cart items
            cart.forEach((item, index) => {
                const itemIdInput = document.createElement('input');
                itemIdInput.type = 'hidden';
                itemIdInput.name = `items[${index}][menu_item_id]`;
                itemIdInput.value = item.id;
                form.appendChild(itemIdInput);

                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = `items[${index}][quantity]`;
                qtyInput.value = item.quantity;
                form.appendChild(qtyInput);
            });

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item - CampusEats</title>
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
            <div class="flex items-center">
                <a href="{{ route('vendor.menu-items.index') }}" class="mr-4 hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold">Add New Menu Item</h2>
                    <p class="mt-1 text-indigo-100">Create a new item for your menu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Item Details</h3>
                    
                    <form action="{{ route('vendor.menu-items.store') }}" method="POST">
                        @csrf
                        
                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Item Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   placeholder="e.g., Chicken Adobo">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                      placeholder="Describe your dish...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price and Category Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (₱) *</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                       placeholder="0.00">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <select name="category" id="category"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="">Select a category</option>
                                    <option value="Rice Meals" {{ old('category') == 'Rice Meals' ? 'selected' : '' }}>Rice Meals</option>
                                    <option value="Breakfast" {{ old('category') == 'Breakfast' ? 'selected' : '' }}>Breakfast</option>
                                    <option value="Main Dishes" {{ old('category') == 'Main Dishes' ? 'selected' : '' }}>Main Dishes</option>
                                    <option value="Noodles & Pasta" {{ old('category') == 'Noodles & Pasta' ? 'selected' : '' }}>Noodles & Pasta</option>
                                    <option value="Snacks" {{ old('category') == 'Snacks' ? 'selected' : '' }}>Snacks</option>
                                    <option value="Beverages" {{ old('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                    <option value="Desserts" {{ old('category') == 'Desserts' ? 'selected' : '' }}>Desserts</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mb-8">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}
                                       class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
                                <span class="ml-3 text-sm font-semibold text-gray-700">Item is available for ordering</span>
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-4">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                                Add Menu Item
                            </button>
                            <a href="{{ route('vendor.menu-items.index') }}" 
                               class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Templates Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">📋 Quick Templates</h3>
                    <p class="text-sm text-gray-600 mb-4">Click to use a template</p>
                    
                    <div class="space-y-3">
                        <!-- Rice Meal Template -->
                        <button onclick="useTemplate('Chicken Adobo', 'Classic Filipino chicken adobo with rice', '65.00', 'Rice Meals')"
                                class="w-full text-left p-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-lg hover:shadow-md transition">
                            <p class="font-semibold text-gray-900">🍛 Rice Meal</p>
                            <p class="text-xs text-gray-600 mt-1">Chicken Adobo - ₱65</p>
                        </button>

                        <!-- Breakfast Template -->
                        <button onclick="useTemplate('Tapsilog', 'Beef tapa, sinangag, and itlog', '75.00', 'Breakfast')"
                                class="w-full text-left p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg hover:shadow-md transition">
                            <p class="font-semibold text-gray-900">🍳 Breakfast</p>
                            <p class="text-xs text-gray-600 mt-1">Tapsilog - ₱75</p>
                        </button>

                        <!-- Snack Template -->
                        <button onclick="useTemplate('Lumpia Shanghai', 'Crispy spring rolls (5 pcs)', '35.00', 'Snacks')"
                                class="w-full text-left p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg hover:shadow-md transition">
                            <p class="font-semibold text-gray-900">🥟 Snack</p>
                            <p class="text-xs text-gray-600 mt-1">Lumpia - ₱35</p>
                        </button>

                        <!-- Beverage Template -->
                        <button onclick="useTemplate('Iced Coffee', 'Cold brewed coffee with milk', '35.00', 'Beverages')"
                                class="w-full text-left p-4 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-lg hover:shadow-md transition">
                            <p class="font-semibold text-gray-900">☕ Beverage</p>
                            <p class="text-xs text-gray-600 mt-1">Iced Coffee - ₱35</p>
                        </button>

                        <!-- Dessert Template -->
                        <button onclick="useTemplate('Halo-Halo', 'Filipino mixed dessert with ice', '50.00', 'Desserts')"
                                class="w-full text-left p-4 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-lg hover:shadow-md transition">
                            <p class="font-semibold text-gray-900">🍨 Dessert</p>
                            <p class="text-xs text-gray-600 mt-1">Halo-Halo - ₱50</p>
                        </button>
                    </div>

                    <div class="mt-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                        <p class="text-xs text-indigo-800">
                            <strong>💡 Tip:</strong> Templates help you add items faster. You can modify the details after clicking!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function useTemplate(name, description, price, category) {
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('category').value = category;
            
            // Scroll to form
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Highlight the name field
            document.getElementById('name').focus();
            document.getElementById('name').select();
        }
    </script>
</body>
</html>

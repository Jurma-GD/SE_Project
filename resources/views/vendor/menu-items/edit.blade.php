<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item - CampusEats</title>
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
                    <h2 class="text-3xl font-bold">Edit Menu Item</h2>
                    <p class="mt-1 text-indigo-100">Update item details</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('vendor.menu-items.update', $menuItem) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Item Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menuItem->name) }}" required
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
                              placeholder="Describe your dish...">{{ old('description', $menuItem->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Category Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (₱) *</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $menuItem->price) }}" step="0.01" min="0" required
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
                            <option value="Rice Meals" {{ old('category', $menuItem->category) == 'Rice Meals' ? 'selected' : '' }}>Rice Meals</option>
                            <option value="Breakfast" {{ old('category', $menuItem->category) == 'Breakfast' ? 'selected' : '' }}>Breakfast</option>
                            <option value="Main Dishes" {{ old('category', $menuItem->category) == 'Main Dishes' ? 'selected' : '' }}>Main Dishes</option>
                            <option value="Noodles & Pasta" {{ old('category', $menuItem->category) == 'Noodles & Pasta' ? 'selected' : '' }}>Noodles & Pasta</option>
                            <option value="Snacks" {{ old('category', $menuItem->category) == 'Snacks' ? 'selected' : '' }}>Snacks</option>
                            <option value="Beverages" {{ old('category', $menuItem->category) == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                            <option value="Desserts" {{ old('category', $menuItem->category) == 'Desserts' ? 'selected' : '' }}>Desserts</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Availability -->
                <div class="mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menuItem->is_available) ? 'checked' : '' }}
                               class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">Item is available for ordering</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                        Update Menu Item
                    </button>
                    <a href="{{ route('vendor.menu-items.index') }}" 
                       class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

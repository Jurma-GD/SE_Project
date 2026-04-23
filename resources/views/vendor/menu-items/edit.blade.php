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
            <form action="{{ route('vendor.menu-items.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="category" id="category" value="{{ old('category', $menuItem->category) }}"
                               list="category-suggestions" maxlength="100"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="e.g., Rice Meals, Snacks...">
                        <datalist id="category-suggestions">
                            @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                        @if($existingCategories->isNotEmpty())
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($existingCategories as $cat)
                                    <button type="button" onclick="document.getElementById('category').value='{{ $cat }}'"
                                            class="px-3 py-1 bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs rounded-full hover:bg-indigo-100 transition">
                                        {{ $cat }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Item Image</label>
                    <input type="hidden" name="remove_image" id="remove_image" value="0">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-indigo-400 transition">
                        @if($menuItem->image_url)
                            <img id="image-preview" src="{{ Storage::url($menuItem->image_url) }}" alt="Current image"
                                 class="mx-auto mb-3 h-40 w-full object-cover rounded-lg">
                        @else
                            <img id="image-preview" src="" alt="Preview" class="hidden mx-auto mb-3 h-40 w-full object-cover rounded-lg">
                        @endif
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp"
                               class="hidden" onchange="previewImage(this)">
                        <div class="flex items-center justify-center gap-3 flex-wrap">
                            <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-300 text-indigo-700 rounded-lg hover:bg-indigo-100 transition text-sm font-medium">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $menuItem->image_url ? 'Replace Image' : 'Choose Image' }}
                            </label>
                            @if($menuItem->image_url)
                                <button type="button" id="remove-btn" onclick="removeImage()"
                                        class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-300 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove Image
                                </button>
                            @endif
                        </div>
                        <p id="image-filename" class="mt-2 text-xs text-gray-500">JPEG, PNG, GIF, WebP — max 2MB</p>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const filename = document.getElementById('image-filename');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    filename.textContent = input.files[0].name;
                };
                reader.readAsDataURL(input.files[0]);
                // Cancel any pending removal
                document.getElementById('remove_image').value = '0';
            } else {
                preview.classList.add('hidden');
                preview.src = '';
                filename.textContent = 'JPEG, PNG, GIF, WebP — max 2MB';
            }
        }

        function removeImage() {
            document.getElementById('remove_image').value = '1';
            const preview = document.getElementById('image-preview');
            preview.classList.add('hidden');
            preview.src = '';
            document.getElementById('image').value = '';
            document.getElementById('image-filename').textContent = 'Image will be removed on save';
            const btn = document.getElementById('remove-btn');
            if (btn) btn.classList.add('hidden');
        }
    </script>
</body>
</html>

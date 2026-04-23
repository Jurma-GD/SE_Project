<!-- Results Summary -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">
        Found {{ $menuItems->count() }} item(s)
        @if(request('q'))
            for "<span style="color: #724e2c;">{{ request('q') }}</span>"
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
            <svg class="mx-auto h-16 w-16" style="color: #724e2c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <p class="text-lg font-bold" style="color: #724e2c;">{{ $item->vendor->vendor_name }}</p>
                            </div>
                            <a href="{{ route('vendors.show', $item->vendor) }}" class="text-sm font-semibold" style="color: #724e2c;">
                                View Vendor →
                            </a>
                        </div>
                        <p class="text-sm text-gray-600 flex items-center mt-1">
                            <svg class="h-4 w-4 mr-1" style="color: #724e2c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $item->vendor->location }}
                        </p>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">{{ $item->description }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl font-bold" style="color: #724e2c;">₱{{ number_format($item->price, 2) }}</span>
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

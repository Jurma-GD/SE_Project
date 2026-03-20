@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8" style="background: #f5efe8;">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-md mb-6">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Receipt Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

                <!-- Brown Header -->
                <div class="p-8 text-white" style="background: linear-gradient(135deg, #724e2c 0%, #563517 100%);">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-extrabold mb-1">Order Confirmed!</h1>
                            <p class="text-sm" style="color: #dfc3a9;">Your food is being prepared</p>
                        </div>
                        <!-- Order Number Badge -->
                        <div class="rounded-xl px-5 py-3 text-center" style="background: rgba(255,255,255,0.15);">
                            <p class="text-xs mb-1" style="color: #dfc3a9;">Order Number</p>
                            <p class="text-2xl font-bold">#{{ $order->order_number }}</p>
                        </div>
                    </div>

                    <!-- Status / Date Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.1);">
                            <p class="text-xs mb-2" style="color: #dfc3a9;">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-bold
                                @if($order->status === 'pending') bg-yellow-400 text-yellow-900
                                @elseif($order->status === 'ready') bg-green-400 text-green-900
                                @elseif($order->status === 'completed') bg-blue-300 text-blue-900
                                @else bg-gray-300 text-gray-900
                                @endif">
                                @if($order->status === 'pending') ⏳ Preparing
                                @elseif($order->status === 'ready') ✅ Ready for Pickup
                                @elseif($order->status === 'completed') 🎉 Completed
                                @else {{ ucfirst($order->status) }}
                                @endif
                            </span>
                        </div>
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.1);">
                            <p class="text-xs mb-2" style="color: #dfc3a9;">Date Placed</p>
                            <p class="text-sm font-semibold text-white">{{ $order->created_at->format('M d, Y') }}</p>
                            <p class="text-xs" style="color: #dfc3a9;">{{ $order->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Vendor / Location Grid -->
                <div class="grid grid-cols-2 gap-0 border-b" style="border-color: #dfc3a9;">
                    <div class="p-5 border-r" style="border-color: #dfc3a9; background: #fdf8f4;">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Vendor</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->vendor->vendor_name }}</p>
                    </div>
                    <div class="p-5" style="background: #fdf8f4;">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Pickup Location</p>
                        <p class="text-lg font-bold" style="color: #724e2c;">{{ $order->vendor->location }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Items</h2>
                    <div class="space-y-3">
                        @foreach($order->orderItems as $index => $item)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                                          style="background-color: #724e2c;">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->item_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }}x · ₱{{ number_format($item->price_at_order, 2) }} each</p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-900">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($order->notes)
                    <div class="px-6 pb-4">
                        <div class="rounded-lg p-4 border-l-4" style="background: #fdf8f4; border-color: #724e2c;">
                            <p class="text-xs font-bold text-gray-500 mb-1">Special Notes</p>
                            <p class="text-gray-800 text-sm">{{ $order->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Brown Total Bar -->
                <div class="px-6 py-5 flex justify-between items-center" style="background: linear-gradient(135deg, #724e2c 0%, #563517 100%);">
                    <span class="text-white text-lg font-bold">Total Amount</span>
                    <span class="text-white text-4xl font-extrabold">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="p-6 flex gap-3" style="background: #fdf8f4;">
                    <a href="{{ route('orders.my') }}"
                       class="flex-1 text-center px-6 py-3 rounded-xl font-semibold transition bg-gray-200 hover:bg-gray-300 text-gray-800">
                        ← My Orders
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex-1 text-center px-6 py-3 rounded-xl font-semibold text-white transition transform hover:scale-105 shadow-lg"
                       style="background: linear-gradient(135deg, #724e2c 0%, #563517 100%);">
                        Browse More →
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

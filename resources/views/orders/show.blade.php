@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-md mb-6 animate-fade-in">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Order Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-2xl shadow-2xl p-8 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-extrabold mb-2">Order Confirmed! 🎉</h1>
                        <p class="text-indigo-100 text-lg">Your food is being prepared</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 text-center">
                        <p class="text-xs text-indigo-100 mb-1">Order Number</p>
                        <p class="text-2xl font-bold">{{ $order->order_number }}</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        @if($order->status === 'pending') bg-yellow-400 text-yellow-900
                        @elseif($order->status === 'ready') bg-green-400 text-green-900 animate-pulse
                        @elseif($order->status === 'completed') bg-blue-400 text-blue-900
                        @else bg-gray-400 text-gray-900
                        @endif">
                        @if($order->status === 'pending') ⏳ Preparing Your Order
                        @elseif($order->status === 'ready') ✅ Ready for Pickup!
                        @elseif($order->status === 'completed') 🎉 Order Completed
                        @else {{ ucfirst($order->status) }}
                        @endif
                    </span>
                    <span class="text-indigo-100 text-sm">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-b-2xl shadow-2xl overflow-hidden">
                <!-- Vendor Information Section -->
                <div class="bg-gradient-to-r from-indigo-100 to-purple-100 p-6 border-b-2 border-indigo-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-indigo-600 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Vendor</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $order->vendor->vendor_name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 font-semibold flex items-center justify-end">
                                <svg class="h-5 w-5 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Pickup Location
                            </p>
                            <p class="text-lg font-bold text-indigo-600">{{ $order->vendor->location }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items Section -->
                <div class="p-6 bg-white">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        📋 Your Order Items
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border-2 border-indigo-200 shadow-md">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <div class="bg-indigo-600 text-white rounded-lg w-12 h-12 flex items-center justify-center font-bold text-xl shadow-lg flex-shrink-0">
                                            {{ $item->quantity }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-extrabold text-gray-900 text-xl mb-1">{{ $item->item_name }}</p>
                                            <p class="text-lg text-gray-800 font-bold">₱{{ number_format($item->price_at_order, 2) }} <span class="text-gray-600 font-semibold">each</span></p>
                                        </div>
                                    </div>
                                    <div class="text-right ml-4 flex-shrink-0">
                                        <p class="text-3xl font-extrabold text-indigo-600">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($order->notes)
                    <div class="px-6 pb-6">
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-4">
                            <p class="text-sm text-blue-900 font-semibold mb-1">📝 Special Notes:</p>
                            <p class="text-blue-800">{{ $order->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Total Section -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                    <div class="flex justify-between items-center">
                        <span class="text-white text-xl font-bold">Total Amount</span>
                        <span class="text-white text-4xl font-extrabold">₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-6 bg-gray-50 flex gap-3">
                    <a href="{{ route('orders.my') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-xl font-semibold text-center transition transform hover:scale-105">
                        ← Back to My Orders
                    </a>
                    <a href="{{ route('home') }}" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold text-center transition transform hover:scale-105 shadow-lg">
                        Continue Browsing →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


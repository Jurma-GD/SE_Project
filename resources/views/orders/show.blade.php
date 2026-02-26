@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="border-b pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
                <p class="text-gray-600 mt-1">Order Number: <span class="font-semibold">{{ $order->order_number }}</span></p>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-semibold">
                            <span class="px-3 py-1 rounded-full text-sm
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'ready') bg-green-100 text-green-800
                                @elseif($order->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vendor</p>
                        <p class="font-semibold">{{ $order->vendor->vendor_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-semibold">{{ $order->vendor->location }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Items</h2>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-center border-b pb-3">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $item->item_name }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</p>
                                <p class="text-sm text-gray-600">₱{{ number_format($item->price_at_order, 2) }} each</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-bold text-gray-800">Total Amount</p>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>

            @if($order->notes)
                <div class="mt-4 p-4 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600 font-semibold">Notes:</p>
                    <p class="text-gray-800">{{ $order->notes }}</p>
                </div>
            @endif

            <div class="mt-6 flex gap-3">
                <a href="{{ route('orders.my') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                    Back to My Orders
                </a>
                <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Continue Browsing
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


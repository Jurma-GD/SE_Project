@extends('layouts.app')

@section('content')
<style>
    /* ── Screen styles ── */
    .receipt-wrapper {
        min-height: 100vh;
        background: #f5efe8;
        padding: 32px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .receipt-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        width: 100%;
        max-width: 420px;
    }
    .btn-back {
        flex: 1;
        text-align: center;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        background: #fff;
        color: #724e2c;
        border: 1.5px solid #e8d5c4;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-back:hover { background: #fdf5ef; }
    .btn-print {
        flex: 1;
        text-align: center;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        background: #724e2c;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-print:hover { background: #563517; }
    .btn-browse {
        flex: 1;
        text-align: center;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        background: #fff;
        color: #724e2c;
        border: 1.5px solid #e8d5c4;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-browse:hover { background: #fdf5ef; }

    /* ── Receipt paper ── */
    .receipt {
        background: #fff;
        width: 100%;
        max-width: 420px;
        font-family: 'Courier New', Courier, monospace;
        box-shadow: 0 4px 24px rgba(114,78,44,0.15);
        position: relative;
    }
    /* Zigzag top edge */
    .receipt::before {
        content: '';
        display: block;
        height: 16px;
        background:
            linear-gradient(135deg, #f5efe8 25%, transparent 25%) -10px 0,
            linear-gradient(225deg, #f5efe8 25%, transparent 25%) -10px 0,
            linear-gradient(315deg, #f5efe8 25%, transparent 25%),
            linear-gradient(45deg,  #f5efe8 25%, transparent 25%);
        background-size: 20px 16px;
        background-color: #fff;
    }
    /* Zigzag bottom edge */
    .receipt::after {
        content: '';
        display: block;
        height: 16px;
        background:
            linear-gradient(135deg, transparent 25%, #f5efe8 25%) -10px 0,
            linear-gradient(225deg, transparent 25%, #f5efe8 25%) -10px 0,
            linear-gradient(315deg, transparent 25%, #f5efe8 25%),
            linear-gradient(45deg,  transparent 25%, #f5efe8 25%);
        background-size: 20px 16px;
        background-color: #fff;
    }
    .receipt-inner { padding: 8px 28px 20px; }
    .receipt-logo {
        text-align: center;
        padding: 16px 0 8px;
        border-bottom: 1px dashed #ccc;
        margin-bottom: 12px;
    }
    .receipt-logo .logo-emoji { font-size: 32px; }
    .receipt-logo .logo-name { font-size: 20px; font-weight: 900; color: #724e2c; letter-spacing: 2px; font-family: sans-serif; }
    .receipt-logo .logo-sub { font-size: 11px; color: #9e8a78; font-family: sans-serif; }
    .receipt-meta { font-size: 12px; color: #555; margin-bottom: 12px; }
    .receipt-meta table { width: 100%; border-collapse: collapse; }
    .receipt-meta td { padding: 2px 0; }
    .receipt-meta td:last-child { text-align: right; font-weight: 600; color: #3c3028; }
    .receipt-divider { border: none; border-top: 1px dashed #ccc; margin: 10px 0; }
    .receipt-status {
        text-align: center;
        margin: 8px 0 12px;
        font-family: sans-serif;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-pending  { background: #fef9c3; color: #854d0e; }
    .status-ready    { background: #dcfce7; color: #166534; }
    .status-completed{ background: #dbeafe; color: #1e40af; }
    .status-cancelled{ background: #f3f4f6; color: #374151; }

    .receipt-items { width: 100%; font-size: 13px; }
    .receipt-items thead tr { border-bottom: 1px solid #ccc; }
    .receipt-items th { font-size: 11px; text-transform: uppercase; color: #9e8a78; padding: 4px 0; font-weight: 700; }
    .receipt-items th:last-child, .receipt-items td:last-child { text-align: right; }
    .receipt-items th:nth-child(2), .receipt-items td:nth-child(2) { text-align: center; }
    .receipt-items td { padding: 5px 0; color: #3c3028; border-bottom: 1px dotted #eee; }
    .receipt-items td:first-child { font-weight: 600; }

    .receipt-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 2px solid #724e2c;
    }
    .receipt-total-label { font-size: 14px; font-weight: 700; color: #724e2c; font-family: sans-serif; }
    .receipt-total-amount { font-size: 24px; font-weight: 900; color: #724e2c; font-family: sans-serif; }

    .receipt-footer {
        text-align: center;
        margin-top: 16px;
        padding-top: 12px;
        border-top: 1px dashed #ccc;
        font-size: 11px;
        color: #9e8a78;
        font-family: sans-serif;
        line-height: 1.6;
    }
    .receipt-barcode {
        text-align: center;
        margin: 12px 0 4px;
        font-size: 36px;
        letter-spacing: 4px;
        color: #3c3028;
        font-family: 'Libre Barcode 39', monospace;
    }
    .receipt-order-num {
        text-align: center;
        font-size: 11px;
        color: #9e8a78;
        letter-spacing: 2px;
        font-family: sans-serif;
    }

    /* ── Print styles ── */
    @media print {
        body * { visibility: hidden; }
        .receipt, .receipt * { visibility: visible; }
        .receipt {
            position: fixed;
            top: 0; left: 50%;
            transform: translateX(-50%);
            box-shadow: none;
            max-width: 380px;
            width: 380px;
        }
        .receipt::before, .receipt::after { display: none; }
        .receipt-actions { display: none !important; }
        @page { margin: 0; size: 80mm auto; }
    }
</style>

<div class="receipt-wrapper">

    @if(session('success'))
        <div style="max-width:420px; width:100%; background:#f0fdf4; border-left:4px solid #22c55e; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px; color:#166534;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Top nav row: My Orders (left) | Browse More (right) -->
    <div style="max-width:420px; width:100%; display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:20px;">
        <a href="{{ route('orders.my') }}" class="btn-back">← My Orders</a>
        <a href="{{ route('home') }}" class="btn-browse">Browse More →</a>
    </div>

    <!-- Receipt -->
    <div class="receipt">
        <div class="receipt-inner">

            <!-- Logo -->
            <div class="receipt-logo">
                <div class="logo-emoji">🍽️</div>
                <div class="logo-name">CAMPUSEATS</div>
                <div class="logo-sub">Your Campus Food Hub</div>
            </div>

            <!-- Meta -->
            <div class="receipt-meta">
                <table>
                    <tr>
                        <td>Order #</td>
                        <td>#{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>{{ $order->created_at->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Vendor</td>
                        <td>{{ $order->vendor->vendor_name }}</td>
                    </tr>
                    <tr>
                        <td>Pickup at</td>
                        <td>{{ $order->vendor->location }}</td>
                    </tr>
                </table>
            </div>

            <!-- Status -->
            <div class="receipt-status">
                @php
                    $statusClass = match($order->status) {
                        'pending'   => 'status-pending',
                        'ready'     => 'status-ready',
                        'completed' => 'status-completed',
                        default     => 'status-cancelled',
                    };
                    $statusLabel = match($order->status) {
                        'pending'   => '⏳ Preparing',
                        'ready'     => '✅ Ready for Pickup',
                        'completed' => '🎉 Completed',
                        default     => ucfirst($order->status),
                    };
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            <hr class="receipt-divider">

            <!-- Items -->
            <table class="receipt-items">
                <thead>
                    <tr>
                        <th style="text-align:left;">Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td style="text-align:center;">{{ $item->quantity }}</td>
                            <td style="text-align:right;">₱{{ number_format($item->price_at_order, 2) }}</td>
                            <td style="text-align:right;">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($order->notes)
                <hr class="receipt-divider">
                <div style="font-size:12px; color:#555;">
                    <span style="font-weight:700; color:#724e2c;">Note: </span>{{ $order->notes }}
                </div>
            @endif

            <!-- Total -->
            <div class="receipt-total-row">
                <span class="receipt-total-label">TOTAL</span>
                <span class="receipt-total-amount">₱{{ number_format($order->total_amount, 2) }}</span>
            </div>

            <!-- Barcode-style order number -->
            <div class="receipt-barcode">||||| ||||| |||||</div>
            <div class="receipt-order-num">{{ $order->order_number }}</div>

            <!-- Footer -->
            <div class="receipt-footer">
                <p>Thank you for ordering at CampusEats!</p>
                <p>Please present this receipt when picking up your order.</p>
                <p style="margin-top:6px;">{{ now()->format('Y') }} © CampusEats</p>
            </div>

        </div>
    </div>

    <!-- Print Receipt button below the receipt -->
    <div style="max-width:420px; width:100%; margin-top:20px;">
        <button onclick="window.print()" class="btn-print" style="width:100%; padding:14px; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px; border-radius:12px;">
            🖨 Print Receipt
        </button>
    </div>

</div>
@endsection

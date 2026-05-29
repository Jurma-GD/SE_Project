<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders — CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background: #f5efe8; font-family: system-ui, -apple-system, sans-serif; margin: 0; }

        .top-nav {
            background: #fff; border-bottom: 3px solid #724e2c;
            position: sticky; top: 0; z-index: 50;
            padding: 0 24px; display: flex; align-items: center; justify-content: space-between; height: 56px;
        }
        .nav-brand { font-size: 18px; font-weight: 800; color: #724e2c; text-decoration: none; }
        .nav-links { display: flex; gap: 4px; }
        .nav-link { padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; color: #5c4a3a; text-decoration: none; transition: background 0.15s; }
        .nav-link:hover { background: #fdf5ef; }
        .nav-link.active { background: #fdf0e6; color: #724e2c; font-weight: 700; }
        .nav-right { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #5c4a3a; }
        .nav-logout { background: none; border: none; font-size: 13px; color: #9e8a78; cursor: pointer; font-weight: 500; }
        .nav-logout:hover { color: #724e2c; }

        .hero {
            background: linear-gradient(135deg, #724e2c 0%, #563517 100%);
            padding: 32px 24px 52px; position: relative;
        }
        .hero::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 32px;
            background: #f5efe8; clip-path: ellipse(55% 100% at 50% 100%);
        }
        .hero-inner { max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .hero-title { font-size: 28px; font-weight: 800; color: #fff; margin: 0 0 4px; }
        .hero-sub { font-size: 14px; color: #dfc3a9; margin: 0; }

        .page { max-width: 1400px; margin: 0 auto; padding: 28px clamp(16px, 4vw, 48px) 64px; }

        .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }

        /* Filter tabs */
        .filter-tabs { display: flex; gap: 8px; margin-bottom: 24px; background: #fff; padding: 6px; border-radius: 12px; box-shadow: 0 1px 4px rgba(114,78,44,0.08); }
        .filter-tab { flex: 1; text-align: center; padding: 9px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #5c4a3a; transition: background 0.15s; }
        .filter-tab:hover { background: #fdf5ef; }
        .filter-tab.active-all    { background: #724e2c; color: #fff; }
        .filter-tab.active-pending  { background: #f59e0b; color: #fff; }
        .filter-tab.active-ready    { background: #22c55e; color: #fff; }
        .filter-tab.active-completed{ background: #3b82f6; color: #fff; }

        /* Order cards */
        .order-card {
            background: #fff; border-radius: 14px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08), 0 4px 16px rgba(114,78,44,0.05);
            border-left: 5px solid transparent;
            margin-bottom: 16px;
        }
        .order-card.pending   { border-left-color: #f59e0b; }
        .order-card.ready     { border-left-color: #22c55e; }
        .order-card.completed { border-left-color: #3b82f6; }

        .order-header { padding: 18px 20px 14px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .order-num { font-size: 18px; font-weight: 800; color: #3c3028; margin: 0 0 4px; }
        .order-meta { font-size: 13px; color: #5c4a3a; margin: 0 0 2px; }
        .order-time { font-size: 12px; color: #9e8a78; margin: 0; }
        .order-right { text-align: right; flex-shrink: 0; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .status-pending   { background: #fef9c3; color: #854d0e; }
        .status-ready     { background: #dcfce7; color: #166534; }
        .status-completed { background: #dbeafe; color: #1e40af; }
        .order-total { font-size: 22px; font-weight: 800; color: #724e2c; margin: 6px 0 0; }

        .order-items { background: #fdf8f4; margin: 0 20px 14px; border-radius: 10px; padding: 12px 16px; }
        .order-items-title { font-size: 11px; font-weight: 700; color: #9e8a78; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 10px; }
        .order-item-row { display: flex; align-items: center; justify-content: space-between; padding: 5px 0; border-bottom: 1px dotted #e8d5c4; }
        .order-item-row:last-child { border-bottom: none; }
        .order-item-left { display: flex; align-items: center; gap: 10px; }
        .qty-badge { background: #724e2c; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 999px; }
        .item-name { font-size: 13px; font-weight: 600; color: #3c3028; }
        .item-subtotal { font-size: 13px; font-weight: 700; color: #724e2c; }

        .order-note { margin: 0 20px 14px; background: #fdf5ef; border-left: 3px solid #724e2c; border-radius: 0 8px 8px 0; padding: 10px 14px; font-size: 13px; color: #5c4a3a; }

        .order-actions { padding: 0 20px 18px; display: flex; gap: 10px; }
        .btn-ready { flex: 1; background: #22c55e; color: #fff; border: none; padding: 11px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.15s; }
        .btn-ready:hover { background: #16a34a; }
        .btn-complete { flex: 1; background: #3b82f6; color: #fff; border: none; padding: 11px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.15s; }
        .btn-complete:hover { background: #2563eb; }
        .btn-done { flex: 1; background: #f3f4f6; color: #6b7280; padding: 11px; border-radius: 10px; font-size: 14px; font-weight: 600; text-align: center; }

        .empty-state { background: #fff; border-radius: 16px; padding: 64px 24px; text-align: center; box-shadow: 0 1px 4px rgba(114,78,44,0.08); }

        @media (max-width: 480px) {
            .filter-tabs { flex-wrap: wrap; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <nav class="top-nav">
        <div style="display:flex; align-items:center; gap:24px;">
            <a href="{{ route('vendor.dashboard') }}" class="nav-brand">🍽️ CampusEats</a>
            <div class="nav-links">
                <a href="{{ route('vendor.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('vendor.menu-items.index') }}" class="nav-link">Menu Items</a>
                <a href="{{ route('vendor.orders') }}" class="nav-link active">Orders</a>
                <a href="{{ route('vendor.profile') }}" class="nav-link">Profile</a>
            </div>
        </div>
        <div class="nav-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-inner">
            <div>
                <h1 class="hero-title">Order Queue</h1>
                <p class="hero-sub">Manage and fulfill incoming orders</p>
            </div>
            @if($orders->total() > 0)
                <div style="background:rgba(255,255,255,0.15); border-radius:12px; padding:14px 20px; text-align:center; flex-shrink:0;">
                    <p style="font-size:11px; color:#dfc3a9; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin:0 0 4px;">Total Orders</p>
                    <p style="font-size:28px; font-weight:800; color:#fff; margin:0;">{{ $orders->total() }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="page">

        @if(session('success'))
            <div class="flash-success">✓ {{ session('success') }}</div>
        @endif

        <!-- Filter tabs -->
        <div class="filter-tabs">
            @php $status = request('status'); @endphp
            <a href="{{ route('vendor.orders') }}"
               class="filter-tab {{ !$status ? 'active-all' : '' }}">All Orders</a>
            <a href="{{ route('vendor.orders', ['status' => 'pending']) }}"
               class="filter-tab {{ $status === 'pending' ? 'active-pending' : '' }}">⏳ Pending</a>
            <a href="{{ route('vendor.orders', ['status' => 'ready']) }}"
               class="filter-tab {{ $status === 'ready' ? 'active-ready' : '' }}">✅ Ready</a>
            <a href="{{ route('vendor.orders', ['status' => 'completed']) }}"
               class="filter-tab {{ $status === 'completed' ? 'active-completed' : '' }}">🎉 Completed</a>
        </div>

        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="order-card {{ $order->status }}">

                    <div class="order-header">
                        <div>
                            <p class="order-num">#{{ $order->order_number }}</p>
                            <p class="order-meta">👤 {{ $order->user->name }}</p>
                            <p class="order-time">{{ $order->created_at->format('M d, Y · h:i A') }}</p>
                        </div>
                        <div class="order-right">
                            <span class="status-badge status-{{ $order->status }}">
                                @if($order->status === 'pending') ⏳ Preparing
                                @elseif($order->status === 'ready') ✅ Ready
                                @else 🎉 Completed
                                @endif
                            </span>
                            <p class="order-total">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="order-items">
                        <p class="order-items-title">Items Ordered</p>
                        @foreach($order->orderItems as $item)
                            <div class="order-item-row">
                                <div class="order-item-left">
                                    <span class="qty-badge">{{ $item->quantity }}x</span>
                                    <span class="item-name">{{ $item->item_name }}</span>
                                </div>
                                <span class="item-subtotal">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if($order->notes)
                        <div class="order-note"><strong>Note:</strong> {{ $order->notes }}</div>
                    @endif

                    <div class="order-actions">
                        @if($order->status === 'pending')
                            <form action="{{ route('vendor.orders.ready', $order) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn-ready" style="width:100%;">Mark as Ready ✅</button>
                            </form>
                        @elseif($order->status === 'ready')
                            <form action="{{ route('vendor.orders.complete', $order) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn-complete" style="width:100%;">Mark as Completed 🎉</button>
                            </form>
                        @else
                            <div class="btn-done">Order Completed ✓</div>
                        @endif
                    </div>

                </div>
            @endforeach

            <div style="margin-top:24px;">{{ $orders->links() }}</div>

        @else
            <div class="empty-state">
                <div style="font-size:56px; margin-bottom:16px;">📋</div>
                <h3 style="font-size:20px; font-weight:700; color:#3c3028; margin:0 0 8px;">No orders found</h3>
                <p style="font-size:14px; color:#9e8a78; margin:0;">
                    @if(request('status'))
                        No {{ request('status') }} orders at the moment.
                    @else
                        You don't have any orders yet.
                    @endif
                </p>
            </div>
        @endif

    </div>

    <footer style="text-align:center; padding:24px; font-size:12px; color:#9e8a78;">
        © 2026 CampusEats — Manage your menu and orders efficiently.
    </footer>

</body>
</html>

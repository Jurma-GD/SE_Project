<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items — CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { box-sizing: border-box; }
        body { background: #f5efe8; font-family: system-ui, -apple-system, sans-serif; margin: 0; }

        /* ── Nav ── */
        .top-nav {
            background: #fff;
            border-bottom: 3px solid #724e2c;
            position: sticky; top: 0; z-index: 50;
            padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between;
            height: 56px;
        }
        .nav-brand { font-size: 18px; font-weight: 800; color: #724e2c; text-decoration: none; }
        .nav-links { display: flex; gap: 4px; }
        .nav-link {
            padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 500;
            color: #5c4a3a; text-decoration: none; transition: background 0.15s;
        }
        .nav-link:hover { background: #fdf5ef; }
        .nav-link.active { background: #fdf0e6; color: #724e2c; font-weight: 700; }
        .nav-right { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #5c4a3a; }
        .nav-logout { background: none; border: none; font-size: 13px; color: #9e8a78; cursor: pointer; font-weight: 500; }
        .nav-logout:hover { color: #724e2c; }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, #724e2c 0%, #563517 100%);
            padding: 32px 24px 48px;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 32px;
            background: #f5efe8;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .hero-inner {
            max-width: 1400px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .hero-title { font-size: 28px; font-weight: 800; color: #fff; margin: 0 0 4px; }
        .hero-sub { font-size: 14px; color: #dfc3a9; margin: 0; }
        .btn-add {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; color: #724e2c;
            padding: 10px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: background 0.15s, transform 0.1s;
            white-space: nowrap;
        }
        .btn-add:hover { background: #fdf5ef; transform: translateY(-1px); }

        /* ── Page ── */
        .page { max-width: 1400px; margin: 0 auto; padding: 28px clamp(16px, 4vw, 48px) 64px; }

        /* ── Stats ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08);
            border-left: 4px solid transparent;
        }
        .stat-label { font-size: 12px; color: #9e8a78; font-weight: 600; margin-bottom: 4px; }
        .stat-value { font-size: 28px; font-weight: 800; }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }

        /* ── Menu grid ── */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .menu-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08), 0 4px 16px rgba(114,78,44,0.05);
            border: 1px solid #f0e6dc;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .menu-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(114,78,44,0.15); }
        .menu-card-img {
            position: relative; height: 180px; overflow: hidden;
        }
        .menu-card-img img {
            width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;
        }
        .menu-card-img .emoji-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 64px;
        }
        .menu-card-img .img-overlay {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.65), transparent);
            padding: 12px;
        }
        .menu-card-img .item-name {
            color: #fff; font-size: 16px; font-weight: 700; margin: 0;
        }
        .avail-badge {
            position: absolute; top: 10px; right: 10px;
            font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
        }
        .cat-badge {
            position: absolute; top: 10px; left: 10px;
            font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
            background: rgba(255,255,255,0.9); color: #724e2c;
        }
        .menu-card-body { padding: 14px 16px 16px; }
        .item-desc { font-size: 13px; color: #5c4a3a; margin: 0 0 10px; height: 36px; overflow: hidden; }
        .item-price { font-size: 22px; font-weight: 800; color: #724e2c; margin: 0 0 14px; }
        .item-actions { display: flex; gap: 8px; }
        .btn-toggle-avail {
            flex: 1; padding: 8px 10px; border-radius: 8px; border: none;
            font-size: 12px; font-weight: 700; cursor: pointer; transition: background 0.15s;
        }
        .btn-edit {
            padding: 8px 14px; border-radius: 8px;
            background: #fdf0e6; color: #724e2c;
            font-size: 12px; font-weight: 700; text-decoration: none;
            transition: background 0.15s;
        }
        .btn-edit:hover { background: #f5e0cc; }
        .btn-delete {
            padding: 8px 14px; border-radius: 8px; border: none;
            background: #fef2f2; color: #dc2626;
            font-size: 12px; font-weight: 700; cursor: pointer;
            transition: background 0.15s;
        }
        .btn-delete:hover { background: #fee2e2; }

        /* ── Flash ── */
        .flash-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
            border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 600;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        /* ── Empty state ── */
        .empty-state {
            background: #fff; border-radius: 16px; padding: 64px 24px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08);
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-inner { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- Nav -->
    <nav class="top-nav">
        <div style="display:flex; align-items:center; gap:24px;">
            <a href="{{ route('vendor.dashboard') }}" class="nav-brand">🍽️ CampusEats</a>
            <div class="nav-links">
                <a href="{{ route('vendor.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('vendor.menu-items.index') }}" class="nav-link active">Menu Items</a>
                <a href="{{ route('vendor.orders') }}" class="nav-link">Orders</a>
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

    <!-- Hero -->
    <div class="hero">
        <div class="hero-inner">
            <div>
                <h1 class="hero-title">Menu Items</h1>
                <p class="hero-sub">Manage your menu offerings</p>
            </div>
            <a href="{{ route('vendor.menu-items.create') }}" class="btn-add">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Item
            </a>
        </div>
    </div>

    <div class="page">

        @if(session('success'))
            <div class="flash-success">✓ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: #724e2c;">
                <div>
                    <p class="stat-label">Total Items</p>
                    <p class="stat-value" style="color:#724e2c;">{{ $menuItems->total() }}</p>
                </div>
                <div class="stat-icon" style="background:#fdf0e6;">🍽️</div>
            </div>
            <div class="stat-card" style="border-left-color: #22c55e;">
                <div>
                    <p class="stat-label">Available</p>
                    <p class="stat-value" style="color:#16a34a;">{{ $menuItems->where('is_available', true)->count() }}</p>
                </div>
                <div class="stat-icon" style="background:#f0fdf4;">✅</div>
            </div>
            <div class="stat-card" style="border-left-color: #ef4444;">
                <div>
                    <p class="stat-label">Unavailable</p>
                    <p class="stat-value" style="color:#dc2626;">{{ $menuItems->where('is_available', false)->count() }}</p>
                </div>
                <div class="stat-icon" style="background:#fef2f2;">❌</div>
            </div>
            <div class="stat-card" style="border-left-color: #a78bfa;">
                <div>
                    <p class="stat-label">Categories</p>
                    <p class="stat-value" style="color:#7c3aed;">{{ $menuItems->pluck('category')->unique()->filter()->count() }}</p>
                </div>
                <div class="stat-icon" style="background:#f5f3ff;">🏷️</div>
            </div>
        </div>

        @if($menuItems->count() > 0)
            <div class="menu-grid">
                @foreach($menuItems as $item)
                    @php
                        $colors = [
                            'Rice Meals'     => 'FFB84D',
                            'Breakfast'      => '4ECDC4',
                            'Main Dishes'    => 'FF6B6B',
                            'Noodles & Pasta'=> 'F7B731',
                            'Snacks'         => '5F27CD',
                            'Beverages'      => '00D2D3',
                            'Desserts'       => 'FF9FF3',
                        ];
                        $emojis = [
                            'Rice Meals'     => '🍛',
                            'Breakfast'      => '🍳',
                            'Main Dishes'    => '🍖',
                            'Noodles & Pasta'=> '🍜',
                            'Snacks'         => '🥟',
                            'Beverages'      => '🥤',
                            'Desserts'       => '🍨',
                        ];
                        $bg    = $colors[$item->category] ?? '6366F1';
                        $emoji = $emojis[$item->category] ?? '🍽️';
                    @endphp
                    <div class="menu-card">
                        <div class="menu-card-img" style="background: linear-gradient(135deg, #{{ $bg }}22, #{{ $bg }}55);">
                            @if($item->image_url)
                                <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}"
                                     style="object-position: {{ $item->image_position ?? 'center center' }}">
                            @else
                                <div class="emoji-placeholder">{{ $emoji }}</div>
                            @endif

                            <span class="avail-badge" style="{{ $item->is_available ? 'background:#22c55e; color:#fff;' : 'background:#ef4444; color:#fff;' }}">
                                {{ $item->is_available ? 'Available' : 'Unavailable' }}
                            </span>

                            @if($item->category)
                                <span class="cat-badge">{{ $item->category }}</span>
                            @endif

                            <div class="img-overlay">
                                <p class="item-name">{{ $item->name }}</p>
                            </div>
                        </div>

                        <div class="menu-card-body">
                            <p class="item-desc">{{ $item->description }}</p>
                            <p class="item-price">₱{{ number_format($item->price, 2) }}</p>
                            <div class="item-actions">
                                <button onclick="toggleAvailability({{ $item->id }}, {{ $item->is_available ? 'false' : 'true' }})"
                                        class="btn-toggle-avail"
                                        style="{{ $item->is_available ? 'background:#fef9c3; color:#854d0e;' : 'background:#dcfce7; color:#166534;' }}">
                                    {{ $item->is_available ? 'Mark Unavailable' : 'Mark Available' }}
                                </button>
                                <a href="{{ route('vendor.menu-items.edit', $item) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('vendor.menu-items.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Delete {{ addslashes($item->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top:28px;">
                {{ $menuItems->links() }}
            </div>

        @else
            <div class="empty-state">
                <div style="font-size:64px; margin-bottom:16px;">🍽️</div>
                <h3 style="font-size:20px; font-weight:700; color:#3c3028; margin:0 0 8px;">No menu items yet</h3>
                <p style="font-size:14px; color:#9e8a78; margin:0 0 24px;">Get started by adding your first menu item!</p>
                <a href="{{ route('vendor.menu-items.create') }}" class="btn-add" style="display:inline-flex;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Your First Item
                </a>
            </div>
        @endif

    </div>

    <footer style="text-align:center; padding:24px; font-size:12px; color:#9e8a78;">
        © 2026 CampusEats — Manage your menu and orders efficiently.
    </footer>

    <script>
        function toggleAvailability(itemId, newStatus) {
            fetch('/vendor/menu-items/' + itemId + '/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_available: newStatus })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) { if (data.success) location.reload(); })
            .catch(function(e) { console.error(e); });
        }
    </script>
</body>
</html>

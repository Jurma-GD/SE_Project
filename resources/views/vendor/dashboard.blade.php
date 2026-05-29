<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            padding: 36px 24px 52px;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 32px;
            background: #f5efe8;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .hero-inner { max-width: 1400px; margin: 0 auto; }
        .hero-greeting { font-size: 13px; color: #dfc3a9; font-weight: 600; margin: 0 0 6px; letter-spacing: 0.04em; text-transform: uppercase; }
        .hero-name { font-size: 30px; font-weight: 800; color: #fff; margin: 0 0 6px; }
        .hero-sub { font-size: 14px; color: #dfc3a9; margin: 0; }

        /* ── Page ── */
        .page { max-width: 1400px; margin: 0 auto; padding: 28px clamp(16px, 4vw, 48px) 64px; }

        /* ── Stats ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: clamp(20px, 3vw, 32px) clamp(20px, 3vw, 32px);
            box-shadow: 0 1px 4px rgba(114,78,44,0.08);
            border-left: 4px solid transparent;
            display: flex; flex-direction: column; justify-content: space-between;
            gap: 16px;
        }
        .stat-top { display: flex; align-items: flex-start; justify-content: space-between; }
        .stat-label { font-size: 13px; color: #9e8a78; font-weight: 600; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 0.04em; }
        .stat-value { font-size: clamp(32px, 4vw, 48px); font-weight: 800; margin: 0; line-height: 1; }
        .stat-icon { width: clamp(48px, 5vw, 64px); height: clamp(48px, 5vw, 64px); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: clamp(22px, 2.5vw, 30px); flex-shrink: 0; }
        .stat-link { font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .stat-link:hover { text-decoration: underline; }

        /* ── Two-col layout ── */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }

        /* ── Cards ── */
        .card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08), 0 4px 16px rgba(114,78,44,0.05);
            overflow: hidden;
        }
        .card-header {
            padding: clamp(18px, 2.5vw, 28px) clamp(20px, 2.5vw, 32px) 0;
            display: flex; align-items: center; gap: 12px;
        }
        .card-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: #fdf0e6; display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .card-title { font-size: 17px; font-weight: 700; color: #3c3028; margin: 0; }
        .card-subtitle { font-size: 13px; color: #9e8a78; margin: 2px 0 0; }
        .card-body { padding: clamp(16px, 2vw, 24px) clamp(20px, 2.5vw, 32px) clamp(20px, 2.5vw, 32px); }

        /* ── Quick actions ── */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .action-btn {
            display: flex; align-items: center; gap: 12px;
            padding: clamp(14px, 2vw, 20px) clamp(14px, 2vw, 20px); border-radius: 14px;
            text-decoration: none; font-size: 14px; font-weight: 600;
            transition: background 0.15s, transform 0.1s;
            border: 1.5px solid transparent;
        }
        .action-btn:hover { transform: translateY(-1px); }
        .action-btn .action-icon { font-size: clamp(20px, 2.5vw, 28px); flex-shrink: 0; }
        .action-btn .action-text { font-size: 14px; font-weight: 700; }
        .action-btn .action-sub { font-size: 12px; opacity: 0.7; margin-top: 2px; }
        .action-primary {
            background: #724e2c; color: #fff;
            box-shadow: 0 2px 8px rgba(114,78,44,0.25);
        }
        .action-primary:hover { background: #563517; }
        .action-secondary {
            background: #fdf5ef; color: #724e2c;
            border-color: #e8d5c4;
        }
        .action-secondary:hover { background: #fdf0e6; }

        /* ── Vendor info ── */
        .info-row {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 12px 0; border-bottom: 1px solid #f5ede6;
        }
        .info-row:last-child { border-bottom: none; }
        .info-icon { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
        .info-label { font-size: 11px; font-weight: 700; color: #9e8a78; text-transform: uppercase; letter-spacing: 0.04em; margin: 0 0 2px; }
        .info-value { font-size: 14px; font-weight: 600; color: #3c3028; margin: 0; }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .two-col { grid-template-columns: 1fr; }
            .actions-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
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
                <a href="{{ route('vendor.dashboard') }}" class="nav-link active">Dashboard</a>
                <a href="{{ route('vendor.menu-items.index') }}" class="nav-link">Menu Items</a>
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
            <p class="hero-greeting">Welcome back</p>
            <h1 class="hero-name">{{ $vendor->vendor_name }} 👋</h1>
            <p class="hero-sub">Here's what's happening with your store today.</p>
        </div>
    </div>

    <div class="page">

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: #724e2c;">
                <div class="stat-top">
                    <div>
                        <p class="stat-label">Menu Items</p>
                        <p class="stat-value" style="color:#724e2c;">{{ $totalItems }}</p>
                    </div>
                    <div class="stat-icon" style="background:#fdf0e6;">🍽️</div>
                </div>
                <a href="{{ route('vendor.menu-items.index') }}" class="stat-link" style="color:#724e2c;">Manage items →</a>
            </div>

            <div class="stat-card" style="border-left-color: #f59e0b;">
                <div class="stat-top">
                    <div>
                        <p class="stat-label">Pending Orders</p>
                        <p class="stat-value" style="color:#d97706;">{{ $pendingOrders }}</p>
                    </div>
                    <div class="stat-icon" style="background:#fffbeb;">⏳</div>
                </div>
                <a href="{{ route('vendor.orders') }}" class="stat-link" style="color:#d97706;">View orders →</a>
            </div>

            <div class="stat-card" style="border-left-color: #22c55e;">
                <div class="stat-top">
                    <div>
                        <p class="stat-label">Location</p>
                        <p style="font-size:16px; font-weight:700; color:#3c3028; margin:4px 0 0; line-height:1.3;">{{ $vendor->location }}</p>
                    </div>
                    <div class="stat-icon" style="background:#f0fdf4;">📍</div>
                </div>
                <a href="{{ route('vendor.profile') }}" class="stat-link" style="color:#16a34a;">Update profile →</a>
            </div>
        </div>

        <!-- Two-col: Quick Actions + Vendor Info -->
        <div class="two-col">

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">⚡</div>
                    <div>
                        <p class="card-title">Quick Actions</p>
                        <p class="card-subtitle">Common tasks at a glance</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="actions-grid">
                        <a href="{{ route('vendor.menu-items.create') }}" class="action-btn action-primary">
                            <span class="action-icon">➕</span>
                            <div>
                                <div class="action-text">Add Item</div>
                                <div class="action-sub">New menu item</div>
                            </div>
                        </a>
                        <a href="{{ route('vendor.orders') }}" class="action-btn action-secondary">
                            <span class="action-icon">📋</span>
                            <div>
                                <div class="action-text">Orders</div>
                                <div class="action-sub">Manage orders</div>
                            </div>
                        </a>
                        <a href="{{ route('vendor.menu-items.index') }}" class="action-btn action-secondary">
                            <span class="action-icon">🍽️</span>
                            <div>
                                <div class="action-text">Menu Items</div>
                                <div class="action-sub">View all items</div>
                            </div>
                        </a>
                        <a href="{{ route('vendor.profile') }}" class="action-btn action-secondary">
                            <span class="action-icon">✏️</span>
                            <div>
                                <div class="action-text">Edit Profile</div>
                                <div class="action-sub">Update info</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vendor Info -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🏪</div>
                    <div>
                        <p class="card-title">Store Information</p>
                        <p class="card-subtitle">Your current profile details</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-icon">🍽️</span>
                        <div>
                            <p class="info-label">Vendor Name</p>
                            <p class="info-value">{{ $vendor->vendor_name }}</p>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">📍</span>
                        <div>
                            <p class="info-label">Location</p>
                            <p class="info-value">{{ $vendor->location }}</p>
                        </div>
                    </div>
                    @if($vendor->contact_info)
                    <div class="info-row">
                        <span class="info-icon">📞</span>
                        <div>
                            <p class="info-label">Contact</p>
                            <p class="info-value">{{ $vendor->contact_info }}</p>
                        </div>
                    </div>
                    @endif
                    @if($vendor->description)
                    <div class="info-row">
                        <span class="info-icon">📝</span>
                        <div>
                            <p class="info-label">Description</p>
                            <p class="info-value" style="font-weight:500; font-size:13px; color:#5c4a3a;">{{ $vendor->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <footer style="text-align:center; padding:24px; font-size:12px; color:#9e8a78;">
        © 2026 CampusEats — Manage your menu and orders efficiently.
    </footer>

</body>
</html>

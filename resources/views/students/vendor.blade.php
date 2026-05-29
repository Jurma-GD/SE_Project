<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vendor->vendor_name }} - CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { display: flex; flex-direction: column; min-height: 100vh; }
        #page-body { display: flex; flex: 1; }

        /* ── Sidebar (desktop) ── */
        #category-sidebar {
            width: 220px;
            min-width: 220px;
            background: #fff;
            border-right: 1px solid #e8e0d8;
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            padding: 24px 0;
            flex-shrink: 0;
            align-self: flex-start;
        }
        #category-sidebar .sidebar-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9e8a78;
            padding: 0 20px 14px;
            display: block;
        }
        .category-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #3c3028;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            cursor: pointer;
        }
        .category-link:hover { background: #fdf5ef; }
        .category-link.active {
            border-left-color: #724e2c;
            background: #fdf0e6;
            color: #724e2c;
            font-weight: 700;
        }
        .category-link .cat-count {
            font-size: 12px;
            color: #9e8a78;
            font-weight: 400;
        }

        /* ── Mobile category bar ── */
        #mobile-cat-bar {
            display: none;
            overflow-x: auto;
            white-space: nowrap;
            background: #fff;
            border-bottom: 1px solid #e8e0d8;
            padding: 10px 16px;
            gap: 8px;
            position: sticky;
            top: 56px;
            z-index: 40;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        #mobile-cat-bar::-webkit-scrollbar { display: none; }
        .mobile-cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1.5px solid #e8e0d8;
            font-size: 13px;
            font-weight: 500;
            color: #3c3028;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
        }
        .mobile-cat-pill:hover { background: #fdf5ef; }
        .mobile-cat-pill.active {
            background: #724e2c;
            border-color: #724e2c;
            color: #fff;
            font-weight: 700;
        }
        .mobile-cat-pill .cat-count {
            font-size: 11px;
            opacity: 0.75;
        }

        /* ── Main scroll area ── */
        #menu-content {
            flex: 1;
            padding: 32px 32px 80px;
        }

        /* ── Menu cards ── */
        .menu-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e8e0d8;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .menu-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(114,78,44,0.15); }

        /* ── Item Modal ── */
        #item-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        #item-modal.open { display: flex; }
        #modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
        }
        #modal-box {
            position: relative;
            background: #fff;
            border-radius: 16px;
            width: 480px;
            max-width: 95vw;
            max-height: 90vh;
            overflow-y: auto;
            z-index: 101;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        #modal-img { width: 100%; height: 240px; object-fit: cover; object-position: center; }
        #modal-img-placeholder { width: 100%; height: 240px; display: flex; align-items: center; justify-content: center; font-size: 80px; }
        #modal-body { padding: 24px; }

        /* ── Cart ── */
        #cart-summary {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 360px;
            z-index: 60;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #category-sidebar { display: none !important; }
            #mobile-cat-bar { display: flex; }
            #page-body { flex-direction: column; }
            #menu-content { padding: 20px 16px 100px; }
            #cart-summary {
                left: 12px;
                right: 12px;
                bottom: 12px;
                width: auto;
                border-radius: 14px;
            }
            #modal-box { border-radius: 12px; max-height: 95vh; }
            #modal-img, #modal-img-placeholder { height: 200px; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <nav style="background:#fff; border-bottom: 4px solid #724e2c; position: sticky; top: 0; z-index: 50;">
        <div style="max-width:1400px; margin:0 auto; padding:0 24px; display:flex; justify-content:space-between; align-items:center; height:56px;">
            <div style="display:flex; align-items:center; gap:24px;">
                <a href="{{ route('home') }}" style="font-size:20px; font-weight:800; color:#724e2c; text-decoration:none;">🍽️ CampusEats</a>
                <a href="{{ route('home') }}" style="font-size:13px; color:#724e2c; text-decoration:none;">← Back to Vendors</a>
            </div>
            <div style="display:flex; align-items:center; gap:16px;">
                @auth
                    @if(auth()->user()->isStudent())
                        <a href="{{ route('orders.my') }}" style="font-size:13px; color:#3c3028; text-decoration:none;">My Orders</a>
                    @endif
                    <span style="font-size:13px; color:#3c3028; font-weight:600;">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="font-size:13px; color:#724e2c; background:none; border:none; cursor:pointer; font-weight:600;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="font-size:13px; color:#724e2c; text-decoration:none; font-weight:600;">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Vendor Header -->
    <div style="background: linear-gradient(to right, #724e2c, #563517); color:#fff; padding: 32px 24px;">
        <div style="max-width:1400px; margin:0 auto; display:flex; align-items:flex-start; justify-content:space-between; gap:24px;">
            <div style="flex:1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <h1 style="font-size:32px; font-weight:800; margin:0;">{{ $vendor->vendor_name }}</h1>
                    @if($isOpenNow)
                        <span style="background:#22c55e; color:#fff; font-size:12px; font-weight:700; padding:4px 12px; border-radius:999px;">● Open Now</span>
                    @else
                        <span style="background:#ef4444; color:#fff; font-size:12px; font-weight:700; padding:4px 12px; border-radius:999px;">● Closed</span>
                    @endif
                </div>
                <p style="color:#dfc3a9; margin:4px 0;">📍 {{ $vendor->location }}</p>
                @if($vendor->contact_info)<p style="color:#dfc3a9; margin:4px 0;">📞 {{ $vendor->contact_info }}</p>@endif
                @if($vendor->description)<p style="color:#dfc3a9; margin:8px 0 0;">{{ $vendor->description }}</p>@endif

                @if($vendor->operatingHours->isNotEmpty())
                    @php $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; @endphp
                    <div style="margin-top:16px;">
                        <p style="font-size:11px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#dfc3a9; margin-bottom:8px;">Weekly Schedule</p>
                        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:4px;">
                            @foreach($vendor->operatingHours as $hours)
                                <div style="display:flex; justify-content:space-between; font-size:13px; padding:3px 0; border-bottom:1px solid rgba(255,255,255,0.1);">
                                    <span style="color:#f5efe8;">{{ $dayNames[$hours->day_of_week] }}</span>
                                    @if($hours->is_closed)
                                        <span style="color:#fca5a5;">Closed</span>
                                    @else
                                        <span style="color:#dfc3a9;">{{ date('g:i A', strtotime($hours->open_time)) }} – {{ date('g:i A', strtotime($hours->close_time)) }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div style="background:rgba(255,255,255,0.15); border-radius:12px; padding:20px 28px; text-align:center; flex-shrink:0;">
                <p style="font-size:12px; color:#dfc3a9; margin:0 0 4px;">Total Items</p>
                <p style="font-size:36px; font-weight:800; margin:0;">{{ $vendor->menuItems->count() }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#f0fdf4; border-left:4px solid #22c55e; padding:12px 24px; font-size:14px; color:#166534;">{{ session('success') }}</div>
    @endif

    @if($vendor->menuItems->isEmpty())
        <div style="text-align:center; padding:80px 24px; color:#9e8a78;">
            <p style="font-size:20px; font-weight:600;">No menu items available yet.</p>
        </div>
    @else

    <!-- ── Mobile category pill bar ── -->
    @if(!$vendor->menuItems->isEmpty())
    <div id="mobile-cat-bar">
        @php $groupedForBar = $vendor->menuItems->groupBy('category'); @endphp
        @foreach($groupedForBar as $category => $items)
            @php $slug = Str::slug($category ?: 'other-items'); @endphp
            <a class="mobile-cat-pill" data-target="cat-{{ $slug }}"
               onclick="smoothScroll('cat-{{ $slug }}'); return false;" href="#cat-{{ $slug }}">
                <span>{{ $category ?: 'Other' }}</span>
                <span class="cat-count">{{ $items->count() }}</span>
            </a>
        @endforeach
    </div>
    @endif

    <!-- ── Page body: sidebar + content ── -->
    <div id="page-body">

        <!-- Sidebar -->
        <aside id="category-sidebar">
            <span class="sidebar-label">Categories</span>
            @php $groupedItems = $vendor->menuItems->groupBy('category'); @endphp
            @foreach($groupedItems as $category => $items)
                @php $slug = Str::slug($category ?: 'other-items'); @endphp
                <a class="category-link" data-target="cat-{{ $slug }}"
                   onclick="smoothScroll('cat-{{ $slug }}'); return false;" href="#cat-{{ $slug }}">
                    <span>{{ $category ?: 'Other' }}</span>
                    <span class="cat-count">{{ $items->count() }}</span>
                </a>
            @endforeach
        </aside>

        <!-- Menu content -->
        <main id="menu-content">

            @foreach($groupedItems as $category => $items)
                @php
                    $slug = Str::slug($category ?: 'other-items');
                    $colors = ['Rice Meals'=>'FFB84D','Breakfast'=>'4ECDC4','Main Dishes'=>'FF6B6B','Noodles & Pasta'=>'F7B731','Snacks'=>'5F27CD','Beverages'=>'00D2D3','Desserts'=>'FF9FF3'];
                    $emojis = ['Rice Meals'=>'🍛','Breakfast'=>'🍳','Main Dishes'=>'🍖','Noodles & Pasta'=>'🍜','Snacks'=>'🥟','Beverages'=>'🥤','Desserts'=>'🍨'];
                @endphp
                <div id="cat-{{ $slug }}" style="margin-bottom:48px;">
                    <h2 style="font-size:24px; font-weight:800; color:#3c3028; border-bottom:3px solid #724e2c; padding-bottom:10px; margin-bottom:20px;">
                        {{ $category ?: 'Other Items' }}
                    </h2>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px;">
                        @foreach($items as $item)
                            @php
                                $bg = $colors[$item->category] ?? '6366F1';
                                $emoji = $emojis[$item->category] ?? '🍽️';
                            @endphp
                            <div class="menu-card {{ !$item->is_available ? '' : '' }}"
                                 onclick="openModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->description) }}', {{ $item->price }}, '{{ $item->is_available ? 'true' : 'false' }}', '{{ $item->image_url ? Storage::url($item->image_url) : '' }}', '{{ addslashes($item->category) }}', '{{ $emoji }}')"
                                 style="{{ !$item->is_available ? 'opacity:0.6;' : '' }}">
                                <!-- Image -->
                                <div style="position:relative; height:180px; background:linear-gradient(135deg,#{{ $bg }}22,#{{ $bg }}55); overflow:hidden;">
                                    @if($item->image_url)
                                        <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}"
                                             style="width:100%; height:100%; object-fit:cover; object-position:{{ $item->image_position ?? 'center center' }}; display:block;">
                                    @else
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:64px;">{{ $emoji }}</div>
                                    @endif
                                    @if(!$item->is_available)
                                        <div style="position:absolute; inset:0; background:rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center;">
                                            <span style="background:#ef4444; color:#fff; font-weight:700; padding:6px 16px; border-radius:999px; font-size:13px;">SOLD OUT</span>
                                        </div>
                                    @else
                                        <span style="position:absolute; top:10px; right:10px; background:#22c55e; color:#fff; font-size:11px; font-weight:700; padding:3px 10px; border-radius:999px;">AVAILABLE</span>
                                    @endif
                                    <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(0,0,0,0.7),transparent); padding:12px;">
                                        <p style="color:#fff; font-weight:700; font-size:15px; margin:0;">{{ $item->name }}</p>
                                    </div>
                                </div>
                                <!-- Body -->
                                <div style="padding:14px 16px;">
                                    <p style="font-size:12px; color:#9e8a78; margin:0 0 6px;">{{ $item->category }}</p>
                                    <p style="font-size:13px; color:#5c4a3a; margin:0 0 10px; height:36px; overflow:hidden;">{{ $item->description }}</p>
                                    <p style="font-size:20px; font-weight:800; color:#724e2c; margin:0;">₱{{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </main>
    </div>

    <!-- ── Item Modal ── -->
    <div id="item-modal">
        <div id="modal-backdrop" onclick="closeModal()"></div>
        <div id="modal-box">
            <div id="modal-img-wrap"></div>
            <div id="modal-body">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                    <div>
                        <p id="modal-category" style="font-size:12px; color:#9e8a78; margin:0 0 4px;"></p>
                        <h2 id="modal-name" style="font-size:22px; font-weight:800; color:#3c3028; margin:0;"></h2>
                    </div>
                    <button onclick="closeModal()" style="background:none; border:none; font-size:22px; cursor:pointer; color:#9e8a78; line-height:1; padding:0 0 0 12px;">✕</button>
                </div>
                <p id="modal-desc" style="font-size:14px; color:#5c4a3a; margin:0 0 16px;"></p>
                <p id="modal-price" style="font-size:28px; font-weight:800; color:#724e2c; margin:0 0 20px;"></p>

                <div id="modal-actions"></div>
            </div>
        </div>
    </div>

    <!-- ── Sticky Cart ── -->
    <div id="cart-summary" style="display:none;">
        <div style="background:linear-gradient(to right,#724e2c,#563517); padding:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="font-size:20px;">🛒</span>
                    <div>
                        <p style="color:#fff; font-weight:700; font-size:15px; margin:0;">Your Cart</p>
                        <p id="cart-count" style="color:rgba(255,255,255,0.7); font-size:12px; margin:0;">0 items</p>
                    </div>
                </div>
                <button onclick="clearCart()" style="background:rgba(255,255,255,0.2); border:none; color:#fff; border-radius:50%; width:32px; height:32px; cursor:pointer; font-size:16px;">✕</button>
            </div>
        </div>
        <div style="background:#fff; max-height:240px; overflow-y:auto;">
            <div id="cart-items" style="padding:12px; display:flex; flex-direction:column; gap:8px;"></div>
        </div>
        <div style="background:linear-gradient(to right,#724e2c,#563517); padding:16px;">
            <div style="background:rgba(255,255,255,0.15); border-radius:10px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <span style="color:#fff; font-weight:600;">Total</span>
                <span id="cart-total" style="color:#fff; font-size:22px; font-weight:800;">₱0.00</span>
            </div>
            <button onclick="proceedToCheckout()" style="width:100%; background:#fff; color:#724e2c; border:none; border-radius:10px; padding:14px; font-size:15px; font-weight:700; cursor:pointer;">
                Place Order Now →
            </button>
        </div>
    </div>

    @endif

    <script>
        let cart = [];

        // ── Sidebar scroll spy ──
        function setActiveLink(id) {
            // Desktop sidebar
            document.querySelectorAll('.category-link').forEach(function(l) { l.classList.remove('active'); });
            var a = document.querySelector('.category-link[data-target="' + id + '"]');
            if (a) a.classList.add('active');
            // Mobile pills
            document.querySelectorAll('.mobile-cat-pill').forEach(function(l) { l.classList.remove('active'); });
            var m = document.querySelector('.mobile-cat-pill[data-target="' + id + '"]');
            if (m) {
                m.classList.add('active');
                // Scroll pill into view
                m.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        function smoothScroll(id) {
            var el = document.getElementById(id);
            if (!el) return;
            // Account for sticky nav (56px) + mobile cat bar (~50px on mobile)
            var mobileBar = document.getElementById('mobile-cat-bar');
            var barH = (mobileBar && mobileBar.offsetHeight) ? mobileBar.offsetHeight : 0;
            var navHeight = 56 + barH + 8;
            var top = el.getBoundingClientRect().top + window.scrollY - navHeight;
            window.scrollTo({ top: top, behavior: 'smooth' });
            setActiveLink(id);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Set first active
            var first = document.querySelector('.category-link');
            if (first) first.classList.add('active');

            // Scroll spy on window
            window.addEventListener('scroll', function() {
                var sections = document.querySelectorAll('[id^="cat-"]');
                var current = null;
                sections.forEach(function(s) {
                    if (s.getBoundingClientRect().top <= 100) current = s.id;
                });
                if (current) setActiveLink(current);
            });
        });

        // ── Modal ──
        function openModal(id, name, desc, price, available, imageUrl, category, emoji) {
            var wrap = document.getElementById('modal-img-wrap');
            if (imageUrl) {
                wrap.innerHTML = '<img id="modal-img" src="' + imageUrl + '" alt="' + name + '">';
            } else {
                wrap.innerHTML = '<div id="modal-img-placeholder" style="background:#f5ede6;">' + emoji + '</div>';
            }
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-desc').textContent = desc;
            document.getElementById('modal-price').textContent = '₱' + parseFloat(price).toFixed(2);
            document.getElementById('modal-category').textContent = category;

            var actions = document.getElementById('modal-actions');
            if (available === 'true') {
                @auth
                    @if(auth()->user()->isStudent())
                    actions.innerHTML = `
                        <div style="display:flex; align-items:center; gap:10px;">
                            <button onclick="modalDecrement()" style="width:40px; height:40px; border-radius:8px; border:1px solid #e8e0d8; background:#f9f5f2; font-size:20px; cursor:pointer; font-weight:700;">−</button>
                            <input id="modal-qty" type="number" value="1" min="1" max="99"
                                   style="width:60px; text-align:center; border:2px solid #e8e0d8; border-radius:8px; padding:8px; font-size:16px; font-weight:700;">
                            <button onclick="modalIncrement()" style="width:40px; height:40px; border-radius:8px; border:1px solid #e8e0d8; background:#f9f5f2; font-size:20px; cursor:pointer; font-weight:700;">+</button>
                            <button onclick="modalAddToCart(${id}, '${name.replace(/'/g,"\\'")}', ${price})"
                                    style="flex:1; background:#724e2c; color:#fff; border:none; border-radius:8px; padding:12px; font-size:15px; font-weight:700; cursor:pointer;">
                                Add to Cart
                            </button>
                        </div>`;
                    @else
                    actions.innerHTML = '<p style="color:#9e8a78; font-size:14px;">Only students can place orders.</p>';
                    @endif
                @else
                actions.innerHTML = '<a href="{{ route("login") }}" style="display:block; text-align:center; background:#724e2c; color:#fff; border-radius:8px; padding:12px; font-weight:700; text-decoration:none;">Login to Order</a>';
                @endauth
            } else {
                actions.innerHTML = '<div style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626; padding:12px; border-radius:8px; text-align:center; font-weight:600;">Currently Unavailable</div>';
            }

            document.getElementById('item-modal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('item-modal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function modalIncrement() {
            var input = document.getElementById('modal-qty');
            if (parseInt(input.value) < 99) input.value = parseInt(input.value) + 1;
        }
        function modalDecrement() {
            var input = document.getElementById('modal-qty');
            if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        }
        function modalAddToCart(itemId, itemName, price) {
            var qty = parseInt(document.getElementById('modal-qty').value) || 1;
            var existingIndex = cart.findIndex(function(i) { return i.id === itemId; });
            if (existingIndex >= 0) {
                cart[existingIndex].quantity += qty;
            } else {
                cart.push({ id: itemId, name: itemName, price: price, quantity: qty });
            }
            updateCartDisplay();
            closeModal();
        }

        // ── Cart ──
        function updateCartDisplay() {
            var summary = document.getElementById('cart-summary');
            var itemsEl = document.getElementById('cart-items');
            var totalEl = document.getElementById('cart-total');
            var countEl = document.getElementById('cart-count');

            if (cart.length === 0) { summary.style.display = 'none'; return; }
            summary.style.display = 'block';

            var total = 0, totalItems = 0, html = '';
            cart.forEach(function(item, index) {
                var itemTotal = item.price * item.quantity;
                total += itemTotal; totalItems += item.quantity;
                html += '<div style="background:#fdf5ef; border-radius:8px; padding:10px 12px;">'
                    + '<div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">'
                    + '<span style="font-size:13px; font-weight:600; color:#3c3028; flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">' + item.name + '</span>'
                    + '<span style="font-size:13px; font-weight:700; color:#724e2c; white-space:nowrap;">₱' + itemTotal.toFixed(2) + '</span>'
                    + '</div>'
                    + '<div style="display:flex; align-items:center; gap:6px; margin-top:8px;">'
                    + '<button onclick="cartDecrement(' + index + ')" style="width:28px; height:28px; border-radius:6px; border:1px solid #e8e0d8; background:#fff; font-size:16px; cursor:pointer; font-weight:700; line-height:1;">−</button>'
                    + '<span style="min-width:28px; text-align:center; font-size:14px; font-weight:700; color:#3c3028;">' + item.quantity + '</span>'
                    + '<button onclick="cartIncrement(' + index + ')" style="width:28px; height:28px; border-radius:6px; border:1px solid #e8e0d8; background:#fff; font-size:16px; cursor:pointer; font-weight:700; line-height:1;">+</button>'
                    + '<button onclick="removeFromCart(' + index + ')" style="margin-left:auto; background:#fee2e2; border:none; color:#dc2626; border-radius:6px; width:28px; height:28px; cursor:pointer; font-size:14px; line-height:1;">✕</button>'
                    + '</div>'
                    + '</div>';
            });
            itemsEl.innerHTML = html;
            totalEl.textContent = '₱' + total.toFixed(2);
            countEl.textContent = totalItems + ' item' + (totalItems !== 1 ? 's' : '');
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        function cartIncrement(index) {
            if (cart[index] && cart[index].quantity < 99) {
                cart[index].quantity++;
                updateCartDisplay();
            }
        }

        function cartDecrement(index) {
            if (!cart[index]) return;
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
            } else {
                cart.splice(index, 1);
            }
            updateCartDisplay();
        }

        function clearCart() {
            if (confirm('Clear your cart?')) { cart = []; updateCartDisplay(); }
        }

        function proceedToCheckout() {
            if (cart.length === 0) { alert('Your cart is empty!'); return; }
            @guest window.location.href = '{{ route("login") }}'; return; @endguest
            var form = document.createElement('form');
            form.method = 'POST'; form.action = '{{ route("orders.store") }}';
            var csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrf);
            var vid = document.createElement('input'); vid.type = 'hidden'; vid.name = 'vendor_id'; vid.value = '{{ $vendor->id }}';
            form.appendChild(vid);
            cart.forEach(function(item, index) {
                var ii = document.createElement('input'); ii.type = 'hidden'; ii.name = 'items[' + index + '][menu_item_id]'; ii.value = item.id; form.appendChild(ii);
                var qi = document.createElement('input'); qi.type = 'hidden'; qi.name = 'items[' + index + '][quantity]'; qi.value = item.quantity; form.appendChild(qi);
            });
            document.body.appendChild(form); form.submit();
        }
    </script>
</body>
</html>

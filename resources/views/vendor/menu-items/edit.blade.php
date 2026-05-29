<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item — CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background: #f5efe8; font-family: system-ui, -apple-system, sans-serif; margin: 0; }
        .top-nav { background: #fff; border-bottom: 3px solid #724e2c; position: sticky; top: 0; z-index: 50; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; height: 56px; }
        .nav-brand { font-size: 18px; font-weight: 800; color: #724e2c; text-decoration: none; }
        .nav-links { display: flex; gap: 4px; }
        .nav-link { padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; color: #5c4a3a; text-decoration: none; transition: background 0.15s; }
        .nav-link:hover { background: #fdf5ef; }
        .nav-link.active { background: #fdf0e6; color: #724e2c; font-weight: 700; }
        .nav-right { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #5c4a3a; }
        .nav-logout { background: none; border: none; font-size: 13px; color: #9e8a78; cursor: pointer; font-weight: 500; }
        .nav-logout:hover { color: #724e2c; }

        .page { max-width: 1400px; margin: 0 auto; padding: 28px clamp(16px, 4vw, 48px) 64px; display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(114,78,44,0.08), 0 4px 16px rgba(114,78,44,0.05); overflow: hidden; }
        .card-header { padding: 18px 22px 0; display: flex; align-items: center; gap: 10px; }
        .card-icon { width: 36px; height: 36px; border-radius: 10px; background: #fdf0e6; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .card-title { font-size: 15px; font-weight: 700; color: #3c3028; margin: 0; }
        .card-subtitle { font-size: 12px; color: #9e8a78; margin: 2px 0 0; }
        .card-body { padding: 18px 22px 22px; }

        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 12px; font-weight: 700; color: #5c4a3a; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
        .field input, .field textarea {
            width: 100%; padding: 10px 14px; border-radius: 10px;
            border: 1.5px solid #e8d5c4; font-size: 14px; color: #3c3028;
            background: #fdfaf8; transition: border-color 0.15s, box-shadow 0.15s;
            outline: none; font-family: inherit;
        }
        .field input:focus, .field textarea:focus { border-color: #724e2c; box-shadow: 0 0 0 3px rgba(114,78,44,0.1); }
        .field textarea { resize: vertical; min-height: 80px; }
        .field .error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .two-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .cat-pills { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .cat-pill { padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; background: #fdf0e6; color: #724e2c; border: 1.5px solid #e8d5c4; cursor: pointer; transition: background 0.15s; }
        .cat-pill:hover { background: #f5e0cc; border-color: #724e2c; }

        .img-upload-area { border: 2px dashed #e8d5c4; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: border-color 0.15s; background: #fdfaf8; }
        .img-upload-area:hover { border-color: #724e2c; }
        .img-preview { width: 100%; height: 180px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; }
        .img-upload-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: #fdf0e6; color: #724e2c; border: 1.5px solid #e8d5c4; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s; }
        .img-upload-btn:hover { background: #f5e0cc; }
        .img-remove-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s; margin-left: 8px; }
        .img-remove-btn:hover { background: #fee2e2; }

        .avail-toggle { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .avail-toggle input { display: none; }
        .toggle-track { width: 44px; height: 24px; border-radius: 999px; background: #e8d5c4; position: relative; transition: background 0.2s; flex-shrink: 0; }
        .toggle-track.on { background: #22c55e; }
        .toggle-thumb { position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; transition: left 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .toggle-track.on .toggle-thumb { left: 23px; }
        .avail-label { font-size: 13px; font-weight: 600; color: #3c3028; }

        .btn-primary { background: #724e2c; color: #fff; border: none; padding: 12px 28px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.15s; }
        .btn-primary:hover { background: #563517; }
        .btn-cancel { background: #fdf5ef; color: #724e2c; border: 1.5px solid #e8d5c4; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.15s; }
        .btn-cancel:hover { background: #f5e0cc; }
        .btn-row { display: flex; gap: 10px; margin-top: 20px; }

        .preview-card { border-radius: 14px; overflow: hidden; border: 1px solid #f0e6dc; box-shadow: 0 1px 4px rgba(114,78,44,0.08); }
        .preview-img-el { width: 100%; height: 180px; object-fit: cover; object-position: center; display: block; }
        .preview-img-placeholder { width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 64px; }
        .preview-body { padding: 14px 16px 16px; background: #fff; }
        .preview-avail { position: absolute; top: 10px; right: 10px; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }

        .cat-manager-input { display: flex; gap: 8px; margin-bottom: 10px; }
        .cat-manager-input input { flex: 1; padding: 8px 12px; border-radius: 8px; border: 1.5px solid #e8d5c4; font-size: 13px; color: #3c3028; background: #fdfaf8; outline: none; font-family: inherit; }
        .cat-manager-input input:focus { border-color: #724e2c; }
        .cat-add-btn { padding: 8px 14px; background: #724e2c; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .cat-add-btn:hover { background: #563517; }
        .cat-list { display: flex; flex-wrap: wrap; gap: 6px; }
        .cat-item { display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px 5px 12px; border-radius: 999px; background: #fdf0e6; color: #724e2c; border: 1.5px solid #e8d5c4; font-size: 12px; font-weight: 600; }
        .cat-item button { background: none; border: none; color: #9e8a78; cursor: pointer; font-size: 14px; line-height: 1; padding: 0; }
        .cat-item button:hover { color: #dc2626; }
        .cat-use-btn { background: none; border: none; color: #724e2c; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: underline; padding: 0; }

        @media (max-width: 900px) {
            .page { grid-template-columns: 1fr; }
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
                <a href="{{ route('vendor.menu-items.index') }}" class="nav-link active">Menu Items</a>
                <a href="{{ route('vendor.orders') }}" class="nav-link">Orders</a>
                <a href="{{ route('vendor.profile') }}" class="nav-link">Profile</a>
            </div>
        </div>
        <div class="nav-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="nav-logout">Logout</button></form>
        </div>
    </nav>

    <div style="background: linear-gradient(135deg, #724e2c 0%, #563517 100%); color:#fff; padding:28px 24px 48px; position:relative;">
        <div style="position:absolute; bottom:0; left:0; right:0; height:28px; background:#f5efe8; clip-path:ellipse(55% 100% at 50% 100%);"></div>
        <div style="max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:12px;">
            <a href="{{ route('vendor.menu-items.index') }}" style="background:rgba(255,255,255,0.15); color:#fff; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:18px; flex-shrink:0;">←</a>
            <div>
                <h2 style="font-size:24px; font-weight:800; color:#fff; margin:0 0 4px;">Edit Menu Item</h2>
                <p style="font-size:13px; color:#dfc3a9; margin:0;">Updating: {{ $menuItem->name }}</p>
            </div>
        </div>
    </div>

    <div class="page">

        <!-- Left: Form -->
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">✏️</div>
                    <div><p class="card-title">Item Details</p><p class="card-subtitle">Update the information below</p></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.menu-items.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="remove_image" id="remove_image" value="0">

                        <div class="field">
                            <label>Item Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $menuItem->name) }}" required oninput="updatePreview()">
                            @error('name')<p class="error">{{ $message }}</p>@enderror
                        </div>

                        <div class="field">
                            <label>Description</label>
                            <textarea name="description" id="description" oninput="updatePreview()">{{ old('description', $menuItem->description) }}</textarea>
                            @error('description')<p class="error">{{ $message }}</p>@enderror
                        </div>

                        <div class="two-fields">
                            <div class="field">
                                <label>Price (₱) <span style="color:#ef4444;">*</span></label>
                                <input type="number" name="price" id="price" value="{{ old('price', $menuItem->price) }}" step="0.01" min="0" required oninput="updatePreview()">
                                @error('price')<p class="error">{{ $message }}</p>@enderror
                            </div>
                            <div class="field">
                                <label>Category</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $menuItem->category) }}" oninput="updatePreview()">
                                @error('category')<p class="error">{{ $message }}</p>@enderror
                                @if($existingCategories->isNotEmpty())
                                    <div class="cat-pills" id="cat-pills">
                                        @foreach($existingCategories as $cat)
                                            <button type="button" class="cat-pill" onclick="setCategory('{{ addslashes($cat) }}')">{{ $cat }}</button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Image (combined upload + reposition) -->
                        <div class="field">
                            <label>Item Image</label>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp"
                                   style="display:none;" onchange="previewImage(this)">
                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                            <input type="hidden" name="image_position" id="image_position" value="{{ old('image_position', $menuItem->image_position ?? 'center center') }}">

                            @php $hasImage = !empty($menuItem->image_url); @endphp

                            <!-- Empty state (no image) -->
                            <div id="upload-trigger"
                                 style="{{ $hasImage ? 'display:none;' : '' }} border:2px dashed #e8d5c4; border-radius:12px; padding:32px; text-align:center; cursor:pointer; background:#fdfaf8;"
                                 onclick="document.getElementById('image').click()">
                                <span class="img-upload-btn">📷 Choose Image</span>
                                <p style="font-size:12px; color:#9e8a78; margin:8px 0 0;">JPEG, PNG, GIF, WebP — max 2MB</p>
                            </div>

                            <!-- Canvas (shown when image exists) -->
                            <div id="pos-canvas"
                                 style="{{ $hasImage ? '' : 'display:none;' }} position:relative; width:100%; height:180px; overflow:hidden; border-radius:12px; border:2px solid #e8d5c4; cursor:grab; background:#111; user-select:none;">
                                <img id="pos-img" src="{{ $hasImage ? Storage::url($menuItem->image_url) : '' }}" alt=""
                                     style="position:absolute; top:0; left:0; width:100%; height:auto; display:block; pointer-events:none;">
                                <div style="position:absolute; inset:0; pointer-events:none;">
                                    <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                                        <span id="ov-hint" style="background:rgba(0,0,0,0.55); color:#fff; font-size:12px; font-weight:600; padding:5px 12px; border-radius:999px;">✥ Drag to reposition</span>
                                    </div>
                                </div>
                                <!-- Buttons overlaid at bottom -->
                                <div style="position:absolute; bottom:12px; left:0; right:0; display:flex; justify-content:center; gap:8px; z-index:10;">
                                    <button type="button" onclick="document.getElementById('image').click()"
                                            style="background:rgba(255,255,255,0.92); color:#724e2c; border:none; padding:7px 16px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer;">
                                        📷 Replace
                                    </button>
                                    <button type="button" onclick="removeImage()"
                                            style="background:rgba(255,255,255,0.92); color:#dc2626; border:none; padding:7px 16px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer;">
                                        🗑 Remove
                                    </button>
                                </div>
                            </div>
                            <p id="pos-label" style="font-size:11px; color:#9e8a78; margin:6px 0 0; text-align:center; {{ $hasImage ? '' : 'display:none;' }}">
                                Focus: {{ old('image_position', $menuItem->image_position ?? 'center center') }}
                            </p>
                            @error('image')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <!-- Availability -->
                        <div class="field">
                            <label>Availability</label>
                            <label class="avail-toggle" onclick="toggleAvail()">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $menuItem->is_available) ? 'checked' : '' }}>
                                <div class="toggle-track {{ old('is_available', $menuItem->is_available) ? 'on' : '' }}" id="avail-track">
                                    <div class="toggle-thumb"></div>
                                </div>
                                <span class="avail-label" id="avail-label">{{ old('is_available', $menuItem->is_available) ? 'Available for ordering' : 'Not available' }}</span>
                            </label>
                        </div>

                        <div class="btn-row">
                            <button type="submit" class="btn-primary">Save Changes</button>
                            <a href="{{ route('vendor.menu-items.index') }}" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Preview + Category Manager -->
        <div style="display:flex; flex-direction:column; gap:20px;">

            <!-- Live preview -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">👁️</div>
                    <div><p class="card-title">Live Preview</p><p class="card-subtitle">How it looks to students</p></div>
                </div>
                <div class="card-body" style="padding-top:14px;">
                    <div class="preview-card">
                        <div style="position:relative;">
                            @if($menuItem->image_url)
                                <img id="preview-img" class="preview-img-el" src="{{ Storage::url($menuItem->image_url) }}" alt="">
                                <div id="preview-placeholder" class="preview-img-placeholder" style="background:#fdf0e6; display:none;">🍽️</div>
                            @else
                                <img id="preview-img" class="preview-img-el" src="" alt="" style="display:none;">
                                <div id="preview-placeholder" class="preview-img-placeholder" style="background:#fdf0e6;">🍽️</div>
                            @endif
                            <span id="preview-avail-badge" class="preview-avail" style="background:{{ $menuItem->is_available ? '#22c55e' : '#ef4444' }}; color:#fff;">{{ $menuItem->is_available ? 'AVAILABLE' : 'UNAVAILABLE' }}</span>
                            <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(0,0,0,0.65),transparent); padding:12px;">
                                <p id="preview-name-overlay" style="color:#fff; font-size:15px; font-weight:700; margin:0;">{{ $menuItem->name }}</p>
                            </div>
                        </div>
                        <div class="preview-body">
                            <p id="preview-cat" style="font-size:11px; color:#9e8a78; margin:0 0 4px;">{{ $menuItem->category }}</p>
                            <p id="preview-desc" style="font-size:12px; color:#5c4a3a; margin:0 0 10px; height:32px; overflow:hidden;">{{ $menuItem->description }}</p>
                            <p id="preview-price" style="font-size:20px; font-weight:800; color:#724e2c; margin:0;">₱{{ number_format($menuItem->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category manager -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🏷️</div>
                    <div><p class="card-title">My Categories</p><p class="card-subtitle">Create and reuse your own categories</p></div>
                </div>
                <div class="card-body">
                    <div class="cat-manager-input">
                        <input type="text" id="new-cat-input" placeholder="New category name..." onkeydown="if(event.key==='Enter'){event.preventDefault();addCategory();}">
                        <button type="button" class="cat-add-btn" onclick="addCategory()">+ Add</button>
                    </div>
                    <div class="cat-list" id="cat-manager-list">
                        @foreach($existingCategories as $cat)
                            <span class="cat-item">
                                <button type="button" class="cat-use-btn" onclick="setCategory('{{ addslashes($cat) }}')">{{ $cat }}</button>
                                <button type="button" onclick="removeCategory(this, '{{ addslashes($cat) }}')" title="Remove">✕</button>
                            </span>
                        @endforeach
                    </div>
                    <p style="font-size:11px; color:#9e8a78; margin:10px 0 0;">Click a category to use it. Categories are shared across your menu items.</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updatePreview() {
            var name  = document.getElementById('name').value || 'Item Name';
            var desc  = document.getElementById('description').value || 'Description will appear here...';
            var price = parseFloat(document.getElementById('price').value) || 0;
            var cat   = document.getElementById('category').value || 'Category';
            document.getElementById('preview-name-overlay').textContent = name;
            document.getElementById('preview-cat').textContent = cat;
            document.getElementById('preview-desc').textContent = desc;
            document.getElementById('preview-price').textContent = '₱' + price.toFixed(2);
        }
        function setCategory(cat) { document.getElementById('category').value = cat; updatePreview(); }

        function previewImage(input) {
            if (!input.files || !input.files[0]) return;
            var reader = new FileReader();
            reader.onload = function(e) {
                var src = e.target.result;
                document.getElementById('upload-trigger').style.display = 'none';
                document.getElementById('pos-canvas').style.display = 'block';
                document.getElementById('pos-label').style.display = 'block';
                var previewImg = document.getElementById('preview-img');
                if (previewImg) { previewImg.src = src; previewImg.style.display = 'block'; }
                var ph = document.getElementById('preview-placeholder');
                if (ph) ph.style.display = 'none';
                document.getElementById('remove_image').value = '0';
                if (window.initPositionAdjuster) window.initPositionAdjuster(src, 'center center');
            };
            reader.readAsDataURL(input.files[0]);
        }

        function removeImage() {
            document.getElementById('remove_image').value = '1';
            document.getElementById('pos-canvas').style.display = 'none';
            document.getElementById('pos-label').style.display = 'none';
            document.getElementById('upload-trigger').style.display = 'block';
            document.getElementById('image').value = '';
            var previewImg = document.getElementById('preview-img');
            if (previewImg) { previewImg.style.display = 'none'; previewImg.src = ''; }
            var ph = document.getElementById('preview-placeholder');
            if (ph) ph.style.display = 'flex';
        }

        // ── Drag-to-reposition (pan image inside viewport) ──
        (function() {
            var isDragging = false;
            var startX, startY, imgOffsetX, imgOffsetY;
            var canvas, posImg, posInput, posLabel;

            document.addEventListener('DOMContentLoaded', function() {
                canvas   = document.getElementById('pos-canvas');
                posImg   = document.getElementById('pos-img');
                posInput = document.getElementById('image_position');
                posLabel = document.getElementById('pos-label');
                if (!canvas) return;
                // Init with existing image if present
                if (posImg && posImg.src && posImg.src !== window.location.href) {
                    posImg.onload = function() { scaleImg(); };
                    if (posImg.complete) { scaleImg(); }
                }                canvas.addEventListener('mousedown',  startDrag);
                canvas.addEventListener('touchstart', startDrag, { passive: false });
                document.addEventListener('mousemove',  doDrag);
                document.addEventListener('touchmove',  doDrag, { passive: false });
                document.addEventListener('mouseup',   stopDrag);
                document.addEventListener('touchend',  stopDrag);
            });

            function scaleImg() {
                var ch = canvas.offsetHeight, cw = canvas.offsetWidth;
                var ratio = posImg.naturalWidth / posImg.naturalHeight;
                var newH = Math.max(ch, cw / ratio);
                var newW = newH * ratio;
                posImg.style.width  = newW + 'px';
                posImg.style.height = newH + 'px';
                posImg.style.left   = Math.round((cw - newW) / 2) + 'px';
                posImg.style.top    = Math.round((ch - newH) / 2) + 'px';
                imgOffsetX = posImg.offsetLeft;
                imgOffsetY = posImg.offsetTop;
            }

            function getClient(e) { return e.touches ? { x: e.touches[0].clientX, y: e.touches[0].clientY } : { x: e.clientX, y: e.clientY }; }

            function startDrag(e) {
                if (e.cancelable) e.preventDefault();
                isDragging = true; canvas.style.cursor = 'grabbing';
                var c = getClient(e); startX = c.x; startY = c.y;
                imgOffsetX = posImg.offsetLeft; imgOffsetY = posImg.offsetTop;
            }

            function doDrag(e) {
                if (!isDragging) return; if (e.cancelable) e.preventDefault();
                var c = getClient(e);
                var newX = imgOffsetX + (c.x - startX);
                var newY = imgOffsetY + (c.y - startY);
                var cw = canvas.offsetWidth, ch = canvas.offsetHeight;
                var iw = posImg.offsetWidth, ih = posImg.offsetHeight;
                newX = Math.min(0, Math.max(cw - iw, newX));
                newY = Math.min(0, Math.max(ch - ih, newY));
                posImg.style.left = newX + 'px'; posImg.style.top = newY + 'px';
                var px = iw > cw ? Math.round((-newX / (iw - cw)) * 100) : 50;
                var py = ih > ch ? Math.round((-newY / (ih - ch)) * 100) : 50;
                var val = px + '% ' + py + '%';
                posInput.value = val; posLabel.textContent = 'Focus: ' + px + '% ' + py + '%';
                var pi = document.getElementById('preview-img');
                if (pi) pi.style.objectPosition = val;
            }

            function stopDrag() { isDragging = false; if (canvas) canvas.style.cursor = 'grab'; }

            window.initPositionAdjuster = function(src, initialPos) {
                posImg.src = src;
                posImg.style.left = '0px'; posImg.style.top = '0px';
                posImg.style.width = '100%'; posImg.style.height = 'auto';
                posImg.onload = function() { scaleImg(); initOverlay(); };
            };
        })();

        function toggleAvail() {
            var cb = document.getElementById('is_available');
            var track = document.getElementById('avail-track');
            var label = document.getElementById('avail-label');
            var badge = document.getElementById('preview-avail-badge');
            cb.checked = !cb.checked;
            if (cb.checked) { track.classList.add('on'); label.textContent = 'Available for ordering'; badge.style.background = '#22c55e'; badge.textContent = 'AVAILABLE'; }
            else { track.classList.remove('on'); label.textContent = 'Not available'; badge.style.background = '#ef4444'; badge.textContent = 'UNAVAILABLE'; }
        }

        var customCategories = @json($existingCategories->values());
        function addCategory() {
            var input = document.getElementById('new-cat-input'), val = input.value.trim();
            if (!val || customCategories.includes(val)) { input.value = ''; return; }
            customCategories.push(val); renderCategoryManager(); renderCategoryPills(); input.value = ''; setCategory(val);
        }
        function removeCategory(btn, cat) { customCategories = customCategories.filter(function(c){return c!==cat;}); renderCategoryManager(); renderCategoryPills(); }
        function renderCategoryManager() {
            document.getElementById('cat-manager-list').innerHTML = customCategories.map(function(cat){
                return '<span class="cat-item"><button type="button" class="cat-use-btn" onclick="setCategory(\''+cat.replace(/'/g,"\\'")+'\')">'+cat+'</button><button type="button" onclick="removeCategory(this,\''+cat.replace(/'/g,"\\'")+'\')">✕</button></span>';
            }).join('');
        }
        function renderCategoryPills() {
            var pills = document.getElementById('cat-pills'); if (!pills) return;
            pills.innerHTML = customCategories.map(function(cat){
                return '<button type="button" class="cat-pill" onclick="setCategory(\''+cat.replace(/'/g,"\\'")+'\')">'+cat+'</button>';
            }).join('');
        }
    </script>
</body>
</html>

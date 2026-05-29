<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Profile — CampusEats</title>
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
            padding: 36px 24px 0;
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 32px;
            background: #f5efe8;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .hero-inner {
            max-width: 1400px; margin: 0 auto;
            display: flex; align-items: flex-end; gap: 24px;
            padding-bottom: 48px;
        }
        .hero-avatar {
            width: 88px; height: 88px; border-radius: 20px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; flex-shrink: 0;
            border: 3px solid rgba(255,255,255,0.3);
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }
        .hero-info { flex: 1; min-width: 0; }
        .hero-name-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 6px; }
        .hero-name { font-size: 28px; font-weight: 800; color: #fff; margin: 0; }
        .badge-open  { background: #22c55e; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
        .badge-closed{ background: #ef4444; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
        .hero-meta { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 4px; }
        .hero-meta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #dfc3a9; }
        .hero-hint { font-size: 12px; color: #f5efe8; margin-top: 8px; font-weight: 600; }
        .hero-today {
            flex-shrink: 0;
            background: rgba(255,255,255,0.15);
            border-radius: 14px; padding: 14px 20px; text-align: center;
            min-width: 110px;
        }
        .hero-today-label { font-size: 10px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #dfc3a9; margin-bottom: 6px; }
        .hero-today-time { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.3; }
        .hero-today-sep { font-size: 11px; color: #dfc3a9; }

        /* ── Page layout ── */
        .page { max-width: 1400px; margin: 0 auto; padding: 32px clamp(16px, 4vw, 48px) 64px; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .full-col { margin-top: 24px; }

        /* ── Cards ── */
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 4px rgba(114,78,44,0.08), 0 4px 16px rgba(114,78,44,0.06);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 24px 0;
            display: flex; align-items: center; gap: 10px;
        }
        .card-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: #fdf0e6; display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .card-title { font-size: 15px; font-weight: 700; color: #3c3028; margin: 0; }
        .card-subtitle { font-size: 12px; color: #9e8a78; margin: 2px 0 0; }
        .card-body { padding: 20px 24px 24px; }

        /* ── Form fields ── */
        .field { margin-bottom: 16px; }
        .field:last-child { margin-bottom: 0; }
        .field label { display: block; font-size: 12px; font-weight: 600; color: #5c4a3a; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; }
        .field input, .field textarea {
            width: 100%; padding: 10px 14px; border-radius: 10px;
            border: 1.5px solid #e8d5c4; font-size: 14px; color: #3c3028;
            background: #fdfaf8; transition: border-color 0.15s, box-shadow 0.15s;
            outline: none; font-family: inherit;
        }
        .field input:focus, .field textarea:focus {
            border-color: #724e2c;
            box-shadow: 0 0 0 3px rgba(114,78,44,0.1);
        }
        .field textarea { resize: vertical; min-height: 80px; }
        .field .error { font-size: 12px; color: #dc2626; margin-top: 4px; }

        /* ── Buttons ── */
        .btn-primary {
            background: #724e2c; color: #fff; border: none;
            padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: background 0.15s, transform 0.1s;
        }
        .btn-primary:hover { background: #563517; transform: translateY(-1px); }
        .btn-row { display: flex; justify-content: flex-end; margin-top: 20px; }

        /* ── Weekly schedule ── */
        .schedule-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid #f5ede6;
        }
        .schedule-row:last-child { border-bottom: none; }
        .schedule-day { font-size: 13px; font-weight: 500; color: #5c4a3a; display: flex; align-items: center; gap: 8px; }
        .today-pill { font-size: 10px; font-weight: 700; background: #fdf0e6; color: #724e2c; padding: 2px 8px; border-radius: 999px; }
        .schedule-time { font-size: 13px; color: #3c3028; font-weight: 600; }
        .schedule-closed { font-size: 13px; color: #ef4444; font-weight: 500; }

        /* ── Operating hours form ── */
        .hours-row {
            display: grid;
            grid-template-columns: 100px 1fr;
            align-items: center;
            gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #f5ede6;
        }
        .hours-row:last-child { border-bottom: none; }
        .hours-day-name { font-size: 13px; font-weight: 700; color: #3c3028; }
        .hours-controls { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .toggle-closed {
            display: flex; align-items: center; gap-6px;
            cursor: pointer; user-select: none;
        }
        .toggle-closed input[type=checkbox] { display: none; }
        .toggle-track {
            width: 40px; height: 22px; border-radius: 999px;
            background: #ef4444; position: relative; transition: background 0.2s;
            flex-shrink: 0;
        }
        .toggle-track.open-state { background: #22c55e; }
        .toggle-thumb {
            position: absolute; top: 3px; left: 3px;
            width: 16px; height: 16px; border-radius: 50%;
            background: #fff; transition: left 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .toggle-track.open-state .toggle-thumb { left: 21px; }
        .toggle-label { font-size: 12px; font-weight: 600; color: #9e8a78; min-width: 40px; }
        .time-group { display: flex; align-items: center; gap: 8px; }
        .time-group label { font-size: 11px; font-weight: 600; color: #9e8a78; text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; }
        .time-group input[type=time] {
            padding: 7px 10px; border-radius: 8px; border: 1.5px solid #e8d5c4;
            font-size: 13px; color: #3c3028; background: #fdfaf8;
            outline: none; transition: border-color 0.15s;
        }
        .time-group input[type=time]:focus { border-color: #724e2c; }
        .time-group input[type=time]:disabled { opacity: 0.35; cursor: not-allowed; }
        .time-sep { font-size: 12px; color: #9e8a78; }

        /* ── Flash ── */
        .flash-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
            border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 600;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .two-col { grid-template-columns: 1fr; }
            .hero-today { display: none; }
            .hero-name { font-size: 22px; }
            .hours-row { grid-template-columns: 1fr; gap: 8px; }
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
                <a href="{{ route('vendor.menu-items.index') }}" class="nav-link">Menu Items</a>
                <a href="{{ route('vendor.orders') }}" class="nav-link">Orders</a>
                <a href="{{ route('vendor.profile') }}" class="nav-link active">Profile</a>
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

    @php
        $dayNames   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $isOpenNow  = $vendor->isOpenNow();
        $hoursMap   = $vendor->operatingHours->keyBy('day_of_week');
        $todayIndex = (int) now()->format('w');
        $fmt = fn($t) => $t ? date('g:i A', strtotime($t)) : '';

        $nextOpenDay = $nextOpenTime = null;
        for ($i = 1; $i <= 7; $i++) {
            $cd = ($todayIndex + $i) % 7;
            $r  = $hoursMap->get($cd);
            if ($r && !$r->is_closed && $r->open_time) {
                $nextOpenDay  = $dayNames[$cd];
                $nextOpenTime = $fmt($r->open_time);
                break;
            }
        }
        $todayRec = $hoursMap->get($todayIndex);
    @endphp

    <!-- Hero -->
    <div class="hero">
        <div class="hero-inner">
            <div class="hero-avatar">🍽️</div>
            <div class="hero-info">
                <div class="hero-name-row">
                    <h1 class="hero-name">{{ $vendor->vendor_name }}</h1>
                    @if($isOpenNow)
                        <span class="badge-open">● Open Now</span>
                    @else
                        <span class="badge-closed">● Closed</span>
                    @endif
                </div>
                <div class="hero-meta">
                    <span class="hero-meta-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $vendor->location ?: '—' }}
                    </span>
                    @if($vendor->contact_info)
                    <span class="hero-meta-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $vendor->contact_info }}
                    </span>
                    @endif
                </div>
                @if($vendor->description)
                    <p style="font-size:13px; color:#dfc3a9; margin:6px 0 0;">{{ $vendor->description }}</p>
                @endif
                <p class="hero-hint">
                    @if($isOpenNow && $todayRec?->close_time)
                        🕐 Open until {{ $fmt($todayRec->close_time) }}
                    @elseif(!$isOpenNow && $nextOpenDay)
                        🕐 Opens {{ $nextOpenDay }} at {{ $nextOpenTime }}
                    @else
                        🕐 No upcoming open hours scheduled
                    @endif
                </p>
            </div>
            <div class="hero-today">
                <div class="hero-today-label">Today</div>
                @if($todayRec && !$todayRec->is_closed && $todayRec->open_time)
                    <div class="hero-today-time">{{ $fmt($todayRec->open_time) }}</div>
                    <div class="hero-today-sep">to</div>
                    <div class="hero-today-time">{{ $fmt($todayRec->close_time) }}</div>
                @else
                    <div style="font-size:14px; font-weight:700; color:#fca5a5;">Closed</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="page">

        @if(session('success'))
            <div class="flash-success">✓ {{ session('success') }}</div>
        @endif

        <!-- Two-column: Edit Profile + Weekly Schedule -->
        <div class="two-col">

            <!-- Edit Profile -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">✏️</div>
                    <div>
                        <p class="card-title">Edit Profile</p>
                        <p class="card-subtitle">Update your store information</p>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendor.profile.update') }}">
                        @method('PUT')
                        @csrf
                        <div class="field">
                            <label>Vendor Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="vendor_name" value="{{ old('vendor_name', $vendor->vendor_name) }}" required>
                            @error('vendor_name')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label>Location <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="location" value="{{ old('location', $vendor->location) }}" required>
                            @error('location')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label>Contact Info</label>
                            <input type="text" name="contact_info" value="{{ old('contact_info', $vendor->contact_info) }}">
                            @error('contact_info')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <textarea name="description">{{ old('description', $vendor->description) }}</textarea>
                            @error('description')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="btn-row">
                            <button type="submit" class="btn-primary">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Weekly Schedule (read-only) -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">📅</div>
                    <div>
                        <p class="card-title">Weekly Schedule</p>
                        <p class="card-subtitle">Your current opening hours</p>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($dayNames as $idx => $name)
                        @php $rec = $hoursMap->get($idx); $isToday = $idx === $todayIndex; @endphp
                        <div class="schedule-row">
                            <span class="schedule-day" style="{{ $isToday ? 'font-weight:700; color:#724e2c;' : '' }}">
                                {{ $name }}
                                @if($isToday)<span class="today-pill">Today</span>@endif
                            </span>
                            @if($rec && !$rec->is_closed && $rec->open_time)
                                <span class="schedule-time">{{ $fmt($rec->open_time) }} – {{ $fmt($rec->close_time) }}</span>
                            @else
                                <span class="schedule-closed">Closed</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Operating Hours Form (full width) -->
        <div class="full-col">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🕐</div>
                    <div>
                        <p class="card-title">Operating Hours</p>
                        <p class="card-subtitle">Set open and close times for each day</p>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendor.operating-hours.update') }}">
                        @method('PUT')
                        @csrf

                        @php
                            $hoursMap = $vendor->operatingHours->keyBy('day_of_week');
                        @endphp

                        @foreach($dayNames as $dayIndex => $dayName)
                            @php
                                $record    = $hoursMap->get($dayIndex);
                                $oldVal    = old("hours.{$dayIndex}.is_closed");
                                $isClosed  = $oldVal !== null ? (bool)(int)$oldVal : ($record ? (bool)$record->is_closed : true);
                                $openTime  = old("hours.{$dayIndex}.open_time",  $record?->open_time  ? substr($record->open_time, 0, 5)  : '');
                                $closeTime = old("hours.{$dayIndex}.close_time", $record?->close_time ? substr($record->close_time, 0, 5) : '');
                                $isToday   = $dayIndex === $todayIndex;
                            @endphp

                            <div class="hours-row">
                                <span class="hours-day-name" style="{{ $isToday ? 'color:#724e2c;' : '' }}">
                                    {{ $dayName }}
                                    @if($isToday)<span class="today-pill" style="margin-left:6px;">Today</span>@endif
                                </span>
                                <div class="hours-controls">
                                    <!-- Custom toggle -->
                                    <label class="toggle-closed" onclick="toggleDay({{ $dayIndex }}, !document.getElementById('is_closed_{{ $dayIndex }}').checked)">
                                        <input type="checkbox"
                                               id="is_closed_{{ $dayIndex }}"
                                               name="hours[{{ $dayIndex }}][is_closed]"
                                               value="1"
                                               {{ $isClosed ? 'checked' : '' }}>
                                        <div class="toggle-track {{ $isClosed ? '' : 'open-state' }}" id="track_{{ $dayIndex }}">
                                            <div class="toggle-thumb"></div>
                                        </div>
                                        <span class="toggle-label" id="label_{{ $dayIndex }}">{{ $isClosed ? 'Closed' : 'Open' }}</span>
                                    </label>

                                    <!-- Time inputs -->
                                    <div id="times_{{ $dayIndex }}" style="{{ $isClosed ? 'opacity:0.35; pointer-events:none;' : '' }}; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                                        <div class="time-group">
                                            <label>Open</label>
                                            <input type="time" id="open_time_{{ $dayIndex }}"
                                                   name="hours[{{ $dayIndex }}][open_time]"
                                                   value="{{ $openTime }}"
                                                   {{ $isClosed ? 'disabled' : '' }}>
                                        </div>
                                        <span class="time-sep">→</span>
                                        <div class="time-group">
                                            <label>Close</label>
                                            <input type="time" id="close_time_{{ $dayIndex }}"
                                                   name="hours[{{ $dayIndex }}][close_time]"
                                                   value="{{ $closeTime }}"
                                                   {{ $isClosed ? 'disabled' : '' }}>
                                        </div>
                                    </div>

                                    @error("hours.{$dayIndex}.open_time")
                                        <span style="font-size:12px; color:#dc2626;">{{ $message }}</span>
                                    @enderror
                                    @error("hours.{$dayIndex}.close_time")
                                        <span style="font-size:12px; color:#dc2626;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="btn-row">
                            <button type="submit" class="btn-primary">Save Operating Hours</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <footer style="text-align:center; padding:24px; font-size:12px; color:#9e8a78;">
        © 2026 CampusEats — Manage your menu and orders efficiently.
    </footer>

    <script>
        function toggleDay(dayIndex, nowOpen) {
            var checkbox  = document.getElementById('is_closed_' + dayIndex);
            var track     = document.getElementById('track_' + dayIndex);
            var label     = document.getElementById('label_' + dayIndex);
            var wrapper   = document.getElementById('times_' + dayIndex);
            var openInput = document.getElementById('open_time_' + dayIndex);
            var closeInput= document.getElementById('close_time_' + dayIndex);

            if (nowOpen) {
                checkbox.checked = false;
                track.classList.add('open-state');
                label.textContent = 'Open';
                wrapper.style.opacity = '1';
                wrapper.style.pointerEvents = 'auto';
                openInput.disabled  = false;
                closeInput.disabled = false;
            } else {
                checkbox.checked = true;
                track.classList.remove('open-state');
                label.textContent = 'Closed';
                wrapper.style.opacity = '0.35';
                wrapper.style.pointerEvents = 'none';
                openInput.disabled  = true;
                closeInput.disabled = true;
            }
        }
    </script>
</body>
</html>

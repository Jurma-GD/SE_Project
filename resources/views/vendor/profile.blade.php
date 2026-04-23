<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Profile - CampusEats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold" style="color: #724e2c;">🍽️ CampusEats</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('vendor.dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('vendor.menu-items.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                            Menu Items
                        </a>
                        <a href="{{ route('vendor.profile') }}" class="px-3 py-2 text-sm font-medium border-b-2" style="color: #724e2c; border-color: #724e2c;">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 text-sm font-medium">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Hero Banner -->
    <div class="text-white" style="background: linear-gradient(to right, #724e2c, #563517);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @php
                // Compute open/closed status and next opening time
                $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $isOpenNow = $vendor->isOpenNow();
                $hoursMap  = $vendor->operatingHours->keyBy('day_of_week');
                $todayIndex = (int) now()->format('w');

                // Helper: convert HH:MM or HH:MM:SS to 12-hour format
                $fmt = fn($t) => $t ? date('g:i A', strtotime($t)) : '';

                // Find the next day the store opens (look ahead up to 7 days)
                $nextOpenDay  = null;
                $nextOpenTime = null;
                for ($i = 1; $i <= 7; $i++) {
                    $checkDay = ($todayIndex + $i) % 7;
                    $rec = $hoursMap->get($checkDay);
                    if ($rec && ! $rec->is_closed && $rec->open_time) {
                        $nextOpenDay  = $dayNames[$checkDay];
                        $nextOpenTime = $fmt($rec->open_time);
                        break;
                    }
                }
            @endphp

            <div class="flex items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0 w-20 h-20 rounded-2xl flex items-center justify-center text-4xl shadow-lg"
                     style="background: rgba(255,255,255,0.2);">
                    🍽️
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <h2 class="text-3xl font-bold text-white">{{ $vendor->vendor_name }}</h2>

                        {{-- Open / Closed badge --}}
                        @if($isOpenNow)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow">
                                <span class="w-2 h-2 rounded-full bg-white inline-block animate-pulse"></span>
                                Open Now
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow">
                                <span class="w-2 h-2 rounded-full bg-white inline-block"></span>
                                Closed
                            </span>
                        @endif
                    </div>

                    <!-- Location -->
                    <p class="flex items-center gap-2 text-sm mb-1" style="color: #dfc3a9;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $vendor->location ?: '—' }}
                    </p>

                    @if($vendor->contact_info)
                        <p class="flex items-center gap-2 text-sm mb-1" style="color: #dfc3a9;">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $vendor->contact_info }}
                        </p>
                    @endif

                    @if($vendor->description)
                        <p class="text-sm mt-2" style="color: #dfc3a9;">{{ $vendor->description }}</p>
                    @endif

                    <!-- Next opening hint -->
                    @if(! $isOpenNow)
                        <p class="mt-3 text-xs font-semibold" style="color: #f5efe8;">
                            @if($nextOpenDay)
                                🕐 Opens {{ $nextOpenDay }} at {{ $nextOpenTime }}
                            @else
                                🕐 No upcoming open hours scheduled
                            @endif
                        </p>
                    @else
                        @php
                            $todayRecord = $hoursMap->get($todayIndex);
                        @endphp
                        @if($todayRecord && $todayRecord->close_time)
                            <p class="mt-3 text-xs font-semibold" style="color: #f5efe8;">
                                🕐 Open until {{ $fmt($todayRecord->close_time) }}
                            </p>
                        @endif
                    @endif
                </div>

                <!-- Today's hours pill -->
                <div class="hidden sm:block flex-shrink-0 rounded-xl p-4 text-center"
                     style="background: rgba(255,255,255,0.15); min-width: 120px;">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: #dfc3a9;">Today</p>
                    @php $todayRec = $hoursMap->get($todayIndex); @endphp
                    @if($todayRec && ! $todayRec->is_closed && $todayRec->open_time)
                        <p class="text-sm font-bold text-white">
                            {{ $fmt($todayRec->open_time) }}
                        </p>
                        <p class="text-xs" style="color: #dfc3a9;">to</p>
                        <p class="text-sm font-bold text-white">
                            {{ $fmt($todayRec->close_time) }}
                        </p>
                    @else
                        <p class="text-sm font-bold text-red-300">Closed</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm font-medium">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- ── Profile Form ── -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Profile</h3>

            <form method="POST" action="{{ route('vendor.profile.update') }}">
                @method('PUT')
                @csrf

                <!-- Vendor Name -->
                <div class="mb-5">
                    <label for="vendor_name" class="form-label">Vendor Name <span class="text-red-500">*</span></label>
                    <input type="text" id="vendor_name" name="vendor_name"
                           value="{{ old('vendor_name', $vendor->vendor_name) }}"
                           class="form-input @error('vendor_name') border-red-500 @enderror"
                           required>
                    @error('vendor_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="mb-5">
                    <label for="location" class="form-label">Location <span class="text-red-500">*</span></label>
                    <input type="text" id="location" name="location"
                           value="{{ old('location', $vendor->location) }}"
                           class="form-input @error('location') border-red-500 @enderror"
                           required>
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Info -->
                <div class="mb-5">
                    <label for="contact_info" class="form-label">Contact Info</label>
                    <input type="text" id="contact_info" name="contact_info"
                           value="{{ old('contact_info', $vendor->contact_info) }}"
                           class="form-input @error('contact_info') border-red-500 @enderror">
                    @error('contact_info')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="form-input @error('description') border-red-500 @enderror">{{ old('description', $vendor->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- ── Weekly Schedule Summary ── -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Weekly Schedule</h3>
            <div class="divide-y divide-gray-100">
                @foreach($dayNames as $idx => $name)
                    @php
                        $rec = $hoursMap->get($idx);
                        $isToday = $idx === $todayIndex;
                    @endphp
                    <div class="flex items-center justify-between py-2.5 {{ $isToday ? 'font-semibold' : '' }}">
                        <span class="text-sm w-28 {{ $isToday ? 'text-gray-900' : 'text-gray-600' }}">
                            {{ $name }}
                            @if($isToday)
                                <span class="ml-1 text-xs px-1.5 py-0.5 rounded" style="background:#724e2c20; color:#724e2c;">Today</span>
                            @endif
                        </span>
                        @if($rec && ! $rec->is_closed && $rec->open_time)
                            <span class="text-sm text-gray-700">
                                {{ date('g:i A', strtotime($rec->open_time)) }}
                                <span class="text-gray-400 mx-1">–</span>
                                {{ date('g:i A', strtotime($rec->close_time)) }}
                            </span>
                        @else
                            <span class="text-sm text-red-500 font-medium">Closed</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ── Operating Hours Form ── -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Operating Hours</h3>
            <p class="text-sm text-gray-500 mb-6">Set your open and close times for each day of the week.</p>

            <form method="POST" action="{{ route('vendor.operating-hours.update') }}">
                @method('PUT')
                @csrf

                @php
                    $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    // Build a keyed map of existing records for quick lookup
                    $hoursMap = $vendor->operatingHours->keyBy('day_of_week');
                @endphp

                <div class="space-y-4">
                    @foreach($dayNames as $dayIndex => $dayName)
                        @php
                            $record   = $hoursMap->get($dayIndex);
                            // old() returns a string ("0" or "1"), so cast explicitly to avoid "0" being truthy
                            $oldIsClosed = old("hours.{$dayIndex}.is_closed");
                            $isClosed = $oldIsClosed !== null
                                ? (bool)(int)$oldIsClosed
                                : ($record ? (bool)$record->is_closed : true);
                            $openTime = old("hours.{$dayIndex}.open_time",  $record?->open_time  ? \Illuminate\Support\Str::substr($record->open_time, 0, 5) : '');
                            $closeTime= old("hours.{$dayIndex}.close_time", $record?->close_time ? \Illuminate\Support\Str::substr($record->close_time, 0, 5) : '');
                        @endphp

                        <div class="border border-gray-200 rounded-lg p-4">
                            <!-- Day header row -->
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">

                                <!-- Day name -->
                                <span class="w-28 text-sm font-semibold text-gray-700">{{ $dayName }}</span>

                                <!-- Closed checkbox -->
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                                    <input type="checkbox"
                                           id="is_closed_{{ $dayIndex }}"
                                           name="hours[{{ $dayIndex }}][is_closed]"
                                           value="1"
                                           {{ $isClosed ? 'checked' : '' }}
                                           onchange="toggleDay({{ $dayIndex }}, this.checked)"
                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    Closed
                                </label>

                                <!-- Time inputs -->
                                <div id="times_{{ $dayIndex }}"
                                     class="flex flex-wrap items-center gap-3 {{ $isClosed ? 'opacity-40 pointer-events-none' : '' }}">

                                    <div class="flex items-center gap-2">
                                        <label for="open_time_{{ $dayIndex }}" class="text-xs font-medium text-gray-500 whitespace-nowrap">Open</label>
                                        <input type="time"
                                               id="open_time_{{ $dayIndex }}"
                                               name="hours[{{ $dayIndex }}][open_time]"
                                               value="{{ $openTime }}"
                                               {{ $isClosed ? 'disabled' : '' }}
                                               class="form-input py-1.5 px-2 text-sm w-32 @error("hours.{$dayIndex}.open_time") border-red-500 @enderror">
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <label for="close_time_{{ $dayIndex }}" class="text-xs font-medium text-gray-500 whitespace-nowrap">Close</label>
                                        <input type="time"
                                               id="close_time_{{ $dayIndex }}"
                                               name="hours[{{ $dayIndex }}][close_time]"
                                               value="{{ $closeTime }}"
                                               {{ $isClosed ? 'disabled' : '' }}
                                               class="form-input py-1.5 px-2 text-sm w-32 @error("hours.{$dayIndex}.close_time") border-red-500 @enderror">
                                    </div>
                                </div>
                            </div>

                            <!-- Inline validation errors for this day -->
                            @error("hours.{$dayIndex}.open_time")
                                <p class="form-error mt-2">{{ $dayName }} open time: {{ $message }}</p>
                            @enderror
                            @error("hours.{$dayIndex}.close_time")
                                <p class="form-error mt-2">{{ $dayName }} close time: {{ $message }}</p>
                            @enderror
                            @error("hours.{$dayIndex}")
                                <p class="form-error mt-2">{{ $dayName }}: {{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn-primary">
                        Save Operating Hours
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 text-sm">
                © 2026 CampusEats. Manage your menu and orders efficiently.
            </p>
        </div>
    </footer>

    <script>
        /**
         * Toggle the disabled/opacity state of the time inputs for a given day.
         * @param {number} dayIndex  - 0 (Sunday) through 6 (Saturday)
         * @param {boolean} isClosed - true when the "Closed" checkbox is checked
         */
        function toggleDay(dayIndex, isClosed) {
            var wrapper   = document.getElementById('times_' + dayIndex);
            var openInput = document.getElementById('open_time_'  + dayIndex);
            var closeInput= document.getElementById('close_time_' + dayIndex);

            if (isClosed) {
                wrapper.classList.add('opacity-40', 'pointer-events-none');
                openInput.disabled  = true;
                closeInput.disabled = true;
            } else {
                wrapper.classList.remove('opacity-40', 'pointer-events-none');
                openInput.disabled  = false;
                closeInput.disabled = false;
            }
        }
    </script>
</body>
</html>

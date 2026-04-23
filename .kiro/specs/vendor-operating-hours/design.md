# Design Document: Vendor Operating Hours

## Overview

This feature adds operating hours management to CampusEats. Vendors define a weekly schedule (open/close times per day), and students see a live open/closed badge on vendor cards and the vendor menu page.

The implementation follows the existing Laravel MVC patterns in the codebase: a new Eloquent model (`VendorOperatingHours`) backed by a migration, a new controller (`VendorOperatingHoursController`) for the vendor-side update action, and additions to `VendorController`/`StudentController` to pass operating hours data to views. The `Vendor` model gains an `operatingHours` relationship and an `isOpenNow()` method.

No new packages are required. PHPUnit (already present) is used for testing.

---

## Architecture

The feature is a vertical slice through the existing MVC stack:

```
┌─────────────────────────────────────────────────────────────┐
│  Blade Views                                                │
│  ┌──────────────────┐  ┌──────────────────────────────────┐ │
│  │ vendor/profile   │  │ students/index  students/vendor  │ │
│  │ (edit schedule)  │  │ (open/closed badge + schedule)   │ │
│  └────────┬─────────┘  └──────────────┬───────────────────┘ │
└───────────┼──────────────────────────┼─────────────────────┘
            │                          │
┌───────────▼──────────────────────────▼─────────────────────┐
│  Controllers                                                │
│  VendorOperatingHoursController::update()                   │
│  VendorController::profile()  (passes operatingHours)       │
│  StudentController::index()   (calls isOpenNow per vendor)  │
│  StudentController::showVendor() (passes schedule + status) │
└───────────────────────────┬─────────────────────────────────┘
                            │
┌───────────────────────────▼─────────────────────────────────┐
│  Models                                                     │
│  Vendor  ──hasMany──►  VendorOperatingHours                 │
│  Vendor::isOpenNow()  (pure time comparison logic)          │
└───────────────────────────┬─────────────────────────────────┘
                            │
┌───────────────────────────▼─────────────────────────────────┐
│  Database                                                   │
│  vendors  ──1:7──►  vendor_operating_hours                  │
└─────────────────────────────────────────────────────────────┘
```

**Key design decisions:**

- **Seven-row-per-vendor model** (one row per day of week) rather than a JSON column on `vendors`. This keeps queries simple, allows per-day indexing, and is consistent with the existing relational style of the codebase.
- **`isOpenNow()` on the `Vendor` model** rather than a service class, because the logic is a pure function of the vendor's own data and the current time. This keeps it easy to call from Blade and from tests.
- **Seeding rows on vendor creation** via a model observer (`VendorObserver`) rather than inside `RegisterController`, keeping registration logic clean and ensuring rows are created regardless of how a vendor is created (e.g., seeders, tests).
- **Separate `VendorOperatingHoursController`** for the update action, keeping `VendorController` focused on profile data. The route is nested under the existing `/vendor` prefix.

---

## Components and Interfaces

### 1. Migration: `vendor_operating_hours`

File: `database/migrations/{timestamp}_create_vendor_operating_hours_table.php`

Creates the `vendor_operating_hours` table with:
- `id` — bigint, primary key
- `vendor_id` — foreign key → `vendors.id`, cascade delete
- `day_of_week` — tinyint (0 = Sunday … 6 = Saturday)
- `open_time` — time, nullable
- `close_time` — time, nullable
- `is_closed` — boolean, default `true`
- `created_at`, `updated_at` — timestamps
- Unique constraint on `(vendor_id, day_of_week)`

### 2. Model: `VendorOperatingHours`

File: `app/Models/VendorOperatingHours.php`

```php
class VendorOperatingHours extends Model
{
    protected $fillable = [
        'vendor_id', 'day_of_week', 'open_time', 'close_time', 'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'day_of_week' => 'integer',
    ];

    public function vendor(): BelongsTo { ... }
}
```

### 3. Model additions: `Vendor`

Two additions to `app/Models/Vendor.php`:

```php
// Relationship — returns all 7 records ordered by day_of_week
public function operatingHours(): HasMany
{
    return $this->hasMany(VendorOperatingHours::class)->orderBy('day_of_week');
}

// Open/closed computation
public function isOpenNow(): bool
{
    $dayOfWeek = (int) now()->format('w');   // 0=Sun … 6=Sat
    $currentTime = now()->format('H:i:s');

    $record = $this->operatingHours
        ->firstWhere('day_of_week', $dayOfWeek);

    if (!$record || $record->is_closed) {
        return false;
    }

    return $currentTime >= $record->open_time
        && $currentTime <= $record->close_time;
}
```

### 4. Observer: `VendorObserver`

File: `app/Observers/VendorObserver.php`

Listens to the `created` event on `Vendor` and inserts seven `VendorOperatingHours` rows (days 0–6, all `is_closed = true`).

Registered in `AppServiceProvider::boot()`.

### 5. Controller: `VendorOperatingHoursController`

File: `app/Http/Controllers/VendorOperatingHoursController.php`

Single public method:

```php
public function update(Request $request): RedirectResponse
```

- Resolves the authenticated vendor.
- Validates the submitted `hours` array (see Data Models section for shape).
- For each day 0–6, calls `updateOrCreate` on `VendorOperatingHours`.
- Redirects to `vendor.profile` with a success flash.

### 6. Route addition

Added inside the existing `vendor.*` middleware group in `routes/web.php`:

```php
Route::put('/operating-hours', [VendorOperatingHoursController::class, 'update'])
    ->name('vendor.operating-hours.update');
```

### 7. View changes

**`resources/views/vendor/profile.blade.php`** — adds an operating hours section below the existing profile form. Each of the seven days renders:
- Day name label
- "Closed" checkbox (`is_closed`)
- Open time input (`open_time`) — disabled when `is_closed` is checked
- Close time input (`close_time`) — disabled when `is_closed` is checked

A small inline `<script>` toggles the disabled state of time inputs when the checkbox changes.

**`resources/views/students/index.blade.php`** — adds an open/closed badge to each vendor card, positioned in the top-left of the card image area alongside the existing item-count badge.

**`resources/views/students/vendor.blade.php`** — adds:
1. An "Open Now" / "Closed" indicator in the vendor header section.
2. A weekly schedule table below the vendor description showing each day's hours or "Closed".

---

## Data Models

### `vendor_operating_hours` table

| Column       | Type         | Constraints                          |
|--------------|--------------|--------------------------------------|
| id           | bigint       | PK, auto-increment                   |
| vendor_id    | bigint       | FK → vendors.id, cascade delete      |
| day_of_week  | tinyint      | 0–6, NOT NULL                        |
| open_time    | time         | nullable                             |
| close_time   | time         | nullable                             |
| is_closed    | boolean      | NOT NULL, default true               |
| created_at   | timestamp    |                                      |
| updated_at   | timestamp    |                                      |

Unique index: `(vendor_id, day_of_week)`

### Form submission shape (operating hours update)

```
POST /vendor/operating-hours
hours[0][is_closed]  = 1|0
hours[0][open_time]  = "08:00"
hours[0][close_time] = "17:00"
hours[1][is_closed]  = 1
...
hours[6][is_closed]  = 0
hours[6][open_time]  = "09:00"
hours[6][close_time] = "14:00"
```

### Validation rules (per day entry)

| Field                    | Rule                                                                 |
|--------------------------|----------------------------------------------------------------------|
| `hours.*.is_closed`      | `boolean`                                                            |
| `hours.*.open_time`      | `nullable`, `date_format:H:i`, required when `is_closed` is `false` |
| `hours.*.close_time`     | `nullable`, `date_format:H:i`, required when `is_closed` is `false` |
| `close_time` > `open_time` | Custom rule: `close_time` must be after `open_time` when not closed |

---

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system — essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Closed-day always returns false

*For any* vendor and any day of the week where the Operating_Hours_Record has `is_closed = true`, `isOpenNow()` SHALL return `false` regardless of the current time.

**Validates: Requirements 3.2**

### Property 2: Open-status reflects time range

*For any* vendor with a non-closed Operating_Hours_Record for the current day, `isOpenNow()` SHALL return `true` if and only if the current time is within `[open_time, close_time]` (inclusive).

**Validates: Requirements 3.3, 3.4**

### Property 3: Missing record defaults to closed

*For any* vendor that has no Operating_Hours_Record for the current day of the week, `isOpenNow()` SHALL return `false`.

**Validates: Requirements 3.5**

### Property 4: Vendor creation seeds all seven days

*For any* newly created Vendor, the `operatingHours` relationship SHALL return exactly seven records — one for each day 0–6 — all with `is_closed = true`.

**Validates: Requirements 1.3, 1.4**

### Property 5: Unique constraint per vendor per day

*For any* vendor, the `vendor_operating_hours` table SHALL contain at most one record per `day_of_week` value (0–6).

**Validates: Requirements 1.2**

### Property 6: Valid update persists correctly

*For any* valid operating hours submission where a day has `is_closed = false` and `open_time < close_time`, the stored record SHALL reflect the submitted values exactly after the update.

**Validates: Requirements 2.3**

### Property 7: Invalid time order is rejected

*For any* operating hours submission where a day has `is_closed = false` and `open_time >= close_time`, the system SHALL reject the submission with a validation error and leave the existing records unchanged.

**Validates: Requirements 2.2**

---

## Error Handling

### Validation errors (operating hours form)

- Invalid time format → Laravel validation returns to form with `$errors` bag; submitted values are preserved via `old()`.
- `close_time` not after `open_time` → same flow; the specific day's error is shown inline.
- Missing required time when `is_closed = false` → same flow.

### Missing operating hours records

- If a vendor somehow has no record for the current day (e.g., data inconsistency), `isOpenNow()` returns `false` (safe default — Requirement 3.5).
- The vendor profile view handles a missing record gracefully by rendering a default "Closed" state for that day.

### Authorization

- `VendorOperatingHoursController::update()` resolves the vendor via `auth()->user()->vendor`. If no vendor profile exists, it aborts with 404 — consistent with `VendorController`.
- The route is inside the `auth` + `vendor` middleware group, so unauthenticated or non-vendor users are rejected before reaching the controller.

### Observer failure

- If the `VendorObserver` fails to seed operating hours rows (e.g., DB error during registration), the exception propagates and the registration transaction rolls back — no partial vendor record is left.

---

## Testing Strategy

### Unit tests (`tests/Unit/`)

**`VendorIsOpenNowTest`** — tests the `isOpenNow()` method in isolation using a `Vendor` model instance with a manually constructed `operatingHours` collection (no DB required):

- Returns `false` when `is_closed = true` (any time).
- Returns `true` when current time is within `[open_time, close_time]`.
- Returns `false` when current time is before `open_time`.
- Returns `false` when current time is after `close_time`.
- Returns `false` when no record exists for the current day.
- Returns `true` at exactly `open_time` (boundary).
- Returns `true` at exactly `close_time` (boundary).

**`VendorOperatingHoursValidationTest`** — tests the validation logic for the update form:

- Accepts valid `HH:MM` time strings.
- Rejects invalid time formats.
- Rejects `close_time <= open_time` when `is_closed = false`.
- Accepts any times when `is_closed = true`.

### Feature tests (`tests/Feature/`)

**`VendorOperatingHoursTest`** — HTTP-level tests using SQLite in-memory DB (existing `phpunit.xml` config):

- `GET /vendor/profile` shows operating hours form pre-populated with 7 days.
- `PUT /vendor/operating-hours` with valid data updates records and redirects with success.
- `PUT /vendor/operating-hours` with invalid data (bad format) returns 422 / redirects back with errors.
- `PUT /vendor/operating-hours` with `close_time <= open_time` returns validation error.
- Unauthenticated `PUT` is redirected to login.
- Vendor cannot update another vendor's operating hours (403).

**`VendorObserverTest`** — verifies that creating a `Vendor` seeds exactly 7 `VendorOperatingHours` rows, all `is_closed = true`.

**`StudentVendorListingTest`** — verifies that `GET /browse` includes open/closed badge data for each vendor card.

**`StudentVendorMenuTest`** — verifies that `GET /vendors/{vendor}` includes the open/closed indicator and the weekly schedule.

### Property-based testing

PHPUnit does not ship a property-based testing library. The project uses PHPUnit 11.5 (per `tech.md`). The properties above are implemented as **parameterized data-provider tests** using `@dataProvider` — a practical approximation within the existing toolchain that covers the key boundary conditions without introducing a new dependency.

For Properties 1–3 (time-based logic), the data providers generate a representative set of time combinations covering: before open, at open boundary, mid-range, at close boundary, after close, and midnight edge cases. This gives meaningful multi-input coverage for the pure `isOpenNow()` function.

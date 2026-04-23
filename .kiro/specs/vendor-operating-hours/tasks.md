# Implementation Plan: Vendor Operating Hours

## Overview

Implement operating hours management for CampusEats vendors. This covers the database layer, model logic, observer-based seeding, controller, routes, and Blade view updates — following the existing Laravel MVC patterns in the codebase.

## Tasks

- [x] 1. Create the `vendor_operating_hours` migration
  - Create `database/migrations/{timestamp}_create_vendor_operating_hours_table.php`
  - Define columns: `id`, `vendor_id` (FK → `vendors.id`, cascade delete), `day_of_week` (tinyint), `open_time` (time, nullable), `close_time` (time, nullable), `is_closed` (boolean, default `true`), timestamps
  - Add unique index on `(vendor_id, day_of_week)`
  - _Requirements: 1.1, 1.2_

- [x] 2. Create the `VendorOperatingHours` model and seed via observer
  - [x] 2.1 Create `app/Models/VendorOperatingHours.php`
    - Set `$fillable`: `vendor_id`, `day_of_week`, `open_time`, `close_time`, `is_closed`
    - Add `$casts`: `is_closed` → `boolean`, `day_of_week` → `integer`
    - Add `vendor()` BelongsTo relationship
    - _Requirements: 1.1_

  - [x] 2.2 Add `operatingHours()` HasMany relationship to `app/Models/Vendor.php`
    - Return `$this->hasMany(VendorOperatingHours::class)->orderBy('day_of_week')`
    - _Requirements: 1.4_

  - [x] 2.3 Create `app/Observers/VendorObserver.php`
    - On the `created` event, insert seven `VendorOperatingHours` rows (days 0–6, all `is_closed = true`) for the new vendor
    - _Requirements: 1.3_

  - [x] 2.4 Register `VendorObserver` in `AppServiceProvider::boot()`
    - Call `Vendor::observe(VendorObserver::class)`
    - _Requirements: 1.3_

  - [ ]* 2.5 Write property test for vendor creation seeding (Property 4)
    - **Property 4: Vendor creation seeds all seven days**
    - **Validates: Requirements 1.3, 1.4**
    - Create `tests/Feature/VendorObserverTest.php`
    - Use a `@dataProvider` with multiple vendor creation scenarios
    - Assert exactly 7 `VendorOperatingHours` rows exist, all `is_closed = true`, days 0–6 each present exactly once

  - [ ]* 2.6 Write property test for unique constraint per vendor per day (Property 5)
    - **Property 5: Unique constraint per vendor per day**
    - **Validates: Requirements 1.2**
    - In `VendorObserverTest.php`, assert that attempting to insert a duplicate `(vendor_id, day_of_week)` throws a database exception

- [x] 3. Implement `isOpenNow()` on the `Vendor` model
  - Add `isOpenNow(): bool` to `app/Models/Vendor.php`
  - Resolve current day via `(int) now()->format('w')` and current time via `now()->format('H:i:s')`
  - Return `false` if no record exists for the day (Property 3)
  - Return `false` if `is_closed = true` (Property 1)
  - Return `true` if and only if `current_time >= open_time && current_time <= close_time` (Property 2)
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

  - [ ]* 3.1 Write property tests for `isOpenNow()` (Properties 1, 2, 3)
    - **Property 1: Closed-day always returns false — Validates: Requirements 3.2**
    - **Property 2: Open-status reflects time range — Validates: Requirements 3.3, 3.4**
    - **Property 3: Missing record defaults to closed — Validates: Requirements 3.5**
    - Create `tests/Unit/VendorIsOpenNowTest.php`
    - Use `@dataProvider` to cover: `is_closed = true` (any time), time before `open_time`, time at exactly `open_time`, time mid-range, time at exactly `close_time`, time after `close_time`, no record for current day, midnight edge cases
    - Test using a `Vendor` instance with a manually set `operatingHours` relation collection (no DB required)

- [x] 4. Checkpoint — Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 5. Create `VendorOperatingHoursController` and route
  - [x] 5.1 Create `app/Http/Controllers/VendorOperatingHoursController.php`
    - Implement `update(Request $request): RedirectResponse`
    - Resolve vendor via `auth()->user()->vendor`; abort 404 if not found
    - Validate the `hours` array: `hours.*.is_closed` (boolean), `hours.*.open_time` (nullable, `date_format:H:i`, required_if `is_closed` is false), `hours.*.close_time` (nullable, `date_format:H:i`, required_if `is_closed` is false)
    - Add custom `after` validation rule: when `is_closed = false`, `close_time` must be strictly after `open_time`
    - Loop days 0–6 and call `updateOrCreate` on `VendorOperatingHours`
    - Redirect to `vendor.profile` with a success flash message
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [x] 5.2 Add route to `routes/web.php` inside the `vendor.*` middleware group
    - `Route::put('/operating-hours', [VendorOperatingHoursController::class, 'update'])->name('vendor.operating-hours.update');`
    - _Requirements: 2.3, 2.5_

  - [ ]* 5.3 Write property test for valid update persistence (Property 6)
    - **Property 6: Valid update persists correctly**
    - **Validates: Requirements 2.3**
    - In `tests/Feature/VendorOperatingHoursTest.php`, use a `@dataProvider` with varied valid day configurations
    - Assert stored records match submitted values exactly after `PUT /vendor/operating-hours`

  - [ ]* 5.4 Write property test for invalid time order rejection (Property 7)
    - **Property 7: Invalid time order is rejected**
    - **Validates: Requirements 2.2**
    - In `tests/Feature/VendorOperatingHoursTest.php`, use a `@dataProvider` with cases where `open_time >= close_time`
    - Assert validation error is returned and existing records are unchanged

  - [ ]* 5.5 Write remaining feature tests for `VendorOperatingHoursController`
    - `GET /vendor/profile` shows operating hours form pre-populated with 7 days
    - `PUT /vendor/operating-hours` with invalid time format returns validation errors
    - Unauthenticated `PUT` redirects to login
    - Vendor cannot update another vendor's operating hours (403)
    - _Requirements: 2.1, 2.4, 2.5_

- [x] 6. Update vendor profile view to include operating hours form
  - Update `resources/views/vendor/profile.blade.php`
  - Add an operating hours section below the existing profile form
  - Render a `<form method="POST" action="{{ route('vendor.operating-hours.update') }}">` with `@method('PUT')` and `@csrf`
  - For each of the 7 days, render: day name label, `is_closed` checkbox, `open_time` input, `close_time` input
  - Disable time inputs when `is_closed` is checked; use a small inline `<script>` to toggle disabled state on checkbox change
  - Pre-populate inputs using the vendor's `operatingHours` collection; fall back to defaults if a record is missing
  - Display validation errors inline per day using `$errors`
  - Use Tailwind CSS classes consistent with the existing profile form style
  - Pass `$vendor->operatingHours` from `VendorController::profile()` (already loaded via relationship)
  - _Requirements: 6.1, 6.2, 6.3, 6.4_

- [x] 7. Update student vendor listing view to show open/closed badge
  - Update `StudentController::index()` to eager-load `operatingHours` on all vendors and call `isOpenNow()` per vendor, passing the result to the view
  - Update `resources/views/students/index.blade.php` to display an open/closed badge on each vendor card
  - Green "Open" badge when `isOpenNow()` is `true`; red "Closed" badge when `false`
  - Position badge in the top-left of the card image area alongside the existing item-count badge
  - Use Tailwind CSS utility classes consistent with the existing CampusEats visual style
  - _Requirements: 4.1, 4.2, 4.3, 4.4_

  - [ ]* 7.1 Write feature test for student vendor listing badge
    - Create `tests/Feature/StudentVendorListingTest.php`
    - Assert `GET /browse` response contains open/closed badge markup for each vendor
    - _Requirements: 4.1, 4.2, 4.3_

- [x] 8. Update student vendor menu page to show open/closed status and weekly schedule
  - Update `StudentController::showVendor()` to eager-load `operatingHours` and pass `isOpenNow()` result to the view
  - Update `resources/views/students/vendor.blade.php`:
    - Add "Open Now" (green) / "Closed" (red) indicator in the vendor header section
    - Add a weekly schedule table below the vendor description showing each day's open/close times or "Closed" for `is_closed = true` days
  - Use Tailwind CSS utility classes consistent with the existing CampusEats visual style
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

  - [ ]* 8.1 Write feature test for student vendor menu page
    - Create `tests/Feature/StudentVendorMenuTest.php`
    - Assert `GET /vendors/{vendor}` response contains the open/closed indicator and the weekly schedule
    - _Requirements: 5.1, 5.4_

- [x] 9. Final checkpoint — Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for a faster MVP
- Each task references specific requirements for traceability
- Property tests are implemented as PHPUnit `@dataProvider` tests (no new dependencies required)
- The `VendorObserver` approach keeps seeding logic out of `RegisterController` and works for any vendor creation path (seeders, tests, etc.)
- Eager-load `operatingHours` in student controllers to avoid N+1 queries on the vendor listing page

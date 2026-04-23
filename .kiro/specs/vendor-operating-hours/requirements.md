# Requirements Document

## Introduction

This feature adds operating hours management to CampusEats. Vendors can define which days of the week they are open and set open/close times for each active day. Students browsing the platform can see a clear open/closed status badge on vendor cards and on the vendor menu page, so they know whether they can place an order right now.

The feature integrates with the existing `Vendor` model and profile editing flow for vendors, and with the student browsing views (`students.index` and `students.vendor`).

---

## Glossary

- **Vendor**: A campus food stall or canteen registered on CampusEats with a profile managed through `VendorController`.
- **Operating_Hours**: A set of day-specific open and close times that define when a Vendor accepts orders.
- **Operating_Hours_Record**: A single database row representing the open/close schedule for one day of the week for one Vendor.
- **Open_Status**: A computed boolean indicating whether a Vendor is currently open, derived by comparing the current server time against the Vendor's Operating_Hours for the current day of the week.
- **Student**: An authenticated user with the `student` role who browses vendors and places orders.
- **Day_Of_Week**: An integer from 0 (Sunday) to 6 (Saturday), consistent with PHP's `date('w')` convention.
- **Time_Value**: A time stored in `HH:MM:SS` format (24-hour clock).

---

## Requirements

### Requirement 1: Store Operating Hours Per Vendor

**User Story:** As a vendor, I want to define open and close times for each day of the week, so that students know when I am available to take orders.

#### Acceptance Criteria

1. THE System SHALL store Operating_Hours_Records in a dedicated `vendor_operating_hours` database table with columns: `id`, `vendor_id` (foreign key to `vendors`), `day_of_week` (integer 0–6), `open_time` (time), `close_time` (time), `is_closed` (boolean, default `true`), `created_at`, `updated_at`.
2. THE System SHALL enforce a unique constraint on (`vendor_id`, `day_of_week`) so that each Vendor has at most one Operating_Hours_Record per day.
3. WHEN a Vendor record is created, THE System SHALL seed seven Operating_Hours_Records for that Vendor (one per day), all with `is_closed = true`.
4. THE `Vendor` model SHALL expose an `operatingHours` relationship returning all seven Operating_Hours_Records ordered by `day_of_week` ascending.

---

### Requirement 2: Vendor Can Update Operating Hours

**User Story:** As a vendor, I want to update my operating hours from my profile page, so that I can keep my schedule accurate.

#### Acceptance Criteria

1. WHEN a Vendor submits the operating hours form, THE System SHALL validate that each submitted `open_time` and `close_time` is a valid time in `HH:MM` format.
2. WHEN a Vendor submits the operating hours form with `is_closed = false` for a day, THE System SHALL validate that `open_time` is earlier than `close_time` for that day.
3. WHEN a Vendor submits valid operating hours data, THE System SHALL update the corresponding Operating_Hours_Records and redirect to the vendor profile page with a success message.
4. IF a Vendor submits invalid operating hours data, THEN THE System SHALL redisplay the operating hours form with descriptive validation error messages and preserve the submitted values.
5. THE System SHALL restrict operating hours updates so that only the authenticated Vendor who owns the Operating_Hours_Records can modify them.

---

### Requirement 3: Compute Open/Closed Status

**User Story:** As a student, I want to see whether a vendor is currently open or closed, so that I know if I can place an order right now.

#### Acceptance Criteria

1. WHEN the Open_Status is requested for a Vendor, THE System SHALL compare the current server time against the Vendor's Operating_Hours_Record for the current Day_Of_Week.
2. WHEN the current Day_Of_Week has an Operating_Hours_Record with `is_closed = true`, THE System SHALL return an Open_Status of `false` for that Vendor.
3. WHEN the current time is greater than or equal to `open_time` AND less than or equal to `close_time` for the current day's Operating_Hours_Record with `is_closed = false`, THE System SHALL return an Open_Status of `true`.
4. WHEN the current time is outside the `open_time`–`close_time` range for the current day's Operating_Hours_Record, THE System SHALL return an Open_Status of `false`.
5. WHEN a Vendor has no Operating_Hours_Record for the current Day_Of_Week, THE System SHALL return an Open_Status of `false`.
6. THE `Vendor` model SHALL expose an `isOpenNow()` method that encapsulates the Open_Status computation described in criteria 1–5.

---

### Requirement 4: Display Open/Closed Badge on Vendor Listing

**User Story:** As a student, I want to see an open/closed badge on each vendor card in the vendor list, so that I can quickly identify which vendors are accepting orders.

#### Acceptance Criteria

1. WHEN a Student views the vendor listing page (`students.index`), THE System SHALL display an open/closed badge on each vendor card.
2. WHEN a Vendor's Open_Status is `true`, THE System SHALL display a green "Open" badge on that vendor's card.
3. WHEN a Vendor's Open_Status is `false`, THE System SHALL display a red "Closed" badge on that vendor's card.
4. THE System SHALL display the badge using Tailwind CSS utility classes consistent with the existing CampusEats visual style.

---

### Requirement 5: Display Open/Closed Status on Vendor Menu Page

**User Story:** As a student, I want to see the vendor's current open/closed status and their full weekly schedule on the vendor menu page, so that I have full context before placing an order.

#### Acceptance Criteria

1. WHEN a Student views a vendor's menu page (`students.vendor`), THE System SHALL display the Vendor's Open_Status prominently in the vendor header section.
2. WHEN a Vendor's Open_Status is `true`, THE System SHALL display a green "Open Now" indicator on the vendor menu page.
3. WHEN a Vendor's Open_Status is `false`, THE System SHALL display a red "Closed" indicator on the vendor menu page.
4. WHEN a Student views a vendor's menu page, THE System SHALL display the full weekly Operating_Hours schedule showing each day's open/close times or a "Closed" label for days with `is_closed = true`.

---

### Requirement 6: Display Operating Hours on Vendor Profile (Vendor View)

**User Story:** As a vendor, I want to see and edit my operating hours on my profile page, so that I can manage my schedule in one place.

#### Acceptance Criteria

1. WHEN a Vendor views their profile page, THE System SHALL display the operating hours form with the current schedule pre-populated for all seven days.
2. THE System SHALL display day names (e.g., "Sunday", "Monday") alongside each day's time inputs and closed toggle.
3. WHEN a Vendor marks a day as closed using the `is_closed` toggle, THE System SHALL visually disable the time inputs for that day.
4. THE System SHALL display the operating hours form within the existing vendor profile page layout using Blade templates and Tailwind CSS.

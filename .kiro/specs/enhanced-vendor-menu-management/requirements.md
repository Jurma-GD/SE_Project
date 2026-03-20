# Requirements Document

## Introduction

This feature enhances the vendor menu management experience in CampusEats, a campus food ordering platform built on Laravel 12. Vendors currently manage menu items through a basic CRUD interface limited to name, description, price, category (fixed dropdown), and availability. The database already has extended columns migrated but not wired up.

This feature wires up those columns and adds new capabilities: food photo uploads, custom categories, bulk availability toggling, drag-and-drop display ordering, and real food photos on the student-facing menu page. Vendor dashboard views will also be re-themed from indigo/purple to the app's brown brand color.

## Glossary

- **Vendor**: An authenticated user with the vendor role who owns a stall/shop on campus.
- **MenuItem**: An Eloquent model representing a single food or drink item offered by a Vendor.
- **MenuItemController**: The Laravel controller handling CRUD and AJAX operations for MenuItems.
- **Image_Uploader**: The subsystem responsible for receiving, validating, storing, and deleting food photo files.
- **Public_Disk**: Laravel's `public` filesystem disk rooted at `storage/app/public`, symlinked to `public/storage`.
- **Effective_Category**: The resolved display category for a MenuItem — equals `custom_category` when set, otherwise equals `category`.
- **Student**: An authenticated user with the student role who browses vendor menus and places orders.
- **Bulk_Toggle**: The AJAX endpoint and UI that allows a Vendor to change `is_available` on multiple MenuItems in a single request.
- **Display_Order**: The integer field on MenuItem that controls the sort position of items within a category on both vendor and student views.

---

## Requirements

### Requirement 1: Food Photo Upload

**User Story:** As a vendor, I want to upload a photo for each menu item, so that students can see what the food looks like before ordering.

#### Acceptance Criteria

1. WHEN a vendor submits the create or edit menu item form with an image file attached, THE Image_Uploader SHALL store the file on the Public_Disk under the path `menu-items/{vendor_id}/` and persist the resulting relative path in the `image_url` column of the MenuItem.
2. WHEN a vendor submits the create or edit menu item form without attaching an image file, THE MenuItemController SHALL leave the existing `image_url` value unchanged (or null for new items).
3. WHEN a vendor uploads a replacement image for an existing MenuItem that already has an `image_url`, THE Image_Uploader SHALL delete the previously stored file from the Public_Disk before storing the new file.
4. THE Image_Uploader SHALL accept only files with MIME types `image/jpeg`, `image/png`, `image/gif`, and `image/webp`.
5. THE Image_Uploader SHALL reject any uploaded file whose size exceeds 2 MB and return a validation error message to the vendor.
6. WHEN a MenuItem has a non-null `image_url`, THE MenuItemController SHALL generate the public URL using `Storage::url($image_url)` so the path resolves correctly through the `public/storage` symlink.
7. IF a vendor submits an image file with an unsupported MIME type, THEN THE MenuItemController SHALL return a validation error and SHALL NOT store any file or modify the MenuItem record.

---

### Requirement 2: Custom Category

**User Story:** As a vendor, I want to type my own category name instead of choosing from a fixed list, so that I can organize my menu in a way that fits my stall.

#### Acceptance Criteria

1. WHEN a vendor selects "Custom..." from the category dropdown and types a value in the custom category text field, THE MenuItemController SHALL persist that value in the `custom_category` column of the MenuItem.
2. WHEN a vendor selects a preset category from the dropdown and leaves the custom category field empty, THE MenuItemController SHALL persist the preset value in the `category` column and leave `custom_category` as null.
3. THE MenuItemController SHALL compute the Effective_Category as `custom_category` when `custom_category` is non-null and non-empty, otherwise as `category`.
4. THE MenuItemController SHALL validate that the Effective_Category is not null and not an empty string before saving a MenuItem.
5. WHEN a vendor provides both a preset `category` and a non-empty `custom_category`, THE system SHALL use `custom_category` as the Effective_Category and ignore the preset value for display purposes.
6. FOR ALL MenuItems, the Effective_Category SHALL equal `custom_category` when `custom_category` is non-null and non-empty, and SHALL equal `category` otherwise. (Invariant property — must hold after every create and update operation.)

---

### Requirement 3: Bulk Availability Toggle

**User Story:** As a vendor, I want to select multiple menu items and toggle their availability at once, so that I can quickly mark items as sold out or available at the start or end of service.

#### Acceptance Criteria

1. THE vendor menu index page SHALL provide a checkbox on each MenuItem card that allows the vendor to select one or more items for bulk action.
2. WHEN a vendor selects one or more MenuItems and submits the bulk availability action, THE Bulk_Toggle SHALL send a single AJAX request containing the array of selected MenuItem IDs and the target availability state.
3. WHEN THE Bulk_Toggle receives a valid request, THE MenuItemController SHALL update `is_available` to the requested state for every MenuItem ID in the request that belongs to the authenticated vendor.
4. IF a Bulk_Toggle request contains a MenuItem ID that does not belong to the authenticated vendor, THEN THE MenuItemController SHALL skip that ID and SHALL NOT modify it, and SHALL return a 200 response with a count of successfully updated items.
5. THE Bulk_Toggle endpoint SHALL require at least one MenuItem ID; IF the ID array is empty, THEN THE MenuItemController SHALL return a validation error.
6. WHEN the Bulk_Toggle AJAX request completes successfully, THE vendor menu index page SHALL update the availability badge of each affected item without a full page reload.
7. FOR ALL bulk toggle operations: the count of items updated SHALL equal the count of IDs in the request that belong to the authenticated vendor. (Metamorphic property.)

---

### Requirement 4: Display Order Management

**User Story:** As a vendor, I want to reorder my menu items within each category, so that I can control which items appear first on the student-facing menu.

#### Acceptance Criteria

1. THE vendor menu index page SHALL display menu items grouped by Effective_Category and sorted by `display_order` ascending within each group.
2. THE vendor menu index page SHALL provide a drag-and-drop interface that allows the vendor to reorder items within a category.
3. WHEN a vendor saves a new item order, THE MenuItemController SHALL receive an ordered array of MenuItem IDs and update each item's `display_order` to its position index (0-based) in the submitted array.
4. WHEN the display order is saved, THE MenuItemController SHALL only update items that belong to the authenticated vendor; items belonging to other vendors SHALL be ignored.
5. AFTER a display order save, THE vendor menu index page and the student-facing vendor menu page SHALL render items in the newly saved `display_order` sequence within each category.
6. FOR ALL display order save operations: the set of MenuItem IDs belonging to the vendor SHALL be identical before and after the operation — only the `display_order` values change. (Invariant property.)
7. FOR ALL display order save operations: fetching the vendor's items sorted by `display_order` after saving SHALL return items in the same sequence as the submitted ID array. (Round-trip property.)

---

### Requirement 5: Student-Facing Menu Image Display

**User Story:** As a student, I want to see real photos of food items on the vendor menu page, so that I can make more informed ordering decisions.

#### Acceptance Criteria

1. WHEN a MenuItem has a non-null `image_url`, THE student-facing vendor menu page SHALL render an `<img>` element whose `src` attribute is set to `Storage::url($image_url)`.
2. WHEN a MenuItem has a null `image_url`, THE student-facing vendor menu page SHALL render the existing category-based emoji placeholder in place of a photo.
3. THE student-facing vendor menu page SHALL display all images with a consistent aspect ratio (16:9 or 4:3) using CSS `object-fit: cover` so that images of varying dimensions do not distort the layout.
4. THE student-facing vendor menu page SHALL group and sort items by Effective_Category and then by `display_order` ascending, consistent with the vendor dashboard view.

---

### Requirement 6: Vendor Dashboard Theme Consistency

**User Story:** As a vendor, I want the menu management pages to use the same brown brand color as the rest of the app, so that the interface feels consistent.

#### Acceptance Criteria

1. THE vendor menu index, create, and edit views SHALL use the brown brand color (`#724e2c` / `#563517` gradient) for the navigation border, header gradient, and primary action buttons, replacing the existing indigo/purple theme.
2. THE vendor menu index, create, and edit views SHALL apply the brown theme consistently with the student-facing pages and the vendor dashboard page.

---

### Requirement 7: Input Validation and Security

**User Story:** As a system administrator, I want all vendor menu inputs to be validated server-side, so that invalid or malicious data cannot corrupt the database or expose the application to attack.

#### Acceptance Criteria

1. THE MenuItemController SHALL validate all fields on store and update: `name` (required, string, max 255), `description` (nullable, string, max 1000), `price` (required, numeric, min 0.01, max 99999.99), `category` (nullable, string, max 100), `custom_category` (nullable, string, max 100), `display_order` (nullable, integer, min 0).
2. THE MenuItemController SHALL verify on every store, update, destroy, toggleAvailability, bulkToggle, and reorder request that the target MenuItem's `vendor_id` matches the authenticated vendor's id, returning HTTP 403 if not.
3. IF a vendor submits a `price` of 0 or a negative number, THEN THE MenuItemController SHALL return a validation error.
4. THE Image_Uploader SHALL generate a unique filename (e.g., using `Str::uuid()`) when storing uploaded images to prevent filename collisions and path traversal attacks.
5. THE MenuItemController SHALL use Laravel's `$request->validate()` or a dedicated Form Request class for all validation, ensuring validation errors are returned before any database write or file operation occurs.

---

## Correctness Properties for Property-Based Testing

The following properties are suitable for property-based tests using PHPUnit with a data provider or a library such as `eris/eris`.

### Property 1: Effective_Category Invariant

For any MenuItem created or updated with arbitrary combinations of `category` and `custom_category` values:
- IF `custom_category` is non-null and non-empty, THEN `effective_category == custom_category`
- IF `custom_category` is null or empty, THEN `effective_category == category`

This invariant must hold after every create and update operation regardless of input order.

### Property 2: Bulk Toggle Metamorphic Property

For any set S of MenuItem IDs belonging to the authenticated vendor, after a bulk toggle to state X:
- The count of items updated equals |S ∩ vendor_item_ids|
- Every item in S ∩ vendor_item_ids has `is_available == X`
- Every item NOT in S retains its original `is_available` value

### Property 3: Bulk Toggle Idempotence

Applying a bulk toggle to state X twice in a row produces the same result as applying it once:
- `bulkToggle(ids, X)` followed by `bulkToggle(ids, X)` leaves all items with `is_available == X`

### Property 4: Display Order Round-Trip

For any permutation P of a vendor's MenuItem IDs:
- After `saveOrder(P)`, fetching the vendor's items sorted by `display_order` returns items in the same sequence as P

### Property 5: Display Order Set Invariant

For any display order save operation:
- The set of MenuItem IDs belonging to the vendor is identical before and after the operation
- Only `display_order` values change; no items are created or deleted

### Property 6: Image Upload Round-Trip

For any valid image file F uploaded for a MenuItem:
- After upload, `MenuItem.image_url` is non-null
- `Storage::url(MenuItem.image_url)` returns a URL that resolves to a publicly accessible file
- After a replacement upload, the old file path no longer exists on the Public_Disk

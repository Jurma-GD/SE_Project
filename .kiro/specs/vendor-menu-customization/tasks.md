# Implementation Plan: Vendor Menu Customization

## Overview

Extends the existing menu item system to support image uploads and custom categories. Builds on the existing `MenuItemController`, `MenuItem` model, and vendor Blade views. The migration adding the new columns already exists.

## Tasks

- [x] 1. Update MenuItem model and run migration
  - Add new fields to `$fillable`: `image_url`, `custom_category`, `tags`, `preparation_time`, `is_spicy`, `is_vegetarian`, `is_featured`, `stock_quantity`, `customization_options`, `allergen_info`, `calories`, `display_order`
  - Add casts for `tags` and `customization_options` as `array`, `is_spicy`/`is_vegetarian`/`is_featured` as `boolean`
  - Run `php artisan migrate` to apply the existing customization fields migration
  - _Requirements: 1.1, 1.2, 1.3, 2.6_

- [x] 2. Implement image upload in MenuItemController
  - [x] 2.1 Add image handling to `store()` method
    - Validate `image` input: `nullable|image|mimes:jpeg,png,gif,webp|max:2048`
    - If image present, store to `storage/app/public/menu-images/` using `$request->file('image')->store('menu-images', 'public')`
    - Save returned relative path to `image_url`
    - _Requirements: 1.1, 1.4, 1.5_

  - [x] 2.2 Add image handling to `update()` method
    - Validate `image` input: `nullable|image|mimes:jpeg,png,gif,webp|max:2048`
    - If new image uploaded, delete old file via `Storage::disk('public')->delete($menuItem->image_url)` then store new file
    - If no new image, retain existing `image_url`
    - Handle `remove_image` flag: delete file and set `image_url` to null
    - _Requirements: 1.2, 1.3, 1.4, 1.5, 4.2_

  - [x] 2.3 Delete image file in `destroy()` method
    - Before deleting the model, check if `image_url` is non-null
    - Call `Storage::disk('public')->delete($menuItem->image_url)` to remove the file
    - _Requirements: 1.10_

  - [ ]* 2.4 Write feature tests for image upload
    - Test store with valid image saves file and sets `image_url`
    - Test store with oversized file returns validation error
    - Test store with invalid MIME type returns validation error
    - Test update with new image replaces old file
    - Test update without image retains existing `image_url`
    - Test destroy deletes associated image file
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.10_

- [x] 3. Implement custom category suggestions in MenuItemController
  - [x] 3.1 Pass existing categories to create/edit views
    - In `create()`, query `$vendor->menuItems()->whereNotNull('category')->distinct()->pluck('category')` and pass as `$existingCategories`
    - In `edit()`, do the same and pass alongside `$menuItem`
    - _Requirements: 2.2, 2.4_

  - [x] 3.2 Update validation in `store()` and `update()` for category
    - Change category validation rule to `nullable|string|max:100`
    - Store the submitted value directly without modification
    - _Requirements: 2.1, 2.5, 2.6, 2.7_

  - [ ]* 3.3 Write feature tests for custom categories
    - Test that categories exceeding 100 characters are rejected
    - Test that empty category stores null
    - Test that valid category is stored as-is
    - Test that existing categories are passed to the view
    - _Requirements: 2.1, 2.5, 2.6, 2.7_

- [x] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Update vendor create/edit Blade views
  - [x] 5.1 Add image upload field to `create.blade.php`
    - Add `enctype="multipart/form-data"` to the form
    - Add `<input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp">`
    - Add JS-driven image preview: on `change` event, read file with `FileReader` and show `<img>` preview; on clear, hide preview
    - _Requirements: 1.1, 3.1, 3.2_

  - [x] 5.2 Add image upload field to `edit.blade.php`
    - Add `enctype="multipart/form-data"` to the form
    - Show existing image as initial preview when `$menuItem->image_url` is non-null
    - Add file input with same accept types
    - Add "Remove Image" checkbox/button that sets a hidden `remove_image` input to `1` and hides the preview
    - Add JS preview logic consistent with create form
    - _Requirements: 1.2, 1.3, 3.1, 3.2, 3.3, 4.1, 4.2_

  - [x] 5.3 Replace hardcoded category dropdown with free-text input and suggestions
    - Replace `<select>` with `<input type="text" name="category">` pre-filled with existing value
    - Render `$existingCategories` as a `<datalist>` linked to the input, or as clickable suggestion chips below the input
    - Clicking a suggestion populates the text input via JS
    - _Requirements: 2.1, 2.2, 2.3_

- [x] 6. Update vendor menu index view to display images
  - In `resources/views/vendor/menu-items/index.blade.php`, update each item card:
    - If `$item->image_url` is non-null, render `<img src="{{ Storage::url($item->image_url) }}">`
    - Otherwise render the existing category-based emoji placeholder
  - _Requirements: 1.6, 1.8_

- [x] 7. Update student vendor view to display images
  - In `resources/views/students/vendor.blade.php`, update each menu item display:
    - If `$item->image_url` is non-null, render `<img src="{{ Storage::url($item->image_url) }}">`
    - Otherwise render the existing category-based emoji placeholder
  - Ensure category label is always displayed regardless of image presence
  - _Requirements: 1.7, 1.9, 5.1, 5.2, 5.3_

- [x] 8. Final checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for a faster MVP
- The database migration (`2026_03_12_110714_add_customization_fields_to_menu_items_table.php`) already exists and only needs to be run
- Use `Storage::disk('public')` and `Storage::url()` consistently; ensure `php artisan storage:link` has been run
- The `remove_image` flag in the edit form should be a hidden input set to `1` by JS when the vendor clicks "Remove Image"

# Requirements Document

## Introduction

This feature enhances the CampusEats vendor menu management experience by allowing vendors to upload real images for their menu items (replacing emoji/placeholder icons) and to define their own custom food categories (replacing the hardcoded dropdown list). The goal is to give vendors more creative freedom and control when building and maintaining their menus, resulting in a more visually appealing and accurately categorized menu for students.

## Glossary

- **Vendor**: An authenticated user with the vendor role who owns a food stall on CampusEats.
- **MenuItem**: A food or beverage item belonging to a Vendor, stored in the `menu_items` table.
- **Menu_Image**: A photo file uploaded by a Vendor to represent a MenuItem visually.
- **Category**: A text label assigned to a MenuItem to group it with similar items.
- **Image_Upload_Service**: The Laravel component responsible for validating, storing, and retrieving Menu_Image files using the public storage disk.
- **Category_Manager**: The UI component that allows a Vendor to select an existing category or type a new one when creating or editing a MenuItem.
- **Student**: An authenticated user with the student role who browses vendor menus.

---

## Requirements

### Requirement 1: Menu Item Image Upload

**User Story:** As a vendor, I want to upload a photo for each menu item, so that students can see what the food looks like instead of a generic emoji placeholder.

#### Acceptance Criteria

1. WHEN a Vendor submits the create menu item form with an image file, THE Image_Upload_Service SHALL store the file in `storage/app/public/menu-images/` and save the relative path to the `image_url` column of the MenuItem.
2. WHEN a Vendor submits the edit menu item form with a new image file, THE Image_Upload_Service SHALL replace the previously stored image and update the `image_url` column of the MenuItem.
3. WHEN a Vendor submits the edit menu item form without selecting a new image file, THE Image_Upload_Service SHALL retain the existing `image_url` value on the MenuItem.
4. THE Image_Upload_Service SHALL accept only files with MIME types `image/jpeg`, `image/png`, `image/gif`, and `image/webp`.
5. THE Image_Upload_Service SHALL reject any uploaded file exceeding 2048 kilobytes and return a validation error message to the Vendor.
6. WHEN a MenuItem has a non-null `image_url`, THE vendor menu index view SHALL display the stored image in the item card instead of the emoji placeholder.
7. WHEN a MenuItem has a non-null `image_url`, THE student vendor view SHALL display the stored image instead of the emoji placeholder.
8. WHEN a MenuItem has a null `image_url`, THE vendor menu index view SHALL display the category-based emoji placeholder as a fallback.
9. WHEN a MenuItem has a null `image_url`, THE student vendor view SHALL display the category-based emoji placeholder as a fallback.
10. WHEN a Vendor deletes a MenuItem that has a stored image, THE Image_Upload_Service SHALL delete the associated image file from storage.

---

### Requirement 2: Custom Food Categories

**User Story:** As a vendor, I want to define my own food categories, so that my menu accurately reflects my stall's offerings without being limited to a preset list.

#### Acceptance Criteria

1. WHEN a Vendor opens the create or edit menu item form, THE Category_Manager SHALL display a text input that allows the Vendor to type any category name up to 100 characters.
2. WHEN a Vendor opens the create or edit menu item form, THE Category_Manager SHALL display the Vendor's previously used categories as selectable suggestions below the text input.
3. WHEN a Vendor selects a suggestion, THE Category_Manager SHALL populate the category text input with the selected suggestion value.
4. THE Category_Manager SHALL derive the suggestion list from the distinct `category` values of all MenuItems belonging to the authenticated Vendor.
5. IF a Vendor submits a category value exceeding 100 characters, THEN THE MenuItemController SHALL reject the request and return a validation error message.
6. THE MenuItem SHALL store the category value entered by the Vendor in the `category` column without modification.
7. WHEN a Vendor leaves the category field empty, THE MenuItemController SHALL store a null value in the `category` column of the MenuItem.

---

### Requirement 3: Image Preview Before Save

**User Story:** As a vendor, I want to preview the image I selected before saving the menu item, so that I can confirm it looks correct before publishing.

#### Acceptance Criteria

1. WHEN a Vendor selects an image file in the create or edit form, THE create/edit view SHALL display a preview of the selected image within the same form page without a page reload.
2. WHEN a Vendor removes the selected file from the file input, THE create/edit view SHALL hide the image preview and restore the previous placeholder or existing image display.
3. WHEN the edit form loads for a MenuItem with an existing `image_url`, THE edit view SHALL display the current stored image as the initial preview.

---

### Requirement 4: Image Removal

**User Story:** As a vendor, I want to remove an existing image from a menu item, so that I can revert to the emoji placeholder if needed.

#### Acceptance Criteria

1. WHEN a MenuItem has a non-null `image_url`, THE edit view SHALL display a "Remove Image" option alongside the current image preview.
2. WHEN a Vendor confirms image removal and submits the edit form, THE Image_Upload_Service SHALL delete the stored image file and set the `image_url` column of the MenuItem to null.
3. WHEN the `image_url` of a MenuItem is set to null after removal, THE vendor menu index view SHALL display the category-based emoji placeholder for that item.

---

### Requirement 5: Student-Facing Menu Display

**User Story:** As a student, I want to see real food photos on vendor menus, so that I can make more informed ordering decisions.

#### Acceptance Criteria

1. WHEN a student views a vendor's menu page, THE student vendor view SHALL display the Menu_Image for each MenuItem that has a non-null `image_url`.
2. WHEN a student views a vendor's menu page, THE student vendor view SHALL display the category-based emoji placeholder for each MenuItem that has a null `image_url`.
3. WHEN a student views a vendor's menu page, THE student vendor view SHALL display the category label for each MenuItem regardless of whether a Menu_Image is present.

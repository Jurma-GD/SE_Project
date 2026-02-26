# Implementation Plan: Vendor Menu System

## Overview

This implementation plan breaks down the Vendor Menu System into incremental coding tasks. The system will be built using Laravel 12's MVC architecture with Eloquent models, Blade views, and RESTful controllers. Each task builds on previous work, with property-based tests integrated throughout to validate correctness early.

## Tasks

- [x] 1. Set up database schema and migrations
  - Create migration for users table modification (add role column)
  - Create migration for vendors table
  - Create migration for menu_items table
  - Create migration for orders table
  - Create migration for order_items table
  - Add foreign key constraints and indexes
  - _Requirements: 1.1, 1.4, 2.1, 8.1_

- [x] 2. Create Eloquent models with relationships
  - [x] 2.1 Extend User model with role functionality
    - Add role column to fillable array
    - Add isVendor() and isStudent() helper methods
    - Define vendor() relationship (hasOne)
    - Define orders() relationship (hasMany)
    - _Requirements: 1.1, 1.2_
  
  - [x] 2.2 Create Vendor model
    - Define fillable attributes
    - Define user() relationship (belongsTo)
    - Define menuItems() relationship (hasMany)
    - Define orders() relationship (hasMany)
    - _Requirements: 1.4_
  
  - [x] 2.3 Create MenuItem model
    - Define fillable attributes and casts
    - Define vendor() relationship (belongsTo)
    - Define orderItems() relationship (hasMany)
    - Add scopeAvailable() query scope
    - _Requirements: 2.1, 2.4_
  
  - [x] 2.4 Create Order model
    - Define fillable attributes and casts
    - Add status constants (PENDING, READY, COMPLETED, CANCELLED)
    - Define user() relationship (belongsTo)
    - Define vendor() relationship (belongsTo)
    - Define orderItems() relationship (hasMany)
    - Add status query scopes (scopePending, scopeReady, scopeCompleted)
    - _Requirements: 8.1, 8.2, 9.1_
  
  - [x] 2.5 Create OrderItem model
    - Define fillable attributes and casts
    - Define order() relationship (belongsTo)
    - Define menuItem() relationship (belongsTo)
    - _Requirements: 8.1_

- [x] 3. Create model factories for testing
  - [x] 3.1 Create UserFactory with vendor and student traits
    - Generate realistic user data with Faker
    - Add vendor() and student() state methods
    - _Requirements: 1.1_
  
  - [x] 3.2 Create VendorFactory
    - Generate vendor profiles with location and contact info
    - Associate with User factory
    - _Requirements: 1.4_
  
  - [x] 3.3 Create MenuItemFactory
    - Generate menu items with varied prices and categories
    - Associate with Vendor factory
    - Include available and unavailable states
    - _Requirements: 2.1_
  
  - [x] 3.4 Create OrderFactory and OrderItemFactory
    - Generate orders with unique order numbers
    - Generate order items with quantities
    - Associate with User and Vendor factories
    - _Requirements: 8.1, 8.2_

- [ ]* 4. Write property tests for models (Part 1)
  - [ ]* 4.1 Write property test for vendor registration
    - **Property 1: Vendor Registration Creates Unique Accounts**
    - **Validates: Requirements 1.1, 1.4**
  
  - [ ]* 4.2 Write property test for menu item CRUD
    - **Property 3: Menu Item CRUD Operations Persist Correctly**
    - **Validates: Requirements 2.1, 2.2, 2.3, 11.1**
  
  - [ ]* 4.3 Write property test for order creation
    - **Property 13: Order Creation Stores Complete Information**
    - **Validates: Requirements 8.1**
  
  - [ ]* 4.4 Write property test for unique order numbers
    - **Property 14: Order Numbers Are Unique**
    - **Validates: Requirements 8.2**

- [x] 5. Implement authentication and role middleware
  - [x] 5.1 Set up Laravel authentication scaffolding
    - Configure authentication routes
    - Update registration to include role selection
    - _Requirements: 1.1, 1.2_
  
  - [x] 5.2 Create RoleMiddleware
    - Implement role checking logic (vendor/student)
    - Register middleware in HTTP kernel
    - _Requirements: 1.2, 1.3_
  
  - [ ]* 5.3 Write property test for authentication
    - **Property 2: Authentication Correctness**
    - **Validates: Requirements 1.2, 1.3**

- [x] 6. Create vendor controllers and routes
  - [x] 6.1 Create VendorController
    - Implement dashboard() method
    - Implement profile() and updateProfile() methods
    - Add validation for profile updates
    - _Requirements: 1.4_
  
  - [x] 6.2 Create MenuItemController
    - Implement index() to list vendor's menu items
    - Implement create() and store() for adding items
    - Implement edit() and update() for modifying items
    - Implement destroy() for deleting items
    - Implement toggleAvailability() for AJAX updates
    - Add validation rules for menu items
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_
  
  - [x] 6.3 Define vendor routes with middleware
    - Group routes under /vendor prefix
    - Apply auth and vendor middleware
    - Define resource routes for menu items
    - Add custom route for availability toggle
    - _Requirements: 1.2, 2.1_

- [ ]* 7. Write property tests for menu management
  - [ ]* 7.1 Write property test for availability toggle
    - **Property 4: Availability Toggle Reflects in Student Views**
    - **Validates: Requirements 2.4, 2.5, 3.2, 5.1, 5.2**
  
  - [ ]* 7.2 Write property test for multiple menu items
    - **Property 6: Multiple Menu Items Can Be Managed**
    - **Validates: Requirements 3.3**
  
  - [ ]* 7.3 Write property test for input validation
    - **Property 23: Input Validation Prevents Invalid Data**
    - **Validates: Requirements 11.3**

- [x] 8. Create student browsing controllers and routes
  - [x] 8.1 Create StudentController
    - Implement index() to show all vendors with menus
    - Implement showVendor() to display vendor's menu
    - Implement search() for menu item search
    - Implement myOrders() to show student's orders
    - _Requirements: 4.1, 4.2, 7.1_
  
  - [x] 8.2 Define public and student routes
    - Add public routes for browsing (no auth required)
    - Add authenticated student routes for orders
    - _Requirements: 4.4_

- [ ]* 9. Write property tests for student browsing
  - [ ]* 9.1 Write property test for menu visibility
    - **Property 5: Published Menus Are Visible to Students**
    - **Validates: Requirements 3.1, 4.1, 4.2**
  
  - [ ]* 9.2 Write property test for availability distinction
    - **Property 7: Available and Unavailable Items Are Distinguished**
    - **Validates: Requirements 4.3**
  
  - [ ]* 9.3 Write property test for vendor information
    - **Property 9: Vendor Information Completeness**
    - **Validates: Requirements 6.1, 6.2, 6.3**

- [x] 10. Implement search and filtering functionality
  - [x] 10.1 Add search logic to StudentController
    - Implement search by item name and description
    - Implement filter by vendor
    - Implement filter by availability
    - Return filtered results
    - _Requirements: 7.1, 7.2, 7.3_
  
  - [ ]* 10.2 Write property tests for search and filtering
    - **Property 10: Search Returns Matching Items**
    - **Property 11: Vendor Filtering Works Correctly**
    - **Property 12: Availability Filtering Works Correctly**
    - **Validates: Requirements 7.1, 7.2, 7.3**

- [x] 11. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 12. Implement order placement functionality
  - [x] 12.1 Create OrderController with student methods
    - Implement store() to create orders
    - Validate item availability before order creation
    - Generate unique order numbers
    - Calculate total amount
    - Create order and order items in transaction
    - Return order confirmation
    - _Requirements: 8.1, 8.2, 8.3, 8.5_
  
  - [x] 12.2 Implement show() method for order details
    - Display order information
    - Show order items with quantities and prices
    - Display order status
    - _Requirements: 8.4, 8.5_
  
  - [x] 12.3 Add order routes
    - POST /orders for order creation
    - GET /orders/{order} for order details
    - GET /my-orders for student's order list
    - _Requirements: 8.1, 8.4_

- [ ]* 13. Write property tests for order placement
  - [ ]* 13.1 Write property test for unavailable items rejection
    - **Property 15: Unavailable Items Cannot Be Ordered**
    - **Validates: Requirements 8.3**
  
  - [ ]* 13.2 Write property test for order viewing
    - **Property 16: Students Can View Their Orders**
    - **Validates: Requirements 8.4**
  
  - [ ]* 13.3 Write property test for order confirmation
    - **Property 17: Order Confirmation Contains Required Information**
    - **Validates: Requirements 8.5**

- [x] 14. Implement vendor order management
  - [x] 14.1 Add vendor order methods to OrderController
    - Implement vendorOrders() to list vendor's orders
    - Implement updateStatus() for status changes
    - Implement markReady() to mark orders ready
    - Implement markCompleted() to complete orders
    - Add status filtering
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5_
  
  - [x] 14.2 Add vendor order routes
    - GET /vendor/orders for order queue
    - POST /vendor/orders/{order}/ready
    - POST /vendor/orders/{order}/complete
    - _Requirements: 9.1, 9.2, 9.3_

- [ ]* 15. Write property tests for order management
  - [ ]* 15.1 Write property test for order queue visibility
    - **Property 18: New Orders Appear in Vendor Queue**
    - **Validates: Requirements 9.1**
  
  - [ ]* 15.2 Write property test for status transitions
    - **Property 19: Order Status Transitions Persist**
    - **Validates: Requirements 9.2, 9.3, 9.5**
  
  - [ ]* 15.3 Write property test for status filtering
    - **Property 20: Order Status Filtering Works**
    - **Validates: Requirements 9.4**

- [ ] 16. Implement order notification system
  - [ ] 16.1 Add notification display to student dashboard
    - Query for ready orders
    - Display notification badge/indicator
    - Show order number and vendor location
    - Distinguish order statuses visually
    - _Requirements: 10.1, 10.2, 10.3, 10.4_
  
  - [ ]* 16.2 Write property tests for notifications
    - **Property 21: Ready Orders Display Notifications**
    - **Property 22: Order Status Is Visually Distinguished**
    - **Validates: Requirements 10.1, 10.2, 10.3, 10.4**

- [x] 17. Create Blade views for vendor interface
  - [x] 17.1 Create vendor dashboard view
    - Display vendor profile summary
    - Show quick stats (total items, pending orders)
    - Include navigation to menu and orders
    - _Requirements: 1.4_
  
  - [x] 17.2 Create menu item management views
    - Create index view listing all menu items
    - Create create/edit forms with validation
    - Add availability toggle buttons
    - Style with Tailwind CSS
    - _Requirements: 2.1, 2.2, 2.3, 2.4_
  
  - [x] 17.3 Create vendor order management views
    - Create order queue view with status tabs
    - Display order details with items
    - Add action buttons (mark ready, complete)
    - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [x] 18. Create Blade views for student interface
  - [x] 18.1 Create home page with vendor listings
    - Display all vendors with published menus
    - Show vendor location and basic info
    - Add search bar
    - Style with Tailwind CSS
    - _Requirements: 4.1, 4.4, 7.1_
  
  - [x] 18.2 Create vendor menu detail view
    - Display vendor information prominently
    - List all menu items with prices
    - Distinguish available/unavailable items
    - Add order form/cart functionality
    - _Requirements: 4.2, 4.3, 5.1, 5.2, 6.1, 6.3_
  
  - [x] 18.3 Create student order views
    - Create my orders page with status filtering
    - Display order details with items
    - Show notifications for ready orders
    - Highlight order number and pickup location
    - _Requirements: 8.4, 10.2, 10.3, 10.4_
  
  - [x] 18.4 Create search results view
    - Display filtered menu items
    - Show vendor information for each item
    - Support multiple filter types
    - _Requirements: 7.1, 7.2, 7.3_

- [ ] 19. Add frontend interactivity with JavaScript
  - [ ] 19.1 Implement AJAX availability toggle
    - Add click handler for availability buttons
    - Send AJAX request to toggle endpoint
    - Update UI without page reload
    - _Requirements: 2.4, 3.2_
  
  - [ ] 19.2 Implement real-time search
    - Add input event listener for search field
    - Debounce search requests
    - Update results dynamically
    - _Requirements: 7.1_
  
  - [ ] 19.3 Add order cart functionality
    - Implement add to cart with quantities
    - Show cart summary
    - Validate before submission
    - _Requirements: 8.1_

- [ ]* 20. Write unit tests for edge cases
  - [ ]* 20.1 Test empty menu scenario
    - Verify display when vendor has no menu items
    - _Requirements: 3.4_
  
  - [ ]* 20.2 Test validation edge cases
    - Test boundary values for prices (0, negative, very large)
    - Test empty strings and whitespace
    - Test invalid quantities
    - _Requirements: 11.3_
  
  - [ ]* 20.3 Test error handling
    - Test database error scenarios
    - Test authentication failures
    - Test authorization failures
    - _Requirements: 11.4_

- [ ] 21. Create database seeders for development
  - [ ] 21.1 Create VendorSeeder
    - Generate sample vendors with profiles
    - Create associated user accounts
    - _Requirements: 1.1, 1.4_
  
  - [ ] 21.2 Create MenuItemSeeder
    - Generate varied menu items for each vendor
    - Include different categories and price ranges
    - Mix available and unavailable items
    - _Requirements: 2.1_
  
  - [ ] 21.3 Create OrderSeeder
    - Generate sample orders in different statuses
    - Create realistic order histories
    - _Requirements: 8.1_

- [ ] 22. Final checkpoint - Ensure all tests pass
  - Run full test suite (unit and property tests)
  - Verify all routes are accessible
  - Check validation on all forms
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 23. Polish and final integration
  - [ ] 23.1 Add timestamps display throughout UI
    - Show last updated times for menu items
    - Display order creation times
    - _Requirements: 5.4_
  
  - [ ] 23.2 Improve error messages and user feedback
    - Add flash messages for success/error states
    - Improve validation error display
    - Add loading states for AJAX operations
    - _Requirements: 1.3, 8.3, 11.4_
  
  - [ ] 23.3 Add responsive design touches
    - Ensure mobile-friendly layouts
    - Test on different screen sizes
    - Optimize navigation for mobile
  
  - [ ] 23.4 Run Laravel Pint for code style
    - Fix any code style issues
    - Ensure PSR-12 compliance

## Notes

- Tasks marked with `*` are optional property-based and unit tests that can be skipped for faster MVP
- Each task references specific requirements for traceability
- Property tests validate universal correctness properties with 100+ iterations
- Unit tests validate specific examples and edge cases
- Checkpoints ensure incremental validation throughout development
- All views use Blade templates with Tailwind CSS for consistent styling
- AJAX operations enhance UX without requiring full page reloads

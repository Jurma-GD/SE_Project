# 🔑 Test Credentials

## CampusEats Test Accounts

Use these credentials to test the application:

### 🎓 Student Account
- **Email:** `student@test.com`
- **Password:** `password`
- **Access:** Browse vendors, view menus, place orders

### 🏪 Vendor Account (Kwago)
- **Email:** `vendor@test.com`
- **Password:** `password`
- **Vendor Name:** Kwago
- **Location:** Main Building, Ground Floor - Near Library
- **Access:** Manage menu items, view and process orders

### 🍴 Vendor Account (Canteen)
- **Email:** `canteen@test.com`
- **Password:** `password`
- **Vendor Name:** Canteen
- **Location:** Student Center, 2nd Floor
- **Access:** Manage menu items, view and process orders

---

## Quick Start

1. **Reset Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Start Development Server:**
   ```bash
   composer dev
   ```

3. **Login:**
   - Visit `http://localhost:8000`
   - Use any of the credentials above

---

## Notes

- All passwords are `password` for easy testing
- The database seeder creates sample menu items for both vendors
- Students can browse all vendor menus and place orders
- Vendors can only manage their own menu items and orders

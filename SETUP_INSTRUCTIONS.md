# CampusEats Setup Instructions

Follow these steps to set up the project on your local machine.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL/MariaDB (or use SQLite for simpler setup)

## Setup Steps

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

### 3. Choose Your Database Option

#### Option A: Using MySQL/MariaDB

1. Create a new database in MySQL:
   ```sql
   CREATE DATABASE se_project;
   ```

2. Update your `.env` file with YOUR MySQL credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=se_project
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password_here
   ```
   
   **Important**: Replace `your_mysql_password_here` with your actual MySQL root password!

#### Option B: Using SQLite (Easier - Recommended for Development)

1. Update your `.env` file:
   ```env
   DB_CONNECTION=sqlite
   # Comment out or remove these lines:
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=se_project
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

2. Create the SQLite database file:
   ```bash
   touch database/database.sqlite
   ```
   
   On Windows (PowerShell):
   ```powershell
   New-Item database/database.sqlite -ItemType File
   ```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This will create all the necessary tables and populate them with sample data.

### 6. Build Frontend Assets

```bash
npm run build
```

### 7. Start the Development Server

```bash
composer dev
```

Or run individually:
```bash
php artisan serve
npm run dev
```

### 8. Access the Application

Open your browser and go to: `http://localhost:8000`

## Default Test Accounts

After seeding, you can log in with these accounts:

**Vendor Account:**
- Email: `vendor@example.com`
- Password: `password`

**Student Account:**
- Email: `student@example.com`
- Password: `password`

## Troubleshooting

### "Access denied for user 'root'@'localhost'"

This means your MySQL password is incorrect. Either:
1. Update `DB_PASSWORD` in `.env` with your correct MySQL password
2. Switch to SQLite (see Option B above)

### "SQLSTATE[HY000] [2002] No connection could be made"

This means MySQL is not running. Either:
1. Start your MySQL service
2. Switch to SQLite (see Option B above)

### "Class 'X' not found"

Run:
```bash
composer dump-autoload
```

### Assets not loading

Run:
```bash
npm run build
php artisan config:clear
php artisan cache:clear
```

## Need Help?

Contact the project maintainer or check the Laravel documentation at https://laravel.com/docs

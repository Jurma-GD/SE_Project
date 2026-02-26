---
inclusion: always
---

# Technology Stack

## Backend
- PHP 8.2+
- Laravel Framework 12.0
- Composer for dependency management

## Frontend
- Vite 7.0 (build tool and dev server)
- Tailwind CSS 4.0
- Axios for HTTP requests
- Laravel Vite Plugin for asset compilation

## Testing
- PHPUnit 11.5
- Laravel's built-in testing utilities
- Faker for test data generation
- Mockery for mocking

## Development Tools
- Laravel Pint (code style fixer)
- Laravel Sail (Docker development environment)
- Laravel Tinker (REPL)
- Laravel Pail (log viewer)
- Concurrently (run multiple commands)

## Common Commands

### Setup
```bash
composer setup
```
Installs dependencies, creates .env, generates app key, runs migrations, and builds assets.

### Development
```bash
composer dev
```
Starts PHP dev server, queue worker, and Vite dev server concurrently.

Or run individually:
```bash
php artisan serve          # Start development server
npm run dev                # Start Vite dev server
php artisan queue:listen   # Start queue worker
```

### Testing
```bash
composer test
# or
php artisan test
```

### Code Style
```bash
./vendor/bin/pint          # Fix code style issues
```

### Database
```bash
php artisan migrate        # Run migrations
php artisan migrate:fresh  # Drop all tables and re-run migrations
php artisan db:seed        # Run database seeders
```

### Cache Management
```bash
php artisan config:cache   # Cache configuration
php artisan config:clear   # Clear configuration cache
php artisan cache:clear    # Clear application cache
php artisan view:clear     # Clear compiled views
```

### Asset Compilation
```bash
npm run build              # Build production assets
npm run dev                # Start Vite dev server with HMR
```

## Code Style Conventions
- 4 spaces for indentation (PHP, JS, CSS)
- 2 spaces for YAML files
- LF line endings
- UTF-8 encoding
- Trim trailing whitespace
- Insert final newline
- Follow PSR-12 coding standards (enforced by Laravel Pint)

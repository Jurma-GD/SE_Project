---
inclusion: always
---

# Project Structure

## Root Directory Layout

```
├── app/                    # Application core code
├── bootstrap/              # Framework bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations, factories, seeders
├── public/                 # Web server document root
├── resources/              # Views, raw assets (CSS, JS)
├── routes/                 # Route definitions
├── storage/                # Compiled views, logs, cache
├── tests/                  # Automated tests
└── vendor/                 # Composer dependencies
```

## Application Directory (`app/`)

```
app/
├── Http/
│   └── Controllers/        # HTTP controllers
├── Models/                 # Eloquent models
└── Providers/              # Service providers
```

### Key Conventions
- Controllers go in `app/Http/Controllers/`
- Models go in `app/Models/`
- Use singular names for models (e.g., `User.php`, not `Users.php`)
- Controllers should be suffixed with `Controller` (e.g., `UserController.php`)
- Service providers go in `app/Providers/`

## Database Directory (`database/`)

```
database/
├── factories/              # Model factories for testing
├── migrations/             # Database migrations
└── seeders/                # Database seeders
```

### Conventions
- Migration files are timestamped automatically
- Factory classes should match model names with `Factory` suffix
- Main seeder is `DatabaseSeeder.php`

## Resources Directory (`resources/`)

```
resources/
├── css/                    # CSS source files
├── js/                     # JavaScript source files
└── views/                  # Blade templates
```

### Conventions
- Blade templates use `.blade.php` extension
- Entry points for Vite: `resources/css/app.css` and `resources/js/app.js`
- Views are referenced using dot notation (e.g., `welcome` for `welcome.blade.php`)

## Routes Directory (`routes/`)

- `web.php` - Web routes (with session, CSRF protection)
- `console.php` - Artisan console commands
- Health check endpoint automatically configured at `/up`

## Public Directory (`public/`)

- Document root for the web server
- `index.php` - Application entry point
- Compiled assets are published here by Vite

## Storage Directory (`storage/`)

```
storage/
├── app/                    # Application-generated files
│   ├── private/            # Private files
│   └── public/             # Publicly accessible files
├── framework/              # Framework-generated files
│   ├── cache/              # Framework cache
│   ├── sessions/           # Session files
│   └── views/              # Compiled Blade views
└── logs/                   # Application logs
```

### Important Notes
- Never commit files in `storage/framework/` or `storage/logs/`
- `storage/app/public` should be symlinked to `public/storage` for public file access

## Tests Directory (`tests/`)

```
tests/
├── Feature/                # Feature/integration tests
├── Unit/                   # Unit tests
└── TestCase.php            # Base test case
```

### Testing Conventions
- Feature tests for HTTP requests, database interactions
- Unit tests for isolated logic
- Test classes should extend `TestCase`
- Use `php artisan test` to run tests

## Configuration Files (`config/`)

- Each config file corresponds to a service or component
- Access config values using `config('file.key')`
- Environment-specific values should use `env()` helper in config files only
- Never use `env()` directly in application code - always go through config files

## Autoloading (PSR-4)

- `App\` namespace maps to `app/` directory
- `Database\Factories\` maps to `database/factories/`
- `Database\Seeders\` maps to `database/seeders/`
- `Tests\` maps to `tests/`

## File Naming Conventions

- PHP classes: PascalCase (e.g., `UserController.php`)
- Blade views: kebab-case (e.g., `user-profile.blade.php`)
- Migrations: snake_case with timestamp prefix
- Config files: lowercase (e.g., `database.php`)

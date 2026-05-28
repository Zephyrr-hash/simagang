# Project Structure

Standard Laravel 8 directory layout with role-based organization.

```
├── app/
│   ├── Console/              # Artisan commands
│   ├── Exceptions/           # Exception handlers
│   ├── Http/
│   │   ├── Controllers/      # Route handlers (role-based naming)
│   │   │   ├── Auth/         # Laravel UI auth controllers
│   │   │   ├── ApplyController.php      # Application/approval flow
│   │   │   ├── BimbinganController.php  # Guidance submissions
│   │   │   ├── DepartController.php     # Department admin actions
│   │   │   ├── DospemController.php     # Academic advisor actions
│   │   │   ├── LogBookController.php    # Logbook CRUD + PDF export
│   │   │   ├── LowonganController.php   # Internship listings CRUD
│   │   │   ├── MhsController.php        # Student dashboard
│   │   │   ├── MitraController.php      # Partner dashboard
│   │   │   ├── ProfileController.php    # User profile management
│   │   │   ├── SpvController.php        # Supervisor dashboard
│   │   │   └── UserController.php       # User CRUD (admin)
│   │   ├── Kernel.php        # HTTP middleware stack
│   │   └── Middleware/       # Role-based middleware guards
│   │       ├── IsApprove.php       # Checks student is approved for internship
│   │       ├── IsDepart.php        # Department role check
│   │       ├── IsDospem.php        # Academic advisor role check
│   │       ├── IsMahasiswa.php     # Student role check
│   │       ├── IsMitra.php         # Partner role check
│   │       └── IsSupervisor.php    # Supervisor role check
│   ├── Models/               # Eloquent models (one per domain entity)
│   └── Providers/            # Service providers
├── bootstrap/                # Framework bootstrap
├── config/                   # Configuration files
├── database/
│   ├── factories/            # Model factories (for testing)
│   ├── migrations/           # Schema migrations (timestamped)
│   └── seeders/              # Reference data seeders (roles, categories, skills, etc.)
├── public/                   # Web root (index.php, compiled assets, uploaded images)
├── resources/
│   ├── css/                  # Raw CSS
│   ├── js/                   # Raw JS (app.js, bootstrap.js)
│   ├── lang/                 # Localization files
│   ├── sass/                 # Sass source files
│   └── views/               # Blade templates
│       ├── auth/             # Login/register views
│       ├── depart/           # Department admin views
│       ├── dosen/            # Academic advisor views
│       ├── layouts/          # Master layouts (app.blade.php, log.blade.php)
│       ├── lowongan/         # Listing views (public)
│       ├── mhs/              # Student views
│       ├── mitra/            # Partner views
│       ├── spv/              # Supervisor views
│       └── vendor/           # Published package views
├── routes/
│   └── web.php              # All web routes (grouped by role middleware)
├── storage/                  # Logs, cache, compiled views
└── tests/                    # PHPUnit tests
```

## Key Conventions

- **Route grouping**: Routes are grouped by role middleware (`is_depart`, `is_mitra`, `is_dospem`, `is_supervisor`, `is_mahasiswa`).
- **Views mirror roles**: Each role has its own subdirectory under `resources/views/`.
- **Models are flat**: All Eloquent models live directly in `app/Models/` with no subdirectories.
- **File uploads**: Stored in `public/images/` via `move()` to public path.
- **Naming**: Controllers use Indonesian domain terms (Lowongan, Bimbingan, Logbook, Mitra, etc.).
- **Validation**: Uses `Validator::make()` pattern in controllers (not Form Requests).
- **Flash messages**: Success/error messages via session flash with SweetAlert rendering.

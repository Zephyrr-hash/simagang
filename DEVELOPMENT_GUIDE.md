# 🛠️ Development Guide - SIMAGANG

Panduan lengkap untuk development, debugging, dan best practices dalam project SIMAGANG.

---

## 📚 Table of Contents

1. [Project Overview](#project-overview)
2. [Development Setup](#development-setup)
3. [Code Standards](#code-standards)
4. [Common Workflows](#common-workflows)
5. [Debugging](#debugging)
6. [Database Management](#database-management)
7. [File Structure](#file-structure)
8. [API Documentation](#api-documentation)
9. [Troubleshooting](#troubleshooting)
10. [Best Practices](#best-practices)

---

## 🎯 Project Overview

**SIMAGANG** adalah Sistem Informasi Magang yang mengelola proses magang mahasiswa dari aplikasi hingga penilaian akhir.

### Key Stakeholders
1. **Mahasiswa** - Apply, logbook, bimbingan
2. **Mitra** - Post lowongan, approve applicants
3. **Dosen Pembimbing** - Review bimbingan
4. **Supervisor** - Review logbook, scoring
5. **Departemen** - Admin, assign dospem

### Core Workflows
```
1. Mitra posts Lowongan
2. Mahasiswa applies
3. Mitra approves → creates Magang record
4. Departemen assigns Dosen Pembimbing
5. Supervisor creates Project
6. Mahasiswa creates Logbook & Bimbingan
7. Supervisor reviews Logbook
8. Dosen reviews Bimbingan
9. Supervisor gives final score
10. Mitra ends internship
```

---

## 🚀 Development Setup

### Initial Setup
```cmd
# 1. Clone repository (jika dari Git)
git clone [repository-url]
cd simagang

# 2. Install PHP dependencies
C:\xampp\php\php.exe composer.phar install

# 3. Install NPM dependencies (optional)
npm install

# 4. Copy environment file
copy .env.example .env

# 5. Generate application key
C:\xampp\php\php.exe artisan key:generate

# 6. Configure .env file
# Edit database credentials, APP_URL, etc.

# 7. Run migrations
C:\xampp\php\php.exe artisan migrate

# 8. Seed database
C:\xampp\php\php.exe artisan db:seed

# 9. Create storage symlink
C:\xampp\php\php.exe artisan storage:link

# 10. Compile frontend assets
npm run dev
```

### Daily Development
```cmd
# Start MySQL (via XAMPP Control Panel or)
net start mysql

# Start Laravel server
C:\xampp\php\php.exe artisan serve

# Watch frontend changes (optional terminal)
npm run watch
```

---

## 📝 Code Standards

### PHP Standards (PSR-4)

**Controller Example:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LowonganController extends BaseController
{
    /**
     * Display a listing of lowongan.
     */
    public function index(): \Illuminate\View\View
    {
        $lowongan = Lowongan::with('mitra', 'kategori')
            ->latest()
            ->paginate(10);
            
        return view('lowongan.index', compact('lowongan'));
    }
    
    /**
     * Store a newly created lowongan.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_low' => 'required|string|max:255',
            'deskripsi_low' => 'required|string',
            'jumlah_mhs' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
            'kategori_id' => 'required|exists:kategori,id',
            'foto_low' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_low.required' => 'Nama lowongan wajib diisi.',
            'jumlah_mhs.min' => 'Jumlah mahasiswa minimal 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process file upload
        $fotoPath = null;
        if ($request->hasFile('foto_low')) {
            $file = $request->file('foto_low');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $fotoPath = 'images/' . $filename;
        }

        try {
            Lowongan::create([
                'nama_low' => $request->nama_low,
                'deskripsi_low' => $request->deskripsi_low,
                'jumlah_mhs' => $request->jumlah_mhs,
                'durasi' => $request->durasi,
                'kategori_id' => $request->kategori_id,
                'mitra_id' => auth()->user()->mitra->id,
                'foto_low' => $fotoPath,
            ]);

            Alert::success('Berhasil', 'Lowongan berhasil dibuat.');
            return redirect()->route('lowongan.index');
            
        } catch (\Exception $e) {
            \Log::error('Error creating lowongan: ' . $e->getMessage());
            Alert::error('Gagal', 'Terjadi kesalahan saat membuat lowongan.');
            return redirect()->back()->withInput();
        }
    }
}
```

### Model Best Practices
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id';
    
    // Mass assignment protection
    protected $fillable = [
        'nama_low',
        'deskripsi_low',
        'jumlah_mhs',
        'durasi',
        'mitra_id',
        'kategori_id',
        'lokasi',
        'foto_low'
    ];

    // Type casting
    protected $casts = [
        'jumlah_mhs' => 'integer',
        'durasi' => 'integer',
    ];

    // Relationships dengan eager loading
    public function kategori(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function mitra(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function magang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Magang::class, 'lowongan_id');
    }

    // Accessor
    public function getFotoUrlAttribute(): string
    {
        return $this->foto_low 
            ? asset($this->foto_low)
            : asset('images/default-lowongan.png');
    }

    // Scope untuk query reusable
    public function scopeAktif($query)
    {
        return $query->where('jumlah_mhs', '>', 0);
    }
}
```

### Blade Template Standards
```blade
{{-- resources/views/lowongan/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Lowongan')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Lowongan Magang</h4>
                    @if(auth()->user()->role_id == \App\Models\Role::MITRA)
                        <a href="{{ route('lowongan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Lowongan
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if($lowongan->isEmpty())
                        <div class="alert alert-info">
                            Belum ada lowongan tersedia.
                        </div>
                    @else
                        <div class="row">
                            @foreach($lowongan as $item)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ $item->foto_url }}" 
                                             class="card-img-top" 
                                             alt="{{ $item->nama_low }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->nama_low }}</h5>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ $item->mitra->nama_mitra }}
                                                </small>
                                            </p>
                                            <p class="card-text">
                                                {{ Str::limit($item->deskripsi_low, 100) }}
                                            </p>
                                            <div class="mb-2">
                                                <span class="badge badge-primary">
                                                    {{ $item->kategori->kategori }}
                                                </span>
                                                <span class="badge badge-info">
                                                    {{ $item->jumlah_mhs }} posisi
                                                </span>
                                            </div>
                                            <a href="{{ route('lowongan.show', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary btn-block">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $lowongan->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

### Validation Messages (Bahasa Indonesia)
```php
$validator = Validator::make($request->all(), [
    'nama_low' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'telepon' => 'required|numeric|digits_between:10,13',
    'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
], [
    'nama_low.required' => 'Nama lowongan wajib diisi.',
    'nama_low.max' => 'Nama lowongan maksimal 255 karakter.',
    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'email.unique' => 'Email sudah terdaftar.',
    'telepon.numeric' => 'Telepon harus berupa angka.',
    'telepon.digits_between' => 'Telepon harus 10-13 digit.',
    'foto.image' => 'File harus berupa gambar.',
    'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
    'foto.max' => 'Ukuran gambar maksimal 2MB.',
]);
```

---

## 🔄 Common Workflows

### Adding a New Feature

#### 1. Create Migration
```cmd
C:\xampp\php\php.exe artisan make:migration create_notifications_table
```

```php
// database/migrations/2026_06_24_xxxxx_create_notifications_table.php
public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('title');
        $table->text('message');
        $table->boolean('is_read')->default(false);
        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
    });
}
```

#### 2. Create Model
```cmd
C:\xampp\php\php.exe artisan make:model Notification
```

#### 3. Create Controller
```cmd
C:\xampp\php\php.exe artisan make:controller NotificationController
```

#### 4. Add Routes
```php
// routes/web.php
Route::group(['middleware' => 'auth'], function () {
    Route::get('notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
});
```

#### 5. Create Views
```
resources/views/notifications/
├── index.blade.php
└── _notification_item.blade.php
```

#### 6. Test Feature
- Run migration
- Test CRUD operations
- Test with different roles
- Test validation
- Test edge cases

---

### Modifying Existing Feature

#### 1. Identify Files
```
Controller: app/Http/Controllers/LowonganController.php
Model: app/Models/Lowongan.php
Views: resources/views/lowongan/*.blade.php
Migration: database/migrations/*_create_lowongan_table.php
```

#### 2. Make Changes
- Update controller method
- Update validation rules
- Update model $fillable if adding fields
- Update views

#### 3. Test Changes
- Clear cache
- Test functionality
- Check for breaking changes
- Test related features

---

## 🐛 Debugging

### Enable Debug Mode
```env
# .env
APP_DEBUG=true
APP_ENV=local
LOG_LEVEL=debug
```

### Common Debug Techniques

#### 1. Dump and Die
```php
// In controller
dd($request->all());  // Dump request data
dd($user);            // Dump variable
dump($data);          // Dump without stopping
```

#### 2. Logging
```php
// Basic logging
\Log::info('User logged in', ['user_id' => $user->id]);
\Log::error('Failed to create lowongan', [
    'error' => $e->getMessage(),
    'data' => $request->all()
]);

// Check logs
// storage/logs/laravel.log
```

#### 3. Query Debugging
```php
// Enable query log
\DB::enableQueryLog();

// Run your queries
$lowongan = Lowongan::with('mitra')->get();

// Get executed queries
dd(\DB::getQueryLog());
```

#### 4. Tinker (REPL)
```cmd
C:\xampp\php\php.exe artisan tinker
```

```php
>>> User::count()
=> 9

>>> Lowongan::with('mitra')->first()
=> App\Models\Lowongan {
     id: 1,
     nama_low: "Frontend Developer",
     ...
   }

>>> auth()->user()
# Returns currently authenticated user

>>> User::find(1)->role
# Get user's role
```

---

### Laravel Debugbar (Optional)
```cmd
C:\xampp\php\php.exe composer.phar require barryvdh/laravel-debugbar --dev
```

Shows:
- Query count and execution time
- View rendering time
- Route info
- Session data
- Request/Response

---

## 💾 Database Management

### Common Database Commands

```cmd
# Run all pending migrations
C:\xampp\php\php.exe artisan migrate

# Rollback last migration
C:\xampp\php\php.exe artisan migrate:rollback

# Rollback all and re-run
C:\xampp\php\php.exe artisan migrate:refresh

# Fresh migrations (drop all tables)
C:\xampp\php\php.exe artisan migrate:fresh

# Fresh with seeders
C:\xampp\php\php.exe artisan migrate:fresh --seed

# Run specific seeder
C:\xampp\php\php.exe artisan db:seed --class=RoleSeeder

# Check migration status
C:\xampp\php\php.exe artisan migrate:status
```

### Database Backup
```cmd
# Backup
C:\xampp\mysql\bin\mysqldump.exe -u root simagang > backup_2026_06_24.sql

# Restore
C:\xampp\mysql\bin\mysql.exe -u root simagang < backup_2026_06_24.sql
```

### Manual Database Queries
```cmd
# Login to MySQL
C:\xampp\mysql\bin\mysql.exe -u root simagang

# Example queries
SELECT * FROM users WHERE role_id = 5;
SELECT COUNT(*) FROM lowongan;
UPDATE magang SET approval = 1 WHERE id = 1;
```

---

## 📁 File Structure

### Important Directories

```
simagang/
│
├── app/
│   ├── Console/
│   │   └── Commands/          # Custom artisan commands
│   ├── Http/
│   │   ├── Controllers/       # Business logic
│   │   │   ├── Auth/          # Laravel UI auth
│   │   │   ├── ApplyController.php
│   │   │   ├── BimbinganController.php
│   │   │   ├── DepartController.php
│   │   │   ├── DospemController.php
│   │   │   ├── LogBookController.php
│   │   │   ├── LowonganController.php
│   │   │   ├── MhsController.php
│   │   │   ├── MitraController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── SpvController.php
│   │   │   └── UserController.php
│   │   └── Middleware/        # Authorization
│   │       ├── IsApprove.php
│   │       ├── IsDepart.php
│   │       ├── IsDospem.php
│   │       ├── IsMahasiswa.php
│   │       ├── IsMitra.php
│   │       ├── IsProfileComplete.php
│   │       └── IsSupervisor.php
│   ├── Models/                # Eloquent models
│   └── Providers/             # Service providers
│
├── config/                    # Configuration files
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
│
├── database/
│   ├── migrations/            # Schema definitions
│   └── seeders/               # Reference data
│
├── public/                    # Web root
│   ├── css/                   # Compiled CSS
│   ├── js/                    # Compiled JS
│   ├── images/                # Uploaded images
│   └── index.php              # Entry point
│
├── resources/
│   ├── views/                 # Blade templates
│   │   ├── auth/
│   │   ├── depart/
│   │   ├── dosen/
│   │   ├── layouts/
│   │   ├── lowongan/
│   │   ├── mhs/
│   │   ├── mitra/
│   │   ├── project/
│   │   └── spv/
│   ├── css/                   # Raw CSS
│   ├── js/                    # Raw JS
│   └── sass/                  # Sass files
│
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes
│
├── storage/
│   ├── app/                   # Application storage
│   ├── framework/             # Framework cache
│   └── logs/                  # Log files
│
├── .env                       # Environment config
├── composer.json              # PHP dependencies
├── package.json               # NPM dependencies
└── artisan                    # CLI tool
```

---

## 🌐 API Documentation

### Authentication Required
All API endpoints require authentication (`middleware: auth`).

### Wilayah API (Cascading Dropdown)

#### Get Provinsi
```
GET /api/wilayah/provinsi
```

**Response:**
```json
[
    {
        "id": 11,
        "nama": "ACEH"
    },
    {
        "id": 12,
        "nama": "SUMATERA UTARA"
    }
]
```

#### Get Kabupaten
```
GET /api/wilayah/kabupaten?provinsi_id={id}
```

**Response:**
```json
[
    {
        "id": 1101,
        "nama": "KAB. ACEH BARAT",
        "provinsi_id": 11
    }
]
```

#### Get Kecamatan
```
GET /api/wilayah/kecamatan?kabupaten_id={id}
```

**Response:**
```json
[
    {
        "id": 110101,
        "nama": "ARONGAN LAMBALEK",
        "kabupaten_id": 1101
    }
]
```

### Usage Example (JavaScript)
```javascript
// On provinsi change
$('#provinsi').change(function() {
    let provinsiId = $(this).val();
    
    $.ajax({
        url: '/api/wilayah/kabupaten',
        data: { provinsi_id: provinsiId },
        success: function(data) {
            $('#kabupaten').empty();
            $('#kabupaten').append('<option value="">Pilih Kabupaten</option>');
            data.forEach(function(item) {
                $('#kabupaten').append(
                    `<option value="${item.id}">${item.nama}</option>`
                );
            });
        }
    });
});
```

---

## 🔧 Troubleshooting

### Common Issues & Solutions

#### 1. Class 'App\Something' not found
```cmd
# Regenerate autoload files
C:\xampp\php\php.exe composer.phar dump-autoload
```

#### 2. View not found
```cmd
# Clear view cache
C:\xampp\php\php.exe artisan view:clear
```

#### 3. Route not found
```cmd
# Clear route cache
C:\xampp\php\php.exe artisan route:clear
```

#### 4. Config changes not taking effect
```cmd
# Clear config cache
C:\xampp\php\php.exe artisan config:clear
```

#### 5. Permission denied on file upload
- Pastikan folder `public/images/` ada
- Check write permissions di Windows
- Jalankan CMD as Administrator jika perlu

#### 6. Database connection error
- Pastikan MySQL running
- Check credentials di `.env`
- Test koneksi manual:
```cmd
C:\xampp\mysql\bin\mysql.exe -u root -p
```

#### 7. CSRF token mismatch
- Clear browser cookies
- Regenerate session:
```cmd
C:\xampp\php\php.exe artisan session:clear
```

#### 8. 419 Page Expired
- Session expired
- Refresh halaman
- Re-login

#### 9. 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Enable debug mode in `.env`
- Check server error logs

#### 10. Assets not loading (404)
```cmd
# Recompile assets
npm run dev

# Or
C:\xampp\php\php.exe artisan storage:link
```

---

## ✅ Best Practices

### Security
1. **Never commit `.env` file**
2. **Always validate user input**
3. **Use parameterized queries (Eloquent handles this)**
4. **Implement CSRF protection (included by default)**
5. **Validate file uploads**
6. **Use `filled()` helper for optional fields**
7. **Hash passwords: `Hash::make($password)`**
8. **Sanitize output: `{{ }}` auto-escapes, `{!! !!}` doesn't**

### Performance
1. **Use eager loading to avoid N+1 queries**
   ```php
   // Bad
   $lowongan = Lowongan::all();
   foreach ($lowongan as $low) {
       echo $low->mitra->nama_mitra; // N+1 query
   }
   
   // Good
   $lowongan = Lowongan::with('mitra')->get();
   foreach ($lowongan as $low) {
       echo $low->mitra->nama_mitra; // Single query
   }
   ```

2. **Paginate large datasets**
   ```php
   $lowongan = Lowongan::paginate(10);
   ```

3. **Use `select()` to limit columns**
   ```php
   $users = User::select('id', 'name', 'email')->get();
   ```

4. **Cache expensive queries**
   ```php
   $categories = Cache::remember('categories', 3600, function () {
       return Kategori::all();
   });
   ```

### Code Quality
1. **Follow PSR-4 naming conventions**
2. **Use type hints for parameters and return types**
3. **Write descriptive method names**
4. **Keep controllers thin, models fat**
5. **Comment complex logic**
6. **Use service classes for complex business logic**
7. **Use form requests for complex validation**

### Git Workflow
```cmd
# Create feature branch
git checkout -b feature/add-notifications

# Make changes
# ...

# Stage changes
git add .

# Commit with descriptive message
git commit -m "feat: add notification system for mahasiswa"

# Push to remote
git push origin feature/add-notifications

# Create Pull Request
```

### Commit Message Convention
```
feat: add new feature
fix: bug fix
docs: documentation changes
style: code formatting
refactor: code restructuring
test: add tests
chore: maintenance tasks
```

---

## 📚 Additional Resources

### Laravel Documentation
- [Laravel 8 Docs](https://laravel.com/docs/8.x)
- [Eloquent ORM](https://laravel.com/docs/8.x/eloquent)
- [Blade Templates](https://laravel.com/docs/8.x/blade)
- [Validation](https://laravel.com/docs/8.x/validation)

### Project-Specific
- `PROJECT_STATUS.md` - Current project status
- `QUICK_START.md` - Quick setup guide
- `TEST_SCENARIOS.md` - Testing guide
- `.kiro/steering/*.md` - Tech conventions

### Tools
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
- [PHPStan](https://phpstan.org/) - Static analysis

---

**Happy Coding! 🚀**

*Last Updated: 24 Juni 2026*

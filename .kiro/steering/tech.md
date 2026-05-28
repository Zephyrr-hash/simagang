# Tech Stack

## Backend

- **Framework**: Laravel 8.x (PHP ^7.3 | ^8.0)
- **Authentication**: Laravel UI with Blade-based auth scaffolding
- **PDF Generation**: barryvdh/laravel-dompdf
- **Alerts**: realrashid/sweet-alert (SweetAlert2 integration)
- **HTTP Client**: Guzzle 7

## Frontend

- **Templating**: Blade templates
- **CSS Framework**: Bootstrap 4
- **JS Libraries**: jQuery 3, Lodash, Axios
- **CSS Preprocessor**: Sass
- **Build Tool**: Laravel Mix 6 (Webpack-based)

## Database

- MySQL (implied by Laravel conventions and migration structure)
- Eloquent ORM with relationships

## Testing

- PHPUnit 9 (configured via phpunit.xml)
- Mockery for mocking
- Laravel Sail available for Docker-based development

## Code Style

- StyleCI with Laravel preset
- EditorConfig: 4-space indentation, UTF-8, LF line endings
- PSR-4 autoloading

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Compile frontend assets (development)
npm run dev

# Compile frontend assets (production)
npm run prod

# Watch for frontend changes
npm run watch

# Start development server
php artisan serve

# Run tests
php artisan test
# or
./vendor/bin/phpunit

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## Panduan Development

### Bahasa & Respons

- Selalu gunakan **Bahasa Indonesia** dalam memberikan respons, komentar kode, commit message, dan dokumentasi.
- Penamaan variabel, method, dan class tetap menggunakan konvensi bahasa Inggris atau istilah domain Indonesia yang sudah ada di project (contoh: `Lowongan`, `Bimbingan`, `Mahasiswa`).

### Prinsip Umum

- Gunakan **PHP** sebagai bahasa utama dan **Laravel versi terbaru** sebagai acuan best practice.
- Tulis kode yang **lengkap, fungsional, dan production-ready** — jangan setengah-setengah.
- Setiap fitur baru harus **langsung bisa digunakan** tanpa perlu modifikasi tambahan dari user.
- Prioritaskan **keamanan**, **performa**, dan **maintainability** di setiap implementasi.
- Ikuti prinsip **DRY (Don't Repeat Yourself)** dan **SOLID** secara konsisten.

### Standar Penulisan Kode PHP/Laravel

- Gunakan **type hints** pada parameter dan return type di semua method.
- Gunakan **Eloquent relationships** secara maksimal, hindari raw query kecuali untuk optimasi performa yang terukur.
- Gunakan **eager loading** (`with()`) untuk menghindari N+1 query problem.
- Gunakan **mass assignment protection** (`$fillable` atau `$guarded`) di setiap model.
- Gunakan **route model binding** jika memungkinkan.
- Gunakan **resource controllers** dan RESTful naming convention.
- Validasi input menggunakan `Validator::make()` (sesuai pola existing) dengan rules yang lengkap dan pesan error dalam Bahasa Indonesia.
- Gunakan **database transactions** (`DB::beginTransaction()`) untuk operasi yang melibatkan multiple write.
- Selalu handle **exception** dengan try-catch pada operasi kritis.
- Gunakan **policy/gate** untuk authorization jika logic otorisasi kompleks.

### Standar Blade & Frontend

- Gunakan **layout inheritance** (`@extends`, `@section`, `@yield`) sesuai pola existing.
- Komponen UI menggunakan **Bootstrap 4** classes — jangan tambahkan framework CSS lain.
- Form harus menyertakan `@csrf` dan `@method` yang sesuai.
- Tampilkan **validation errors** menggunakan `@error` directive atau `$errors->first()`.
- Gunakan **old()** helper untuk mempertahankan input saat validasi gagal.
- Pastikan semua view **responsive** dan accessible (label, alt text, aria attributes).

### Standar Database & Migration

- Setiap perubahan schema harus melalui **migration file** baru (jangan edit migration lama).
- Gunakan **foreign key constraints** dengan `onDelete('cascade')` atau `onDelete('set null')` sesuai kebutuhan.
- Tambahkan **index** pada kolom yang sering digunakan untuk query/filter.
- Seeder harus **idempotent** — bisa dijalankan berulang tanpa duplikasi data.

### Keamanan

- Jangan pernah trust input user — selalu **validasi dan sanitasi**.
- Gunakan **parameterized queries** (Eloquent/Query Builder sudah handle ini secara default).
- File upload harus divalidasi: tipe file, ukuran maksimal, dan rename file untuk menghindari path traversal.
- Jangan expose **sensitive data** (password, token) di response atau log.
- Gunakan **middleware** untuk proteksi route sesuai role.

### Pola Error Handling & Flash Message

- Gunakan `Alert::success()` / `Alert::error()` dari SweetAlert untuk feedback ke user.
- Untuk operasi gagal, kembalikan `redirect()->back()->withErrors()` dengan pesan yang jelas.
- Log error penting menggunakan `Log::error()` dengan konteks yang cukup.

### File Upload

- Simpan file di `public/images/` menggunakan `move()` (sesuai pola existing).
- Validasi ekstensi file: `mimes:jpg,jpeg,png,pdf` sesuai kebutuhan.
- Batasi ukuran file: `max:2048` (2MB) atau sesuai kebutuhan fitur.
- Gunakan nama file unik (timestamp atau UUID) untuk menghindari konflik.

### Performa

- Gunakan **pagination** (`paginate()`) untuk list data yang besar.
- Gunakan **caching** untuk data yang jarang berubah (referensi: kategori, skill, kabupaten).
- Hindari query di dalam loop — gunakan eager loading atau batch processing.
- Gunakan `select()` untuk membatasi kolom yang di-query jika tidak butuh semua field.

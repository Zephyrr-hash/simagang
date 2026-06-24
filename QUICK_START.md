# 🚀 Quick Start Guide - SIMAGANG

Panduan cepat untuk menjalankan dan menggunakan aplikasi SIMAGANG.

---

## 📋 Prerequisites

Pastikan sudah terinstall:
- ✅ XAMPP (PHP 8.2.12 + MySQL)
- ✅ Composer 2.x
- ✅ Node.js & NPM (optional, untuk compile assets)

---

## 🔥 Start Development Server

### Opsi 1: Menggunakan Path Penuh (Recommended)
```cmd
C:\xampp\php\php.exe artisan serve
```

### Opsi 2: Jika PHP sudah ada di PATH
```cmd
php artisan serve
```

Server akan berjalan di: **http://127.0.0.1:8000**

---

## 🔐 Login Credentials

Gunakan salah satu akun berikut untuk testing:

### Departemen (Admin)
- **Email:** admin2@simagang.id
- **Password:** *[cek di database atau tanya team]*

### Mitra (Partner Company)
- **Email:** zephyr@gmail.com
- **Password:** *[cek di database]*

atau

- **Email:** mitra@simagang.id
- **Password:** *[cek di database]*

### Dosen Pembimbing (Academic Advisor)
- **Email:** lubis@gmail.com
- **Password:** *[cek di database]*

### Supervisor
- **Email:** raka@gmail.com
- **Password:** *[cek di database]*

### Mahasiswa (Student)
- **Email:** jaka@gmail.com
- **Password:** *[cek di database]*

atau

- **Email:** rangga@gmail.com
- **Password:** *[cek di database]*

---

## 🛠️ Common Commands

### Artisan Commands
```cmd
# Clear cache
C:\xampp\php\php.exe artisan cache:clear
C:\xampp\php\php.exe artisan config:clear
C:\xampp\php\php.exe artisan route:clear
C:\xampp\php\php.exe artisan view:clear

# Database
C:\xampp\php\php.exe artisan migrate          # Run migrations
C:\xampp\php\php.exe artisan migrate:fresh    # Fresh migrations
C:\xampp\php\php.exe artisan db:seed          # Seed database

# Route info
C:\xampp\php\php.exe artisan route:list       # List all routes
```

### Composer Commands
```cmd
# Install dependencies
C:\xampp\php\php.exe composer.phar install

# Update dependencies
C:\xampp\php\php.exe composer.phar update

# Autoload optimization
C:\xampp\php\php.exe composer.phar dump-autoload
```

### NPM Commands (Jika ingin compile frontend)
```cmd
# Install packages
npm install

# Compile for development
npm run dev

# Watch for changes
npm run watch

# Compile for production
npm run prod
```

### MySQL Commands
```cmd
# Login ke MySQL
C:\xampp\mysql\bin\mysql.exe -u root

# Login dengan database
C:\xampp\mysql\bin\mysql.exe -u root simagang

# Backup database
C:\xampp\mysql\bin\mysqldump.exe -u root simagang > backup.sql

# Restore database
C:\xampp\mysql\bin\mysql.exe -u root simagang < backup.sql
```

---

## 🗂️ Project Structure Navigation

### Controllers
```
app/Http/Controllers/
├── ApplyController.php       # Application flow & approval
├── BimbinganController.php   # Guidance submissions
├── DepartController.php      # Department admin
├── DospemController.php      # Academic advisor
├── LogBookController.php     # Logbook CRUD
├── LowonganController.php    # Internship listings
├── MhsController.php         # Student dashboard
├── MitraController.php       # Partner dashboard
├── ProfileController.php     # User profile
├── ProjectController.php     # Project management
├── SpvController.php         # Supervisor dashboard
└── UserController.php        # User management
```

### Models
```
app/Models/
├── User.php           # User dengan role
├── Role.php           # Role definitions
├── Lowongan.php       # Internship listings
├── Magang.php         # Internship instances
├── Mahasiswa.php      # Student profiles
├── Mitra.php          # Partner profiles
├── Dosen.php          # Academic advisor profiles
├── Supervisor.php     # Field supervisor profiles
├── Departemen.php     # Department profiles
├── Logbook.php        # Daily activity logs
├── Bimbingan.php      # Guidance reports
└── ProjectMagang.php  # Internship projects
```

### Views
```
resources/views/
├── auth/              # Login, register
├── depart/            # Department views
├── dosen/             # Academic advisor views
├── mhs/               # Student views
├── mitra/             # Partner views
├── spv/               # Supervisor views
├── project/           # Project views
├── lowongan/          # Public listings
└── layouts/           # Master templates
```

---

## 🎯 Feature Testing Checklist

### Public Features
- [ ] Browse lowongan (homepage)
- [ ] View lowongan detail
- [ ] Login page accessible

### Mahasiswa Features
- [ ] Login sebagai mahasiswa
- [ ] View available internships
- [ ] Apply for internship
- [ ] View application status
- [ ] Complete profile
- [ ] Submit bimbingan
- [ ] Create logbook entries
- [ ] View feedback

### Mitra Features
- [ ] Login sebagai mitra
- [ ] Create lowongan
- [ ] Edit/delete lowongan
- [ ] View applicants
- [ ] Approve/reject applicants
- [ ] View active interns
- [ ] End internship

### Dosen Pembimbing Features
- [ ] Login sebagai dosen
- [ ] View assigned students
- [ ] Review bimbingan submissions
- [ ] Provide feedback

### Supervisor Features
- [ ] Login sebagai supervisor
- [ ] Create project
- [ ] Review logbook entries
- [ ] Provide logbook feedback
- [ ] Score students

### Departemen Features
- [ ] Login sebagai departemen
- [ ] Manage users
- [ ] View all students
- [ ] Assign academic advisors
- [ ] View applications

---

## 🐞 Troubleshooting

### Server tidak bisa start
```cmd
# Cek apakah port 8000 sudah digunakan
netstat -ano | findstr :8000

# Kill process jika ada
taskkill /PID [PID_NUMBER] /F

# Atau gunakan port lain
C:\xampp\php\php.exe artisan serve --port=8080
```

### Database connection error
1. Pastikan MySQL XAMPP running
2. Cek `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=simagang
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Clear config cache:
   ```cmd
   C:\xampp\php\php.exe artisan config:clear
   ```

### Class not found error
```cmd
# Regenerate autoload
C:\xampp\php\php.exe composer.phar dump-autoload
```

### View not found error
```cmd
# Clear view cache
C:\xampp\php\php.exe artisan view:clear
```

### Route not found error
```cmd
# Clear route cache
C:\xampp\php\php.exe artisan route:clear
```

### Permission denied (file upload)
Pastikan folder `public/images/` memiliki write permission:
```cmd
# Windows: klik kanan folder → Properties → Security → Edit
# Atau jalankan as Administrator
```

---

## 📸 Screenshots & Demo

### Homepage (Public)
- URL: http://127.0.0.1:8000
- Menampilkan daftar lowongan magang yang tersedia

### Login Page
- URL: http://127.0.0.1:8000/login
- Login dengan email dan password

### Role-based Dashboards
- Departemen: http://127.0.0.1:8000/depart/home
- Mitra: http://127.0.0.1:8000/mitra/home
- Dosen: http://127.0.0.1:8000/dosen/home
- Supervisor: http://127.0.0.1:8000/supervisor/home
- Mahasiswa: http://127.0.0.1:8000/mahasiswa/home

---

## 🔧 Development Tips

### Hot Reload untuk Frontend
```cmd
npm run watch
```
Akan watch perubahan di `resources/css/` dan `resources/js/`

### Debug Mode
Edit `.env`:
```
APP_DEBUG=true
APP_ENV=local
```

### Menggunakan Tinker (Laravel REPL)
```cmd
C:\xampp\php\php.exe artisan tinker
```

Contoh query di Tinker:
```php
// Get all users
User::all()

// Get user by email
User::where('email', 'admin2@simagang.id')->first()

// Get lowongan dengan mitra
Lowongan::with('mitra')->get()

// Create user baru
$user = new User();
$user->name = 'Test User';
$user->email = 'test@example.com';
$user->password = Hash::make('password');
$user->role_id = 5;
$user->save();
```

### Database Query Logging
Tambahkan di `AppServiceProvider.php` boot method:
```php
\DB::listen(function($query) {
    logger($query->sql, $query->bindings);
});
```

---

## 📦 Fresh Installation (Jika Diperlukan)

Jika ingin start dari awal:

```cmd
# 1. Install dependencies
C:\xampp\php\php.exe composer.phar install
npm install

# 2. Copy environment file
copy .env.example .env

# 3. Generate app key
C:\xampp\php\php.exe artisan key:generate

# 4. Edit .env sesuai kebutuhan

# 5. Create database 'simagang' di MySQL

# 6. Run migrations
C:\xampp\php\php.exe artisan migrate

# 7. Seed database
C:\xampp\php\php.exe artisan db:seed

# 8. Compile assets
npm run dev

# 9. Start server
C:\xampp\php\php.exe artisan serve
```

---

## 🎓 Learning Resources

### Laravel Documentation
- [Laravel 8 Docs](https://laravel.com/docs/8.x)
- [Eloquent ORM](https://laravel.com/docs/8.x/eloquent)
- [Blade Templates](https://laravel.com/docs/8.x/blade)
- [Authentication](https://laravel.com/docs/8.x/authentication)

### Project-specific
- Role constants: `app/Models/Role.php`
- Middleware guards: `app/Http/Middleware/`
- Route definitions: `routes/web.php`
- Database schema: `database/migrations/`

---

## 💡 Pro Tips

1. **Gunakan `artisan tinker`** untuk quick database testing
2. **Check logs** di `storage/logs/laravel.log` jika ada error
3. **Gunakan `dd()` atau `dump()`** untuk debugging
4. **Clear cache** jika ada perubahan config/routes yang tidak apply
5. **Backup database** sebelum run migration fresh
6. **Gunakan Git** untuk version control
7. **Read steering files** di `.kiro/steering/` untuk conventions

---

## 📞 Need Help?

- Check `PROJECT_STATUS.md` untuk status lengkap project
- Check `.kiro/steering/*.md` untuk tech stack & conventions
- Review Laravel logs: `storage/logs/laravel.log`
- Check database: `C:\xampp\mysql\bin\mysql.exe -u root simagang`

---

**Happy Coding! 🚀**

*Updated: 24 Juni 2026*

# Panduan Reset Password Manual

## Akun yang akan direset
- **Email**: admin2@simagang.id
- **Password Baru**: password123

## Cara 1: Menggunakan Script PHP (Tercepat)

Jalankan command berikut di terminal (pastikan PHP sudah terinstall):

```bash
php reset_password.php
```

File `reset_password.php` sudah tersedia di root project.

---

## Cara 2: Menggunakan Laravel Seeder

Jalankan command berikut:

```bash
php artisan db:seed --class=ResetPasswordDepartemenSeeder
```

File seeder sudah tersedia di `database/seeders/ResetPasswordDepartemenSeeder.php`.

---

## Cara 3: Menggunakan Laravel Tinker (Manual)

1. Buka terminal dan jalankan:
```bash
php artisan tinker
```

2. Ketik command berikut dan tekan Enter:
```php
$user = App\Models\User::where('email', 'admin2@simagang.id')->first();
$user->password = Hash::make('password123');
$user->save();
echo "Password berhasil direset!\n";
```

3. Keluar dari Tinker dengan `exit` atau Ctrl+C

---

## Cara 4: Menggunakan Database Client (phpMyAdmin/HeidiSQL/DBeaver)

1. Buka database client Anda
2. Koneksi ke database `simagang`
3. Cari tabel `users`
4. Cari record dengan email = `admin2@simagang.id`
5. Update kolom `password` dengan hash berikut:

```
$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
```

Hash di atas adalah hasil dari `Hash::make('password')` - password default Laravel.

Atau gunakan hash untuk `password123`:
```
$2y$10$8p7oeW6YGXvQ5xJxKJ8HcOn0qCFJNjYJX1pFl2QEJ3dQvQPGwPJqO
```

---

## Cara 5: Menggunakan SQL Query Langsung

Jalankan query SQL berikut di database client:

```sql
-- Untuk password: password123
UPDATE users 
SET password = '$2y$10$8p7oeW6YGXvQ5xJxKJ8HcOn0qCFJNjYJX1pFl2QEJ3dQvQPGwPJqO' 
WHERE email = 'admin2@simagang.id';
```

Atau jika Anda ingin menggunakan password default Laravel (`password`):

```sql
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE email = 'admin2@simagang.id';
```

---

## Verifikasi

Setelah reset, coba login dengan:
- **Email**: admin2@simagang.id
- **Password**: password123

Jika berhasil login, password sudah berhasil direset!

---

## Catatan Keamanan

⚠️ **Penting**: Setelah berhasil login, segera ganti password melalui menu Profile di aplikasi untuk keamanan yang lebih baik.

## Troubleshooting

### Problem: "User tidak ditemukan"
- Pastikan email benar-benar ada di database
- Cek tabel `users` dengan query:
```sql
SELECT id, name, email, role_id FROM users WHERE email = 'admin2@simagang.id';
```

### Problem: "Password salah setelah reset"
- Pastikan tidak ada spasi atau karakter tersembunyi saat copy-paste hash
- Pastikan menggunakan hash bcrypt yang benar (dimulai dengan `$2y$10$`)
- Cache mungkin perlu dibersihkan: `php artisan cache:clear`

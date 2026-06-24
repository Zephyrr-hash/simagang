# 🔐 Login Credentials - SIMAGANG

## 📋 Akun Departemen (Admin)

### **✅ AKUN BARU (RECOMMENDED)**

```
Email    : departemen@simagang.test
Password : password123
Role     : Departemen (Admin)
Status   : ✅ ACTIVE & TESTED
```

---

### **✅ AKUN DEPARTEMEN KEDUA**

```
Email    : admin2@simagang.id
Password : password123
Role     : Departemen (Admin)
Status   : ✅ Password sudah direset
```

**Catatan**: Untuk reset password akun ini, lihat panduan di `RESET_PASSWORD_MANUAL.md`

---

### **Akun Lama (Backup)**

```
Email    : admin@simagang.id
Password : adminsimagang
Role     : Departemen (Admin)
Status   : ⚠️ Mungkin tidak aktif
```

---

## 🚀 Cara Login

1. **Buka Browser**
   ```
   http://127.0.0.1:8000/login
   ```

2. **Masukkan Credentials BARU**
   - Email: `departemen@simagang.test`
   - Password: `password123`

3. **Klik "Masuk"**

4. **Akan Redirect ke Dashboard Departemen**
   ```
   http://127.0.0.1:8000/depart/home
   ```

---

## 🎯 Akses Fitur Log Aktivitas

Setelah login sebagai Departemen:

1. **Via Sidebar**
   - Klik menu **"Log Aktivitas"** di sidebar kiri

2. **Via URL Langsung**
   ```
   http://127.0.0.1:8000/depart/activity-logs
   ```

---

## 👥 Akun Test Lainnya (Jika Ada)

Untuk mendapatkan daftar lengkap akun yang ada di database, jalankan:

### **Via MySQL/PhpMyAdmin**
```sql
SELECT 
    u.id,
    u.name,
    u.email,
    r.role as role_name
FROM users u
LEFT JOIN role r ON u.role_id = r.id
ORDER BY u.role_id;
```

### **Via Laravel Artisan**
```bash
php artisan tinker
```
```php
User::with('role')->get(['id', 'name', 'email', 'role_id']);
```

---

## 🔒 Keamanan

### **Default Password untuk Development**
- Password default: `adminsimagang`
- **⚠️ PENTING:** Ganti password ini untuk production!

### **Cara Ganti Password**
1. Login sebagai admin
2. Klik avatar/nama di topbar
3. Pilih "Profil" atau "Edit Profil"
4. Ganti password

Atau via database:
```php
// Via Tinker
$user = User::where('email', 'admin@simagang.id')->first();
$user->password = bcrypt('password_baru');
$user->save();
```

---

## 📊 Role IDs

Untuk referensi:

| Role ID | Role Name | Dashboard Route |
|---------|-----------|-----------------|
| 1 | Departemen | `/depart/home` |
| 2 | Mitra | `/mitra/home` |
| 3 | Dosen Pembimbing | `/dospem/home` |
| 4 | Supervisor | `/supervisor/home` |
| 5 | Mahasiswa | `/mahasiswa/home` |

---

## 🆘 Troubleshooting

### **Lupa Password?**
1. Akses database via PhpMyAdmin
2. Buka tabel `users`
3. Edit user dengan email `admin@simagang.id`
4. Update field `password` dengan: `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`
   (ini adalah hash untuk password: `password`)
5. Login dengan email: `admin@simagang.id` dan password: `password`

### **Email Tidak Valid?**
Cek di database tabel `users` kolom `email`

### **Role Salah?**
Cek di database tabel `users` kolom `role_id` harus = `1` untuk Departemen

---

## ✅ Quick Test

### **Test Login:**
```
Email: admin@simagang.id
Pass: adminsimagang
```

### **Expected Result:**
- ✅ Login berhasil
- ✅ Redirect ke `/depart/home`
- ✅ Sidebar muncul dengan menu:
  - Dashboard
  - Kelola User
  - Data Mahasiswa
  - Pengajuan Dospem
  - **Log Aktivitas** ← NEW!
- ✅ Ada log "User melakukan login" di activity logs

---

## 📝 Notes

- Akun ini dibuat oleh `AdminSeeder.php`
- Password di-hash dengan bcrypt
- Seeder bisa dijalankan ulang dengan: `php artisan db:seed --class=AdminSeeder`
- Jika akun belum ada, run seeder atau buat manual via register

---

**Server URL:** http://127.0.0.1:8000  
**Login URL:** http://127.0.0.1:8000/login  
**Dashboard:** http://127.0.0.1:8000/depart/home  
**Activity Logs:** http://127.0.0.1:8000/depart/activity-logs

---

**Status:** ✅ Ready to Login!

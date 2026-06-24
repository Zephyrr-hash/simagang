# 🔧 Troubleshooting Login Issue - admin2@simagang.id

## Masalah: Tidak Bisa Login

Ada beberapa kemungkinan penyebab:

### 1️⃣ Akun Belum Ada di Database

**Cara Cek:**
Jalankan query SQL ini di phpMyAdmin/HeidiSQL:

```sql
SELECT id, name, email, role_id 
FROM users 
WHERE email = 'admin2@simagang.id';
```

**Jika tidak ada hasil** → Akun memang belum ada, lanjut ke [Solusi 1A](#solusi-1a-buat-akun-baru)

**Jika ada hasil** → Lanjut ke kemungkinan 2

---

### 2️⃣ Password Hash Salah

**Cara Reset:**

#### **Opsi A: Via SQL (Tercepat)**

Jalankan di phpMyAdmin/HeidiSQL/MySQL Workbench:

```sql
-- Gunakan password: "password"
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'admin2@simagang.id';
```

Kemudian login dengan:
- Email: `admin2@simagang.id`
- Password: `password`

#### **Opsi B: Via Artisan Command**

Buka terminal/cmd di folder project, jalankan:

```bash
php artisan user:reset-password admin2@simagang.id password123
```

Command ini akan:
- ✅ Cek apakah user ada
- ✅ Tampilkan info user
- ✅ Reset password menjadi "password123"
- ✅ Konfirmasi hasilnya

---

### 3️⃣ Role Salah (Bukan Departemen)

**Cara Cek:**

```sql
SELECT u.id, u.name, u.email, u.role_id, r.role
FROM users u
LEFT JOIN role r ON u.role_id = r.id
WHERE email = 'admin2@simagang.id';
```

**Jika role_id BUKAN 1** → Lanjut ke [Solusi 3A](#solusi-3a-ubah-role-jadi-departemen)

---

### 4️⃣ Email Salah / Typo

**Lihat Semua Email Departemen:**

```sql
SELECT id, name, email 
FROM users 
WHERE role_id = 1
ORDER BY id;
```

Pastikan email yang Anda masukkan **persis sama** dengan yang ada di database.

---

## 🛠️ SOLUSI LENGKAP

### Solusi 1A: Buat Akun Baru

Jika akun belum ada sama sekali, jalankan SQL ini:

```sql
-- Cek dulu role_id untuk Departemen
SELECT * FROM role WHERE role = 'Departemen';
-- Biasanya role_id = 1

-- Insert user baru
INSERT INTO users (name, email, email_verified_at, password, role_id, created_at, updated_at)
VALUES (
    'Admin Departemen 2',
    'admin2@simagang.id',
    NOW(),
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1,
    NOW(),
    NOW()
);

-- Ambil user_id yang baru dibuat
SET @user_id = LAST_INSERT_ID();

-- Buat record di tabel departemen
INSERT INTO departemen (user_id, nama_depart, telepon_depart, created_at, updated_at)
VALUES (
    @user_id,
    'Departemen Teknik Informatika 2',
    '081234567890',
    NOW(),
    NOW()
);
```

Login dengan:
- Email: `admin2@simagang.id`
- Password: `password`

---

### Solusi 3A: Ubah Role Jadi Departemen

Jika user ada tapi role salah:

```sql
UPDATE users 
SET role_id = 1 
WHERE email = 'admin2@simagang.id';
```

---

## 📋 Checklist Debugging

Ikuti langkah ini satu per satu:

- [ ] **Step 1**: Cek apakah user ada
  ```sql
  SELECT * FROM users WHERE email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 2**: Jika user ADA, reset password:
  ```sql
  UPDATE users 
  SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
  WHERE email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 3**: Cek role_id (harus = 1 untuk Departemen):
  ```sql
  SELECT role_id FROM users WHERE email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 4**: Jika role_id salah, update:
  ```sql
  UPDATE users SET role_id = 1 WHERE email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 5**: Cek apakah ada record di tabel `departemen`:
  ```sql
  SELECT d.* 
  FROM departemen d
  INNER JOIN users u ON d.user_id = u.id
  WHERE u.email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 6**: Jika TIDAK ada di tabel `departemen`, buat:
  ```sql
  INSERT INTO departemen (user_id, nama_depart, telepon_depart, created_at, updated_at)
  SELECT 
      u.id,
      'Departemen Teknik Informatika 2',
      '081234567890',
      NOW(),
      NOW()
  FROM users u
  WHERE u.email = 'admin2@simagang.id';
  ```
  
- [ ] **Step 7**: Clear cache Laravel:
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan view:clear
  ```
  
- [ ] **Step 8**: Coba login dengan:
  - Email: `admin2@simagang.id`
  - Password: `password`

---

## 🎯 QUICK FIX (Copy-Paste)

Jalankan semua query ini secara berurutan di phpMyAdmin/HeidiSQL:

```sql
-- 1. Cek user ada atau tidak
SELECT id, name, email, role_id FROM users WHERE email = 'admin2@simagang.id';

-- 2. Jika TIDAK ADA, buat user baru (jalankan semua ini sekaligus)
INSERT INTO users (name, email, email_verified_at, password, role_id, created_at, updated_at)
SELECT * FROM (SELECT 
    'Admin Departemen 2' as name,
    'admin2@simagang.id' as email,
    NOW() as email_verified_at,
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' as password,
    1 as role_id,
    NOW() as created_at,
    NOW() as updated_at
) AS tmp
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE email = 'admin2@simagang.id'
);

-- 3. Jika ADA, reset password
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    role_id = 1
WHERE email = 'admin2@simagang.id';

-- 4. Pastikan ada record di tabel departemen
INSERT INTO departemen (user_id, nama_depart, telepon_depart, created_at, updated_at)
SELECT 
    u.id,
    'Departemen Teknik Informatika 2',
    '081234567890',
    NOW(),
    NOW()
FROM users u
WHERE u.email = 'admin2@simagang.id'
AND NOT EXISTS (
    SELECT 1 FROM departemen WHERE user_id = u.id
);

-- 5. Verifikasi semuanya OK
SELECT 
    u.id as user_id,
    u.name,
    u.email,
    u.role_id,
    r.role,
    d.id as depart_id,
    d.nama_depart
FROM users u
LEFT JOIN role r ON u.role_id = r.id
LEFT JOIN departemen d ON d.user_id = u.id
WHERE u.email = 'admin2@simagang.id';
```

Setelah query di atas selesai, login dengan:
- **Email**: `admin2@simagang.id`
- **Password**: `password`

---

## 🔑 Password Hash Reference

| Password | Bcrypt Hash |
|----------|-------------|
| `password` | `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi` |
| `password123` | `$2y$10$8p7oeW6YGXvQ5xJxKJ8HcOn0qCFJNjYJX1pFl2QEJ3dQvQPGwPJqO` |
| `adminsimagang` | Perlu generate baru via `Hash::make()` |

---

## 💡 Tips

1. **Gunakan password sederhana dulu** (`password`) untuk memastikan bisa login
2. **Setelah berhasil login**, ganti password via menu Profile
3. **Pastikan tidak ada spasi** di email saat login
4. **Case-sensitive**: Email biasanya tidak case-sensitive, tapi password YA
5. **Browser cache**: Coba gunakan Incognito/Private window jika masih gagal

---

## 🆘 Masih Gagal?

Jika sudah ikuti semua langkah di atas tapi masih gagal:

1. **Screenshot error message** yang muncul saat login
2. **Cek Laravel logs** di `storage/logs/laravel.log`
3. **Jalankan query ini** dan berikan hasilnya:
   ```sql
   SELECT 
       u.id,
       u.name,
       u.email,
       u.role_id,
       r.role,
       d.id as depart_id,
       d.nama_depart,
       LEFT(u.password, 20) as password_prefix
   FROM users u
   LEFT JOIN role r ON u.role_id = r.id
   LEFT JOIN departemen d ON d.user_id = u.id
   WHERE u.email = 'admin2@simagang.id';
   ```

---

**File ini dibuat**: 2026-06-24  
**Untuk akun**: admin2@simagang.id  
**Database**: simagang (MySQL)

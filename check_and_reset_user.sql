-- Script SQL untuk cek dan reset password akun admin2@simagang.id
-- Jalankan di phpMyAdmin, HeidiSQL, atau MySQL Workbench

-- STEP 1: Cek apakah user ada
SELECT 
    id,
    name,
    email,
    role_id,
    created_at
FROM users 
WHERE email = 'admin2@simagang.id';

-- Jika user ditemukan, lanjut ke STEP 2
-- Jika tidak ada hasil, berarti akun belum ada di database

-- STEP 2: Reset password menjadi "password123"
-- Jalankan query ini jika user ditemukan di STEP 1
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'admin2@simagang.id';

-- STEP 3: Verifikasi perubahan
SELECT 
    id,
    name,
    email,
    role_id,
    LEFT(password, 30) as password_hash,
    updated_at
FROM users 
WHERE email = 'admin2@simagang.id';

-- CATATAN:
-- Hash di atas adalah untuk password: "password"
-- Setelah update, login dengan:
-- Email: admin2@simagang.id
-- Password: password

-- ========================================
-- ALTERNATIF: Lihat semua akun Departemen
-- ========================================
SELECT 
    u.id,
    u.name,
    u.email,
    r.role as role_name,
    u.created_at
FROM users u
LEFT JOIN role r ON u.role_id = r.id
WHERE u.role_id = 1
ORDER BY u.id;

-- ============================================================
-- Setup Superadmin - Jalankan di phpMyAdmin atau MySQL client
-- Database: simagang
-- ============================================================

USE simagang;

-- 1. Tambah role Superadmin (id = 6)
INSERT INTO `role` (`id`, `role`, `created_at`, `updated_at`)
VALUES (6, 'Superadmin', NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'Superadmin', `updated_at` = NOW();

-- 2. Buat akun Superadmin
-- Password: superadmin123
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `role_id`, `created_at`, `updated_at`)
VALUES (
    'Super Administrator',
    'superadmin@simagang.test',
    NOW(),
    '$2y$10$3G7aqnXX.V/6L8T2gWTf9.HnPP8c/J.Ia6LL9ZBqLvbPp2XWWQY6',
    6,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = 'Super Administrator',
    `role_id` = 6,
    `password` = '$2y$10$3G7aqnXX.V/6L8T2gWTf9.HnPP8c/J.Ia6LL9ZBqLvbPp2XWWQY6',
    `updated_at` = NOW();

-- 3. Verifikasi
SELECT u.id, u.name, u.email, r.role
FROM users u
JOIN role r ON u.role_id = r.id
WHERE u.role_id = 6;

-- ============================================================
-- Kredensial Login:
-- Email   : superadmin@simagang.test
-- Password: superadmin123
-- ============================================================

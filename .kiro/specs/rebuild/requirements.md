# Requirements — SIMAGANG Rebuild

## Overview

Membangun ulang sistem SIMAGANG (Sistem Informasi Magang) dari awal dengan:
- Semua fitur dari project lama dipertahankan dan diperbaiki
- Semua bug dan inkonsistensi dari analisis sebelumnya diperbaiki
- UI/UX baru sepenuhnya: desain modern, warna baru, font baru, layout baru
- Kode bersih mengikuti best practice Laravel terbaru

---

## Requirement 1 — Fondasi & Infrastruktur

### User Stories

- Sebagai developer, saya ingin project Laravel 8 yang bersih dengan struktur folder standar agar mudah dikembangkan.
- Sebagai developer, saya ingin konstanta approval dan role_id terdefinisi dengan jelas agar tidak ada magic number di kode.
- Sebagai developer, saya ingin semua relasi Eloquent lengkap dan benar agar query bisa menggunakan eager loading.

### Acceptance Criteria

1. GIVEN project baru, WHEN setup selesai, THEN semua dependency terinstall dan `php artisan migrate --seed` berjalan tanpa error.
2. GIVEN model `Magang`, WHEN diakses, THEN memiliki relasi `hasMany(Logbook::class)` dan `hasMany(Bimbingan::class)`.
3. GIVEN model `Mahasiswa`, WHEN diakses, THEN memiliki relasi `hasMany(Magang::class)` dan `hasMany(SkillMhs::class)`.
4. GIVEN model `Lowongan`, WHEN diakses, THEN memiliki relasi `hasMany(Magang::class)`.
5. GIVEN model `Role`, WHEN diakses, THEN memiliki relasi `hasMany(User::class)` (bukan `hasOne`).
6. GIVEN model `Departemen`, WHEN diakses, THEN memiliki relasi `hasMany(Mahasiswa::class)`.
7. GIVEN konstanta approval, WHEN digunakan di controller, THEN menggunakan konstanta `Magang::PENDING`, `Magang::DITERIMA`, `Magang::DITOLAK`, `Magang::SELESAI`.
8. GIVEN konstanta role, WHEN digunakan di middleware/controller, THEN menggunakan konstanta `Role::DEPARTEMEN`, `Role::MITRA`, `Role::DOSPEM`, `Role::SUPERVISOR`, `Role::MAHASISWA`.
9. GIVEN migration baru, WHEN dijalankan, THEN kolom `NIP` dan `no_pegawai` bertipe `string`, `deskripsi_low` dan `feedback` bertipe `text`.
10. GIVEN migration baru, WHEN dijalankan, THEN ada index pada kolom `user_id`, `mhs_id`, `approval`, `dosen_id`, `spv_id` di tabel yang relevan.
11. GIVEN seeder, WHEN dijalankan berulang, THEN tidak menghasilkan duplikasi data (idempotent menggunakan `firstOrCreate`).
12. GIVEN `BaseController`, WHEN controller lain meng-extend-nya, THEN method `getAuthProfile()` tersedia untuk mendapatkan foto profil user yang sedang login tanpa duplikasi kode.

---

## Requirement 2 — Autentikasi & Manajemen User

### User Stories

- Sebagai admin departemen, saya ingin membuat akun untuk semua role agar user bisa login ke sistem.
- Sebagai user, saya ingin login dengan email dan password agar bisa mengakses dashboard sesuai role saya.
- Sebagai sistem, saya ingin registrasi publik dinonaktifkan agar hanya admin yang bisa membuat akun.

### Acceptance Criteria

1. GIVEN halaman login, WHEN user memasukkan email dan password yang benar, THEN diarahkan ke dashboard sesuai `role_id`.
2. GIVEN halaman login, WHEN user memasukkan kredensial salah, THEN muncul pesan error dalam Bahasa Indonesia.
3. GIVEN route registrasi publik, WHEN diakses, THEN diarahkan ke halaman login (registrasi dinonaktifkan).
4. GIVEN admin departemen di halaman buat user, WHEN mengisi form dengan role apapun, THEN akun user dan profil terkait (Departemen/Mitra/Dosen/Supervisor/Mahasiswa) dibuat sekaligus dalam satu transaksi database.
5. GIVEN admin departemen membuat user, WHEN `role_id` dipilih, THEN `role_id` tersimpan dengan benar di tabel `users`.
6. GIVEN admin departemen di halaman edit user, WHEN mengubah data, THEN nama di tabel profil terkait ikut terupdate.
7. GIVEN admin departemen di halaman hapus user, WHEN mengkonfirmasi hapus, THEN user dihapus dengan konfirmasi SweetAlert terlebih dahulu.
8. GIVEN halaman list user, WHEN ditampilkan, THEN ada pagination dan bisa dicari berdasarkan nama/email.
9. GIVEN semua middleware role, WHEN user belum login, THEN diarahkan ke halaman login (bukan crash null pointer).
10. GIVEN semua middleware role, WHEN user login tapi role salah, THEN diarahkan ke halaman yang bermakna dengan pesan error Bahasa Indonesia.

---

## Requirement 3 — Manajemen Profil

### User Stories

- Sebagai user semua role, saya ingin mengupdate profil saya agar data saya selalu akurat.
- Sebagai mahasiswa, saya ingin mengelola skill saya agar mitra bisa melihat kemampuan saya.

### Acceptance Criteria

1. GIVEN user semua role di halaman edit profil, WHEN mengupload foto, THEN foto disimpan dengan nama unik (UUID/timestamp) di `public/images/` dan foto lama dihapus.
2. GIVEN user semua role di halaman edit profil, WHEN tidak mengupload foto baru, THEN foto lama tetap dipertahankan.
3. GIVEN mahasiswa di halaman edit profil, WHEN memilih skill, THEN skill yang tidak dipilih dihapus dari `skill_mhs` dan skill yang dipilih ditambahkan (sync, bukan hanya append).
4. GIVEN user semua role, WHEN mengakses halaman profil, THEN data profil ditampilkan lengkap sesuai role.
5. GIVEN validasi profil, WHEN ada field yang tidak valid, THEN pesan error ditampilkan dalam Bahasa Indonesia dengan `old()` mempertahankan input.

---

## Requirement 4 — Lowongan Magang (Publik & Mitra)

### User Stories

- Sebagai pengunjung/mahasiswa, saya ingin melihat daftar lowongan magang yang tersedia agar bisa memilih yang sesuai.
- Sebagai mitra, saya ingin mengelola lowongan magang saya agar mahasiswa bisa mendaftar.

### Acceptance Criteria

1. GIVEN halaman publik lowongan, WHEN diakses, THEN menampilkan lowongan dengan `jumlah_mhs > 0` menggunakan eager loading `with(['mitra.kabupaten', 'kategori'])` untuk menghindari N+1.
2. GIVEN halaman publik lowongan, WHEN user mencari dengan kata kunci, THEN hasil difilter berdasarkan nama lowongan dengan pagination.
3. GIVEN halaman detail lowongan, WHEN diakses oleh mahasiswa yang sudah login, THEN tombol "Daftar" ditampilkan.
4. GIVEN halaman detail lowongan, WHEN diakses oleh pengunjung yang belum login, THEN tombol "Login untuk Mendaftar" ditampilkan.
5. GIVEN mitra membuat lowongan baru, WHEN mengisi form, THEN foto disimpan dengan nama unik dan lowongan tersimpan.
6. GIVEN mitra mengedit lowongan, WHEN mengupload foto baru, THEN foto lama dihapus dan diganti foto baru.
7. GIVEN mitra menghapus lowongan, WHEN dikonfirmasi, THEN lowongan dihapus dengan konfirmasi SweetAlert.
8. GIVEN halaman list lowongan mitra, WHEN ditampilkan, THEN hanya menampilkan lowongan milik mitra yang login.

---

## Requirement 5 — Alur Apply & Approval

### User Stories

- Sebagai mahasiswa, saya ingin mendaftar ke lowongan magang agar bisa mengikuti magang.
- Sebagai mitra, saya ingin mereview dan menyetujui/menolak pendaftar agar bisa memilih mahasiswa yang tepat.
- Sebagai admin departemen, saya ingin menugaskan dosen pembimbing ke mahasiswa yang diterima magang.

### Acceptance Criteria

1. GIVEN mahasiswa dengan profil belum lengkap, WHEN mengakses halaman apply, THEN tombol daftar di-disable dengan pesan "Lengkapi profil terlebih dahulu".
2. GIVEN mahasiswa dengan profil lengkap, WHEN mendaftar ke lowongan, THEN record `Magang` dibuat dengan `approval = Magang::PENDING` dan status mahasiswa diubah ke `4` (Sedang Mengajukan).
3. GIVEN mahasiswa yang sudah punya pengajuan aktif, WHEN mencoba mendaftar lagi, THEN ditolak dengan pesan error yang jelas.
4. GIVEN mitra di halaman pendaftar, WHEN menyetujui mahasiswa dengan mengisi tanggal dan supervisor, THEN `approval = Magang::DITERIMA`, status mahasiswa = `2` (Sedang Magang), kuota lowongan berkurang 1, semua pengajuan lain mahasiswa tersebut otomatis ditolak — semua dalam satu transaksi database.
5. GIVEN mitra di halaman pendaftar, WHEN menolak mahasiswa, THEN `approval = Magang::DITOLAK`, status mahasiswa = `1` (Belum Magang).
6. GIVEN admin departemen di halaman pengajuan, WHEN menugaskan dosen, THEN hanya `dosen_id` yang diupdate, status mahasiswa TIDAK diubah.
7. GIVEN mitra di halaman magang aktif, WHEN mengakhiri magang mahasiswa, THEN `approval = Magang::SELESAI`, status mahasiswa = `3` (Sudah Magang).
8. GIVEN halaman list pendaftar mitra, WHEN ditampilkan, THEN hanya menampilkan pendaftar untuk lowongan milik mitra yang login.

---

## Requirement 6 — Bimbingan

### User Stories

- Sebagai mahasiswa yang sedang magang, saya ingin mengajukan laporan bimbingan agar dosen pembimbing bisa memantau progress saya.
- Sebagai dosen pembimbing, saya ingin memberikan feedback atas laporan bimbingan mahasiswa.

### Acceptance Criteria

1. GIVEN mahasiswa dengan status magang aktif (`approval = 1` atau `3`), WHEN mengakses halaman bimbingan, THEN bisa melihat list dan form tambah bimbingan.
2. GIVEN mahasiswa mengisi form bimbingan, WHEN submit, THEN file laporan disimpan di `public/file/` dengan nama unik, dan record `Bimbingan` dibuat.
3. GIVEN mahasiswa di halaman detail bimbingan, WHEN melihat entri, THEN bisa melihat catatan, tanggal, file, dan feedback dari dosen (jika ada).
4. GIVEN mahasiswa di halaman edit bimbingan, WHEN mengubah data, THEN validasi hanya untuk field yang ada di form (`catatan`, `tgl_bimbingan`, `file` opsional).
5. GIVEN mahasiswa menghapus bimbingan, WHEN dikonfirmasi, THEN bimbingan dihapus dan diarahkan ke `bimbingan.index`.
6. GIVEN dosen pembimbing di halaman detail bimbingan mahasiswa, WHEN mengisi feedback, THEN feedback tersimpan dan mahasiswa bisa melihatnya.
7. GIVEN dosen pembimbing di halaman list bimbingan, WHEN ditampilkan, THEN hanya mahasiswa yang ditugaskan ke dosen tersebut yang muncul.

---

## Requirement 7 — Logbook

### User Stories

- Sebagai mahasiswa yang sedang magang, saya ingin mencatat aktivitas harian saya di logbook.
- Sebagai supervisor, saya ingin melihat logbook mahasiswa yang saya bimbing dan memberikan catatan.

### Acceptance Criteria

1. GIVEN mahasiswa dengan status magang aktif, WHEN mengakses halaman logbook, THEN bisa melihat list dan form tambah entri.
2. GIVEN mahasiswa mengisi form logbook, WHEN submit, THEN entri logbook tersimpan dengan `magang_id` yang benar.
3. GIVEN mahasiswa di halaman detail logbook, WHEN melihat entri, THEN bisa melihat semua field termasuk catatan supervisor (jika ada).
4. GIVEN mahasiswa di halaman edit logbook, WHEN mengubah data, THEN data terupdate dan diarahkan ke `logbook.index`.
5. GIVEN mahasiswa menghapus logbook, WHEN dikonfirmasi, THEN logbook dihapus dan diarahkan ke `logbook.index` (bukan `bimbingan.index`).
6. GIVEN mahasiswa mengekspor logbook ke PDF, WHEN diklik, THEN file PDF terdownload dengan semua entri logbook.
7. GIVEN supervisor di halaman logbook mahasiswa, WHEN melihat detail, THEN bisa memberikan catatan/feedback per entri logbook.
8. GIVEN supervisor di halaman list logbook, WHEN ditampilkan, THEN hanya mahasiswa yang di bawah supervisor tersebut yang muncul.

---

## Requirement 8 — Penilaian

### User Stories

- Sebagai supervisor, saya ingin memberikan nilai akhir kepada mahasiswa yang telah selesai magang.

### Acceptance Criteria

1. GIVEN supervisor di halaman penilaian, WHEN ditampilkan, THEN hanya mahasiswa dengan `approval = Magang::SELESAI` yang di bawah supervisor tersebut yang muncul.
2. GIVEN supervisor mengisi form penilaian, WHEN submit, THEN `nilai` dan `keterangan` tersimpan di tabel `magang`.
3. GIVEN supervisor yang sudah memberi nilai, WHEN melihat halaman penilaian, THEN nilai yang sudah diisi tetap bisa diedit.
4. GIVEN validasi penilaian, WHEN nilai tidak diisi, THEN muncul pesan error yang jelas.

---

## Requirement 9 — Dashboard Semua Role

### User Stories

- Sebagai user semua role, saya ingin melihat ringkasan data yang relevan di dashboard agar bisa memantau aktivitas dengan cepat.

### Acceptance Criteria

1. GIVEN admin departemen di dashboard, WHEN ditampilkan, THEN menampilkan: total user, total mitra, total dosen, total supervisor, total mahasiswa, mahasiswa sedang magang, mahasiswa belum magang, dan jumlah pengajuan yang belum ada dosen.
2. GIVEN mitra di dashboard, WHEN ditampilkan, THEN menampilkan: jumlah pendaftar (hanya milik mitra ini), jumlah lowongan aktif, jumlah mahasiswa magang aktif, jumlah lowongan penuh — semua difilter per mitra yang login.
3. GIVEN dosen pembimbing di dashboard, WHEN ditampilkan, THEN menampilkan: jumlah mahasiswa bimbingan aktif dan jumlah bimbingan yang belum diberi feedback.
4. GIVEN supervisor di dashboard, WHEN ditampilkan, THEN menampilkan: jumlah mahasiswa logbook aktif dan jumlah penilaian yang belum diisi.
5. GIVEN mahasiswa di dashboard, WHEN ditampilkan, THEN menampilkan: status magang saat ini, jumlah pengajuan, jumlah entri logbook, dan jumlah bimbingan.

---

## Requirement 10 — UI/UX Baru

### User Stories

- Sebagai user semua role, saya ingin tampilan yang modern, bersih, dan nyaman digunakan.

### Acceptance Criteria

1. GIVEN desain baru, WHEN diimplementasikan, THEN menggunakan palet warna utama: **Indigo/Violet** (`#4F46E5` primary, `#7C3AED` secondary) dengan aksen **Emerald** (`#10B981`) untuk status sukses.
2. GIVEN desain baru, WHEN diimplementasikan, THEN menggunakan font **Inter** (dari Google Fonts) untuk semua teks.
3. GIVEN layout dashboard, WHEN ditampilkan, THEN menggunakan sidebar navigasi vertikal yang collapsible dengan ikon dari **Heroicons** atau **Feather Icons**.
4. GIVEN halaman publik (landing page), WHEN ditampilkan, THEN menggunakan desain hero section modern dengan gradient, card lowongan yang bersih, dan filter kategori.
5. GIVEN semua form, WHEN ditampilkan, THEN menggunakan input style modern dengan floating label atau label di atas, border radius konsisten, dan focus state yang jelas.
6. GIVEN semua tabel data, WHEN ditampilkan, THEN menggunakan style tabel yang bersih dengan hover state, badge status berwarna, dan tombol aksi yang jelas.
7. GIVEN semua notifikasi, WHEN ditampilkan, THEN menggunakan SweetAlert2 dengan tema yang sesuai warna primary.
8. GIVEN semua halaman, WHEN diakses di mobile, THEN layout responsive dan sidebar bisa di-toggle.
9. GIVEN status badge (approval, status mahasiswa), WHEN ditampilkan, THEN menggunakan warna yang konsisten: pending=kuning, diterima=hijau, ditolak=merah, selesai=biru.
10. GIVEN halaman login, WHEN ditampilkan, THEN menggunakan desain split-screen atau card centered yang modern, bukan form default Laravel.

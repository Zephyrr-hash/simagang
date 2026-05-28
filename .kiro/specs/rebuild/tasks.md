# Tasks — SIMAGANG Rebuild

## Task 1: Fondasi — Migration, Model, Konstanta, Seeder

- [x] 1.1 Buat semua migration baru dengan perbaikan schema (tipe data, index, hapus UNIQUE bermasalah, tambah kolom `catatan_spv` di logbook)
- [x] 1.2 Update model `Magang` — tambah konstanta `PENDING/DITERIMA/DITOLAK/SELESAI` dan relasi `hasMany(Logbook)`, `hasMany(Bimbingan)`
- [x] 1.3 Update model `Role` — ubah `hasOne` ke `hasMany`, tambah konstanta role ID
- [x] 1.4 Update model `Mahasiswa` — tambah relasi `hasMany(Magang)`, `hasMany(SkillMhs)`
- [x] 1.5 Update model `Lowongan` — tambah relasi `hasMany(Magang)`
- [x] 1.6 Update model `Dosen` — tambah relasi `hasMany(Magang, 'dosen_id')`
- [x] 1.7 Update model `Supervisor` — tambah relasi `hasMany(Magang, 'spv_id')`
- [x] 1.8 Update model `Departemen` — tambah relasi `hasMany(Mahasiswa, 'depart_id')`
- [x] 1.9 Buat `BaseController` dengan method `getAuthProfile()` untuk menghilangkan duplikasi layout helper
- [x] 1.10 Update semua seeder agar idempotent menggunakan `firstOrCreate`

## Task 2: Autentikasi & Middleware

- [x] 2.1 Update `LoginController` — nonaktifkan registrasi publik (`Auth::routes(['register' => false])`)
- [x] 2.2 Update semua middleware role (`IsDepart`, `IsMitra`, `IsDospem`, `IsSupervisor`, `IsMahasiswa`) — tambah pengecekan `Auth::check()` sebelum cek role, pesan error Bahasa Indonesia
- [x] 2.3 Update `IsApprove` middleware — tambah null check untuk `$mhs`
- [x] 2.4 Buat halaman login baru dengan desain split-screen modern (layout guest.blade.php)

## Task 3: Layout & Komponen UI

- [x] 3.1 Buat `resources/views/layouts/app.blade.php` — layout dashboard dengan sidebar indigo gelap, topbar, dan area konten
- [x] 3.2 Buat `resources/views/layouts/guest.blade.php` — layout untuk halaman auth dan publik
- [x] 3.3 Buat `resources/views/layouts/pdf.blade.php` — layout khusus PDF export
- [x] 3.4 Buat `resources/views/components/sidebar.blade.php` — sidebar navigasi per role yang collapsible
- [x] 3.5 Buat `resources/views/components/stat-card.blade.php` — card statistik dashboard dengan gradient
- [x] 3.6 Buat `resources/views/components/badge-status.blade.php` — badge status approval berwarna
- [x] 3.7 Buat `resources/sass/app.scss` — custom CSS dengan variabel warna baru, font Inter, dan style komponen
- [x] 3.8 Update `webpack.mix.js` dan compile assets

## Task 4: Landing Page & Lowongan Publik

- [x] 4.1 Buat `welcome.blade.php` baru — hero section gradient, search bar, grid card lowongan
- [x] 4.2 Update `LowonganController::AllLowongan()` — tambah eager loading `with(['mitra.kabupaten', 'kategori'])`
- [x] 4.3 Buat `lowongan/detail.blade.php` baru — halaman detail lowongan yang modern
- [x] 4.4 Buat `lowongan/apply.blade.php` baru — form apply dengan info profil mahasiswa

## Task 5: Dashboard Semua Role

- [x] 5.1 Update `DepartController::departHome()` dan buat `depart/home.blade.php` baru
- [x] 5.2 Update `MitraController::mitraHome()` — fix `countPendaftar()` filter per mitra, buat `mitra/home.blade.php` baru
- [x] 5.3 Update `DospemController::dospemHome()` dan buat `dosen/home.blade.php` baru
- [x] 5.4 Update `SpvController::supervisorHome()` dan buat `spv/home.blade.php` baru
- [x] 5.5 Update `MhsController::mahasiswaHome()` dan buat `mhs/home.blade.php` baru

## Task 6: Manajemen User (Admin Departemen)

- [x] 6.1 Update `UserController::store()` — hapus anti-pattern `$request = new Request(...)`, gunakan transaksi DB, pastikan `role_id` tersimpan
- [x] 6.2 Update `UserController::destroy()` — tambah konfirmasi SweetAlert
- [x] 6.3 Update `UserController::index()` — tambah pagination dan search
- [x] 6.4 Buat `depart/user/index.blade.php` baru — tabel dengan search, pagination, badge role
- [x] 6.5 Buat `depart/user/create.blade.php` baru — form buat user modern
- [x] 6.6 Buat `depart/user/edit.blade.php` baru — form edit user modern

## Task 7: Profil Semua Role

- [x] 7.1 Update `ProfileController::update()` — fix sync skill mahasiswa (delete + insert), nama file unik, hapus file lama
- [x] 7.2 Buat semua view profil baru: `depart/profile/`, `mitra/profile/`, `dosen/profile/`, `spv/profile/`, `mhs/profile/` (index + edit per role)

## Task 8: CRUD Lowongan (Mitra)

- [x] 8.1 Update `LowonganController::store()` — nama file unik dengan UUID
- [x] 8.2 Update `LowonganController::update()` — handle upload foto baru, hapus foto lama
- [x] 8.3 Buat `mitra/lowongan/index.blade.php` baru
- [x] 8.4 Buat `mitra/lowongan/create.blade.php` baru
- [x] 8.5 Buat `mitra/lowongan/edit.blade.php` baru
- [x] 8.6 Buat `mitra/lowongan/show.blade.php` baru (detail lowongan untuk mitra)

## Task 9: Alur Apply & Approval

- [x] 9.1 Update `ApplyController::store()` — cek apakah mahasiswa sudah punya pengajuan aktif
- [x] 9.2 Update `ApplyController::approval()` — gunakan `DB::transaction()`, gunakan konstanta Magang
- [x] 9.3 Update `ApplyController::updateDospem()` — hapus update status mahasiswa yang salah, gunakan transaksi
- [x] 9.4 Update `ApplyController::end()` — gunakan konstanta Magang
- [x] 9.5 Buat `mitra/pendaftar/index.blade.php` baru
- [x] 9.6 Buat `mitra/pendaftar/edit.blade.php` baru (form approve/reject dengan tanggal & supervisor)
- [x] 9.7 Buat `mitra/magang/index.blade.php` baru
- [x] 9.8 Buat `mitra/magang/show.blade.php` baru
- [x] 9.9 Buat `depart/pengajuan/index.blade.php` baru
- [x] 9.10 Buat `depart/pengajuan/edit.blade.php` baru (form assign dosen)
- [x] 9.11 Buat `mhs/ajukan/index.blade.php` baru (list pengajuan mahasiswa)

## Task 10: Bimbingan

- [x] 10.1 Update `BimbinganController::update()` — perbaiki validasi (hapus `mhs_id` dan `dosen_id`)
- [x] 10.2 Update `BimbinganController::destroy()` — pastikan redirect ke `bimbingan.index`
- [x] 10.3 Buat `mhs/bimbingan/index.blade.php` baru
- [x] 10.4 Buat `mhs/bimbingan/create.blade.php` baru
- [x] 10.5 Buat `mhs/bimbingan/show.blade.php` — **BARU** (sebelumnya kosong), tampilkan detail bimbingan + feedback
- [x] 10.6 Buat `mhs/bimbingan/edit.blade.php` baru — form edit bimbingan yang benar
- [x] 10.7 Buat `dosen/bimbingan/index.blade.php` baru
- [x] 10.8 Buat `dosen/bimbingan/edit.blade.php` baru (detail mahasiswa + form feedback)

## Task 11: Logbook

- [x] 11.1 Update `LogBookController::destroy()` — perbaiki redirect ke `logbook.index`
- [x] 11.2 Update `LogBookController` — extend `BaseController`, hapus duplikasi layout helper
- [x] 11.3 Tambahkan method `updateCatatanSpv()` di `LogBookController` untuk catatan supervisor
- [x] 11.4 Tambahkan route `POST supervisor/logbook/{id}/catatan` untuk catatan supervisor
- [x] 11.5 Buat `mhs/logbook/index.blade.php` baru
- [x] 11.6 Buat `mhs/logbook/create.blade.php` baru
- [x] 11.7 Buat `mhs/logbook/show.blade.php` — **BARU** (sebelumnya kosong), tampilkan detail + catatan spv
- [x] 11.8 Buat `mhs/logbook/edit.blade.php` — **BARU** (sebelumnya kosong), form edit logbook
- [x] 11.9 Buat `mhs/logbook/print.blade.php` baru — template PDF yang rapi
- [x] 11.10 Buat `spv/logbook/index.blade.php` baru
- [x] 11.11 Buat `spv/logbook/show.blade.php` baru — detail logbook + form catatan supervisor

## Task 12: Penilaian

- [x] 12.1 Update `ApplyController::score()` — tambah validasi input
- [x] 12.2 Buat `spv/penilaian/index.blade.php` baru — tabel mahasiswa selesai magang + form nilai

## Task 13: Mahasiswa — Detail & List

- [x] 13.1 Buat `depart/mhs/index.blade.php` baru — list mahasiswa dengan status badge
- [x] 13.2 Buat `depart/mhs/show.blade.php` baru — detail mahasiswa lengkap

## Task 14: Finalisasi & Polish

- [x] 14.1 Pastikan semua SweetAlert konfirmasi hapus terpasang di semua tombol delete
- [x] 14.2 Pastikan semua flash message (success/error) ditampilkan konsisten di semua view
- [x] 14.3 Pastikan semua form menampilkan validation error dengan `old()` helper
- [ ] 14.4 Test alur lengkap: register user → apply → approve → bimbingan → logbook → penilaian
- [x] 14.5 Pastikan semua halaman responsive di mobile
- [x] 14.6 Update `routes/web.php` — tambah route catatan supervisor, pastikan semua route konsisten

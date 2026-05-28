# Design — SIMAGANG Rebuild

## Arsitektur Sistem

### Stack Teknologi
- **Backend**: Laravel 8.x, PHP 8.0+
- **Frontend**: Blade Templates, Bootstrap 5, Custom CSS (Sass)
- **Font**: Inter (Google Fonts)
- **Icons**: Heroicons (SVG inline)
- **Alerts**: SweetAlert2 via `realrashid/sweet-alert`
- **PDF**: `barryvdh/laravel-dompdf`
- **Build**: Laravel Mix 6

### Palet Warna Baru
```
Primary:    #4F46E5  (Indigo-600)
Primary Dark: #4338CA (Indigo-700)
Secondary:  #7C3AED  (Violet-600)
Accent:     #10B981  (Emerald-500)
Danger:     #EF4444  (Red-500)
Warning:    #F59E0B  (Amber-500)
Info:       #3B82F6  (Blue-500)
Dark:       #1E1B4B  (Indigo-950) — sidebar
Light BG:   #F5F3FF  (Violet-50)  — page background
```

### Font
- **Inter** — semua teks (weight: 300, 400, 500, 600, 700)
- Import via Google Fonts di layout utama

---

## Struktur Database (Perbaikan dari Versi Lama)

### Perubahan Schema
| Tabel | Kolom | Tipe Lama | Tipe Baru | Alasan |
|-------|-------|-----------|-----------|--------|
| `dosen` | `NIP` | `integer` | `string(20)` | NIP bisa > 11 digit |
| `supervisor` | `no_pegawai` | `integer` | `string(20)` | Nomor pegawai bisa alfanumerik |
| `lowongan` | `deskripsi_low` | `string(255)` | `text` | Deskripsi pekerjaan butuh ruang lebih |
| `bimbingan` | `feedback` | `string(255)` | `text` | Feedback dosen butuh ruang lebih |
| `logbook` | `deskripsi_log` | `string(255)` | `text` | Deskripsi aktivitas butuh ruang lebih |
| `logbook` | `saran` | `string(255)` | `text` | Saran butuh ruang lebih |
| `logbook` | `catatan_spv` | — | `text nullable` | Kolom baru untuk catatan supervisor |

### Index Baru
```sql
-- magang
INDEX magang_mhs_id_index (mhs_id)
INDEX magang_approval_index (approval)
INDEX magang_dosen_id_index (dosen_id)
INDEX magang_spv_id_index (spv_id)

-- logbook
INDEX logbook_magang_id_index (magang_id)

-- bimbingan
INDEX bimbingan_magang_id_index (magang_id)
```

### Penghapusan UNIQUE Constraint Bermasalah
- Hapus `UNIQUE` dari `mitra.alamat_mitra`, `mitra.telepon_mitra`, `mitra.fax_mitra`

---

## Struktur Kode

### Konstanta di Model

```php
// app/Models/Magang.php
const PENDING  = 0;
const DITERIMA = 1;
const DITOLAK  = 2;
const SELESAI  = 3;

// app/Models/Role.php  
const DEPARTEMEN = 1;
const MITRA      = 2;
const DOSPEM     = 3;
const SUPERVISOR = 4;
const MAHASISWA  = 5;
```

### BaseController
`app/Http/Controllers/BaseController.php` — menyediakan:
- `getAuthProfile(): array` — mengembalikan data profil + foto user yang login berdasarkan role
- Menghilangkan duplikasi `*Layout()` method di semua controller

### Relasi Eloquent Lengkap

```
Magang::hasMany(Logbook::class)
Magang::hasMany(Bimbingan::class)
Mahasiswa::hasMany(Magang::class)
Mahasiswa::hasMany(SkillMhs::class)
Lowongan::hasMany(Magang::class)
Role::hasMany(User::class)
Departemen::hasMany(Mahasiswa::class, 'depart_id')
Dosen::hasMany(Magang::class, 'dosen_id')
Supervisor::hasMany(Magang::class, 'spv_id')
```

### Helper Upload File
Semua upload file menggunakan nama unik:
```php
$fileName = time() . '_' . Str::uuid() . '.' . $file->extension();
```
Path konsisten:
- Foto profil & lowongan → `public/images/`
- File bimbingan → `public/file/`

---

## Struktur File Baru

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── BaseController.php          ← BARU: base dengan getAuthProfile()
│   │   ├── Auth/
│   │   │   └── LoginController.php     ← UBAH: nonaktifkan register publik
│   │   ├── ApplyController.php         ← PERBAIKI: transaksi DB, fix status bug
│   │   ├── BimbinganController.php     ← PERBAIKI: fix validasi update
│   │   ├── BimbinganSpvController.php  ← BARU: catatan supervisor di logbook
│   │   ├── DepartController.php        ← PERBAIKI: extend BaseController
│   │   ├── DospemController.php        ← PERBAIKI: extend BaseController
│   │   ├── LogBookController.php       ← PERBAIKI: fix redirect destroy
│   │   ├── LowonganController.php      ← PERBAIKI: eager loading, nama file unik
│   │   ├── MhsController.php           ← PERBAIKI: extend BaseController
│   │   ├── MitraController.php         ← PERBAIKI: fix countPendaftar per mitra
│   │   ├── ProfileController.php       ← PERBAIKI: sync skill, nama file unik
│   │   ├── SpvController.php           ← PERBAIKI: extend BaseController
│   │   └── UserController.php          ← PERBAIKI: transaksi DB, hapus anti-pattern
│   └── Middleware/
│       ├── IsDepart.php                ← PERBAIKI: cek auth dulu
│       ├── IsDospem.php                ← PERBAIKI: cek auth dulu
│       ├── IsMahasiswa.php             ← PERBAIKI: cek auth dulu
│       ├── IsMitra.php                 ← PERBAIKI: cek auth dulu
│       ├── IsSupervisor.php            ← PERBAIKI: cek auth dulu
│       └── IsApprove.php               ← PERBAIKI: null check untuk $mhs
├── Models/
│   ├── Magang.php                      ← PERBAIKI: tambah konstanta + relasi
│   ├── Role.php                        ← PERBAIKI: hasMany + konstanta
│   ├── Mahasiswa.php                   ← PERBAIKI: tambah relasi
│   ├── Lowongan.php                    ← PERBAIKI: tambah relasi
│   ├── Dosen.php                       ← PERBAIKI: tambah relasi
│   └── Supervisor.php                  ← PERBAIKI: tambah relasi

resources/views/
├── layouts/
│   ├── app.blade.php                   ← BARU: layout dashboard dengan sidebar baru
│   ├── guest.blade.php                 ← BARU: layout halaman publik/auth
│   └── pdf.blade.php                   ← BARU: layout khusus PDF
├── auth/
│   ├── login.blade.php                 ← BARU: desain modern split-screen
│   └── passwords/                      ← tetap ada
├── components/
│   ├── sidebar.blade.php               ← BARU: sidebar navigasi per role
│   ├── stat-card.blade.php             ← BARU: card statistik dashboard
│   ├── badge-status.blade.php          ← BARU: badge status approval
│   └── alert.blade.php                 ← BARU: komponen alert/flash message
├── welcome.blade.php                   ← BARU: landing page modern
├── depart/
│   ├── home.blade.php
│   ├── user/ (index, create, edit)
│   ├── mhs/ (index, show)
│   ├── pengajuan/ (index, edit)
│   └── profile/ (index, edit)
├── mitra/
│   ├── home.blade.php
│   ├── lowongan/ (index, create, edit, show)
│   ├── pendaftar/ (index, edit)
│   ├── magang/ (index, show)
│   └── profile/ (index, edit)
├── dosen/
│   ├── home.blade.php
│   ├── bimbingan/ (index, edit)
│   └── profile/ (index, edit)
├── spv/
│   ├── home.blade.php
│   ├── logbook/ (index, show)
│   ├── penilaian/ (index)
│   └── profile/ (index, edit)
├── mhs/
│   ├── home.blade.php
│   ├── ajukan/ (index)
│   ├── bimbingan/ (index, show, create, edit)  ← PERBAIKI: show & edit tidak kosong
│   ├── logbook/ (index, show, create, edit, print) ← PERBAIKI: show & edit tidak kosong
│   └── profile/ (index, edit)
└── lowongan/
    ├── index.blade.php                 ← halaman publik
    ├── detail.blade.php
    └── apply.blade.php

database/
├── migrations/
│   └── [semua migration baru dengan perbaikan schema]
└── seeders/
    └── [semua seeder idempotent dengan firstOrCreate]
```

---

## Desain UI/UX

### Layout Dashboard (Semua Role)
```
┌─────────────────────────────────────────────────────┐
│  SIDEBAR (240px, bg: #1E1B4B)                        │
│  ┌─────────────────────────────────────────────────┐ │
│  │  Logo SIMAGANG                                  │ │
│  │  ─────────────────                              │ │
│  │  [Avatar] Nama User                             │ │
│  │           Role                                  │ │
│  │  ─────────────────                              │ │
│  │  🏠 Dashboard                                   │ │
│  │  📋 Menu 1                                      │ │
│  │  📋 Menu 2                                      │ │
│  │  ...                                            │ │
│  │  ─────────────────                              │ │
│  │  👤 Profil                                      │ │
│  │  🚪 Logout                                      │ │
│  └─────────────────────────────────────────────────┘ │
│                                                       │
│  MAIN CONTENT (flex-1, bg: #F5F3FF)                  │
│  ┌─────────────────────────────────────────────────┐ │
│  │  TOPBAR: Breadcrumb | Notifikasi | User Menu    │ │
│  │  ─────────────────────────────────────────────  │ │
│  │  PAGE CONTENT                                   │ │
│  └─────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────┘
```

### Halaman Login
```
┌──────────────────────────────────────────────────────┐
│  LEFT PANEL (50%, bg gradient indigo)                │
│  ┌────────────────────────────────────────────────┐  │
│  │  Logo besar                                    │  │
│  │  "SIMAGANG"                                    │  │
│  │  Tagline sistem                                │  │
│  │  Ilustrasi/pattern                             │  │
│  └────────────────────────────────────────────────┘  │
│                                                       │
│  RIGHT PANEL (50%, bg white)                         │
│  ┌────────────────────────────────────────────────┐  │
│  │  "Selamat Datang Kembali"                      │  │
│  │  "Masuk ke akun Anda"                          │  │
│  │                                                │  │
│  │  [Email Input]                                 │  │
│  │  [Password Input]                              │  │
│  │  [Tombol Masuk]                                │  │
│  └────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────┘
```

### Landing Page Publik
- Hero section dengan gradient indigo-violet, teks putih, search bar
- Section statistik (jumlah lowongan, mitra, mahasiswa)
- Grid card lowongan dengan foto, nama, kategori badge, lokasi, kuota
- Filter kategori horizontal
- Footer sederhana

### Card Statistik Dashboard
```
┌─────────────────────────┐
│  [Icon]    [Angka besar] │
│  Label statistik         │
│  ─────────────────────── │
│  ↑ Deskripsi singkat     │
└─────────────────────────┘
```
Warna card: gradient sesuai jenis data (indigo, violet, emerald, amber)

### Badge Status
| Status | Warna | Label |
|--------|-------|-------|
| `PENDING (0)` | Amber/Kuning | Menunggu |
| `DITERIMA (1)` | Emerald/Hijau | Diterima |
| `DITOLAK (2)` | Red/Merah | Ditolak |
| `SELESAI (3)` | Blue/Biru | Selesai |

### Tabel Data
- Header: bg `#4F46E5`, teks putih
- Row hover: bg `#EEF2FF` (Indigo-50)
- Border: `#E0E7FF` (Indigo-100)
- Tombol aksi: icon + text, ukuran kecil, rounded

---

## Alur Perbaikan Bug

### Bug 1: RegisterController
```php
// SOLUSI: Nonaktifkan route register
// routes/web.php
Auth::routes(['register' => false]);
```

### Bug 2: updateDospem() status mahasiswa
```php
// SOLUSI: Hapus baris update status_id
public function updateDospem(Request $request, $id) {
    $magang = Magang::findOrFail($id);
    DB::transaction(function() use ($magang, $request) {
        $magang->update(['dosen_id' => $request->dosen_id]);
        // TIDAK ada update status_id di sini
    });
    return redirect()->route('pengajuan.index')->with('success', 'Dosen pembimbing berhasil ditugaskan!');
}
```

### Bug 3: LogBookController::destroy() redirect salah
```php
// SOLUSI: Ubah redirect ke logbook.index
return redirect()->route('logbook.index')->with('success', 'Logbook berhasil dihapus!');
```

### Bug 4: BimbinganController::update() validasi salah
```php
// SOLUSI: Validasi hanya field yang ada di form
$request->validate([
    'catatan'       => 'required|string',
    'tgl_bimbingan' => 'required|date',
    'file'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
]);
```

### Bug 5: countPendaftar() MitraController tidak filter per mitra
```php
// SOLUSI: Filter berdasarkan mitra yang login
public function countPendaftar(): int {
    $mitra = Mitra::where('user_id', Auth::id())->first();
    return Magang::whereHas('lowongan', fn($q) => $q->where('mitra_id', $mitra->id))
        ->where('approval', Magang::PENDING)
        ->count();
}
```

### Bug 6: Null pointer di *Layout() helpers
```php
// SOLUSI: Di BaseController, handle null dengan optional()
public function getAuthProfile(): array {
    $user = Auth::user();
    $profile = match((int) $user->role_id) {
        Role::DEPARTEMEN => Departemen::where('user_id', $user->id)->first(),
        Role::MITRA      => Mitra::where('user_id', $user->id)->first(),
        // dst...
    };
    return [
        'profile' => $profile,
        'foto'    => $profile?->foto ?? 'default.png',
    ];
}
```

### Bug 7: UserController anti-pattern $request overwrite
```php
// SOLUSI: Jangan overwrite $request, gunakan array langsung
$user = User::create([
    'name'     => $request->name,
    'email'    => $request->email,
    'role_id'  => $request->role_id,
    'password' => Hash::make($request->password),
]);
```

### Bug 8: Skill mahasiswa tidak di-sync
```php
// SOLUSI: Gunakan sync via delete + insert
SkillMhs::where('mhs_id', $mhs->id)->delete();
if ($request->has('skill_id')) {
    foreach ($request->skill_id as $skillId) {
        SkillMhs::create(['skill_id' => $skillId, 'mhs_id' => $mhs->id]);
    }
}
```

### Bug 9: N+1 query di halaman publik
```php
// SOLUSI: Eager loading
$low = Lowongan::with(['mitra.kabupaten', 'kategori'])
    ->where('jumlah_mhs', '>', 0)
    ->where('nama_low', 'like', "%{$cari}%")
    ->paginate(12);
```

---

## Urutan Implementasi (Tasks)

1. Setup fondasi: migration baru, model dengan konstanta & relasi, BaseController, seeder
2. Autentikasi: login baru, nonaktifkan register, middleware diperbaiki
3. Layout & komponen UI: app.blade.php, guest.blade.php, sidebar, komponen
4. Landing page & lowongan publik
5. Dashboard semua role
6. Manajemen user (admin departemen)
7. Profil semua role
8. CRUD lowongan (mitra)
9. Alur apply & approval
10. Bimbingan (mahasiswa + dosen)
11. Logbook (mahasiswa + supervisor + catatan spv)
12. Penilaian (supervisor)
13. PDF export logbook
14. Testing & polish

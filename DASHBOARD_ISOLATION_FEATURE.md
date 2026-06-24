# Fitur Isolasi Data Dashboard Departemen

## Deskripsi
Fitur ini memastikan bahwa setiap Departemen hanya dapat melihat data statistik dan informasi yang terkait dengan departemen mereka sendiri di halaman dashboard.

## Implementasi

### 1. Dashboard Controller (`DepartController.php`)

Semua method counting di `DepartController` telah diupdate untuk melakukan filtering berdasarkan kepemilikan departemen:

#### a. `countUser()`
Filter user yang dibuat oleh departemen ini (berdasarkan `created_by`):
```php
public function countUser(): int
{
    return User::where('created_by', Auth::id())->count();
}
```

#### b. `countMitra()`
Filter mitra yang dibuat oleh departemen ini:
```php
public function countMitra(): int
{
    return User::where('role_id', Role::MITRA)
        ->where('created_by', Auth::id())
        ->count();
}
```

#### c. `countSpv()`
Filter supervisor yang dibuat oleh departemen ini:
```php
public function countSpv(): int
{
    return User::where('role_id', Role::SUPERVISOR)
        ->where('created_by', Auth::id())
        ->count();
}
```

#### d. `countDosen()`
Filter dosen yang memiliki `depart_id` sesuai dengan departemen ini:
```php
public function countDosen(): int
{
    $depart = Departemen::where('user_id', Auth::id())->first();
    if (!$depart) return 0;
    
    return User::where('role_id', Role::DOSPEM)
        ->whereHas('dospem', function($q) use ($depart) {
            $q->where('depart_id', $depart->id);
        })
        ->count();
}
```

#### e. `countMhs()`
Filter mahasiswa berdasarkan `depart_id`:
```php
public function countMhs(): int
{
    $depart = Departemen::where('user_id', Auth::id())->first();
    if (!$depart) return 0;
    
    return Mahasiswa::where('depart_id', $depart->id)->count();
}
```

#### f. `countMhsMagang()`
Filter mahasiswa yang sedang magang (`status_id = 2`) dari departemen ini:
```php
public function countMhsMagang(): int
{
    $depart = Departemen::where('user_id', Auth::id())->first();
    if (!$depart) return 0;
    
    return Mahasiswa::where('depart_id', $depart->id)
        ->where('status_id', 2)
        ->count();
}
```

#### g. `countBelumMagang()`
Filter mahasiswa yang belum magang (`status_id = 1`) dari departemen ini:
```php
public function countBelumMagang(): int
{
    $depart = Departemen::where('user_id', Auth::id())->first();
    if (!$depart) return 0;
    
    return Mahasiswa::where('depart_id', $depart->id)
        ->where('status_id', 1)
        ->count();
}
```

#### h. `countPengajuan()`
Filter pengajuan magang yang belum ada dosen pembimbing, hanya dari mahasiswa departemen ini:
```php
public function countPengajuan(): int
{
    $depart = Departemen::where('user_id', Auth::id())->first();
    if (!$depart) return 0;
    
    return Magang::whereNull('dosen_id')
        ->whereHas('mahasiswa', function($q) use ($depart) {
            $q->where('depart_id', $depart->id);
        })
        ->count();
}
```

### 2. Security Enhancement pada ApplyController

Ditambahkan verifikasi ownership pada method-method yang digunakan oleh Departemen:

#### a. `pengajuan($id)`
Memastikan bahwa magang yang diakses adalah milik mahasiswa dari departemen yang login:
```php
public function pengajuan($id)
{
    $departId = Departemen::where('user_id', Auth::id())->firstOrFail();
    
    // Verifikasi bahwa magang ini milik mahasiswa dari departemen yang login
    $magang = Magang::with(['mahasiswa', 'lowongan.mitra'])
        ->whereHas('mahasiswa', function($q) use ($departId) {
            $q->where('depart_id', $departId->id);
        })
        ->findOrFail($id);
        
    // ... rest of the code
}
```

#### b. `updateDospem($id)`
Memastikan bahwa:
1. Magang yang diupdate adalah milik mahasiswa dari departemen yang login
2. Dosen yang ditugaskan adalah milik departemen yang sama

```php
public function updateDospem(Request $request, $id)
{
    // ... validation
    
    // Verifikasi bahwa magang ini milik mahasiswa dari departemen yang login
    $departId = Departemen::where('user_id', Auth::id())->firstOrFail();
    $magang = Magang::whereHas('mahasiswa', function($q) use ($departId) {
            $q->where('depart_id', $departId->id);
        })
        ->findOrFail($id);
        
    // Verifikasi bahwa dosen yang dipilih adalah milik departemen ini
    $dosen = Dosen::where('id', $request->dosen_id)
        ->where('depart_id', $departId->id)
        ->firstOrFail();
    
    // ... rest of the code
}
```

## Dashboard View

Dashboard (`resources/views/depart/home.blade.php`) menampilkan:

### Statistik Cards
- **Total User**: Semua user yang dibuat departemen ini
- **Total Mitra**: Mitra yang dibuat departemen ini
- **Total Dosen**: Dosen pembimbing dari departemen ini
- **Total Supervisor**: Supervisor yang dibuat departemen ini
- **Total Mahasiswa**: Mahasiswa yang terdaftar di departemen ini
- **Sedang Magang**: Mahasiswa dengan status aktif magang
- **Belum Magang**: Mahasiswa yang belum mendaftar magang
- **Pengajuan Pending**: Pengajuan magang yang belum ditugaskan dosen

### Quick Actions
- Kelola User
- Data Mahasiswa
- Pengajuan Dospem

## Keamanan

### Prinsip Isolasi Data
1. **User Management**: Setiap departemen hanya bisa melihat/mengelola user yang mereka buat sendiri (`created_by` = Auth::id())
2. **Mahasiswa**: Filter berdasarkan `depart_id` di tabel `mahasiswa`
3. **Dosen**: Filter berdasarkan `depart_id` di tabel `dosen`
4. **Mitra & Supervisor**: Filter berdasarkan `created_by` di tabel `users`
5. **Pengajuan**: Filter magang berdasarkan `depart_id` mahasiswa

### Error Handling
- Jika departemen tidak ditemukan, count method mengembalikan 0
- Jika akses tidak sah (cross-department), Laravel akan throw 404 (findOrFail)

## Testing

Untuk menguji isolasi data:

1. **Login dengan departemen pertama**
   - Buat beberapa user (mitra, dosen, supervisor)
   - Buat/lihat data mahasiswa
   - Catat jumlah di dashboard

2. **Login dengan departemen kedua** (departemen@simagang.test)
   - Dashboard harus menunjukkan statistik 0 atau data departemen kedua saja
   - Tidak boleh bisa mengakses data departemen pertama

3. **Test URL manipulation**
   - Coba akses `/depart/pengajuan/{id}` dengan ID milik departemen lain
   - Harus return 404 Not Found

## File yang Dimodifikasi

1. `app/Http/Controllers/DepartController.php`
   - Semua method count diupdate dengan filtering
   - Removed duplicate `countPengajuan()` method

2. `app/Http/Controllers/ApplyController.php`
   - `pengajuan()` method - added ownership verification
   - `updateDospem()` method - added ownership verification

## Dependencies

Fitur ini bergantung pada:
- Kolom `created_by` di tabel `users` (Task 6)
- Kolom `depart_id` di tabel `mahasiswa`, `dosen`, `departemen`
- Relationship yang sudah ada di model-model terkait

## Related Features

- **Task 6**: User Isolation (menambahkan `created_by` column)
- **Task 3**: Activity Logs (untuk tracking perubahan data)

## Status

✅ **COMPLETED** - Semua fitur dashboard departemen sudah difilter berdasarkan ownership departemen masing-masing.

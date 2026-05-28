{{--
    Komponen Sidebar SIMAGANG
    ─────────────────────────────────────────────────────────────────────────────
    Sidebar navigasi sudah terintegrasi penuh di dalam layout utama:
        resources/views/layouts/app.blade.php

    Layout tersebut menangani:
    - Tampilan sidebar responsif (desktop fixed, mobile slide-in)
    - Navigasi dinamis berdasarkan role user (Departemen, Mitra, Dospem,
      Supervisor, Mahasiswa)
    - Avatar / inisial user
    - Menu profil dan logout

    Komponen ini disediakan sebagai stub untuk kompatibilitas apabila ada
    view yang memanggil <x-sidebar /> secara eksplisit. Tidak ada output HTML
    yang dirender di sini karena sidebar sudah dirender oleh app.blade.php.

    Cara penggunaan layout yang benar:
    ─────────────────────────────────────────────────────────────────────────────
    @extends('layouts.app')

    @section('title', 'Judul Halaman')

    @section('content')
        {{-- konten halaman --}}
    @endsection
    ─────────────────────────────────────────────────────────────────────────────
--}}

{{ $slot ?? '' }}

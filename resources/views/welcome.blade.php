@extends('layouts.guest')

@section('title', 'SIMAGANG — Temukan Magang Impianmu')

@push('styles')
<style>
    /* ===== RESET & BASE ===== */
    *, *::before, *::after { box-sizing: border-box; }

    /* ===== NAVBAR ===== */
    .navbar-simagang {
        background: #ffffff;
        box-shadow: 0 1px 8px rgba(14, 165, 233, 0.10);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 0.75rem 0;
    }
    .navbar-simagang .brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0284C7;
        text-decoration: none;
        letter-spacing: -0.5px;
    }
    .navbar-simagang .brand span {
        color: #14B8A6;
    }
    .btn-masuk {
        background: linear-gradient(135deg, #0EA5E9, #14B8A6);
        color: #fff !important;
        border: none;
        border-radius: 8px;
        padding: 0.45rem 1.25rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-masuk:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25); color: #fff; }
    .navbar-user-name {
        font-weight: 600;
        color: #0284C7;
        font-size: 0.875rem;
    }
    .btn-dashboard {
        background: #F0F9FF;
        color: #0284C7 !important;
        border: 1.5px solid #BAE6FD;
        border-radius: 8px;
        padding: 0.4rem 1.1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-dashboard:hover { background: #E0F2FE; }
</style>
@endpush

@push('styles')
<style>
    /* ===== HERO ===== */
    .hero-section {
        background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 50%, #14B8A6 100%);
        padding: 5rem 0 4rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 320px; height: 320px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -80px; left: -40px;
        width: 260px; height: 260px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .hero-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 400;
        opacity: 0.88;
        margin-bottom: 2rem;
        max-width: 520px;
    }
    .search-bar {
        display: flex;
        gap: 0;
        max-width: 560px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
    }
    .search-bar input {
        flex: 1;
        border: none;
        padding: 0.85rem 1.25rem;
        font-size: 0.95rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
        color: #0F172A;
    }
    .search-bar button {
        background: #14B8A6;
        color: #fff;
        border: none;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .search-bar button:hover { background: #0D9488; }
    .hero-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }
    .hero-stat-item {
        display: flex;
        flex-direction: column;
    }
    .hero-stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1;
    }
    .hero-stat-label {
        font-size: 0.8rem;
        opacity: 0.8;
        margin-top: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@push('styles')
<style>
    /* ===== LOWONGAN SECTION ===== */
    .lowongan-section {
        background: #F8FAFC;
        padding: 3.5rem 0 4rem;
        min-height: 60vh;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 0.25rem;
    }
    .section-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
        margin-bottom: 2rem;
    }

    /* ===== CARD LOWONGAN ===== */
    .card-lowongan {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(14, 165, 233, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #E2E8F0;
    }
    .card-lowongan:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(14, 165, 233, 0.15);
    }
    .card-img-wrap {
        width: 100%;
        height: 180px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    .card-body-low {
        padding: 1.1rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .card-badge {
        display: inline-block;
        background: #F0F9FF;
        color: #0369A1;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        margin-bottom: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .card-title-low {
        font-size: 1rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 0.25rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-mitra-name {
        font-size: 0.85rem;
        color: #0284C7;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        margin-bottom: 1rem;
        flex: 1;
    }
    .card-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: #6B7280;
    }
    .card-meta-item svg {
        flex-shrink: 0;
        color: #9CA3AF;
    }
    .card-kuota {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: #ECFDF5;
        color: #059669;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        margin-bottom: 1rem;
    }
    .btn-detail {
        display: block;
        width: 100%;
        text-align: center;
        background: linear-gradient(135deg, #0EA5E9, #14B8A6);
        color: #fff !important;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
    }
    .btn-detail:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25); color: #fff; }
</style>
@endpush

@push('styles')
<style>
    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: #6B7280;
    }
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .empty-state h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrap {
        margin-top: 2.5rem;
        display: flex;
        justify-content: center;
    }
    .pagination-wrap .pagination {
        gap: 0.25rem;
    }
    .pagination-wrap .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #E2E8F0;
        color: #0284C7;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.4rem 0.75rem;
        transition: all 0.15s;
    }
    .pagination-wrap .page-link:hover {
        background: #F0F9FF;
        border-color: #BAE6FD;
        color: #0369A1;
    }
    .pagination-wrap .page-item.active .page-link {
        background: #0EA5E9;
        border-color: #0EA5E9;
        color: #fff;
    }
    .pagination-wrap .page-item.disabled .page-link {
        color: #9CA3AF;
        border-color: #F3F4F6;
    }

    /* ===== FOOTER ===== */
    .footer-simagang {
        background: #0F172A;
        color: rgba(255,255,255,0.65);
        text-align: center;
        padding: 1.5rem 0;
        font-size: 0.85rem;
    }
    .footer-simagang strong {
        color: #7DD3FC;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .hero-section { padding: 3rem 0 2.5rem; }
        .hero-stats { gap: 1.25rem; }
        .search-bar { max-width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- ===== NAVBAR ===== --}}
<nav class="navbar-simagang">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="brand">SIMA<span>GANG</span></a>

        <div class="d-flex align-items-center gap-3">
            @auth
                <span class="navbar-user-name d-none d-sm-inline">
                    {{ Auth::user()->name }}
                </span>
                @php
                    $roleId = Auth::user()->role_id;
                    $dashboardRoute = match((int) $roleId) {
                        1 => route('depart.home'),
                        2 => route('mitra.home'),
                        3 => route('dospem.home'),
                        4 => route('supervisor.home'),
                        5 => route('mahasiswa.home'),
                        default => url('/home'),
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn-dashboard">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ===== HERO SECTION ===== --}}
<section class="hero-section">
    <div class="container" style="position: relative; z-index: 1;">
        <h1 class="hero-title">Temukan Magang<br>Impianmu</h1>
        <p class="hero-subtitle">
            Jelajahi ratusan lowongan magang dari mitra terpercaya. Mulai perjalanan kariermu hari ini.
        </p>

        {{-- Search Bar --}}
        <form action="{{ url('/') }}" method="GET">
            <div class="search-bar">
                <input
                    type="text"
                    name="cari"
                    value="{{ old('cari', request('cari')) }}"
                    placeholder="Cari lowongan, posisi, atau perusahaan..."
                    autocomplete="off"
                >
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;vertical-align:-2px;">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zm-5.242 1.156a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                    </svg>
                    Cari
                </button>
            </div>
        </form>

        {{-- Statistik --}}
        <div class="hero-stats">
            <div class="hero-stat-item">
                <span class="hero-stat-number">{{ $low->total() }}</span>
                <span class="hero-stat-label">Lowongan Tersedia</span>
            </div>
            <div class="hero-stat-item" style="border-left:1px solid rgba(255,255,255,0.25);padding-left:2rem;">
                <span class="hero-stat-number">Gratis</span>
                <span class="hero-stat-label">Tanpa Biaya Pendaftaran</span>
            </div>
        </div>
    </div>
</section>

{{-- ===== LOWONGAN SECTION ===== --}}
<section class="lowongan-section">
    <div class="container">

        {{-- Section Header --}}
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <h2 class="section-title">
                    @if(request('cari'))
                        Hasil Pencarian: "{{ request('cari') }}"
                    @else
                        Lowongan Terbaru
                    @endif
                </h2>
                <p class="section-subtitle mb-0">
                    Menampilkan {{ $low->firstItem() ?? 0 }}–{{ $low->lastItem() ?? 0 }}
                    dari {{ $low->total() }} lowongan
                </p>
            </div>
            @if(request('cari'))
                <a href="{{ url('/') }}" class="btn-dashboard" style="font-size:0.8rem;padding:0.35rem 0.9rem;">
                    &times; Hapus Filter
                </a>
            @endif
        </div>

        {{-- Grid Lowongan --}}
        @if($low->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h5>Tidak ada lowongan yang tersedia</h5>
                <p>
                    @if(request('cari'))
                        Tidak ditemukan lowongan untuk kata kunci "<strong>{{ request('cari') }}</strong>".
                        <a href="{{ url('/') }}">Lihat semua lowongan</a>
                    @else
                        Belum ada lowongan yang dibuka saat ini. Coba lagi nanti.
                    @endif
                </p>
            </div>
        @else
            <div class="row g-4">
                @foreach($low as $item)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-lowongan">

                        {{-- Foto Lowongan --}}
                        <div class="card-img-wrap">
                            @if($item->foto_low)
                                <img
                                    src="{{ asset('images/' . $item->foto_low) }}"
                                    alt="{{ $item->nama_low }}"
                                    loading="lazy"
                                    onerror="this.parentElement.innerHTML='<div class=\'card-img-placeholder\' style=\'background:linear-gradient(135deg,#0EA5E9,#14B8A6);\'>🏢</div>'"
                                >
                            @else
                                @php
                                    $gradients = [
                                        'linear-gradient(135deg,#0EA5E9,#14B8A6)',
                                        'linear-gradient(135deg,#14B8A6,#06B6D4)',
                                        'linear-gradient(135deg,#38BDF8,#2DD4BF)',
                                        'linear-gradient(135deg,#0284C7,#0D9488)',
                                        'linear-gradient(135deg,#0369A1,#0F766E)',
                                    ];
                                    $grad = $gradients[$item->id % count($gradients)];
                                @endphp
                                <div class="card-img-placeholder" style="background:{{ $grad }};">🏢</div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body-low">
                            {{-- Kategori Badge --}}
                            @if($item->kategori)
                                <span class="card-badge">{{ $item->kategori->kategori }}</span>
                            @endif

                            {{-- Nama Lowongan --}}
                            <h3 class="card-title-low">{{ $item->nama_low }}</h3>

                            {{-- Nama Mitra --}}
                            @if($item->mitra)
                                <p class="card-mitra-name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16" style="margin-right:3px;vertical-align:-1px;">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.029 10 8 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                    {{ $item->mitra->nama_mitra }}
                                </p>
                            @endif

                            {{-- Meta Info --}}
                            <div class="card-meta">
                                {{-- Lokasi --}}
                                <div class="card-meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    <span>
                                        {{ $item->lokasi }}
                                        @if($item->mitra && $item->mitra->kabupaten)
                                            &mdash; {{ $item->mitra->kabupaten->nama }}
                                        @endif
                                    </span>
                                </div>

                                {{-- Durasi --}}
                                <div class="card-meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    <span>{{ $item->durasi }} bulan</span>
                                </div>
                            </div>

                            {{-- Kuota Tersisa --}}
                            <div class="card-kuota">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                                {{ $item->jumlah_mhs }} kuota tersisa
                            </div>

                            {{-- Tombol Detail --}}
                            <a href="{{ route('detail.show', $item->id) }}" class="btn-detail">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrap">
                {{ $low->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="footer-simagang">
    <div class="container">
        &copy; {{ date('Y') }} <strong>SIMAGANG</strong> — Sistem Informasi Magang. Hak cipta dilindungi.
    </div>
</footer>

@endsection

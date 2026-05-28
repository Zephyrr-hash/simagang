@extends('layouts.guest')

@section('title', $low->nama_low . ' — SIMAGANG')

@push('styles')
<style>
    /* ===== NAVBAR ===== */
    .navbar-simagang {
        background: #ffffff;
        box-shadow: 0 1px 8px rgba(79, 70, 229, 0.10);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 0.75rem 0;
    }
    .navbar-simagang .brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4F46E5;
        text-decoration: none;
        letter-spacing: -0.5px;
    }
    .navbar-simagang .brand span { color: #7C3AED; }
    .btn-masuk {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff !important;
        border: none;
        border-radius: 8px;
        padding: 0.45rem 1.25rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-masuk:hover { opacity: 0.88; color: #fff; }
    .navbar-user-name {
        font-weight: 600;
        color: #4F46E5;
        font-size: 0.875rem;
    }
    .btn-dashboard {
        background: #EEF2FF;
        color: #4F46E5 !important;
        border: 1.5px solid #C7D2FE;
        border-radius: 8px;
        padding: 0.4rem 1.1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-dashboard:hover { background: #E0E7FF; }
</style>
@endpush

@push('styles')
<style>
    /* ===== HERO ===== */
    .hero-detail {
        position: relative;
        min-height: 340px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        background: linear-gradient(135deg, #4F46E5 0%, #6D28D9 50%, #7C3AED 100%);
    }
    .hero-detail-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: brightness(0.35);
        transition: filter 0.3s;
    }
    .hero-detail-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(79, 70, 229, 0.55) 0%,
            rgba(30, 27, 75, 0.85) 100%
        );
    }
    .hero-detail-content {
        position: relative;
        z-index: 2;
        padding: 3rem 0 2.5rem;
        width: 100%;
    }
    .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,0.18);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.3);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }
    .hero-title-detail {
        font-size: clamp(1.6rem, 4vw, 2.5rem);
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }
    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: rgba(255,255,255,0.85);
        font-size: 0.875rem;
        font-weight: 500;
    }
    .hero-meta-item svg { flex-shrink: 0; opacity: 0.8; }
</style>
@endpush

@push('styles')
<style>
    /* ===== MAIN CONTENT ===== */
    .detail-section {
        background: #F5F3FF;
        padding: 2.5rem 0 4rem;
    }

    /* ===== CARDS ===== */
    .detail-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.07);
        border: 1px solid #E0E7FF;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .detail-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1E1B4B;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #EEF2FF;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .detail-card-title svg { color: #4F46E5; flex-shrink: 0; }
    .deskripsi-text {
        color: #374151;
        font-size: 0.9rem;
        line-height: 1.75;
        white-space: pre-line;
    }
    .kontak-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #F5F3FF;
        border-radius: 8px;
        color: #374151;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .kontak-item svg { color: #4F46E5; flex-shrink: 0; }

    /* ===== TENTANG PERUSAHAAN ===== */
    .company-logo {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #E0E7FF;
        flex-shrink: 0;
    }
    .company-logo-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }
    .company-name {
        font-size: 1rem;
        font-weight: 700;
        color: #1E1B4B;
        margin-bottom: 0.2rem;
    }
    .company-location {
        font-size: 0.85rem;
        color: #6B7280;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
</style>
@endpush

@push('styles')
<style>
    /* ===== STICKY SIDEBAR CARD ===== */
    .sidebar-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.10);
        border: 1px solid #E0E7FF;
        padding: 1.5rem;
        position: sticky;
        top: 80px;
    }
    .sidebar-card-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }
    .kuota-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #ECFDF5;
        color: #059669;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.25rem;
        width: 100%;
        justify-content: center;
    }
    .sidebar-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #F3F4F6;
    }
    .sidebar-info-item:last-of-type { border-bottom: none; }
    .sidebar-info-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #EEF2FF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #4F46E5;
    }
    .sidebar-info-label {
        font-size: 0.75rem;
        color: #9CA3AF;
        font-weight: 500;
        margin-bottom: 0.1rem;
    }
    .sidebar-info-value {
        font-size: 0.875rem;
        color: #1E1B4B;
        font-weight: 600;
        line-height: 1.3;
    }
    .btn-apply {
        display: block;
        width: 100%;
        text-align: center;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: opacity 0.2s, transform 0.15s;
        margin-top: 1.25rem;
        cursor: pointer;
    }
    .btn-apply:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }
    .btn-login-apply {
        display: block;
        width: 100%;
        text-align: center;
        background: #EEF2FF;
        color: #4F46E5 !important;
        border: 1.5px solid #C7D2FE;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: background 0.2s;
        margin-top: 1.25rem;
    }
    .btn-login-apply:hover { background: #E0E7FF; }
    .magang-notice {
        margin-top: 1.25rem;
        padding: 0.75rem 1rem;
        background: #FFF7ED;
        border: 1px solid #FED7AA;
        border-radius: 8px;
        color: #92400E;
        font-size: 0.85rem;
        font-weight: 500;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: #6B7280;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: background 0.15s, color 0.15s;
        margin-top: 1rem;
        width: 100%;
        justify-content: center;
        border: 1px solid #E5E7EB;
    }
    .btn-back:hover { background: #F9FAFB; color: #374151; }

    /* ===== FOOTER ===== */
    .footer-simagang {
        background: #1E1B4B;
        color: rgba(255,255,255,0.65);
        text-align: center;
        padding: 1.5rem 0;
        font-size: 0.85rem;
    }
    .footer-simagang strong { color: #A5B4FC; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .hero-detail { min-height: 260px; }
        .hero-title-detail { font-size: 1.4rem; }
        .sidebar-card { position: static; margin-top: 0; }
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

{{-- ===== HERO / HEADER SECTION ===== --}}
<section class="hero-detail">
    {{-- Background foto lowongan --}}
    @if($low->foto_low)
        <div class="hero-detail-bg"
             style="background-image: url('{{ asset('images/' . $low->foto_low) }}');">
        </div>
    @endif
    <div class="hero-detail-overlay"></div>

    <div class="hero-detail-content">
        <div class="container">
            {{-- Badge Kategori --}}
            @if($low->kategori_id)
                @php
                    $kategori = \App\Models\Kategori::find($low->kategori_id);
                @endphp
                @if($kategori)
                    <span class="hero-badge">{{ $kategori->kategori }}</span>
                @endif
            @endif

            {{-- Judul Lowongan --}}
            <h1 class="hero-title-detail">{{ $low->nama_low }}</h1>

            {{-- Meta Info --}}
            <div class="hero-meta">
                {{-- Nama Mitra --}}
                <div class="hero-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6H2v2.5a.5.5 0 0 0 .5.5H4v2.5a.5.5 0 0 0 .5.5H6v2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V14h1.5a.5.5 0 0 0 .5-.5V11h1.5a.5.5 0 0 0 .5-.5V8.5h1.5a.5.5 0 0 0 .276-.916l-7.5-5z"/>
                    </svg>
                    <span>{{ $low->nama_mitra }}</span>
                </div>

                {{-- Lokasi --}}
                <div class="hero-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                    <span>{{ $low->lokasi }}</span>
                </div>

                {{-- Durasi --}}
                <div class="hero-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                    </svg>
                    <span>{{ $low->durasi }} bulan</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== MAIN CONTENT ===== --}}
<section class="detail-section">
    <div class="container">
        <div class="row g-4">

            {{-- ===== KOLOM KIRI (8/12) ===== --}}
            <div class="col-12 col-lg-8">

                {{-- Card: Deskripsi Lowongan --}}
                <div class="detail-card">
                    <h2 class="detail-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                        </svg>
                        Deskripsi Lowongan
                    </h2>
                    <p class="deskripsi-text">{{ $low->deskripsi_low }}</p>
                </div>

                {{-- Card: Informasi Kontak --}}
                <div class="detail-card">
                    <h2 class="detail-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        Informasi Kontak
                    </h2>
                    <div class="kontak-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        <span>{{ $low->telepon_low }}</span>
                    </div>
                </div>

                {{-- Card: Tentang Perusahaan --}}
                <div class="detail-card">
                    <h2 class="detail-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6H2v2.5a.5.5 0 0 0 .5.5H4v2.5a.5.5 0 0 0 .5.5H6v2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V14h1.5a.5.5 0 0 0 .5-.5V11h1.5a.5.5 0 0 0 .5-.5V8.5h1.5a.5.5 0 0 0 .276-.916l-7.5-5z"/>
                        </svg>
                        Tentang Perusahaan
                    </h2>
                    <div class="d-flex align-items-center gap-3">
                        {{-- Logo / Foto Mitra --}}
                        @if($low->foto_mitra)
                            <img
                                src="{{ asset('images/' . $low->foto_mitra) }}"
                                alt="{{ $low->nama_mitra }}"
                                class="company-logo"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                            >
                            <div class="company-logo-placeholder" style="display:none;">🏢</div>
                        @else
                            <div class="company-logo-placeholder">🏢</div>
                        @endif

                        {{-- Info Mitra --}}
                        <div>
                            <p class="company-name mb-1">{{ $low->nama_mitra }}</p>
                            @if($low->alamat_mitra)
                                <p class="company-location mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    {{ $low->alamat_mitra }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ===== KOLOM KANAN (4/12) — STICKY CARD ===== --}}
            <div class="col-12 col-lg-4">
                <div class="sidebar-card">
                    <p class="sidebar-card-title">Ringkasan Lowongan</p>

                    {{-- Kuota Tersisa --}}
                    <div class="kuota-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                        {{ $low->jumlah_mhs }} Kuota Tersisa
                    </div>

                    {{-- Durasi --}}
                    <div class="sidebar-info-item">
                        <div class="sidebar-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="sidebar-info-label">Durasi Magang</p>
                            <p class="sidebar-info-value">{{ $low->durasi }} Bulan</p>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="sidebar-info-item">
                        <div class="sidebar-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="sidebar-info-label">Lokasi</p>
                            <p class="sidebar-info-value">{{ $low->lokasi }}</p>
                        </div>
                    </div>

                    {{-- Perusahaan --}}
                    <div class="sidebar-info-item">
                        <div class="sidebar-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6H2v2.5a.5.5 0 0 0 .5.5H4v2.5a.5.5 0 0 0 .5.5H6v2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V14h1.5a.5.5 0 0 0 .5-.5V11h1.5a.5.5 0 0 0 .5-.5V8.5h1.5a.5.5 0 0 0 .276-.916l-7.5-5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="sidebar-info-label">Perusahaan</p>
                            <p class="sidebar-info-value">{{ $low->nama_mitra }}</p>
                        </div>
                    </div>

                    {{-- ===== TOMBOL AKSI ===== --}}
                    @if($mhs)
                        @if($mhs->status_id == 2)
                            {{-- Sedang magang --}}
                            <div class="magang-notice">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                </svg>
                                Anda sedang dalam program magang
                            </div>
                        @else
                            {{-- Bisa mendaftar --}}
                            <a href="{{ route('lowongan.apply', $low->id) }}" class="btn-apply">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;vertical-align:-2px;">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                                Daftar Sekarang
                            </a>
                        @endif
                    @else
                        {{-- Belum login --}}
                        <a href="{{ route('login') }}" class="btn-login-apply">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;vertical-align:-2px;">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.029 10 6 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            </svg>
                            Login untuk Mendaftar
                        </a>
                    @endif

                    {{-- Tombol Kembali --}}
                    <a href="{{ url('/') }}" class="btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Kembali ke Daftar Lowongan
                    </a>

                </div>{{-- /sidebar-card --}}
            </div>{{-- /col-lg-4 --}}

        </div>{{-- /row --}}
    </div>{{-- /container --}}
</section>

{{-- ===== FOOTER ===== --}}
<footer class="footer-simagang">
    <div class="container">
        &copy; {{ date('Y') }} <strong>SIMAGANG</strong> — Sistem Informasi Magang. Hak cipta dilindungi.
    </div>
</footer>

@endsection

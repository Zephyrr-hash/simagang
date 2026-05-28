@extends('layouts.guest')

@section('title', 'Konfirmasi Pengajuan Magang — SIMAGANG')

@push('styles')
<style>
    *, *::before, *::after { box-sizing: border-box; }

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
    /* ===== PAGE BACKGROUND ===== */
    .apply-page {
        background: #F5F3FF;
        min-height: calc(100vh - 64px);
        padding: 2.5rem 0 4rem;
    }

    /* ===== ALERT BANNER ===== */
    .alert-banner {
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
        font-size: 0.9rem;
        font-weight: 500;
        border: none;
    }
    .alert-banner.alert-danger-custom {
        background: #FEF2F2;
        color: #991B1B;
        border-left: 4px solid #EF4444;
    }
    .alert-banner.alert-success-custom {
        background: #ECFDF5;
        color: #065F46;
        border-left: 4px solid #10B981;
    }
    .alert-banner .alert-icon { flex-shrink: 0; margin-top: 1px; }
    .alert-banner a { color: inherit; font-weight: 700; text-decoration: underline; }
    .alert-banner a:hover { opacity: 0.8; }

    /* ===== MAIN CARD ===== */
    .confirm-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(79, 70, 229, 0.10);
        border: 1px solid #E0E7FF;
        overflow: hidden;
    }
    .confirm-card-header {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        padding: 1.5rem 2rem;
        color: #fff;
    }
    .confirm-card-header h1 {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }
    .confirm-card-header p {
        font-size: 0.85rem;
        opacity: 0.85;
        margin: 0;
    }
    .confirm-card-body { padding: 2rem; }
</style>
@endpush

@push('styles')
<style>
    /* ===== SECTION LABELS ===== */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6B7280;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #E0E7FF;
    }

    /* ===== PROFILE SECTION ===== */
    .profile-section {
        background: #F8F7FF;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #E0E7FF;
        height: 100%;
    }
    .profile-avatar-wrap {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #E0E7FF;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #C7D2FE;
        flex-shrink: 0;
    }
    .profile-avatar-initials {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 700;
        flex-shrink: 0;
        border: 3px solid #C7D2FE;
    }
    .profile-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1E1B4B;
        margin: 0 0 0.2rem;
        line-height: 1.3;
    }
    .profile-nim {
        font-size: 0.8rem;
        color: #6B7280;
        margin: 0;
        font-weight: 500;
    }

    /* ===== INFO ROWS ===== */
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.875rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-icon {
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
    .info-row-content { flex: 1; min-width: 0; }
    .info-row-label {
        font-size: 0.72rem;
        color: #9CA3AF;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 0.1rem;
    }
    .info-row-value {
        color: #1F2937;
        font-weight: 500;
        word-break: break-word;
    }
</style>
@endpush

@push('styles')
<style>
    /* ===== SKILL BADGES ===== */
    .skill-badges { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.4rem; }
    .skill-badge {
        background: #EEF2FF;
        color: #4338CA;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        border: 1px solid #C7D2FE;
    }
    .skill-badge-empty {
        color: #9CA3AF;
        font-size: 0.8rem;
        font-style: italic;
    }

    /* ===== LOWONGAN SECTION ===== */
    .lowongan-section {
        background: #F8F7FF;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #E0E7FF;
        height: 100%;
    }
    .lowongan-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1E1B4B;
        margin: 0 0 0.35rem;
        line-height: 1.3;
    }
    .lowongan-mitra {
        font-size: 0.875rem;
        color: #4F46E5;
        font-weight: 600;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #E0E7FF;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* ===== DIVIDER ===== */
    .section-divider {
        border: none;
        border-top: 1px solid #E0E7FF;
        margin: 1.75rem 0;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-bar {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding-top: 1.75rem;
        border-top: 1px solid #E0E7FF;
        margin-top: 1.75rem;
    }
    .btn-ajukan {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 0.7rem 2rem;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Inter', sans-serif;
    }
    .btn-ajukan:hover:not(:disabled) { opacity: 0.88; transform: translateY(-1px); }
    .btn-ajukan:disabled {
        background: #D1D5DB;
        cursor: not-allowed;
        opacity: 1;
        transform: none;
    }
    .btn-batal {
        background: #fff;
        color: #6B7280 !important;
        border: 1.5px solid #D1D5DB;
        border-radius: 10px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Inter', sans-serif;
    }
    .btn-batal:hover { background: #F9FAFB; border-color: #9CA3AF; color: #374151 !important; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .confirm-card-body { padding: 1.25rem; }
        .action-bar { flex-direction: column; align-items: stretch; }
        .btn-ajukan, .btn-batal { justify-content: center; }
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
                <a href="{{ route('login') }}" class="btn-dashboard">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ===== MAIN PAGE ===== --}}
<div class="apply-page">
    <div class="container" style="max-width: 800px;">

        {{-- ===== ALERT BANNER ===== --}}
        @if ($button == 'disabled')
            <div class="alert-banner alert-danger-custom" role="alert">
                <span class="alert-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </span>
                <div>
                    <strong>Profil belum lengkap.</strong>
                    Silakan <a href="{{ route('profile.index') }}">lengkapi profil</a> terlebih dahulu sebelum mendaftar.
                    Data yang harus diisi: NIM, telepon, pengalaman, jurusan, jenis kelamin, tanggal lahir, dan foto profil.
                </div>
            </div>
        @else
            <div class="alert-banner alert-success-custom" role="alert">
                <span class="alert-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </span>
                <div>
                    <strong>Profil Anda sudah lengkap.</strong>
                    Silakan lanjutkan pengajuan magang di bawah ini.
                </div>
            </div>
        @endif

        {{-- ===== CONFIRM CARD ===== --}}
        <div class="confirm-card">

            {{-- Card Header --}}
            <div class="confirm-card-header">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-right:8px;vertical-align:-3px;">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    Konfirmasi Pengajuan Magang
                </h1>
                <p>Periksa kembali data Anda sebelum mengajukan pendaftaran.</p>
            </div>

            {{-- Card Body --}}
            <div class="confirm-card-body">
                <div class="row g-4">

                    {{-- ===== KOLOM KIRI: INFO MAHASISWA ===== --}}
                    <div class="col-12 col-md-6">
                        <p class="section-label">Data Mahasiswa</p>
                        <div class="profile-section">

                            {{-- Avatar + Nama --}}
                            <div class="profile-avatar-wrap">
                                @if ($mhsId->foto_mhs)
                                    <img
                                        src="{{ asset('images/' . $mhsId->foto_mhs) }}"
                                        alt="Foto {{ $mhsId->nama_mhs }}"
                                        class="profile-avatar"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="profile-avatar-initials" style="display:none;">
                                        {{ strtoupper(substr($mhsId->nama_mhs, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="profile-avatar-initials">
                                        {{ strtoupper(substr($mhsId->nama_mhs ?? 'M', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="profile-name">{{ $mhsId->nama_mhs }}</p>
                                    <p class="profile-nim">NIM: {{ $mhsId->NIM ?? '—' }}</p>
                                </div>
                            </div>

                            {{-- Telepon --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Telepon</div>
                                    <div class="info-row-value">{{ $mhsId->telepon_mhs ?? '—' }}</div>
                                </div>
                            </div>

                            {{-- Jurusan --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5z"/>
                                        <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Jurusan</div>
                                    <div class="info-row-value">
                                        {{ $mhsId->jurusan ? $mhsId->jurusan->jurusan : '—' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.029 10 8 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Jenis Kelamin</div>
                                    <div class="info-row-value">{{ $mhsId->jenis_kelamin ?? '—' }}</div>
                                </div>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Tanggal Lahir</div>
                                    <div class="info-row-value">
                                        @if ($mhsId->tgl_lahir)
                                            {{ \Carbon\Carbon::parse($mhsId->tgl_lahir)->translatedFormat('d F Y') }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Pengalaman --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M6 1a1 1 0 0 0-1 1v1H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3V2a1 1 0 0 0-1-1H6zm0 1h4v1H6V2zm-1 5a1 1 0 1 1 2 0 1 1 0 0 1-2 0zm3 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0zm3 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Pengalaman</div>
                                    <div class="info-row-value">{{ $mhsId->pengalaman ?? '—' }}</div>
                                </div>
                            </div>

                            {{-- Skill --}}
                            <div class="info-row" style="border-bottom:none;">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Skill</div>
                                    @if ($skill->count() > 0)
                                        <div class="skill-badges">
                                            @foreach ($skill as $s)
                                                <span class="skill-badge">{{ $s->skill }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="skill-badge-empty">Belum ada skill ditambahkan</span>
                                    @endif
                                </div>
                            </div>

                        </div>{{-- end profile-section --}}
                    </div>{{-- end col kiri --}}

                    {{-- ===== KOLOM KANAN: INFO LOWONGAN ===== --}}
                    <div class="col-12 col-md-6">
                        <p class="section-label">Lowongan Dipilih</p>
                        <div class="lowongan-section">

                            {{-- Nama & Mitra --}}
                            <h2 class="lowongan-title">{{ $low->nama_low }}</h2>
                            <div class="lowongan-mitra">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                </svg>
                                {{ $low->mitra ? $low->mitra->nama_mitra : '—' }}
                            </div>

                            {{-- Durasi --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Durasi</div>
                                    <div class="info-row-value">{{ $low->durasi }} bulan</div>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Lokasi</div>
                                    <div class="info-row-value">{{ $low->lokasi ?? '—' }}</div>
                                </div>
                            </div>

                            {{-- Kategori --}}
                            @if ($low->kategori)
                            <div class="info-row">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Kategori</div>
                                    <div class="info-row-value">{{ $low->kategori->kategori }}</div>
                                </div>
                            </div>
                            @endif

                            {{-- Kuota --}}
                            <div class="info-row" style="border-bottom:none;">
                                <div class="info-row-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                    </svg>
                                </div>
                                <div class="info-row-content">
                                    <div class="info-row-label">Kuota Tersisa</div>
                                    <div class="info-row-value">
                                        <span style="color:#059669;font-weight:700;">{{ $low->jumlah_mhs }}</span> mahasiswa
                                    </div>
                                </div>
                            </div>

                        </div>{{-- end lowongan-section --}}
                    </div>{{-- end col kanan --}}

                </div>{{-- end row --}}

                {{-- ===== FORM SUBMIT ===== --}}
                <form action="{{ route('apply.store') }}" method="POST" id="apply-form">
                    @csrf
                    <input type="hidden" name="mhs_id" value="{{ $mhsId->id }}">
                    <input type="hidden" name="lowongan_id" value="{{ $low->id }}">

                    <div class="action-bar">
                        <button
                            type="submit"
                            class="btn-ajukan"
                            {{ $button == 'disabled' ? 'disabled' : '' }}
                            @if ($button != 'disabled')
                                onclick="return confirm('Yakin ingin mengajukan lamaran untuk lowongan ini?')"
                            @endif
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                            </svg>
                            Ajukan Sekarang
                        </button>

                        <a href="javascript:history.back()" class="btn-batal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Batal
                        </a>

                        @if ($button == 'disabled')
                            <span style="font-size:0.8rem;color:#9CA3AF;margin-left:auto;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16" style="margin-right:3px;vertical-align:-1px;">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                                Lengkapi profil untuk mengaktifkan tombol ini
                            </span>
                        @endif
                    </div>
                </form>

            </div>{{-- end confirm-card-body --}}
        </div>{{-- end confirm-card --}}

    </div>{{-- end container --}}
</div>{{-- end apply-page --}}

{{-- ===== FOOTER ===== --}}
<footer style="background:#1E1B4B;color:rgba(255,255,255,0.65);text-align:center;padding:1.25rem 0;font-size:0.85rem;">
    <div class="container">
        &copy; {{ date('Y') }} <strong style="color:#A5B4FC;">SIMAGANG</strong> — Sistem Informasi Magang. Hak cipta dilindungi.
    </div>
</footer>

@endsection

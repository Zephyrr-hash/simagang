@extends('layouts.app')

@section('title', 'Dashboard — Mahasiswa')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .page-header { margin-bottom: 1.75rem; }
    .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1E1B4B; margin: 0 0 0.25rem; }
    .page-header p  { color: #6B7280; font-size: 0.9rem; margin: 0; }

    /* Status Banner */
    .status-banner {
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.75rem;
        border: 1px solid transparent;
        width: 100%;
    }
    .status-banner.status-1 { background: #EFF6FF; border-color: #BFDBFE; color: #1E40AF; }
    .status-banner.status-2 { background: #ECFDF5; border-color: #A7F3D0; color: #065F46; }
    .status-banner.status-3 { background: #F5F3FF; border-color: #DDD6FE; color: #4C1D95; }
    .status-banner.status-4 { background: #FFFBEB; border-color: #FDE68A; color: #92400E; }
    .status-banner-icon { flex-shrink: 0; margin-top: 1px; }
    .status-banner-icon svg { width: 22px; height: 22px; }
    .status-banner-title { font-size: 0.95rem; font-weight: 700; margin: 0 0 0.25rem; }
    .status-banner-desc  { font-size: 0.85rem; margin: 0; opacity: 0.85; }
    .status-banner-action {
        display: inline-flex; align-items: center; gap: 0.4rem;
        margin-top: 0.75rem; font-size: 0.85rem; font-weight: 600;
        text-decoration: none; padding: 0.4rem 1rem;
        border-radius: 8px; border: 1.5px solid currentColor;
        transition: opacity 0.2s;
    }
    .status-banner-action:hover { opacity: 0.75; }

    /* Stats Grid — Full Width */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.75rem;
        width: 100%;
    }
    @media (max-width: 767px) { .stats-grid { grid-template-columns: 1fr; gap: 1rem; } }

    /* Profile incomplete warning */
    .profile-warning {
        background: #FEF3C7;
        border: 1px solid #FDE68A;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: #92400E;
        margin-bottom: 1.75rem;
        width: 100%;
    }
    .profile-warning a { color: #92400E; font-weight: 700; }
    .profile-warning svg { flex-shrink: 0; width: 20px; height: 20px; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Selamat datang, {{ $authProfile['nama'] }} 👋</h1>
    <p>
        @if($mhsId && $mhsId->status)
            Status: <strong>{{ $mhsId->status->status }}</strong>
        @else
            Mahasiswa SIMAGANG
        @endif
    </p>
</div>

{{-- Peringatan profil belum lengkap --}}
@if($mhsId && (!$mhsId->NIM || !$mhsId->telepon_mhs || !$mhsId->foto_mhs || !$mhsId->jurusan_id))
<div class="profile-warning">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
    </svg>
    <span>Profil Anda belum lengkap. <a href="{{ route('profile.index') }}">Lengkapi profil</a> agar bisa mendaftar lowongan.</span>
</div>
@endif

{{-- Status Banner --}}
@php $statusId = $mhsId?->status_id ?? 1; @endphp

<div class="status-banner status-{{ $statusId }}">
    <div class="status-banner-icon">
        @if($statusId == 1)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
        @elseif($statusId == 2)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        @elseif($statusId == 3)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        @endif
    </div>
    <div>
        @if($statusId == 1)
            <p class="status-banner-title">Anda belum mendaftar magang</p>
            <p class="status-banner-desc">Temukan lowongan magang yang sesuai dan mulai perjalanan karier Anda.</p>
            <a href="{{ url('/') }}" class="status-banner-action">Cari Lowongan →</a>
        @elseif($statusId == 2)
            <p class="status-banner-title">Anda sedang dalam program magang</p>
            <p class="status-banner-desc">Jangan lupa isi logbook harian dan ajukan laporan bimbingan secara rutin.</p>
            <a href="{{ route('project.index') }}" class="status-banner-action">Lihat Project →</a>
        @elseif($statusId == 3)
            <p class="status-banner-title">Selamat! Anda telah menyelesaikan program magang 🎉</p>
            <p class="status-banner-desc">Terima kasih atas dedikasi Anda selama program magang berlangsung.</p>
        @else
            <p class="status-banner-title">Pengajuan Anda sedang diproses</p>
            <p class="status-banner-desc">Mohon tunggu konfirmasi dari mitra. Anda akan dihubungi segera.</p>
            <a href="{{ route('lowongan.diajukan') }}" class="status-banner-action">Lihat Pengajuan →</a>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <x-stat-card
        title="Pengajuan Saya"
        :value="$ajukan"
        color="indigo"
        description="Total pengajuan"
        icon="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
        link="{{ route('lowongan.diajukan') }}"
    />
    @if($statusId == 2 || $statusId == 3)
    <x-stat-card
        title="Project Magang"
        :value="$log"
        color="emerald"
        description="Logbook & bimbingan"
        icon="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"
        link="{{ route('project.index') }}"
    />
    <x-stat-card
        title="Laporan Bimbingan"
        :value="$bim"
        color="violet"
        description="Total laporan"
        icon="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
        link="{{ route('project.index') }}"
    />
    @endif
</div>

@endsection

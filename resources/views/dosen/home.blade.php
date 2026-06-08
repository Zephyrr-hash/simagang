@extends('layouts.app')

@section('title', 'Dashboard — Dosen Pembimbing')

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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
        width: 100%;
    }
    @media (max-width: 575px) { .stats-grid { grid-template-columns: 1fr; } }

    .info-card {
        background: #fff;
        border: 1px solid #E0E7FF;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.75rem;
    }
    .info-card h2 { font-size: 1rem; font-weight: 700; color: #1E1B4B; margin-bottom: 1rem; }
    .info-list { list-style: none; padding: 0; margin: 0; }
    .info-list li {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.6rem 0; border-bottom: 1px solid #F3F4F6; font-size: 0.875rem; color: #374151;
    }
    .info-list li:last-child { border-bottom: none; }
    .info-list li svg { flex-shrink: 0; color: #4F46E5; margin-top: 1px; }

    .btn-primary-action {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff; border: none; border-radius: 10px;
        padding: 0.7rem 1.5rem; font-weight: 600; font-size: 0.9rem;
        text-decoration: none; transition: opacity 0.2s;
        margin-top: 1.25rem;
    }
    .btn-primary-action:hover { opacity: 0.88; color: #fff; }
    .btn-primary-action svg { width: 18px; height: 18px; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Selamat datang, {{ $authProfile['nama'] }} 👋</h1>
    <p>Dosen Pembimbing — pantau progress bimbingan mahasiswa Anda.</p>
</div>

<div class="stats-grid">
    <x-stat-card
        title="Mahasiswa Bimbingan"
        :value="$mhsBim"
        color="indigo"
        description="Aktif saat ini"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
        link="{{ route('project.index') }}"
    />
    <x-stat-card
        title="Feedback Pending"
        :value="$feedback"
        color="amber"
        description="Belum dibalas"
        icon="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
        link="{{ route('project.index') }}"
    />
</div>

<a href="{{ route('project.index') }}" class="btn-primary-action">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
    </svg>
    Lihat Semua Bimbingan
</a>

<div class="info-card">
    <h2>Panduan Tugas Dosen Pembimbing</h2>
    <ul class="info-list">
        <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Pantau progress bimbingan mahasiswa yang ditugaskan kepada Anda.
        </li>
        <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Berikan feedback atas setiap laporan bimbingan yang diajukan mahasiswa.
        </li>
        <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Pastikan mahasiswa mengisi logbook harian secara rutin.
        </li>
    </ul>
</div>

@endsection

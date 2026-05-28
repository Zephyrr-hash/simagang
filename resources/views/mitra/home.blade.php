@extends('layouts.app')

@section('title', 'Dashboard — Mitra')

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
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    @media (max-width: 991px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .stats-grid { grid-template-columns: 1fr; } }

    .quick-actions h2 { font-size: 1rem; font-weight: 700; color: #1E1B4B; margin-bottom: 1rem; }
    .action-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media (max-width: 767px) { .action-grid { grid-template-columns: 1fr; } }

    .action-card {
        background: #fff;
        border: 1.5px solid #E0E7FF;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        text-decoration: none;
        color: #1E1B4B;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .action-card:hover {
        border-color: #4F46E5;
        box-shadow: 0 4px 16px rgba(79,70,229,0.12);
        transform: translateY(-2px);
        color: #1E1B4B;
        text-decoration: none;
    }
    .action-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; color: #fff;
    }
    .action-icon svg { width: 22px; height: 22px; }
    .action-title { font-size: 0.9rem; font-weight: 600; margin: 0 0 0.15rem; }
    .action-desc  { font-size: 0.78rem; color: #6B7280; margin: 0; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Selamat datang, {{ $authProfile['nama'] }} 👋</h1>
    <p>Kelola lowongan dan pantau mahasiswa magang Anda.</p>
</div>

<div class="stats-grid">
    <x-stat-card
        title="Pendaftar Baru"
        :value="$count"
        color="amber"
        description="Menunggu review"
        icon="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
        link="{{ route('pendaftar.index') }}"
    />
    <x-stat-card
        title="Total Lowongan"
        :value="$low"
        color="indigo"
        description="Lowongan Anda"
        icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
        link="{{ route('lowongan.index') }}"
    />
    <x-stat-card
        title="Mahasiswa Magang"
        :value="$mag"
        color="emerald"
        description="Aktif saat ini"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
        link="{{ route('magang.index') }}"
    />
    <x-stat-card
        title="Lowongan Penuh"
        :value="$full"
        color="red"
        description="Kuota habis"
        icon="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"
    />
</div>

<div class="quick-actions">
    <h2>Aksi Cepat</h2>
    <div class="action-grid">
        <a href="{{ route('lowongan.create') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <div>
                <p class="action-title">Buat Lowongan Baru</p>
                <p class="action-desc">Posting lowongan magang baru</p>
            </div>
        </a>
        <a href="{{ route('pendaftar.index') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#D97706,#F59E0B);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div>
                <p class="action-title">Lihat Pendaftar</p>
                <p class="action-desc">Review dan approve pendaftar</p>
            </div>
        </a>
        <a href="{{ route('magang.index') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#059669,#10B981);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
            </div>
            <div>
                <p class="action-title">Mahasiswa Magang</p>
                <p class="action-desc">Pantau mahasiswa aktif</p>
            </div>
        </a>
    </div>
</div>

@endsection

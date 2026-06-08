@extends('layouts.app')

@section('title', 'Dashboard — Supervisor')

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

    .action-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        width: 100%;
    }
    @media (max-width: 575px) { .action-grid { grid-template-columns: 1fr; } }

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
    .quick-actions h2 { font-size: 1rem; font-weight: 700; color: #1E1B4B; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Selamat datang, {{ $authProfile['nama'] }} 👋</h1>
    <p>Supervisor — pantau logbook dan berikan penilaian mahasiswa magang.</p>
</div>

<div class="stats-grid">
    <x-stat-card
        title="Mahasiswa Aktif"
        :value="$mhsLogbook"
        color="indigo"
        description="Aktif saat ini"
        icon="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"
        link="{{ route('project.index') }}"
    />
    <x-stat-card
        title="Penilaian Pending"
        :value="$nilai"
        color="amber"
        description="Belum dinilai"
        icon="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
        link="{{ route('spv.penilaian') }}"
    />
</div>

<div class="quick-actions">
    <h2>Aksi Cepat</h2>
    <div class="action-grid">
        <a href="{{ route('project.index') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
            </div>
            <div>
                <p class="action-title">Project Mahasiswa</p>
                <p class="action-desc">Kelola project, logbook, dan bimbingan</p>
            </div>
        </a>
        <a href="{{ route('project.create') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#059669,#10B981);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <div>
                <p class="action-title">Buat Project Baru</p>
                <p class="action-desc">Tambahkan project untuk mahasiswa</p>
            </div>
        </a>
        <a href="{{ route('spv.penilaian') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#D97706,#F59E0B);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
            </div>
            <div>
                <p class="action-title">Penilaian</p>
                <p class="action-desc">Beri nilai mahasiswa selesai magang</p>
            </div>
        </a>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('title', 'Dashboard — Departemen')

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

    .quick-actions { margin-top: 1.75rem; }
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
        flex-shrink: 0;
        color: #fff;
    }
    .action-icon svg { width: 22px; height: 22px; }
    .action-title { font-size: 0.9rem; font-weight: 600; margin: 0 0 0.15rem; }
    .action-desc  { font-size: 0.78rem; color: #6B7280; margin: 0; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1>Selamat datang, {{ $authProfile['nama'] }} 👋</h1>
    <p>Berikut ringkasan data sistem SIMAGANG hari ini.</p>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <x-stat-card
        title="Total User"
        :value="$user"
        color="indigo"
        description="Semua role"
        icon="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
        link="{{ route('users.index') }}"
    />
    <x-stat-card
        title="Total Mitra"
        :value="$mitra"
        color="violet"
        description="Perusahaan mitra"
        icon="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"
    />
    <x-stat-card
        title="Total Dosen"
        :value="$dosen"
        color="blue"
        description="Dosen pembimbing"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
    />
    <x-stat-card
        title="Total Supervisor"
        :value="$spv"
        color="emerald"
        description="Supervisor lapangan"
        icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
    />
    <x-stat-card
        title="Total Mahasiswa"
        :value="$mhs"
        color="amber"
        description="Terdaftar di sistem"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
        link="{{ route('depart.mhs') }}"
    />
    <x-stat-card
        title="Sedang Magang"
        :value="$mhsMag"
        color="emerald"
        description="Status aktif"
    />
    <x-stat-card
        title="Belum Magang"
        :value="$blmMag"
        color="red"
        description="Belum mendaftar"
    />
    <x-stat-card
        title="Pengajuan Pending"
        :value="$count"
        color="amber"
        description="Belum ada dosen"
        icon="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
        link="{{ route('pengajuan.index') }}"
    />
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <h2>Aksi Cepat</h2>
    <div class="action-grid">
        <a href="{{ route('users.index') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div>
                <p class="action-title">Kelola User</p>
                <p class="action-desc">Tambah, edit, hapus akun pengguna</p>
            </div>
        </a>
        <a href="{{ route('depart.mhs') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#7C3AED,#8B5CF6);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
            </div>
            <div>
                <p class="action-title">Data Mahasiswa</p>
                <p class="action-desc">Lihat status magang mahasiswa</p>
            </div>
        </a>
        <a href="{{ route('pengajuan.index') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg,#D97706,#F59E0B);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>
            <div>
                <p class="action-title">Pengajuan Dospem</p>
                <p class="action-desc">Tugaskan dosen pembimbing</p>
            </div>
        </a>
    </div>
</div>

@endsection

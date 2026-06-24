@extends('layouts.app')

@section('title', 'Dashboard — Superadmin')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    @media (max-width: 991px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .stats-grid { grid-template-columns: 1fr; } }

    .sa-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: linear-gradient(135deg, #7C3AED, #0EA5E9);
        color: #fff;
        font-size: .75rem;
        font-weight: 700;
        padding: .25rem .75rem;
        border-radius: 20px;
        letter-spacing: .4px;
        margin-bottom: 1rem;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media (max-width: 767px) { .quick-grid { grid-template-columns: 1fr; } }

    .quick-card {
        background:#fff;
        border:1.5px solid #E0E7FF;
        border-radius:12px;
        padding:1.25rem 1.5rem;
        display:flex;
        align-items:center;
        gap:1rem;
        text-decoration:none;
        color:#1E293B;
        transition: border-color .2s, box-shadow .2s, transform .15s;
    }
    .quick-card:hover {
        border-color: #0EA5E9;
        box-shadow: 0 4px 16px rgba(14,165,233,.12);
        transform: translateY(-2px);
        text-decoration:none;
        color:#1E293B;
    }
    .quick-icon {
        width:44px;height:44px;border-radius:10px;
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;color:#fff;
    }
    .quick-icon svg { width:22px;height:22px; }
    .quick-title { font-size:.9rem;font-weight:600;margin:0 0 .15rem; }
    .quick-desc  { font-size:.78rem;color:#6B7280;margin:0; }

    .recent-table { width:100%; }
    .recent-table th { font-size:.75rem;font-weight:600;color:#6B7280;text-transform:uppercase;padding:.5rem .75rem;border-bottom:2px solid #F1F5F9; }
    .recent-table td { font-size:.875rem;padding:.65rem .75rem;border-bottom:1px solid #F1F5F9;vertical-align:middle; }
    .recent-table tr:last-child td { border-bottom:none; }
    .role-badge { display:inline-block;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:600; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <span class="sa-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
            </svg>
            Superadmin
        </span>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0F172A;margin:0 0 .25rem;">
            Selamat datang, {{ $authProfile['nama'] }} 👋
        </h1>
        <p style="color:#64748B;font-size:.9rem;margin:0;">Anda memiliki akses penuh ke seluruh sistem SIMAGANG.</p>
    </div>
    <a href="{{ route('superadmin.users.create') }}"
       style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0EA5E9,#0284C7);color:#fff;border-radius:10px;padding:.6rem 1.25rem;font-size:.875rem;font-weight:600;text-decoration:none;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah User
    </a>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <x-stat-card title="Total User"      :value="$stats['total_user']"       color="indigo" description="Semua role" link="{{ route('superadmin.users.index') }}"
        icon="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
    <x-stat-card title="Departemen"      :value="$stats['total_departemen']"  color="blue"   description="Admin departemen"
        icon="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
    <x-stat-card title="Mitra"           :value="$stats['total_mitra']"       color="violet" description="Perusahaan mitra"
        icon="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
    <x-stat-card title="Dosen Pembimbing" :value="$stats['total_dosen']"      color="sky"    description="Dosen pembimbing"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493" />
    <x-stat-card title="Supervisor"      :value="$stats['total_spv']"         color="teal"   description="Supervisor lapangan"
        icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75" />
    <x-stat-card title="Mahasiswa"       :value="$stats['total_mahasiswa']"   color="amber"  description="Total mahasiswa"
        icon="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904" />
    <x-stat-card title="Sedang Magang"   :value="$stats['magang_aktif']"      color="emerald" description="Status aktif"
        icon="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    <x-stat-card title="Pengajuan Pending" :value="$stats['pengajuan_pending']" color="red"  description="Belum ada dosen"
        icon="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192" />
</div>

<div class="row g-4">
    {{-- Recent Users --}}
    <div class="col-12 col-lg-8">
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:1.5rem;">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">User Terbaru</h2>
                <a href="{{ route('superadmin.users.index') }}" style="font-size:.8rem;color:#0EA5E9;text-decoration:none;font-weight:600;">
                    Lihat semua →
                </a>
            </div>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $u)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $u->name }}</div>
                        </td>
                        <td style="color:#64748B;">{{ $u->email }}</td>
                        <td>
                            @php
                                $roleColors = [1=>'#EDE9FE,#7C3AED',2=>'#ECFDF5,#059669',3=>'#EFF6FF,#2563EB',4=>'#F0FDF4,#16A34A',5=>'#FEF3C7,#D97706'];
                                [$bg,$fg] = explode(',', $roleColors[$u->role_id] ?? '#F1F5F9,#64748B');
                            @endphp
                            <span class="role-badge" style="background:{{ $bg }};color:{{ $fg }};">
                                {{ $u->role->role ?? '-' }}
                            </span>
                        </td>
                        <td style="color:#64748B;font-size:.8rem;">{{ $u->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#94A3B8;padding:2rem;">Belum ada user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-12 col-lg-4">
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:1.5rem;">
            <h2 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0 0 1rem;">Aksi Cepat</h2>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('superadmin.users.create') }}" class="quick-card">
                    <div class="quick-icon" style="background:linear-gradient(135deg,#0EA5E9,#0284C7);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg>
                    </div>
                    <div>
                        <p class="quick-title">Tambah User</p>
                        <p class="quick-desc">Buat akun pengguna baru</p>
                    </div>
                </a>
                <a href="{{ route('superadmin.users.index') }}" class="quick-card">
                    <div class="quick-icon" style="background:linear-gradient(135deg,#7C3AED,#8B5CF6);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                    </div>
                    <div>
                        <p class="quick-title">Kelola User</p>
                        <p class="quick-desc">Lihat & manage semua user</p>
                    </div>
                </a>
                <a href="{{ route('superadmin.activity-logs.index') }}" class="quick-card">
                    <div class="quick-icon" style="background:linear-gradient(135deg,#0F172A,#334155);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" /></svg>
                    </div>
                    <div>
                        <p class="quick-title">Log Aktivitas</p>
                        <p class="quick-desc">Monitor semua aktivitas</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

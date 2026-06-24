@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem — Superadmin')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('superadmin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Log Aktivitas</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .page-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem; }
    .page-header h1 { font-size:1.4rem;font-weight:700;color:#0F172A;margin:0; }
    .stats-row { display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.25rem; }
    @media (max-width:767px) { .stats-row { grid-template-columns:repeat(2,1fr); } }
    .stat-mini { background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:1rem 1.25rem; }
    .stat-mini-label { font-size:.72rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem; }
    .stat-mini-value { font-size:1.5rem;font-weight:700;color:#0F172A; }
    .filter-card { background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:1.25rem;margin-bottom:1rem; }
    .table-card { background:#fff;border:1px solid #E2E8F0;border-radius:12px;overflow:hidden; }
    table { width:100%;border-collapse:collapse; }
    thead tr { background:#0F172A; }
    thead th { padding:.75rem 1rem;text-align:left;font-size:.72rem;font-weight:600;color:#fff;text-transform:uppercase;letter-spacing:.5px;white-space:nowrap; }
    tbody tr { border-bottom:1px solid #F1F5F9;transition:background .15s; }
    tbody tr:hover { background:#F0F9FF; }
    tbody td { padding:.75rem 1rem;font-size:.85rem;color:#334155;vertical-align:middle; }
    .action-badge { display:inline-block;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:600; }
    .action-login   { background:#ECFDF5;color:#059669; }
    .action-logout  { background:#FEF3C7;color:#D97706; }
    .action-create  { background:#DBEAFE;color:#2563EB; }
    .action-update  { background:#EDE9FE;color:#7C3AED; }
    .action-delete  { background:#FEF2F2;color:#EF4444; }
    .btn-detail { display:inline-flex;align-items:center;gap:.3rem;background:#EFF6FF;color:#2563EB;border:none;border-radius:7px;padding:.3rem .65rem;font-size:.75rem;font-weight:600;text-decoration:none; }
    .btn-detail:hover { background:#DBEAFE;color:#2563EB; }
    .empty-state { text-align:center;padding:3rem;color:#94A3B8; }
    .pagination-wrap { padding:1rem 1.25rem;border-top:1px solid #F1F5F9; }
    .pagination-wrap .pagination { margin:0; }
    .pagination-wrap .page-link { border-radius:8px!important;border:1.5px solid #E2E8F0;color:#0EA5E9;font-weight:500;font-size:.8rem;padding:.35rem .65rem; }
    .pagination-wrap .page-item.active .page-link { background:#0EA5E9;border-color:#0EA5E9;color:#fff; }
    .btn-export { display:inline-flex;align-items:center;gap:.4rem;background:#fff;color:#0F172A;border:1.5px solid #E2E8F0;border-radius:8px;padding:.45rem 1rem;font-size:.8rem;font-weight:600;text-decoration:none; }
    .btn-export:hover { background:#F8FAFC;color:#0F172A; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1>Log Aktivitas Sistem</h1>
        <p style="font-size:.85rem;color:#64748B;margin:.25rem 0 0;">Monitor semua aktivitas pengguna di seluruh sistem.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('superadmin.activity-logs.export', request()->query()) }}" class="btn-export">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export CSV
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-label">Total Log</div>
        <div class="stat-mini-value">{{ number_format($stats['total']) }}</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-label">Hari Ini</div>
        <div class="stat-mini-value">{{ number_format($stats['today']) }}</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-label">Minggu Ini</div>
        <div class="stat-mini-value">{{ number_format($stats['this_week']) }}</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-label">Bulan Ini</div>
        <div class="stat-mini-value">{{ number_format($stats['this_month']) }}</div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-card">
    <form action="{{ route('superadmin.activity-logs.index') }}" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Deskripsi, aksi, modul..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Aksi</label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $a)
                    <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Modul</label>
                <select name="module" class="form-select form-select-sm">
                    <option value="">Semua Modul</option>
                    @foreach($modules as $m)
                    <option value="{{ $m }}" {{ request('module') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">User</label>
                <select name="user_id" class="form-select form-select-sm">
                    <option value="">Semua User</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Dari</label>
                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-1">
                <label style="font-size:.75rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Sampai</label>
                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary" style="background:#0EA5E9;border-color:#0EA5E9;">Cari</button>
                @if(request()->hasAny(['search','action','module','user_id','start_date','end_date']))
                <a href="{{ route('superadmin.activity-logs.index') }}" class="btn btn-sm btn-outline-secondary">×</a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Aksi</th>
                    <th>Modul</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td style="color:#94A3B8;font-size:.75rem;">{{ $logs->firstItem() + $i }}</td>
                    <td style="white-space:nowrap;font-size:.78rem;color:#64748B;">
                        {{ $log->created_at->format('d/m/y H:i') }}
                    </td>
                    <td style="font-weight:600;">{{ $log->user?->name ?? 'System' }}</td>
                    <td style="font-size:.75rem;color:#64748B;">{{ $log->role ?? '-' }}</td>
                    <td>
                        <span class="action-badge action-{{ strtolower($log->action) }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td style="font-size:.8rem;">{{ $log->module }}</td>
                    <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $log->description }}">
                        {{ $log->description }}
                    </td>
                    <td style="font-size:.75rem;color:#94A3B8;">{{ $log->ip_address ?? '-' }}</td>
                    <td>
                        <a href="{{ route('superadmin.activity-logs.show', $log->id) }}" class="btn-detail">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <p>Belum ada log aktivitas.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="pagination-wrap">{{ $logs->links() }}</div>
    @endif
</div>

@endsection

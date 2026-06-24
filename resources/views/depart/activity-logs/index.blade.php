@extends('layouts.app')

@section('title', 'Log Aktivitas — SIMAGANG')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Log Aktivitas</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s;
    }
    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.08);
        transform: translateY(-2px);
    }
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }
    .stat-label {
        font-size: 0.875rem;
        color: #64748B;
        margin: 0.25rem 0 0;
    }

    /* Filter Card */
    .filter-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        cursor: pointer;
    }
    .filter-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #0F172A;
        margin: 0;
    }
    .filter-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .filter-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.375rem;
    }
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.15s;
    }
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #0EA5E9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .btn-filter {
        padding: 0.5rem 1.25rem;
        background: #0EA5E9;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.15s;
    }
    .btn-filter:hover {
        background: #0284C7;
        transform: translateY(-1px);
    }
    .btn-reset {
        padding: 0.5rem 1.25rem;
        background: #F1F5F9;
        color: #475569;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-reset:hover {
        background: #E2E8F0;
        color: #475569;
    }

    /* Logs Table */
    .logs-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        overflow: hidden;
    }
    .logs-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .logs-header h2 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0F172A;
        margin: 0;
    }
    .logs-actions {
        display: flex;
        gap: 0.75rem;
    }
    .btn-export {
        padding: 0.5rem 1rem;
        background: #14B8A6;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    .btn-export:hover {
        background: #0D9488;
        color: #fff;
        transform: translateY(-1px);
    }
    .table-wrapper {
        overflow-x: auto;
    }
    .logs-table {
        width: 100%;
        border-collapse: collapse;
    }
    .logs-table thead {
        background: #F8FAFC;
    }
    .logs-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border-bottom: 1px solid #E2E8F0;
        white-space: nowrap;
    }
    .logs-table td {
        padding: 1rem;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #F1F5F9;
    }
    .logs-table tbody tr {
        transition: background 0.15s;
    }
    .logs-table tbody tr:hover {
        background: #F8FAFC;
    }
    .log-user {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .log-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0EA5E9, #14B8A6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .log-user-info {
        min-width: 0;
    }
    .log-user-name {
        font-weight: 600;
        color: #0F172A;
        margin: 0;
        font-size: 0.875rem;
    }
    .log-user-role {
        font-size: 0.75rem;
        color: #64748B;
        margin: 0;
    }
    .log-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .log-badge.badge-login,
    .log-badge.badge-view {
        background: #F0F9FF;
        color: #075985;
    }
    .log-badge.badge-create,
    .log-badge.badge-approve {
        background: #F0FDFA;
        color: #0F766E;
    }
    .log-badge.badge-update {
        background: #FFFBEB;
        color: #92400E;
    }
    .log-badge.badge-delete,
    .log-badge.badge-reject {
        background: #FEF2F2;
        color: #991B1B;
    }
    .log-badge.badge-logout {
        background: #F1F5F9;
        color: #475569;
    }
    .log-time {
        font-size: 0.8125rem;
        color: #64748B;
    }
    .log-description {
        max-width: 400px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .btn-view {
        padding: 0.375rem 0.75rem;
        background: #F0F9FF;
        color: #0284C7;
        border: 1px solid #BAE6FD;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
        display: inline-block;
    }
    .btn-view:hover {
        background: #E0F2FE;
        color: #0369A1;
    }
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #94A3B8;
    }
    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .empty-text {
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #E2E8F0;
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">📊 Log Aktivitas Sistem</h1>
            <p class="text-muted mb-0">Monitor semua aktivitas pengguna di sistem SIMAGANG</p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-label">Total Log</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value">{{ number_format($stats['today']) }}</div>
            <div class="stat-label">Hari Ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ number_format($stats['this_week']) }}</div>
            <div class="stat-label">Minggu Ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📆</div>
            <div class="stat-value">{{ number_format($stats['this_month']) }}</div>
            <div class="stat-label">Bulan Ini</div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="filter-card">
        <div class="filter-header" onclick="this.parentElement.classList.toggle('collapsed')">
            <h3>🔍 Filter & Pencarian</h3>
            <span style="color: #94A3B8;">▼</span>
        </div>
        <div class="filter-body">
            <form action="{{ route('activity-logs.index') }}" method="GET" style="display: contents;">
                <div class="filter-group">
                    <label>Cari</label>
                    <input type="text" name="search" placeholder="Cari deskripsi..." value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <label>Aksi</label>
                    <select name="action">
                        <option value="">-- Semua Aksi --</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Module</label>
                    <select name="module">
                        <option value="">-- Semua Module --</option>
                        @foreach($modules as $module)
                            <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>User</label>
                    <select name="user_id">
                        <option value="">-- Semua User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="filter-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="filter-actions" style="grid-column: 1 / -1;">
                    <button type="submit" class="btn-filter">🔍 Terapkan Filter</button>
                    <a href="{{ route('activity-logs.index') }}" class="btn-reset">↻ Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="logs-card">
        <div class="logs-header">
            <h2>📋 Daftar Log Aktivitas</h2>
            <div class="logs-actions">
                <a href="{{ route('activity-logs.export', request()->query()) }}" class="btn-export">
                    <span>📥</span> Export CSV
                </a>
            </div>
        </div>

        @if($logs->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <div class="empty-text">Tidak ada log aktivitas</div>
                <p class="text-muted mt-2 mb-0">Coba ubah filter atau hapus pencarian</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="logs-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Module</th>
                            <th>Deskripsi</th>
                            <th>Waktu</th>
                            <th>IP Address</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>
                                <div class="log-user">
                                    <div class="log-avatar">
                                        {{ $log->user ? strtoupper(substr($log->user->name, 0, 2)) : 'SY' }}
                                    </div>
                                    <div class="log-user-info">
                                        <div class="log-user-name">{{ $log->user?->name ?? 'System' }}</div>
                                        <div class="log-user-role">{{ $log->role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="log-badge badge-{{ $log->action }}">
                                    {{ $log->action_icon }} {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: 600;">{{ ucfirst($log->module) }}</span>
                            </td>
                            <td>
                                <div class="log-description" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                            </td>
                            <td>
                                <div class="log-time">{{ $log->time_ago }}</div>
                                <div style="font-size: 0.75rem; color: #94A3B8;">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td>
                                <code style="font-size: 0.75rem; color: #64748B;">{{ $log->ip_address ?? '-' }}</code>
                            </td>
                            <td>
                                <a href="{{ route('activity-logs.show', $log->id) }}" class="btn-view">
                                    👁️ Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form on filter change (optional)
    document.querySelectorAll('.filter-group select').forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment to auto-submit
            // this.closest('form').submit();
        });
    });
</script>
@endpush

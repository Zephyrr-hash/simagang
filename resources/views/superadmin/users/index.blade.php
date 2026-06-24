@extends('layouts.app')

@section('title', 'Kelola Semua User — Superadmin')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('superadmin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kelola User</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .page-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem; }
    .page-header h1 { font-size:1.4rem;font-weight:700;color:#0F172A;margin:0; }

    .btn-add { display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0EA5E9,#0284C7);color:#fff;border:none;border-radius:10px;padding:.6rem 1.25rem;font-weight:600;font-size:.875rem;text-decoration:none;transition:opacity .2s; }
    .btn-add:hover { opacity:.88;color:#fff; }
    .btn-add svg { width:16px;height:16px; }

    .filter-bar { background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem; }

    .table-card { background:#fff;border:1px solid #E2E8F0;border-radius:12px;overflow:hidden; }
    .table-responsive { overflow-x:auto; }
    table { width:100%;border-collapse:collapse; }
    thead tr { background:#0F172A; }
    thead th { padding:.875rem 1rem;text-align:left;font-size:.75rem;font-weight:600;color:#fff;text-transform:uppercase;letter-spacing:.5px;white-space:nowrap; }
    tbody tr { border-bottom:1px solid #F1F5F9;transition:background .15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#F0F9FF; }
    tbody td { padding:.875rem 1rem;font-size:.875rem;color:#374151;vertical-align:middle; }

    .role-badge { display:inline-block;padding:.2rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600; }
    .role-1 { background:#EDE9FE;color:#6D28D9; }
    .role-2 { background:#ECFDF5;color:#065F46; }
    .role-3 { background:#DBEAFE;color:#1E40AF; }
    .role-4 { background:#F0FDF4;color:#166534; }
    .role-5 { background:#FEF3C7;color:#92400E; }

    .action-btns { display:flex;gap:.5rem;align-items:center; }
    .btn-edit { display:inline-flex;align-items:center;gap:.3rem;background:#EFF6FF;color:#2563EB;border:none;border-radius:7px;padding:.35rem .75rem;font-size:.78rem;font-weight:600;text-decoration:none;transition:background .15s; }
    .btn-edit:hover { background:#DBEAFE;color:#2563EB; }
    .btn-delete { display:inline-flex;align-items:center;gap:.3rem;background:#FEF2F2;color:#EF4444;border:none;border-radius:7px;padding:.35rem .75rem;font-size:.78rem;font-weight:600;cursor:pointer;transition:background .15s; }
    .btn-delete:hover { background:#FEE2E2; }
    .btn-edit svg, .btn-delete svg { width:13px;height:13px; }

    .empty-state { text-align:center;padding:3rem 1rem;color:#94A3B8; }
    .pagination-wrap { padding:1rem 1.25rem;border-top:1px solid #F1F5F9; }
    .pagination-wrap .pagination { margin:0; }
    .pagination-wrap .page-link { border-radius:8px!important;border:1.5px solid #E2E8F0;color:#0EA5E9;font-weight:500;font-size:.8rem;padding:.35rem .65rem; }
    .pagination-wrap .page-item.active .page-link { background:#0EA5E9;border-color:#0EA5E9;color:#fff; }

    .creator-badge { font-size:.7rem;color:#94A3B8; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1>Kelola Semua User</h1>
        <p style="font-size:.85rem;color:#64748B;margin:.25rem 0 0;">Total: <strong>{{ $users->total() }}</strong> user ditemukan</p>
    </div>
    <a href="{{ route('superadmin.users.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah User
    </a>
</div>

{{-- Filter & Search --}}
<form action="{{ route('superadmin.users.index') }}" method="GET">
    <div class="filter-bar">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label style="font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Cari User</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Nama atau email..."
                    value="{{ $search ?? '' }}" autocomplete="off">
            </div>
            <div class="col-12 col-md-3">
                <label style="font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.3rem;display:block;">Filter Role</label>
                <select name="role_id" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->role }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary" style="background:#0EA5E9;border-color:#0EA5E9;">
                    Cari
                </button>
                @if($search || $roleFilter)
                <a href="{{ route('superadmin.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat Oleh</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td style="color:#94A3B8;font-size:.8rem;">{{ $users->firstItem() + $i }}</td>
                    <td style="font-weight:600;color:#0F172A;">{{ $u->name }}</td>
                    <td style="color:#64748B;">{{ $u->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $u->role_id }}">
                            {{ $u->role->role ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($u->creator)
                            <span class="creator-badge">{{ $u->creator->name }}</span>
                        @else
                            <span class="creator-badge">—</span>
                        @endif
                    </td>
                    <td style="color:#94A3B8;font-size:.8rem;">
                        {{ $u->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('superadmin.users.edit', $u->id) }}" class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                </svg>
                                Edit
                            </a>
                            @if($u->id !== Auth::id())
                            <form action="{{ route('superadmin.users.destroy', $u->id) }}" method="POST" class="d-inline" id="del-{{ $u->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-delete"
                                    onclick="confirmDelete({{ $u->id }}, '{{ addslashes($u->name) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:48px;height:48px;color:#CBD5E1;display:block;margin:0 auto .75rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            <p>Tidak ada user ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="pagination-wrap">{{ $users->links() }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus User?',
        text: `Akun "${name}" akan dihapus secara permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
}
</script>
@endpush

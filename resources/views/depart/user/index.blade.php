@extends('layouts.app')

@section('title', 'Kelola User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola User</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #1E1B4B; margin: 0; }

    .btn-add {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff; border: none; border-radius: 10px;
        padding: 0.6rem 1.25rem; font-weight: 600; font-size: 0.875rem;
        text-decoration: none; transition: opacity 0.2s;
    }
    .btn-add:hover { opacity: 0.88; color: #fff; }
    .btn-add svg { width: 16px; height: 16px; }

    .search-bar-wrap {
        background: #fff;
        border: 1px solid #E0E7FF;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        display: flex; gap: 0.75rem; align-items: center;
    }
    .search-input {
        flex: 1; border: 1.5px solid #E5E7EB; border-radius: 8px;
        padding: 0.55rem 1rem; font-size: 0.875rem; font-family: 'Inter', sans-serif;
        outline: none; color: #1E1B4B;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input:focus { border-color: #4F46E5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
    .btn-search {
        background: #4F46E5; color: #fff; border: none; border-radius: 8px;
        padding: 0.55rem 1.25rem; font-size: 0.875rem; font-weight: 600;
        cursor: pointer; transition: background 0.2s; font-family: 'Inter', sans-serif;
    }
    .btn-search:hover { background: #4338CA; }

    .table-card {
        background: #fff;
        border: 1px solid #E0E7FF;
        border-radius: 12px;
        overflow: hidden;
    }
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #4F46E5; }
    thead th {
        padding: 0.875rem 1rem; text-align: left;
        font-size: 0.8rem; font-weight: 600; color: #fff;
        text-transform: uppercase; letter-spacing: 0.5px;
        white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #F3F4F6; transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #F5F3FF; }
    tbody td { padding: 0.875rem 1rem; font-size: 0.875rem; color: #374151; vertical-align: middle; }

    .role-badge {
        display: inline-block; padding: 0.2rem 0.65rem;
        border-radius: 20px; font-size: 0.72rem; font-weight: 600;
    }
    .role-1 { background: #EEF2FF; color: #4338CA; }
    .role-2 { background: #F5F3FF; color: #6D28D9; }
    .role-3 { background: #DBEAFE; color: #1E40AF; }
    .role-4 { background: #ECFDF5; color: #065F46; }
    .role-5 { background: #FEF3C7; color: #92400E; }

    .action-btns { display: flex; gap: 0.5rem; align-items: center; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: 0.3rem;
        background: #EEF2FF; color: #4F46E5; border: none; border-radius: 7px;
        padding: 0.35rem 0.75rem; font-size: 0.78rem; font-weight: 600;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-edit:hover { background: #E0E7FF; color: #4F46E5; }
    .btn-delete {
        display: inline-flex; align-items: center; gap: 0.3rem;
        background: #FEF2F2; color: #EF4444; border: none; border-radius: 7px;
        padding: 0.35rem 0.75rem; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: background 0.15s; font-family: 'Inter', sans-serif;
    }
    .btn-delete:hover { background: #FEE2E2; }
    .btn-edit svg, .btn-delete svg { width: 13px; height: 13px; }

    .empty-state { text-align: center; padding: 3rem 1rem; color: #6B7280; }
    .empty-state svg { width: 48px; height: 48px; color: #D1D5DB; margin-bottom: 0.75rem; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    .pagination-wrap { padding: 1rem 1.25rem; border-top: 1px solid #F3F4F6; }
    .pagination-wrap .pagination { margin: 0; }
    .pagination-wrap .page-link {
        border-radius: 8px !important; border: 1.5px solid #E0E7FF;
        color: #4F46E5; font-weight: 500; font-size: 0.8rem;
        padding: 0.35rem 0.65rem; transition: all 0.15s;
    }
    .pagination-wrap .page-link:hover { background: #EEF2FF; border-color: #C7D2FE; }
    .pagination-wrap .page-item.active .page-link {
        background: #4F46E5; border-color: #4F46E5; color: #fff;
    }
    .pagination-wrap .page-item.disabled .page-link { color: #9CA3AF; border-color: #F3F4F6; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Kelola User</h1>
    <a href="{{ route('users.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah User
    </a>
</div>

{{-- Search --}}
<form action="{{ route('users.index') }}" method="GET">
    <div class="search-bar-wrap">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Cari nama atau email..."
            value="{{ $search ?? '' }}"
            autocomplete="off"
        >
        <button type="submit" class="btn-search">Cari</button>
        @if($search)
            <a href="{{ route('users.index') }}" style="font-size:0.8rem;color:#6B7280;text-decoration:none;white-space:nowrap;">
                &times; Reset
            </a>
        @endif
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
                    @if(Auth::user()->role_id == \App\Models\Role::SUPERADMIN)
                    <th>Dibuat Oleh</th>
                    @endif
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $users->firstItem() + $i }}</td>
                    <td style="font-weight:600;color:#1E1B4B;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $roleLabels = [1=>'Departemen',2=>'Mitra',3=>'Dosen Pembimbing',4=>'Supervisor',5=>'Mahasiswa'];
                            $roleId = $user->role_id;
                        @endphp
                        <span class="role-badge role-{{ $roleId }}">
                            {{ $roleLabels[$roleId] ?? 'Unknown' }}
                        </span>
                    </td>
                    @if(Auth::user()->role_id == \App\Models\Role::SUPERADMIN)
                    <td style="font-size:0.8rem;color:#6B7280;">
                        {{ $user->creator?->name ?? '—' }}
                    </td>
                    @endif
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                </svg>
                                Edit
                            </a>
                            @if($user->id !== Auth::id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" id="delete-form-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete"
                                    onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
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
                    <td colspan="{{ Auth::user()->role_id == \App\Models\Role::SUPERADMIN ? 6 : 5 }}">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
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

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
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
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush

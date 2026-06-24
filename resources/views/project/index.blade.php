@extends('layouts.app')
@section('title', 'Project Magang')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item active">Project</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0;}
.btn-add{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;}
.btn-add:hover{opacity:0.88;color:#fff;}
.proj-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem;}
.proj-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;transition:box-shadow 0.2s,transform 0.15s;display:flex;flex-direction:column;}
.proj-card:hover{box-shadow:0 4px 20px rgba(79,70,229,0.12);transform:translateY(-2px);}
.proj-card-accent{height:4px;width:100%;}
.proj-card-body{padding:1.25rem;flex:1;display:flex;flex-direction:column;}
.proj-status{display:inline-flex;align-items:center;gap:0.35rem;font-size:0.7rem;font-weight:700;padding:0.18rem 0.65rem;border-radius:20px;margin-bottom:0.75rem;}
.proj-status.aktif{background:#EEF2FF;color:#4F46E5;}
.proj-status.selesai{background:#ECFDF5;color:#059669;}
.proj-status.pending{background:#FEF3C7;color:#D97706;}
.proj-name{font-size:0.95rem;font-weight:700;color:#1E1B4B;margin:0 0 0.25rem;line-height:1.3;}
.proj-mhs{font-size:0.78rem;color:#6B7280;margin:0 0 0.5rem;display:flex;align-items:center;gap:0.3rem;}
.proj-tech{font-size:0.72rem;color:#4F46E5;background:#EEF2FF;padding:0.15rem 0.6rem;border-radius:20px;display:inline-block;margin-bottom:0.6rem;}
.proj-desc{font-size:0.8rem;color:#6B7280;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:0.75rem;}
.proj-stats{display:flex;gap:1rem;padding-top:0.75rem;border-top:1px solid #F3F4F6;font-size:0.75rem;color:#9CA3AF;}
.proj-stats span{display:flex;align-items:center;gap:0.3rem;}
.proj-footer{padding:0.875rem 1.25rem;background:#F8F7FF;border-top:1px solid #E0E7FF;display:flex;gap:0.5rem;}
.btn-sm{display:inline-flex;align-items:center;gap:0.3rem;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-view{background:#fff;color:#4F46E5;border:1px solid #C7D2FE;}.btn-view:hover{background:#EEF2FF;color:#4F46E5;}
.btn-edit{background:#F0FDF4;color:#059669;border:1px solid #A7F3D0;}.btn-edit:hover{background:#DCFCE7;color:#059669;}
.btn-del{background:#FEF2F2;color:#EF4444;border:1px solid #FECACA;cursor:pointer;font-family:'Inter',sans-serif;}.btn-del:hover{background:#FEE2E2;}
.empty-state{text-align:center;padding:4rem 1rem;color:#6B7280;background:#fff;border:1px solid #E0E7FF;border-radius:12px;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>
        Project Magang
        @if($roleId === \App\Models\Role::MAHASISWA)
            <span style="font-size:0.8rem;font-weight:500;color:#6B7280;margin-left:0.5rem;">— Dibuat oleh Supervisor Anda</span>
        @elseif($roleId === \App\Models\Role::DOSPEM)
            <span style="font-size:0.8rem;font-weight:500;color:#6B7280;margin-left:0.5rem;">— Mahasiswa bimbingan Anda</span>
        @endif
    </h1>
    @if($roleId === \App\Models\Role::SUPERVISOR)
    <a href="{{ route('project.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Buat Project
    </a>
    @endif
</div>

@if($projects->isEmpty())
<div class="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="color:#D1D5DB;margin-bottom:0.75rem;display:block;margin-inline:auto;"><path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4z"/></svg>
    @if($roleId === \App\Models\Role::SUPERVISOR)
        <p style="font-size:1rem;font-weight:600;margin-bottom:0.5rem;">Belum ada project</p>
        <p style="font-size:0.875rem;">Buat project pertama untuk mengorganisir logbook dan bimbingan mahasiswa.</p>
        <a href="{{ route('project.create') }}" class="btn-add" style="display:inline-flex;margin-top:1rem;">Buat Project Pertama</a>
    @else
        <p style="font-size:1rem;font-weight:600;margin-bottom:0.5rem;">Belum ada project</p>
        <p style="font-size:0.875rem;">Project akan muncul di sini setelah Supervisor membuat project untuk Anda.</p>
    @endif
</div>
@else
<div class="proj-grid">
    @foreach($projects as $p)
    <div class="proj-card">
        <div class="proj-card-accent" style="background:{{ $p->status_color }};"></div>
        <div class="proj-card-body">
            <span class="proj-status {{ $p->status }}">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                {{ $p->status_label }}
            </span>
            <h3 class="proj-name">{{ $p->nama_project }}</h3>
            <p class="proj-mhs">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                {{ $p->magang?->mahasiswa?->nama_mhs ?? '—' }}
                <span style="color:#D1D5DB;">·</span>
                {{ $p->magang?->lowongan?->mitra?->nama_mitra ?? '—' }}
                @if(Auth::user()->role_id == \App\Models\Role::SUPERADMIN && $p->magang?->spv)
                <span style="color:#D1D5DB;">·</span>
                <span style="color:#16A34A;">Supervisor: {{ $p->magang?->spv?->nama_spv }}</span>
                @endif
            </p>
            @if($p->teknologi)
            <span class="proj-tech">{{ $p->teknologi }}</span>
            @endif
            @if($p->deskripsi)
            <p class="proj-desc">{{ $p->deskripsi }}</p>
            @endif
            <div class="proj-stats">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5z"/></svg>
                    {{ $p->logbooks()->count() }} Logbook
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M7.5 8.25h9m-9 3H12"/></svg>
                    {{ $p->bimbingans()->count() }} Bimbingan
                </span>
                @if($p->tgl_mulai)
                <span>📅 {{ $p->tgl_mulai->format('d/m/Y') }}</span>
                @endif
            </div>
        </div>
        <div class="proj-footer">
            <a href="{{ route('project.show', $p->id) }}" class="btn-sm btn-view">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/></svg>
                Lihat
            </a>
            @if($roleId === \App\Models\Role::SUPERVISOR)
            <a href="{{ route('project.edit', $p->id) }}" class="btn-sm btn-edit">Edit</a>
            <form action="{{ route('project.destroy', $p->id) }}" method="POST" id="del-proj-{{ $p->id }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="button" class="btn-sm btn-del" onclick="confirmDel({{ $p->id }}, '{{ addslashes($p->nama_project) }}')">Hapus</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
@push('scripts')
<script>
function confirmDel(id, name) {
    Swal.fire({
        title: 'Hapus Project?',
        html: `Project <strong>${name}</strong> akan dihapus permanen beserta semua logbook dan bimbingan di dalamnya.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(r => { if (r.isConfirmed) document.getElementById('del-proj-' + id).submit(); });
}
</script>
@endpush

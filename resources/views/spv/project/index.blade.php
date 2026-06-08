@extends('layouts.app')
@section('title', 'Project Magang')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
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
.proj-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.25rem;transition:box-shadow 0.2s,transform 0.15s;display:flex;flex-direction:column;}
.proj-card:hover{box-shadow:0 4px 20px rgba(79,70,229,0.12);transform:translateY(-2px);}
.proj-status{display:inline-flex;align-items:center;gap:0.4rem;font-size:0.72rem;font-weight:700;padding:0.2rem 0.7rem;border-radius:20px;margin-bottom:0.75rem;}
.proj-status.aktif{background:#EEF2FF;color:#4F46E5;}
.proj-status.selesai{background:#ECFDF5;color:#059669;}
.proj-status.pending{background:#FEF3C7;color:#D97706;}
.proj-name{font-size:1rem;font-weight:700;color:#1E1B4B;margin:0 0 0.3rem;line-height:1.3;}
.proj-mhs{font-size:0.8rem;color:#6B7280;margin:0 0 0.75rem;display:flex;align-items:center;gap:0.35rem;}
.proj-tech{font-size:0.78rem;color:#4F46E5;background:#EEF2FF;padding:0.2rem 0.65rem;border-radius:20px;display:inline-block;margin-bottom:0.75rem;}
.proj-meta{font-size:0.78rem;color:#9CA3AF;margin-bottom:0.875rem;flex:1;}
.proj-actions{display:flex;gap:0.5rem;margin-top:auto;padding-top:0.75rem;border-top:1px solid #F3F4F6;}
.btn-sm{display:inline-flex;align-items:center;gap:0.3rem;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-view{background:#EEF2FF;color:#4F46E5;}.btn-view:hover{background:#E0E7FF;color:#4F46E5;}
.btn-edit{background:#F0FDF4;color:#059669;}.btn-edit:hover{background:#DCFCE7;color:#059669;}
.btn-del{background:#FEF2F2;color:#EF4444;border:none;cursor:pointer;font-family:'Inter',sans-serif;}.btn-del:hover{background:#FEE2E2;}
.empty-state{text-align:center;padding:4rem 1rem;color:#6B7280;background:#fff;border:1px solid #E0E7FF;border-radius:12px;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Project Magang</h1>
    <a href="{{ route('spv.project.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Buat Project
    </a>
</div>

@if($projects->isEmpty())
    <div class="empty-state">
        <p style="font-size:1rem;font-weight:600;margin-bottom:0.5rem;">Belum ada project</p>
        <p style="font-size:0.875rem;">Buat project untuk mengorganisir logbook mahasiswa yang Anda supervisi.</p>
        <a href="{{ route('spv.project.create') }}" class="btn-add" style="display:inline-flex;margin-top:1rem;">Buat Project Pertama</a>
    </div>
@else
    <div class="proj-grid">
        @foreach($projects as $p)
        <div class="proj-card">
            <div>
                <span class="proj-status {{ $p->status }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                    {{ $p->status_label }}
                </span>
                <h3 class="proj-name">{{ $p->nama_project }}</h3>
                <p class="proj-mhs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 8.029 10 6 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                    {{ $p->magang?->mahasiswa?->nama_mhs ?? '—' }}
                </p>
                @if($p->teknologi)
                    <span class="proj-tech">{{ $p->teknologi }}</span>
                @endif
                <p class="proj-meta">
                    @if($p->tgl_mulai)
                        📅 {{ $p->tgl_mulai->format('d/m/Y') }}
                        @if($p->tgl_selesai) — {{ $p->tgl_selesai->format('d/m/Y') }} @endif
                    @endif
                    @if($p->deskripsi)
                        <br><span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $p->deskripsi }}</span>
                    @endif
                </p>
            </div>
            <div class="proj-actions">
                <a href="{{ route('spv.project.show', $p->id) }}" class="btn-sm btn-view">Detail</a>
                <a href="{{ route('spv.project.edit', $p->id) }}" class="btn-sm btn-edit">Edit</a>
                <form action="{{ route('spv.project.destroy', $p->id) }}" method="POST" id="del-proj-{{ $p->id }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-sm btn-del" onclick="confirmDelProj({{ $p->id }}, '{{ addslashes($p->nama_project) }}')">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
@push('scripts')
<script>
function confirmDelProj(id, name) {
    Swal.fire({
        title: 'Hapus Project?',
        html: `Project <strong>${name}</strong> akan dihapus permanen. Logbook yang terkait akan dilepas dari project ini.`,
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

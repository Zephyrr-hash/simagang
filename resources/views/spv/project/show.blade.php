@extends('layouts.app')
@section('title', $project->nama_project)
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spv.project.index') }}">Project</a></li>
    <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
</ol></nav>
@endsection
@push('styles')
<style>
.proj-grid{display:grid;grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;}
@media(max-width:767px){.proj-grid{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.card-title{font-size:1rem;font-weight:700;color:#1E1B4B;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:2px solid #EEF2FF;display:flex;align-items:center;gap:0.5rem;}
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.75rem;font-weight:600;color:#9CA3AF;min-width:90px;flex-shrink:0;padding-top:2px;}
.info-value{color:#1E1B4B;font-weight:500;line-height:1.5;}
.status-badge{display:inline-flex;align-items:center;gap:0.4rem;font-size:0.72rem;font-weight:700;padding:0.25rem 0.8rem;border-radius:20px;}
.status-aktif{background:#EEF2FF;color:#4F46E5;}
.status-selesai{background:#ECFDF5;color:#059669;}
.status-pending{background:#FEF3C7;color:#D97706;}
.mhs-avatar{width:60px;height:60px;border-radius:50%;object-fit:cover;border:3px solid #C7D2FE;display:block;margin:0 auto 0.75rem;}
.mhs-avatar-init{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:#fff;margin:0 auto 0.75rem;}
.tech-tags{display:flex;flex-wrap:wrap;gap:0.35rem;margin-top:0.25rem;}
.tech-tag{background:#EEF2FF;color:#4338CA;font-size:0.72rem;font-weight:600;padding:0.2rem 0.65rem;border-radius:20px;border:1px solid #C7D2FE;}
.log-item{background:#F8F7FF;border:1px solid #E0E7FF;border-radius:10px;padding:1rem 1.25rem;margin-bottom:0.875rem;}
.log-date{font-size:0.78rem;font-weight:600;color:#4F46E5;margin-bottom:0.35rem;}
.log-kegiatan{font-size:0.9rem;font-weight:600;color:#1E1B4B;margin-bottom:0.3rem;}
.log-desc{font-size:0.85rem;color:#374151;line-height:1.5;margin-bottom:0.4rem;}
.log-saran{font-size:0.8rem;color:#6B7280;font-style:italic;}
.catatan-spv-box{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;padding:0.65rem 0.9rem;margin-top:0.5rem;font-size:0.82rem;color:#065F46;}
.empty-logs{text-align:center;padding:2rem;color:#9CA3AF;font-size:0.875rem;}
.btn-edit-proj{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:9px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;margin-top:1rem;width:100%;justify-content:center;}
.btn-edit-proj:hover{opacity:0.88;color:#fff;}
</style>
@endpush
@section('content')
<div class="proj-grid">

    {{-- ===== KOLOM KIRI: Info Mahasiswa + Info Project ===== --}}
    <div>
        {{-- Card Mahasiswa --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <h2 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 8.029 10 6 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                Mahasiswa
            </h2>
            @php $mhs = $project->magang?->mahasiswa; @endphp
            @if($mhs?->foto_mhs && file_exists(public_path('images/'.$mhs->foto_mhs)))
                <img src="{{ asset('images/'.$mhs->foto_mhs) }}" alt="{{ $mhs->nama_mhs }}" class="mhs-avatar">
            @else
                <div class="mhs-avatar-init">{{ strtoupper(substr($mhs?->nama_mhs ?? 'M', 0, 1)) }}</div>
            @endif
            <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $mhs?->nama_mhs ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $mhs?->NIM ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Jurusan</span><span class="info-value">{{ $mhs?->jurusan?->jurusan ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Lowongan</span><span class="info-value">{{ $project->magang?->lowongan?->nama_low ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Perusahaan</span><span class="info-value">{{ $project->magang?->lowongan?->mitra?->nama_mitra ?? '—' }}</span></div>
        </div>

        {{-- Card Detail Project --}}
        <div class="card">
            <h2 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
                Detail Project
            </h2>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $project->status }}">
                        <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                        {{ $project->status_label }}
                    </span>
                </span>
            </div>
            @if($project->tgl_mulai)
            <div class="info-row"><span class="info-label">Mulai</span><span class="info-value">{{ $project->tgl_mulai->translatedFormat('d F Y') }}</span></div>
            @endif
            @if($project->tgl_selesai)
            <div class="info-row"><span class="info-label">Selesai</span><span class="info-value">{{ $project->tgl_selesai->translatedFormat('d F Y') }}</span></div>
            @endif
            @if($project->teknologi)
            <div class="info-row">
                <span class="info-label">Teknologi</span>
                <span class="info-value">
                    <div class="tech-tags">
                        @foreach(explode(',', $project->teknologi) as $tech)
                            <span class="tech-tag">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                </span>
            </div>
            @endif
            @if($project->tujuan)
            <div class="info-row"><span class="info-label">Tujuan</span><span class="info-value" style="white-space:pre-line;">{{ $project->tujuan }}</span></div>
            @endif
            @if($project->deskripsi)
            <div class="info-row"><span class="info-label">Deskripsi</span><span class="info-value" style="white-space:pre-line;">{{ $project->deskripsi }}</span></div>
            @endif

            <a href="{{ route('spv.project.edit', $project->id) }}" class="btn-edit-proj">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.146 4.207L9.793 1.146 4 6.94V7h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.06l5.793-5.793zM3.23 9.854l-.092.391A.5.5 0 0 0 3.5 11H4v-.5a.5.5 0 0 1 .5-.5H5v-.5a.5.5 0 0 1 .5-.5H6v-.5a.5.5 0 0 1 .146-.354l.734-.734-1.08-.27-2.57.963z"/></svg>
                Edit Project
            </a>
        </div>
    </div>

    {{-- ===== KOLOM KANAN: History Logbook ===== --}}
    <div class="card">
        <h2 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/></svg>
            History Logbook
            <span style="margin-left:auto;font-size:0.75rem;font-weight:500;color:#6B7280;">{{ $logbooks->count() }} entri</span>
        </h2>

        @forelse($logbooks as $log)
        <div class="log-item">
            <p class="log-date">📅 {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}</p>
            <p class="log-kegiatan">{{ $log->kegiatan }}</p>
            <p class="log-desc">{{ $log->deskripsi_log }}</p>
            @if($log->saran)
            <p class="log-saran">💡 {{ $log->saran }}</p>
            @endif
            @if($log->catatan_spv)
            <div class="catatan-spv-box">
                <strong style="display:block;font-size:0.72rem;margin-bottom:0.2rem;">✅ Catatan Anda:</strong>
                {{ $log->catatan_spv }}
            </div>
            @endif
        </div>
        @empty
        <div class="empty-logs">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" style="color:#D1D5DB;margin-bottom:0.75rem;"><path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/></svg>
            <p>Belum ada logbook yang terhubung ke project ini.</p>
            <p style="font-size:0.8rem;color:#9CA3AF;">Mahasiswa dapat memilih project saat mengisi logbook.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection

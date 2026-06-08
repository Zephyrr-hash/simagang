@extends('layouts.app')
@section('title', $project->nama_project)
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></li>
    <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
</ol></nav>
@endsection
@push('styles')
<style>
/* Layout */
.proj-layout{display:grid;grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;}
@media(max-width:991px){.proj-layout{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;margin-bottom:1.25rem;}
.card-header{padding:1rem 1.25rem;border-bottom:1px solid #E0E7FF;display:flex;align-items:center;justify-content:space-between;}
.card-header h2{font-size:0.9rem;font-weight:700;color:#1E1B4B;margin:0;display:flex;align-items:center;gap:0.5rem;}
.card-body{padding:1.25rem;}
/* Info rows */
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.72rem;font-weight:600;color:#9CA3AF;min-width:80px;flex-shrink:0;padding-top:2px;}
.info-value{color:#1E1B4B;font-weight:500;line-height:1.5;}
/* Status badge */
.proj-status{display:inline-flex;align-items:center;gap:0.35rem;font-size:0.7rem;font-weight:700;padding:0.2rem 0.65rem;border-radius:20px;}
.proj-status.aktif{background:#EEF2FF;color:#4F46E5;}
.proj-status.selesai{background:#ECFDF5;color:#059669;}
.proj-status.pending{background:#FEF3C7;color:#D97706;}
/* Tech tags */
.tech-tags{display:flex;flex-wrap:wrap;gap:0.3rem;}
.tech-tag{background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:20px;}
/* Mahasiswa avatar */
.mhs-avatar{width:56px;height:56px;border-radius:50%;object-fit:cover;border:3px solid #C7D2FE;display:block;margin:0 auto 0.75rem;}
.mhs-avatar-init{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:1.4rem;font-weight:700;color:#fff;margin:0 auto 0.75rem;}
/* Action buttons */
.btn-primary{display:inline-flex;align-items:center;gap:0.4rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.55rem 1.1rem;font-weight:600;font-size:0.8rem;text-decoration:none;transition:opacity 0.2s;cursor:pointer;font-family:'Inter',sans-serif;}
.btn-primary:hover{opacity:0.88;color:#fff;}
.btn-secondary{display:inline-flex;align-items:center;gap:0.4rem;background:#F0FDF4;color:#059669;border:1px solid #A7F3D0;border-radius:9px;padding:0.55rem 1.1rem;font-weight:600;font-size:0.8rem;text-decoration:none;transition:background 0.15s;}
.btn-secondary:hover{background:#DCFCE7;color:#059669;}
.btn-danger-sm{background:#FEF2F2;color:#EF4444;border:1px solid #FECACA;border-radius:7px;padding:0.3rem 0.65rem;font-size:0.75rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;text-decoration:none;display:inline-flex;align-items:center;gap:0.3rem;}
.btn-danger-sm:hover{background:#FEE2E2;}
.btn-edit-sm{background:#EEF2FF;color:#4F46E5;border:1px solid #C7D2FE;border-radius:7px;padding:0.3rem 0.65rem;font-size:0.75rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.3rem;}
.btn-edit-sm:hover{background:#E0E7FF;}
/* Logbook items */
.log-item{border:1px solid #E0E7FF;border-radius:10px;padding:1rem 1.25rem;margin-bottom:0.875rem;background:#F8F7FF;}
.log-date{font-size:0.75rem;font-weight:600;color:#4F46E5;margin-bottom:0.3rem;}
.log-kegiatan{font-size:0.9rem;font-weight:600;color:#1E1B4B;margin-bottom:0.3rem;}
.log-desc{font-size:0.82rem;color:#374151;line-height:1.5;margin-bottom:0.4rem;}
.log-saran{font-size:0.78rem;color:#6B7280;font-style:italic;margin-bottom:0.6rem;}
.catatan-spv-box{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;padding:0.6rem 0.9rem;font-size:0.82rem;color:#065F46;margin-bottom:0.6rem;}
.catatan-spv-form{background:#F0FDF4;border:1px solid #A7F3D0;border-radius:9px;padding:0.875rem;}
.catatan-spv-form label{display:block;font-size:0.75rem;font-weight:600;color:#065F46;margin-bottom:0.35rem;}
.catatan-spv-form textarea{width:100%;padding:0.55rem 0.85rem;border:1.5px solid #A7F3D0;border-radius:8px;font-size:0.82rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#fff;outline:none;resize:vertical;}
.catatan-spv-form textarea:focus{border-color:#059669;box-shadow:0 0 0 3px rgba(5,150,105,0.1);}
.btn-catatan{background:linear-gradient(135deg,#059669,#10B981);color:#fff;border:none;border-radius:7px;padding:0.45rem 1rem;font-weight:600;font-size:0.78rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;margin-top:0.6rem;}
.btn-catatan:hover{opacity:0.88;}
/* Bimbingan items */
.bim-item{border:1px solid #E0E7FF;border-radius:10px;padding:1rem 1.25rem;margin-bottom:0.875rem;background:#F8F7FF;}
.bim-date{font-size:0.75rem;font-weight:600;color:#7C3AED;margin-bottom:0.3rem;}
.bim-catatan{font-size:0.875rem;color:#374151;line-height:1.5;margin-bottom:0.5rem;}
.feedback-box{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;padding:0.6rem 0.9rem;font-size:0.82rem;color:#065F46;margin-bottom:0.5rem;}
.feedback-form{background:#F5F3FF;border:1px solid #DDD6FE;border-radius:9px;padding:0.875rem;}
.feedback-form label{display:block;font-size:0.75rem;font-weight:600;color:#4C1D95;margin-bottom:0.35rem;}
.feedback-form textarea{width:100%;padding:0.55rem 0.85rem;border:1.5px solid #DDD6FE;border-radius:8px;font-size:0.82rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#fff;outline:none;resize:vertical;}
.feedback-form textarea:focus{border-color:#7C3AED;box-shadow:0 0 0 3px rgba(124,58,237,0.1);}
.btn-feedback{background:linear-gradient(135deg,#7C3AED,#4F46E5);color:#fff;border:none;border-radius:7px;padding:0.45rem 1rem;font-weight:600;font-size:0.78rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;margin-top:0.6rem;}
.btn-feedback:hover{opacity:0.88;}
/* Tab */
.tab-bar{display:flex;gap:0;border-bottom:2px solid #E0E7FF;margin-bottom:1.25rem;}
.tab-btn{padding:0.65rem 1.25rem;font-size:0.875rem;font-weight:600;color:#6B7280;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;transition:all 0.15s;display:flex;align-items:center;gap:0.5rem;}
.tab-btn.active{color:#4F46E5;border-bottom-color:#4F46E5;}
.tab-btn:hover:not(.active){color:#374151;}
.tab-count{background:#EEF2FF;color:#4F46E5;font-size:0.68rem;font-weight:700;padding:0.1rem 0.5rem;border-radius:20px;}
.tab-pane{display:none;}.tab-pane.active{display:block;}
.empty-tab{text-align:center;padding:2.5rem 1rem;color:#9CA3AF;font-size:0.875rem;}
.log-actions{display:flex;gap:0.4rem;align-items:center;flex-wrap:wrap;}
</style>
@endpush
@section('content')
<div class="proj-layout">

    {{-- ===== KOLOM KIRI: Info Project + Mahasiswa ===== --}}
    <div>
        {{-- Card Info Project --}}
        <div class="card">
            <div class="card-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4z"/></svg>
                    Project
                </h2>
                @if($roleId === \App\Models\Role::SUPERVISOR)
                <a href="{{ route('project.edit', $project->id) }}" style="font-size:0.75rem;color:#4F46E5;font-weight:600;text-decoration:none;">Edit</a>
                @endif
            </div>
            <div class="card-body">
                <div style="margin-bottom:0.75rem;">
                    <span class="proj-status {{ $project->status }}">
                        <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                        {{ $project->status_label }}
                    </span>
                    <h3 style="font-size:1rem;font-weight:700;color:#1E1B4B;margin:0.4rem 0 0;">{{ $project->nama_project }}</h3>
                </div>
                @if($project->teknologi)
                <div class="tech-tags" style="margin-bottom:0.75rem;">
                    @foreach(explode(',', $project->teknologi) as $t)
                        <span class="tech-tag">{{ trim($t) }}</span>
                    @endforeach
                </div>
                @endif
                @if($project->tgl_mulai)
                <div class="info-row"><span class="info-label">Mulai</span><span class="info-value">{{ $project->tgl_mulai->translatedFormat('d F Y') }}</span></div>
                @endif
                @if($project->tgl_selesai)
                <div class="info-row"><span class="info-label">Selesai</span><span class="info-value">{{ $project->tgl_selesai->translatedFormat('d F Y') }}</span></div>
                @endif
                @if($project->tujuan)
                <div class="info-row"><span class="info-label">Tujuan</span><span class="info-value" style="white-space:pre-line;font-size:0.82rem;">{{ $project->tujuan }}</span></div>
                @endif
                @if($project->deskripsi)
                <div class="info-row"><span class="info-label">Deskripsi</span><span class="info-value" style="white-space:pre-line;font-size:0.82rem;">{{ $project->deskripsi }}</span></div>
                @endif
            </div>
        </div>

        {{-- Card Mahasiswa --}}
        <div class="card">
            <div class="card-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                    Mahasiswa
                </h2>
            </div>
            <div class="card-body">
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
                @if($project->magang?->dosen)
                <div class="info-row"><span class="info-label">Dospem</span><span class="info-value">{{ $project->magang->dosen->nama_dosen }}</span></div>
                @endif
                @if($project->magang?->spv)
                <div class="info-row"><span class="info-label">Supervisor</span><span class="info-value">{{ $project->magang->spv->nama_spv }}</span></div>
                @endif
            </div>
        </div>

        {{-- PDF Export (mahasiswa & SPV) --}}
        @if(in_array($roleId, [\App\Models\Role::MAHASISWA, \App\Models\Role::SUPERVISOR]))
        <a href="{{ route('project.logbook.print', $project->id) }}"
           style="display:flex;align-items:center;gap:0.5rem;background:#ECFDF5;color:#059669;border:1.5px solid #A7F3D0;border-radius:10px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;width:100%;justify-content:center;">
            📄 Export PDF Logbook
        </a>
        @endif
    </div>

    {{-- ===== KOLOM KANAN: Logbook + Bimbingan ===== --}}
    <div>
        {{-- Tab: Logbook / Bimbingan --}}
        <div class="card">
            <div class="card-body" style="padding-bottom:0;">
                <div class="tab-bar">
                    {{-- Tab Logbook: hanya SPV dan Mahasiswa --}}
                    @if(in_array($roleId, [\App\Models\Role::SUPERVISOR, \App\Models\Role::MAHASISWA]))
                    <button class="tab-btn {{ $roleId !== \App\Models\Role::DOSPEM ? 'active' : '' }}" onclick="switchTab('logbook', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5z"/><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2z"/></svg>
                        Logbook <span class="tab-count">{{ $logbooks->count() }}</span>
                    </button>
                    @endif
                    {{-- Tab Bimbingan: hanya Dosen dan Mahasiswa --}}
                    @if(in_array($roleId, [\App\Models\Role::DOSPEM, \App\Models\Role::MAHASISWA]))
                    <button class="tab-btn {{ $roleId === \App\Models\Role::DOSPEM ? 'active' : '' }}" onclick="switchTab('bimbingan', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M7.5 8.25h9m-9 3H12M2.25 6.741c0-1.602 1.123-2.995 2.707-3.228A48.394 48.394 0 0 1 9 3c2.392 0 4.744.175 7.043.513C17.627 3.746 18.75 5.14 18.75 6.741v6.018c0 1.602-1.123 2.995-2.707 3.228A48.172 48.172 0 0 1 9 16.5c-2.392 0-4.744-.175-7.043-.513C.373 15.754-.75 14.36-.75 12.759V6.741z"/></svg>
                        Bimbingan <span class="tab-count">{{ $bimbingans->count() }}</span>
                    </button>
                    @endif
                </div>
            </div>

            {{-- TAB: LOGBOOK — hanya SPV dan Mahasiswa --}}
            @if(in_array($roleId, [\App\Models\Role::SUPERVISOR, \App\Models\Role::MAHASISWA]))
            <div id="tab-logbook" class="tab-pane {{ $roleId !== \App\Models\Role::DOSPEM ? 'active' : '' }}" style="padding:1.25rem;">
                @if($roleId === \App\Models\Role::MAHASISWA)
                <div style="margin-bottom:1rem;">
                    <a href="{{ route('project.logbook.create', $project->id) }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                        Tambah Logbook
                    </a>
                </div>
                @endif

                @forelse($logbooks as $log)
                <div class="log-item">
                    <p class="log-date">📅 {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}</p>
                    <p class="log-kegiatan">{{ $log->kegiatan }}</p>
                    <p class="log-desc">{{ $log->deskripsi_log }}</p>
                    @if($log->saran)<p class="log-saran">💡 {{ $log->saran }}</p>@endif

                    {{-- Catatan SPV --}}
                    @if($log->catatan_spv)
                    <div class="catatan-spv-box">
                        <strong style="display:block;font-size:0.7rem;margin-bottom:0.2rem;">✅ Catatan Supervisor:</strong>
                        {{ $log->catatan_spv }}
                    </div>
                    @elseif($roleId === \App\Models\Role::SUPERVISOR)
                    <div class="catatan-spv-form">
                        <form action="{{ route('project.logbook.catatan', [$project->id, $log->id]) }}" method="POST">
                            @csrf
                            <label>Berikan Catatan:</label>
                            <textarea name="catatan_spv" rows="2" placeholder="Catatan untuk mahasiswa..."></textarea>
                            <button type="submit" class="btn-catatan">Simpan Catatan</button>
                        </form>
                    </div>
                    @endif

                    {{-- Actions untuk mahasiswa --}}
                    @if($roleId === \App\Models\Role::MAHASISWA)
                    <div class="log-actions">
                        <a href="{{ route('project.logbook.edit', [$project->id, $log->id]) }}" class="btn-edit-sm">Edit</a>
                        <form action="{{ route('project.logbook.destroy', [$project->id, $log->id]) }}" method="POST" id="del-log-{{ $log->id }}" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-danger-sm" onclick="confirmDelLog({{ $log->id }})">Hapus</button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-tab">
                    <p style="font-weight:600;margin-bottom:0.25rem;">Belum ada logbook</p>
                    @if($roleId === \App\Models\Role::MAHASISWA)
                    <p>Tambahkan aktivitas logbook untuk project ini.</p>
                    @endif
                </div>
                @endforelse
            </div>
            @endif

            {{-- TAB: BIMBINGAN — hanya Dosen dan Mahasiswa --}}
            @if(in_array($roleId, [\App\Models\Role::DOSPEM, \App\Models\Role::MAHASISWA]))
            <div id="tab-bimbingan" class="tab-pane {{ $roleId === \App\Models\Role::DOSPEM ? 'active' : '' }}" style="padding:1.25rem;">
                @if($roleId === \App\Models\Role::MAHASISWA)
                <div style="margin-bottom:1rem;">
                    <a href="{{ route('project.bimbingan.create', $project->id) }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                        Kirim Laporan Bimbingan
                    </a>
                </div>
                @endif

                @forelse($bimbingans as $bim)
                <div class="bim-item">
                    <p class="bim-date">📅 {{ \Carbon\Carbon::parse($bim->tgl_bimbingan)->translatedFormat('d F Y') }}</p>
                    <p class="bim-catatan">{{ $bim->catatan }}</p>
                    @if($bim->file)
                    <p style="font-size:0.8rem;margin-bottom:0.5rem;">
                        <a href="{{ asset('file/'.$bim->file) }}" target="_blank" style="color:#4F46E5;">📎 Lihat File Laporan</a>
                    </p>
                    @endif

                    {{-- Feedback Dosen --}}
                    @if($bim->feedback)
                    <div class="feedback-box">
                        <strong style="display:block;font-size:0.7rem;margin-bottom:0.2rem;">✅ Feedback Dosen Pembimbing:</strong>
                        {{ $bim->feedback }}
                    </div>
                    @elseif($roleId === \App\Models\Role::DOSPEM)
                    <div class="feedback-form">
                        <form action="{{ route('project.bimbingan.feedback', [$project->id, $bim->id]) }}" method="POST">
                            @csrf
                            <label>Berikan Feedback:</label>
                            <textarea name="feedback" rows="3" placeholder="Tulis feedback untuk mahasiswa..."></textarea>
                            <button type="submit" class="btn-feedback">Kirim Feedback</button>
                        </form>
                    </div>
                    @endif

                    {{-- Actions untuk mahasiswa --}}
                    @if($roleId === \App\Models\Role::MAHASISWA)
                    <div class="log-actions">
                        <a href="{{ route('project.bimbingan.edit', [$project->id, $bim->id]) }}" class="btn-edit-sm">Edit</a>
                        <form action="{{ route('project.bimbingan.destroy', [$project->id, $bim->id]) }}" method="POST" id="del-bim-{{ $bim->id }}" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-danger-sm" onclick="confirmDelBim({{ $bim->id }})">Hapus</button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-tab">
                    <p style="font-weight:600;margin-bottom:0.25rem;">Belum ada laporan bimbingan</p>
                    @if($roleId === \App\Models\Role::MAHASISWA)
                    <p>Kirim laporan bimbingan kepada dosen pembimbing Anda.</p>
                    @endif
                </div>
                @endforelse
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
}
function confirmDelLog(id) {
    Swal.fire({title:'Hapus Logbook?',text:'Entri logbook ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#EF4444',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('del-log-'+id).submit();});
}
function confirmDelBim(id) {
    Swal.fire({title:'Hapus Bimbingan?',text:'Laporan bimbingan ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#EF4444',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('del-bim-'+id).submit();});
}
</script>
@endpush

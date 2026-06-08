@extends('layouts.app')
@section('title', 'Logbook')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Logbook</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0;}
.header-actions{display:flex;gap:0.75rem;}
.btn-add{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;}
.btn-add:hover{opacity:0.88;color:#fff;}
.btn-pdf{display:inline-flex;align-items:center;gap:0.5rem;background:#ECFDF5;color:#059669;border:1.5px solid #A7F3D0;border-radius:10px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:all 0.2s;}
.btn-pdf:hover{background:#D1FAE5;color:#059669;}
.info-banner{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:#1E40AF;}
.table-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;}
table{width:100%;border-collapse:collapse;}
thead tr{background:#4F46E5;}
thead th{padding:0.875rem 1rem;text-align:left;font-size:0.8rem;font-weight:600;color:#fff;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;}
tbody tr{border-bottom:1px solid #F3F4F6;transition:background 0.15s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#F5F3FF;}
tbody td{padding:0.875rem 1rem;font-size:0.875rem;color:#374151;vertical-align:middle;}
.action-btns{display:flex;gap:0.5rem;}
.btn-sm{display:inline-flex;align-items:center;gap:0.3rem;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-view{background:#EEF2FF;color:#4F46E5;}.btn-view:hover{background:#E0E7FF;color:#4F46E5;}
.btn-edit{background:#F0FDF4;color:#059669;}.btn-edit:hover{background:#DCFCE7;color:#059669;}
.btn-del{background:#FEF2F2;color:#EF4444;border:none;cursor:pointer;font-family:'Inter',sans-serif;}.btn-del:hover{background:#FEE2E2;}
.empty-state{text-align:center;padding:3rem 1rem;color:#6B7280;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Logbook Harian</h1>
    <div class="header-actions">
        <a href="{{ route('logbook.print') }}" class="btn-pdf">📄 Export PDF</a>
        <a href="{{ route('logbook.create') }}" class="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Aktivitas
        </a>
    </div>
</div>

@if($magang)
<div class="info-banner">
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem 1.5rem;align-items:center;">
        <span>
            <strong>Lowongan:</strong> {{ $magang->lowongan?->nama_low ?? '—' }}
        </span>
        <span style="color:#6B7280;">|</span>
        <span>
            <strong>Perusahaan:</strong> {{ $magang->lowongan?->mitra?->nama_mitra ?? '—' }}
        </span>
        @if($magang->tgl_mulai)
        <span style="color:#6B7280;">|</span>
        <span>
            <strong>Periode:</strong>
            {{ \Carbon\Carbon::parse($magang->tgl_mulai)->format('d/m/Y') }}
            &ndash;
            {{ $magang->tgl_selesai ? \Carbon\Carbon::parse($magang->tgl_selesai)->format('d/m/Y') : 'Sekarang' }}
        </span>
        @endif
        @if($magang->lowongan?->lokasi)
        <span style="color:#6B7280;">|</span>
        <span><strong>Lokasi:</strong> {{ $magang->lowongan->lokasi }}</span>
        @endif
    </div>
    @if($magang->spv || $magang->dosen)
    <div style="margin-top:0.5rem;padding-top:0.5rem;border-top:1px solid #BFDBFE;display:flex;flex-wrap:wrap;gap:0.5rem 1.5rem;">
        @if($magang->spv)
        <span><strong>Supervisor:</strong> {{ $magang->spv->nama_spv }} &mdash; <span style="opacity:0.8;">{{ $magang->spv->telepon_spv ?? '—' }}</span></span>
        @endif
        @if($magang->dosen)
        @if($magang->spv)<span style="color:#6B7280;">|</span>@endif
        <span><strong>Dosen Pembimbing:</strong> {{ $magang->dosen->nama_dosen }} &mdash; <span style="opacity:0.8;">NIP: {{ $magang->dosen->NIP ?? '—' }}</span></span>
        @endif
    </div>
    @endif
</div>
@endif

{{-- ===== CARDS PROJECT ===== --}}
@if($projects->isNotEmpty())
<div style="margin-bottom:1.5rem;">
    <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#6B7280;margin-bottom:0.75rem;">Project Magang Anda</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;">
        @foreach($projects as $proj)
        <div style="background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.1rem;border-left:4px solid {{ $proj->status_color }};">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.5rem;margin-bottom:0.5rem;">
                <p style="font-size:0.9rem;font-weight:700;color:#1E1B4B;margin:0;line-height:1.3;">{{ $proj->nama_project }}</p>
                <span style="display:inline-block;font-size:0.68rem;font-weight:700;padding:0.15rem 0.6rem;border-radius:20px;white-space:nowrap;
                    @if($proj->status=='aktif') background:#EEF2FF;color:#4F46E5;
                    @elseif($proj->status=='selesai') background:#ECFDF5;color:#059669;
                    @else background:#FEF3C7;color:#D97706; @endif">
                    {{ $proj->status_label }}
                </span>
            </div>
            @if($proj->teknologi)
            <p style="font-size:0.75rem;color:#4F46E5;margin:0 0 0.5rem;">🔧 {{ $proj->teknologi }}</p>
            @endif
            @if($proj->deskripsi)
            <p style="font-size:0.8rem;color:#6B7280;margin:0 0 0.5rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $proj->deskripsi }}</p>
            @endif
            <p style="font-size:0.75rem;color:#9CA3AF;margin:0;">
                {{ $proj->logbooks()->count() }} logbook terhubung
                @if($proj->tgl_mulai) &bull; Mulai {{ $proj->tgl_mulai->format('d/m/Y') }} @endif
            </p>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>#</th><th>Tanggal</th><th>Kegiatan</th><th>Project</th><th>Catatan SPV</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}</td>
                    <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $log->kegiatan }}</td>
                    <td>
                        @if($log->project)
                            <span style="display:inline-block;background:#EEF2FF;color:#4338CA;font-size:0.72rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $log->project->nama_project }}
                            </span>
                        @else
                            <span style="color:#9CA3AF;font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($log->catatan_spv)
                            <span style="display:inline-block;background:#ECFDF5;color:#065F46;font-size:0.72rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;">Ada Catatan</span>
                        @else
                            <span style="color:#9CA3AF;font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('logbook.show', $log->id) }}" class="btn-sm btn-view">Detail</a>
                            <a href="{{ route('logbook.edit', $log->id) }}" class="btn-sm btn-edit">Edit</a>
                            <form action="{{ route('logbook.destroy', $log->id) }}" method="POST" id="del-log-{{ $log->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-sm btn-del" onclick="confirmDelLog({{ $log->id }})">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p>Belum ada entri logbook. <a href="{{ route('logbook.create') }}" style="color:#4F46E5;font-weight:600;">Tambah sekarang.</a></p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
function confirmDelLog(id) {
    Swal.fire({title:'Hapus Logbook?',text:'Entri logbook ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#EF4444',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('del-log-'+id).submit();});
}
</script>
@endpush

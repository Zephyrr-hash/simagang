@extends('layouts.app')
@section('title', 'Bimbingan')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Bimbingan</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0;}
.btn-add{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;}
.btn-add:hover{opacity:0.88;color:#fff;}
.info-banner{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:#1E40AF;}
.info-banner strong{font-weight:700;}
.table-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;}
table{width:100%;border-collapse:collapse;}
thead tr{background:#4F46E5;}
thead th{padding:0.875rem 1rem;text-align:left;font-size:0.8rem;font-weight:600;color:#fff;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;}
tbody tr{border-bottom:1px solid #F3F4F6;transition:background 0.15s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#F5F3FF;}
tbody td{padding:0.875rem 1rem;font-size:0.875rem;color:#374151;vertical-align:middle;}
.feedback-badge{display:inline-block;background:#ECFDF5;color:#065F46;font-size:0.75rem;font-weight:600;padding:0.2rem 0.65rem;border-radius:20px;}
.feedback-badge.pending{background:#FEF3C7;color:#92400E;}
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
    <h1>Bimbingan</h1>
    <a href="{{ route('bimbingan.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Bimbingan
    </a>
</div>

@if($magang)
<div class="info-banner">
    <strong>Magang aktif:</strong> {{ $magang->lowongan?->nama_low ?? '—' }}
    @if($magang->dosen_id)
        &bull; Dosen Pembimbing: <strong>{{ $magang->dosen?->nama_dosen ?? '—' }}</strong>
    @else
        &bull; <span style="color:#D97706;">Dosen pembimbing belum ditugaskan.</span>
    @endif
</div>
@endif

<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>#</th><th>Tanggal</th><th>Catatan</th><th>File</th><th>Feedback</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($bimbingan as $i => $item)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_bimbingan)->format('d/m/Y') }}</td>
                    <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->catatan }}</td>
                    <td>
                        @if($item->file)
                            <a href="{{ asset('file/'.$item->file) }}" target="_blank" style="color:#4F46E5;font-size:0.8rem;">📎 Lihat File</a>
                        @else —
                        @endif
                    </td>
                    <td>
                        @if($item->feedback)
                            <span class="feedback-badge">Ada Feedback</span>
                        @else
                            <span class="feedback-badge pending">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('bimbingan.show', $item->id) }}" class="btn-sm btn-view">Detail</a>
                            <a href="{{ route('bimbingan.edit', $item->id) }}" class="btn-sm btn-edit">Edit</a>
                            <form action="{{ route('bimbingan.destroy', $item->id) }}" method="POST" id="del-bim-{{ $item->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-sm btn-del" onclick="confirmDelBim({{ $item->id }})">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p>Belum ada entri bimbingan. <a href="{{ route('bimbingan.create') }}" style="color:#4F46E5;font-weight:600;">Tambah sekarang.</a></p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
function confirmDelBim(id) {
    Swal.fire({title:'Hapus Bimbingan?',text:'Data bimbingan ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#EF4444',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('del-bim-'+id).submit();});
}
</script>
@endpush

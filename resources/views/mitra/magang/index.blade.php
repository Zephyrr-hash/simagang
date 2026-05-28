@extends('layouts.app')
@section('title', 'Mahasiswa Magang')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Mahasiswa Magang</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0 0 0.25rem;}
.page-header p{color:#6B7280;font-size:0.9rem;margin:0;}
.table-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;}
table{width:100%;border-collapse:collapse;}
thead tr{background:#4F46E5;}
thead th{padding:0.875rem 1rem;text-align:left;font-size:0.8rem;font-weight:600;color:#fff;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;}
tbody tr{border-bottom:1px solid #F3F4F6;transition:background 0.15s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#F5F3FF;}
tbody td{padding:0.875rem 1rem;font-size:0.875rem;color:#374151;vertical-align:middle;}
.btn-detail{display:inline-flex;align-items:center;gap:0.3rem;background:#EEF2FF;color:#4F46E5;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-detail:hover{background:#E0E7FF;color:#4F46E5;}
.btn-end{display:inline-flex;align-items:center;gap:0.3rem;background:#FEF3C7;color:#92400E;border:none;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;cursor:pointer;transition:background 0.15s;font-family:'Inter',sans-serif;}
.btn-end:hover{background:#FDE68A;}
.empty-state{text-align:center;padding:3rem 1rem;color:#6B7280;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Mahasiswa Magang</h1>
    <p>Daftar mahasiswa yang sedang atau telah menjalani magang di perusahaan Anda.</p>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Mahasiswa</th><th>Lowongan</th><th>Tgl Mulai</th><th>Tgl Selesai</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#1E1B4B;">{{ $item->mahasiswa?->nama_mhs ?? '—' }}</td>
                    <td>{{ $item->lowongan?->nama_low ?? '—' }}</td>
                    <td>{{ $item->tgl_mulai ? \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') : '—' }}</td>
                    <td>{{ $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') : '—' }}</td>
                    <td><x-badge-status :status="$item->approval" /></td>
                    <td>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="{{ route('magang.show', $item->id) }}" class="btn-detail">Detail</a>
                            @if($item->approval == \App\Models\Magang::DITERIMA)
                            <form action="{{ route('pendaftar.end', $item->id) }}" method="POST" id="end-{{ $item->id }}">
                                @csrf
                                <button type="button" class="btn-end" onclick="confirmEnd({{ $item->id }})">Akhiri</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7"><div class="empty-state"><p>Belum ada mahasiswa magang.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
function confirmEnd(id) {
    Swal.fire({title:'Akhiri Magang?',text:'Magang mahasiswa ini akan ditandai selesai.',icon:'question',showCancelButton:true,confirmButtonColor:'#D97706',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Akhiri',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('end-'+id).submit();});
}
</script>
@endpush

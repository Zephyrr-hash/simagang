@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Mahasiswa</li>
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
.status-badge{display:inline-block;padding:0.2rem 0.65rem;border-radius:20px;font-size:0.72rem;font-weight:600;}
.status-1{background:#FEF3C7;color:#92400E;}
.status-2{background:#D1FAE5;color:#065F46;}
.status-3{background:#DBEAFE;color:#1E40AF;}
.status-4{background:#EDE9FE;color:#4C1D95;}
.btn-detail{display:inline-flex;align-items:center;gap:0.3rem;background:#EEF2FF;color:#4F46E5;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-detail:hover{background:#E0E7FF;color:#4F46E5;}
.empty-state{text-align:center;padding:3rem 1rem;color:#6B7280;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Data Mahasiswa</h1>
    <p>Daftar mahasiswa yang terdaftar di departemen Anda.</p>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>#</th><th>Nama</th><th>NIM</th><th>Jurusan</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($mhs as $i => $item)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#1E1B4B;">{{ $item->nama_mhs }}</td>
                    <td>{{ $item->NIM ?? '—' }}</td>
                    <td>{{ $item->jurusan?->jurusan ?? '—' }}</td>
                    <td>
                        @php $statusLabels = [1=>'Belum Magang',2=>'Sedang Magang',3=>'Sudah Magang',4=>'Sedang Mengajukan']; @endphp
                        <span class="status-badge status-{{ $item->status_id }}">
                            {{ $statusLabels[$item->status_id] ?? '—' }}
                        </span>
                    </td>
                    <td><a href="{{ route('depart.detailMhs', $item->id) }}" class="btn-detail">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p>Belum ada mahasiswa terdaftar.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

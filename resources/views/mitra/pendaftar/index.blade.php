@extends('layouts.app')
@section('title', 'Pendaftar')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pendaftar</li>
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
.btn-review{display:inline-flex;align-items:center;gap:0.3rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:7px;padding:0.35rem 0.85rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:opacity 0.2s;}
.btn-review:hover{opacity:0.88;color:#fff;}
.empty-state{text-align:center;padding:3rem 1rem;color:#6B7280;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Pendaftar Baru</h1>
    <p>Mahasiswa yang mendaftar ke lowongan Anda dan menunggu review.</p>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Mahasiswa</th><th>Lowongan</th>
                @if(Auth::user()->role_id == \App\Models\Role::SUPERADMIN)
                <th>Perusahaan Mitra</th>
                @endif
                <th>Tanggal Daftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#1E1B4B;">{{ $item->mahasiswa?->nama_mhs ?? '—' }}</td>
                    <td>{{ $item->lowongan?->nama_low ?? '—' }}</td>
                    @if(Auth::user()->role_id == \App\Models\Role::SUPERADMIN)
                    <td style="font-size:0.8rem;color:#6B7280;">{{ $item->lowongan?->mitra?->nama_mitra ?? '—' }}</td>
                    @endif
                    <td>{{ $item->created_at?->format('d/m/Y') ?? '—' }}</td>
                    <td><a href="{{ route('pendaftar.edit', $item->id) }}" class="btn-review">Review</a></td>
                </tr>
                @empty
                <tr><td colspan="{{ Auth::user()->role_id == \App\Models\Role::SUPERADMIN ? 6 : 5 }}"><div class="empty-state"><p>Tidak ada pendaftar baru saat ini.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

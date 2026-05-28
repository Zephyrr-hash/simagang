@extends('layouts.app')
@section('title', 'Pengajuan Saya')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengajuan Saya</li>
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
.empty-state{text-align:center;padding:3rem 1rem;color:#6B7280;}
.empty-state svg{width:48px;height:48px;color:#D1D5DB;margin-bottom:0.75rem;}
.btn-cari{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:10px;padding:0.65rem 1.5rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;margin-top:1rem;}
.btn-cari:hover{opacity:0.88;color:#fff;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Pengajuan Saya</h1>
    <p>Daftar semua pengajuan magang yang pernah Anda ajukan.</p>
</div>

<div class="table-card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#1E1B4B;">{{ $item->lowongan?->nama_low ?? '—' }}</td>
                    <td>{{ $item->lowongan?->mitra?->nama_mitra ?? '—' }}</td>
                    <td>{{ $item->tgl_mulai ? \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') : '—' }}</td>
                    <td>{{ $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') : '—' }}</td>
                    <td><x-badge-status :status="$item->approval" /></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
                            <p>Belum ada pengajuan.</p>
                            <a href="{{ url('/') }}" class="btn-cari">Cari Lowongan</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

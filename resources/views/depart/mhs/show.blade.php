@extends('layouts.app')
@section('title', 'Detail Mahasiswa')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('depart.mhs') }}">Data Mahasiswa</a></li>
    <li class="breadcrumb-item active">{{ $mhs->nama_mhs }}</li>
</ol></nav>
@endsection
@push('styles')
<style>
.detail-grid{display:grid;grid-template-columns:280px 1fr;gap:1.25rem;max-width:900px;}
@media(max-width:767px){.detail-grid{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.card-title{font-size:1rem;font-weight:700;color:#1E1B4B;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:2px solid #EEF2FF;}
.mhs-avatar{width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #C7D2FE;display:block;margin:0 auto 0.75rem;}
.mhs-avatar-init{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;color:#fff;margin:0 auto 0.75rem;}
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.75rem;font-weight:600;color:#9CA3AF;min-width:100px;flex-shrink:0;padding-top:1px;}
.info-value{color:#1E1B4B;font-weight:500;}
.skill-badge{display:inline-block;background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:20px;margin:0.1rem;}
.status-badge{display:inline-block;padding:0.2rem 0.65rem;border-radius:20px;font-size:0.72rem;font-weight:600;}
.status-1{background:#FEF3C7;color:#92400E;}
.status-2{background:#D1FAE5;color:#065F46;}
.status-3{background:#DBEAFE;color:#1E40AF;}
.status-4{background:#EDE9FE;color:#4C1D95;}
.btn-back{display:inline-flex;align-items:center;gap:0.5rem;background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:all 0.2s;margin-top:1rem;}
.btn-back:hover{background:#F9FAFB;color:#374151;}
</style>
@endpush
@section('content')
<div class="detail-grid">
    <div class="card">
        <h2 class="card-title">Profil Mahasiswa</h2>
        @if($mhs->foto_mhs && file_exists(public_path('images/'.$mhs->foto_mhs)))
            <img src="{{ asset('images/'.$mhs->foto_mhs) }}" alt="{{ $mhs->nama_mhs }}" class="mhs-avatar">
        @else
            <div class="mhs-avatar-init">{{ strtoupper(substr($mhs->nama_mhs,0,1)) }}</div>
        @endif
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $mhs->nama_mhs }}</span></div>
        <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $mhs->NIM ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">{{ $mhs->telepon_mhs ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jurusan</span><span class="info-value">{{ $mhs->jurusan?->jurusan ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jenis Kelamin</span><span class="info-value">{{ $mhs->jenis_kelamin ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Tgl Lahir</span><span class="info-value">{{ $mhs->tgl_lahir ? \Carbon\Carbon::parse($mhs->tgl_lahir)->format('d/m/Y') : '—' }}</span></div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                @php $statusLabels = [1=>'Belum Magang',2=>'Sedang Magang',3=>'Sudah Magang',4=>'Sedang Mengajukan']; @endphp
                <span class="status-badge status-{{ $mhs->status_id }}">{{ $statusLabels[$mhs->status_id] ?? '—' }}</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Skill</span>
            <span class="info-value">
                @forelse($skill as $s)
                    <span class="skill-badge">{{ $s->skill }}</span>
                @empty <span style="color:#9CA3AF;font-style:italic;">—</span>
                @endforelse
            </span>
        </div>
    </div>

    <div class="card">
        <h2 class="card-title">Riwayat Magang</h2>
        @if($data)
            <div class="info-row"><span class="info-label">Lowongan</span><span class="info-value">{{ $data->nama_low ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Perusahaan</span><span class="info-value">{{ $data->nama_mitra ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Tgl Mulai</span><span class="info-value">{{ $data->tgl_mulai ? \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') : '—' }}</span></div>
            <div class="info-row"><span class="info-label">Tgl Selesai</span><span class="info-value">{{ $data->tgl_selesai ? \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') : '—' }}</span></div>
            @if($data->nilai !== null)
            <div class="info-row"><span class="info-label">Nilai</span><span class="info-value" style="font-weight:700;color:#4F46E5;">{{ $data->nilai }}</span></div>
            @endif
        @else
            <p style="color:#6B7280;font-size:0.875rem;">Belum ada riwayat magang.</p>
        @endif
    </div>
</div>
<a href="{{ route('depart.mhs') }}" class="btn-back">← Kembali</a>
@endsection

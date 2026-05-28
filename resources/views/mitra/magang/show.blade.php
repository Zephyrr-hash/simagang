@extends('layouts.app')
@section('title', 'Detail Magang')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('magang.index') }}">Mahasiswa Magang</a></li>
    <li class="breadcrumb-item active">Detail</li>
</ol></nav>
@endsection
@push('styles')
<style>
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;max-width:900px;}
@media(max-width:767px){.detail-grid{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.card-title{font-size:1rem;font-weight:700;color:#1E1B4B;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:2px solid #EEF2FF;}
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.75rem;font-weight:600;color:#9CA3AF;min-width:110px;flex-shrink:0;padding-top:1px;}
.info-value{color:#1E1B4B;font-weight:500;}
.skill-badge{display:inline-block;background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:20px;margin:0.1rem;}
.btn-back{display:inline-flex;align-items:center;gap:0.5rem;background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:all 0.2s;margin-top:1rem;}
.btn-back:hover{background:#F9FAFB;color:#374151;}
</style>
@endpush
@section('content')
<div class="detail-grid">
    <div class="card">
        <h2 class="card-title">Profil Mahasiswa</h2>
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $mhs->nama_mhs }}</span></div>
        <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $mhs->NIM ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">{{ $mhs->telepon_mhs ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jurusan</span><span class="info-value">{{ $mhs->jurusan?->jurusan ?? '—' }}</span></div>
        <div class="info-row">
            <span class="info-label">Skill</span>
            <span class="info-value">
                @forelse($skill as $s)
                    <span class="skill-badge">{{ $s->skill?->skill }}</span>
                @empty <span style="color:#9CA3AF;font-style:italic;">—</span>
                @endforelse
            </span>
        </div>
    </div>
    <div class="card">
        <h2 class="card-title">Detail Magang</h2>
        <div class="info-row"><span class="info-label">Lowongan</span><span class="info-value">{{ $magang->lowongan?->nama_low ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Tgl Mulai</span><span class="info-value">{{ $magang->tgl_mulai ? \Carbon\Carbon::parse($magang->tgl_mulai)->format('d/m/Y') : '—' }}</span></div>
        <div class="info-row"><span class="info-label">Tgl Selesai</span><span class="info-value">{{ $magang->tgl_selesai ? \Carbon\Carbon::parse($magang->tgl_selesai)->format('d/m/Y') : '—' }}</span></div>
        <div class="info-row"><span class="info-label">Supervisor</span><span class="info-value">{{ $magang->spv?->nama_spv ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Status</span><span class="info-value"><x-badge-status :status="$magang->approval" /></span></div>
        @if($magang->approval == \App\Models\Magang::DITERIMA)
        <form action="{{ route('pendaftar.end', $magang->id) }}" method="POST" id="end-form" style="margin-top:1rem;">
            @csrf
            <button type="button" onclick="Swal.fire({title:'Akhiri Magang?',icon:'question',showCancelButton:true,confirmButtonColor:'#D97706',cancelButtonColor:'#6B7280',confirmButtonText:'Ya',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('end-form').submit();})" style="background:#FEF3C7;color:#92400E;border:none;border-radius:9px;padding:0.65rem 1.5rem;font-weight:600;font-size:0.875rem;cursor:pointer;font-family:'Inter',sans-serif;">
                Akhiri Magang
            </button>
        </form>
        @endif
    </div>
</div>
<a href="{{ route('magang.index') }}" class="btn-back">← Kembali</a>
@endsection

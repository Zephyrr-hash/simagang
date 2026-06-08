@extends('layouts.app')
@section('title', $lowongan->nama_low)
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lowongan.index') }}">Lowongan</a></li>
    <li class="breadcrumb-item active">Detail</li>
</ol></nav>
@endsection
@push('styles')
<style>
.detail-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;width:100%;max-width:none;}
.detail-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.5rem 1.75rem;color:#fff;}
.detail-header h1{font-size:1.25rem;font-weight:700;margin:0 0 0.25rem;}
.detail-header p{font-size:0.85rem;opacity:0.85;margin:0;}
.detail-body{padding:1.75rem;}
.info-row{display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 0;border-bottom:1px solid #F3F4F6;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.78rem;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.4px;min-width:140px;flex-shrink:0;padding-top:1px;}
.info-value{font-size:0.9rem;color:#1E1B4B;font-weight:500;line-height:1.6;}
.btn-edit{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:10px;padding:0.65rem 1.5rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;margin-top:1.25rem;}
.btn-edit:hover{opacity:0.88;color:#fff;}
</style>
@endpush
@section('content')
<div class="detail-card">
    <div class="detail-header">
        <h1>{{ $lowongan->nama_low }}</h1>
        <p>Detail Lowongan</p>
    </div>
    <div class="detail-body">
        @if($lowongan->foto_low && file_exists(public_path('images/'.$lowongan->foto_low)))
            <img src="{{ asset('images/'.$lowongan->foto_low) }}" alt="{{ $lowongan->nama_low }}" style="width:100%;height:200px;object-fit:cover;border-radius:10px;margin-bottom:1.25rem;">
        @endif
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $lowongan->nama_low }}</span></div>
        <div class="info-row"><span class="info-label">Kategori</span><span class="info-value">{{ $lowongan->kategori?->kategori ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Deskripsi</span><span class="info-value">{{ $lowongan->deskripsi_low }}</span></div>
        <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">{{ $lowongan->telepon_low }}</span></div>
        <div class="info-row"><span class="info-label">Kuota</span><span class="info-value">{{ $lowongan->jumlah_mhs }} mahasiswa</span></div>
        <div class="info-row"><span class="info-label">Durasi</span><span class="info-value">{{ $lowongan->durasi }} bulan</span></div>
        <div class="info-row"><span class="info-label">Lokasi</span><span class="info-value">{{ $lowongan->lokasi }}</span></div>
        <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="btn-edit">Edit Lowongan</a>
    </div>
</div>
@endsection

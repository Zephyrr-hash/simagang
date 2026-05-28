@extends('layouts.app')
@section('title', 'Detail Bimbingan')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bimbingan.index') }}">Bimbingan</a></li>
    <li class="breadcrumb-item active">Detail</li>
</ol></nav>
@endsection
@push('styles')
<style>
.detail-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;max-width:640px;}
.detail-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.25rem 1.75rem;color:#fff;}
.detail-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.detail-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.detail-body{padding:1.75rem;}
.info-row{display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 0;border-bottom:1px solid #F3F4F6;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.78rem;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.4px;min-width:140px;flex-shrink:0;padding-top:1px;}
.info-value{font-size:0.9rem;color:#1E1B4B;font-weight:500;line-height:1.6;}
.feedback-box{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:10px;padding:1rem 1.25rem;margin-top:1.25rem;}
.feedback-box h3{font-size:0.875rem;font-weight:700;color:#065F46;margin:0 0 0.5rem;}
.feedback-box p{font-size:0.875rem;color:#065F46;margin:0;line-height:1.6;}
.no-feedback{background:#FEF3C7;border:1px solid #FDE68A;border-radius:10px;padding:1rem 1.25rem;margin-top:1.25rem;font-size:0.875rem;color:#92400E;}
.btn-back{display:inline-flex;align-items:center;gap:0.5rem;background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:all 0.2s;margin-top:1.25rem;}
.btn-back:hover{background:#F9FAFB;color:#374151;}
</style>
@endpush
@section('content')
<div class="detail-card">
    <div class="detail-header">
        <h1>Detail Bimbingan</h1>
        <p>{{ \Carbon\Carbon::parse($bimbingan->tgl_bimbingan)->translatedFormat('d F Y') }}</p>
    </div>
    <div class="detail-body">
        <div class="info-row">
            <span class="info-label">Tanggal</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($bimbingan->tgl_bimbingan)->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Catatan</span>
            <span class="info-value" style="white-space:pre-line;">{{ $bimbingan->catatan }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">File Laporan</span>
            <span class="info-value">
                @if($bimbingan->file)
                    <a href="{{ asset('file/'.$bimbingan->file) }}" target="_blank" style="color:#4F46E5;font-weight:600;">📎 Unduh File</a>
                @else
                    —
                @endif
            </span>
        </div>

        @if($bimbingan->feedback)
            <div class="feedback-box">
                <h3>✅ Feedback Dosen Pembimbing</h3>
                <p>{{ $bimbingan->feedback }}</p>
            </div>
        @else
            <div class="no-feedback">
                ⏳ Feedback dari dosen pembimbing belum tersedia.
            </div>
        @endif

        <a href="{{ route('bimbingan.index') }}" class="btn-back">← Kembali</a>
    </div>
</div>
@endsection

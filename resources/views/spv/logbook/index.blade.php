@extends('layouts.app')
@section('title', 'Logbook Mahasiswa')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Logbook Mahasiswa</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0 0 0.25rem;}
.page-header p{color:#6B7280;font-size:0.9rem;margin:0;}
.mhs-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}
@media(max-width:991px){.mhs-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:575px){.mhs-grid{grid-template-columns:1fr;}}
.mhs-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.25rem;transition:box-shadow 0.2s,transform 0.2s;}
.mhs-card:hover{box-shadow:0 4px 16px rgba(79,70,229,0.1);transform:translateY(-2px);}
.mhs-avatar{width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid #C7D2FE;flex-shrink:0;}
.mhs-avatar-init{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:700;color:#fff;flex-shrink:0;}
.mhs-name{font-size:0.95rem;font-weight:700;color:#1E1B4B;margin:0 0 0.15rem;}
.mhs-low{font-size:0.78rem;color:#6B7280;margin:0;}
.btn-review{display:block;width:100%;text-align:center;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:8px;padding:0.55rem 1rem;font-weight:600;font-size:0.8rem;text-decoration:none;transition:opacity 0.2s;margin-top:0.875rem;}
.btn-review:hover{opacity:0.88;color:#fff;}
.empty-state{text-align:center;padding:4rem 1rem;color:#6B7280;background:#fff;border:1px solid #E0E7FF;border-radius:12px;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Logbook Mahasiswa</h1>
    <p>Daftar mahasiswa yang Anda supervisi.</p>
</div>

@if($data->isEmpty())
<div class="empty-state"><p>Belum ada mahasiswa yang ditugaskan kepada Anda.</p></div>
@else
<div class="mhs-grid">
    @foreach($data as $item)
    <div class="mhs-card">
        <div style="display:flex;align-items:center;gap:0.875rem;">
            @if($item->foto_mhs && file_exists(public_path('images/'.$item->foto_mhs)))
                <img src="{{ asset('images/'.$item->foto_mhs) }}" alt="{{ $item->nama_mhs }}" class="mhs-avatar">
            @else
                <div class="mhs-avatar-init">{{ strtoupper(substr($item->nama_mhs,0,1)) }}</div>
            @endif
            <div>
                <p class="mhs-name">{{ $item->nama_mhs }}</p>
                <p class="mhs-low">{{ $item->nama_low ?? 'Lowongan tidak diketahui' }}</p>
            </div>
        </div>
        <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid #F3F4F6;">
            <x-badge-status :status="$item->approval" />
        </div>
        <a href="{{ route('spv.logbook', $item->mhs_id) }}" class="btn-review">Lihat Logbook</a>
    </div>
    @endforeach
</div>
@endif
@endsection

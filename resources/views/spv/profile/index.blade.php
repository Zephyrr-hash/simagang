@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
</ol></nav>
@endsection
@push('styles')
<style>
.profile-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;width:100%;max-width:none;}
.profile-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:2rem;display:flex;align-items:center;gap:1.5rem;}
.profile-avatar{width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.4);flex-shrink:0;}
.profile-avatar-init{width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;color:#fff;flex-shrink:0;border:3px solid rgba(255,255,255,0.4);}
.profile-header-info h1{font-size:1.25rem;font-weight:700;color:#fff;margin:0 0 0.2rem;}
.profile-header-info p{font-size:0.85rem;color:rgba(255,255,255,0.8);margin:0;}
.profile-body{padding:1.75rem;}
.info-row{display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 0;border-bottom:1px solid #F3F4F6;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.78rem;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.4px;min-width:140px;flex-shrink:0;padding-top:1px;}
.info-value{font-size:0.9rem;color:#1E1B4B;font-weight:500;}
.btn-edit{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:10px;padding:0.65rem 1.5rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;margin-top:1.25rem;}
.btn-edit:hover{opacity:0.88;color:#fff;}
</style>
@endpush
@section('content')
@php $editUrl = $profile ? route('profile.edit', $profile->id) : '#'; @endphp
@include('components.profile-incomplete-banner', ['editUrl' => $editUrl])
<div class="profile-card">
    <div class="profile-header">
        @if($profile?->foto_spv && file_exists(public_path('images/'.$profile->foto_spv)))
            <img src="{{ asset('images/'.$profile->foto_spv) }}" alt="Foto" class="profile-avatar">
        @else
            <div class="profile-avatar-init">{{ strtoupper(substr($authProfile['nama'],0,1)) }}</div>
        @endif
        <div class="profile-header-info">
            <h1>{{ $authProfile['nama'] }}</h1>
            <p>Supervisor</p>
        </div>
    </div>
    <div class="profile-body">
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $profile?->nama_spv ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">No. Pegawai</span><span class="info-value">{{ $profile?->no_pegawai ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">{{ $profile?->telepon_spv ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Mitra</span><span class="info-value">{{ $profile?->mitra?->nama_mitra ?? '—' }}</span></div>
        @if($profile)
        <a href="{{ route('profile.edit', $profile->id) }}" class="btn-edit">Edit Profil</a>
        @else
        <a href="{{ route('profile.create') }}" class="btn-edit">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
            Buat Profil
        </a>
        @endif
    </div>
</div>
@endsection

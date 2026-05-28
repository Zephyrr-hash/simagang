@extends('layouts.app')
@section('title', 'Buat Lowongan')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lowongan.index') }}">Lowongan</a></li>
    <li class="breadcrumb-item active">Buat Baru</li>
</ol></nav>
@endsection
@push('styles')
<style>
.form-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;max-width:680px;}
.form-card-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.25rem 1.75rem;color:#fff;}
.form-card-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.form-card-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.form-card-body{padding:1.75rem;}
.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.form-label .req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.65rem 1rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:575px){.form-row{grid-template-columns:1fr;}}
.form-actions{display:flex;gap:0.75rem;padding-top:1.25rem;border-top:1px solid #F3F4F6;margin-top:0.5rem;}
.btn-save{background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.75rem;font-weight:600;font-size:0.9rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
.btn-save:hover{opacity:0.88;}
.btn-cancel{background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;}
.btn-cancel:hover{background:#F9FAFB;color:#374151;}
.error-alert{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.875rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#DC2626;}
.error-alert ul{margin:0.4rem 0 0;padding-left:1.25rem;}
</style>
@endpush
@section('content')
<div class="form-card">
    <div class="form-card-header">
        <h1>Buat Lowongan Baru</h1>
        <p>Isi detail lowongan magang yang ingin Anda posting.</p>
    </div>
    <div class="form-card-body">
        @if(session('errorForm'))
        <div class="error-alert"><strong>Terdapat kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach@endforeach</ul></div>
        @endif
        <form action="{{ route('lowongan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="mitra_id" value="{{ $mitra->id }}">
            <div class="form-group">
                <label class="form-label">Nama Lowongan <span class="req">*</span></label>
                <input type="text" name="nama_low" class="form-control-c" value="{{ old('nama_low') }}" placeholder="Contoh: Frontend Developer Intern" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi <span class="req">*</span></label>
                <textarea name="deskripsi_low" class="form-control-c" rows="5" placeholder="Jelaskan tugas, kualifikasi, dan benefit..." required>{{ old('deskripsi_low') }}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori <span class="req">*</span></label>
                    <select name="kategori_id" class="form-control-c" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon <span class="req">*</span></label>
                    <input type="text" name="telepon_low" class="form-control-c" value="{{ old('telepon_low') }}" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kuota Mahasiswa <span class="req">*</span></label>
                    <input type="number" name="jumlah_mhs" class="form-control-c" value="{{ old('jumlah_mhs', 1) }}" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (bulan) <span class="req">*</span></label>
                    <input type="number" name="durasi" class="form-control-c" value="{{ old('durasi', 3) }}" min="1" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi <span class="req">*</span></label>
                <input type="text" name="lokasi" class="form-control-c" value="{{ old('lokasi') }}" placeholder="Contoh: Jakarta Selatan" required>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Lowongan <span class="req">*</span></label>
                <input type="file" name="foto_low" class="form-control-c" accept="image/jpeg,image/png,image/jpg" required>
                <p style="font-size:0.75rem;color:#9CA3AF;margin-top:0.3rem;">Format: JPG, PNG. Maks 2MB.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Posting Lowongan</button>
                <a href="{{ route('lowongan.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

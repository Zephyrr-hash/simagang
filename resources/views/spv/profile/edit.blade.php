@extends('layouts.app')
@section('title', 'Edit Profil')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profil</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol></nav>
@endsection
@push('styles')
<style>
.form-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;width:100%;max-width:none;}
.form-card-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.25rem 1.75rem;color:#fff;}
.form-card-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.form-card-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.form-card-body{padding:1.75rem;}
.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.form-label .req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.65rem 1rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
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
        <h1>Edit Profil Supervisor</h1>
        <p>Perbarui informasi profil Anda.</p>
    </div>
    <div class="form-card-body">
        @if(session('errorForm'))
        <div class="error-alert"><strong>Terdapat kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach @endforeach</ul></div>
        @endif
        <form action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama_spv" class="form-control-c" value="{{ old('nama_spv', $profile?->nama_spv) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Pegawai <span class="req">*</span></label>
                <input type="text" name="no_pegawai" class="form-control-c" value="{{ old('no_pegawai', $profile?->no_pegawai) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Telepon <span class="req">*</span></label>
                <input type="text" name="telepon_spv" class="form-control-c" value="{{ old('telepon_spv', $profile?->telepon_spv) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mitra <span class="req">*</span></label>
                <select name="mitra_id" class="form-control-c" required>
                    <option value="">-- Pilih Mitra --</option>
                    @foreach($mitras as $m)
                        <option value="{{ $m->id }}" {{ old('mitra_id', $profile?->mitra_id) == $m->id ? 'selected' : '' }}>{{ $m->nama_mitra }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Profil</label>
                @if($profile?->foto_spv)<p style="font-size:0.8rem;color:#6B7280;margin-bottom:0.4rem;">Foto saat ini: {{ $profile->foto_spv }}</p>@endif
                <input type="file" name="foto_spv" class="form-control-c" accept="image/jpeg,image/png,image/jpg">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
                <a href="{{ route('profile.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

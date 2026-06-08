@extends('layouts.app')
@section('title', 'Edit Laporan Bimbingan')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('project.show', $project->id) }}">{{ $project->nama_project }}</a></li>
    <li class="breadcrumb-item active">Edit Bimbingan</li>
</ol></nav>
@endsection
@push('styles')
<style>
.form-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;max-width:640px;}
.form-card-header{background:linear-gradient(135deg,#7C3AED,#4F46E5);padding:1.25rem 1.75rem;color:#fff;}
.form-card-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.form-card-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.form-card-body{padding:1.75rem;}
.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.65rem 1rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#7C3AED;background:#fff;box-shadow:0 0 0 3px rgba(124,58,237,0.1);}
.form-actions{display:flex;gap:0.75rem;padding-top:1.25rem;border-top:1px solid #F3F4F6;margin-top:0.5rem;}
.btn-save{background:linear-gradient(135deg,#7C3AED,#4F46E5);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.75rem;font-weight:600;font-size:0.9rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
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
        <h1>Edit Laporan Bimbingan</h1>
        <p>{{ \Carbon\Carbon::parse($bimbingan->tgl_bimbingan)->translatedFormat('d F Y') }}</p>
    </div>
    <div class="form-card-body">
        @if(session('errorForm'))
        <div class="error-alert"><strong>Kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach @endforeach</ul></div>
        @endif
        <form action="{{ route('project.bimbingan.update', [$project->id, $bimbingan->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Tanggal Bimbingan <span class="req">*</span></label>
                <input type="date" name="tgl_bimbingan" class="form-control-c" value="{{ old('tgl_bimbingan', $bimbingan->tgl_bimbingan) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan / Laporan Progress <span class="req">*</span></label>
                <textarea name="catatan" class="form-control-c" rows="5" required>{{ old('catatan', $bimbingan->catatan) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Ganti File (opsional)</label>
                @if($bimbingan->file)
                <p style="font-size:0.8rem;color:#6B7280;margin-bottom:0.4rem;">File saat ini: <a href="{{ asset('file/'.$bimbingan->file) }}" target="_blank" style="color:#4F46E5;">{{ $bimbingan->file }}</a></p>
                @endif
                <input type="file" name="file" class="form-control-c" accept=".pdf,.doc,.docx">
                <p style="font-size:0.75rem;color:#9CA3AF;margin-top:0.3rem;">Biarkan kosong untuk mempertahankan file lama.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
                <a href="{{ route('project.show', $project->id) }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

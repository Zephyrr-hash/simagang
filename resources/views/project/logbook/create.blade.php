@extends('layouts.app')
@section('title', 'Tambah Logbook')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></li>
    <li class="breadcrumb-item"><a href="{{ route('project.show', $project->id) }}">{{ $project->nama_project }}</a></li>
    <li class="breadcrumb-item active">Tambah Logbook</li>
</ol></nav>
@endsection
@push('styles')
<style>
.form-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;max-width:640px;}
.form-card-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.25rem 1.75rem;color:#fff;}
.form-card-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.form-card-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.form-card-body{padding:1.75rem;}
.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.65rem 1rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
.form-actions{display:flex;gap:0.75rem;padding-top:1.25rem;border-top:1px solid #F3F4F6;margin-top:0.5rem;}
.btn-save{background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.75rem;font-weight:600;font-size:0.9rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
.btn-save:hover{opacity:0.88;}
.btn-cancel{background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;}
.btn-cancel:hover{background:#F9FAFB;color:#374151;}
.error-alert{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.875rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#DC2626;}
.error-alert ul{margin:0.4rem 0 0;padding-left:1.25rem;}
.proj-badge{display:inline-flex;align-items:center;gap:0.4rem;background:#EEF2FF;color:#4F46E5;border-radius:8px;padding:0.4rem 0.875rem;font-size:0.8rem;font-weight:600;margin-bottom:1.25rem;}
</style>
@endpush
@section('content')
<div class="form-card">
    <div class="form-card-header">
        <h1>Tambah Logbook</h1>
        <p>Catat aktivitas harian dalam project ini.</p>
    </div>
    <div class="form-card-body">
        <div class="proj-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4z"/></svg>
            {{ $project->nama_project }}
        </div>
        @if(session('errorForm'))
        <div class="error-alert"><strong>Kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach @endforeach</ul></div>
        @endif
        <form action="{{ route('project.logbook.store', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Tanggal <span class="req">*</span></label>
                <input type="date" name="tanggal" class="form-control-c" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kegiatan <span class="req">*</span></label>
                <input type="text" name="kegiatan" class="form-control-c" value="{{ old('kegiatan') }}" placeholder="Contoh: Implementasi fitur login" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Kegiatan <span class="req">*</span></label>
                <textarea name="deskripsi_log" class="form-control-c" rows="4" placeholder="Jelaskan detail kegiatan..." required>{{ old('deskripsi_log') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Saran / Catatan</label>
                <textarea name="saran" class="form-control-c" rows="3" placeholder="Saran perbaikan atau catatan tambahan...">{{ old('saran') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Lampiran File <span style="font-size:0.75rem;color:#9CA3AF;font-weight:400;">(opsional)</span></label>
                <input type="file" name="file" class="form-control-c" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <p style="font-size:0.75rem;color:#9CA3AF;margin-top:0.3rem;">Format: PDF, DOC, DOCX, JPG, PNG. Maks 5MB.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Logbook</button>
                <a href="{{ route('project.show', $project->id) }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

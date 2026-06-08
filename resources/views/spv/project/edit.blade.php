@extends('layouts.app')
@section('title', 'Edit Project')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spv.project.index') }}">Project</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spv.project.show', $project->id) }}">{{ $project->nama_project }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
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
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:575px){.form-row-2{grid-template-columns:1fr;}}
.form-actions{display:flex;gap:0.75rem;padding-top:1.25rem;border-top:1px solid #F3F4F6;margin-top:0.5rem;}
.btn-save{background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.75rem;font-weight:600;font-size:0.9rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
.btn-save:hover{opacity:0.88;}
.btn-cancel{background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;}
.btn-cancel:hover{background:#F9FAFB;color:#374151;}
.error-alert{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.875rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#DC2626;}
.error-alert ul{margin:0.4rem 0 0;padding-left:1.25rem;}
.mhs-info{background:#F5F3FF;border:1px solid #DDD6FE;border-radius:9px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#4C1D95;}
</style>
@endpush
@section('content')
<div class="form-card">
    <div class="form-card-header">
        <h1>Edit Project</h1>
        <p>{{ $project->nama_project }}</p>
    </div>
    <div class="form-card-body">
        @if(session('errorForm'))
        <div class="error-alert"><strong>Terdapat kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach @endforeach</ul></div>
        @endif

        {{-- Info mahasiswa (read-only) --}}
        <div class="mhs-info">
            <strong>Mahasiswa:</strong> {{ $project->magang?->mahasiswa?->nama_mhs ?? '—' }}
            &mdash; {{ $project->magang?->lowongan?->nama_low ?? '—' }}
        </div>

        <form action="{{ route('spv.project.update', $project->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Project <span class="req">*</span></label>
                <input type="text" name="nama_project" class="form-control-c"
                       value="{{ old('nama_project', $project->nama_project) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Project</label>
                <textarea name="deskripsi" class="form-control-c" rows="3">{{ old('deskripsi', $project->deskripsi) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tujuan / Scope</label>
                <textarea name="tujuan" class="form-control-c" rows="3">{{ old('tujuan', $project->tujuan) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Teknologi / Tools</label>
                <input type="text" name="teknologi" class="form-control-c"
                       value="{{ old('teknologi', $project->teknologi) }}">
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Status <span class="req">*</span></label>
                    <select name="status" class="form-control-c" required>
                        <option value="aktif"   {{ old('status', $project->status) == 'aktif'   ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="selesai" {{ old('status', $project->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div></div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control-c"
                           value="{{ old('tgl_mulai', $project->tgl_mulai?->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control-c"
                           value="{{ old('tgl_selesai', $project->tgl_selesai?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
                <a href="{{ route('spv.project.show', $project->id) }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

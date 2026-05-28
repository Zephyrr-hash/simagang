@extends('layouts.app')
@section('title', 'Review Pendaftar')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pendaftar.index') }}">Pendaftar</a></li>
    <li class="breadcrumb-item active">Review</li>
</ol></nav>
@endsection
@push('styles')
<style>
.review-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;max-width:900px;}
@media(max-width:767px){.review-grid{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.card-title{font-size:1rem;font-weight:700;color:#1E1B4B;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:2px solid #EEF2FF;}
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.75rem;font-weight:600;color:#9CA3AF;min-width:110px;flex-shrink:0;padding-top:1px;}
.info-value{color:#1E1B4B;font-weight:500;}
.skill-badge{display:inline-block;background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:20px;margin:0.1rem;}
.form-group{margin-bottom:1rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.form-label .req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.6rem 0.9rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
.action-btns{display:flex;gap:0.75rem;margin-top:1.25rem;flex-wrap:wrap;}
.btn-approve{background:linear-gradient(135deg,#059669,#10B981);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.5rem;font-weight:600;font-size:0.875rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
.btn-approve:hover{opacity:0.88;}
.btn-reject{background:#FEF2F2;color:#EF4444;border:1.5px solid #FECACA;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;cursor:pointer;transition:all 0.2s;font-family:'Inter',sans-serif;}
.btn-reject:hover{background:#FEE2E2;}
.btn-back{background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:all 0.2s;}
.btn-back:hover{background:#F9FAFB;color:#374151;}
</style>
@endpush
@section('content')
<div class="review-grid">
    {{-- Profil Mahasiswa --}}
    <div class="card">
        <h2 class="card-title">Profil Mahasiswa</h2>
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $mhs->nama_mhs }}</span></div>
        <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $mhs->NIM ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">{{ $mhs->telepon_mhs ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jurusan</span><span class="info-value">{{ $mhs->jurusan?->jurusan ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jenis Kelamin</span><span class="info-value">{{ $mhs->jenis_kelamin ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Pengalaman</span><span class="info-value">{{ $mhs->pengalaman ?? '—' }}</span></div>
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

    {{-- Form Approval --}}
    <div class="card">
        <h2 class="card-title">Keputusan Penerimaan</h2>
        <p style="font-size:0.85rem;color:#6B7280;margin-bottom:1rem;">Lowongan: <strong>{{ $magang->lowongan?->nama_low ?? '—' }}</strong></p>

        <form action="{{ route('pendaftar.approval', $magang->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Tanggal Mulai <span class="req">*</span></label>
                <input type="date" name="tgl_mulai" class="form-control-c" value="{{ old('tgl_mulai') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Selesai <span class="req">*</span></label>
                <input type="date" name="tgl_selesai" class="form-control-c" value="{{ old('tgl_selesai') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Supervisor <span class="req">*</span></label>
                <select name="spv_id" class="form-control-c" required>
                    <option value="">-- Pilih Supervisor --</option>
                    @foreach($spv as $s)
                        <option value="{{ $s->id }}" {{ old('spv_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_spv }}</option>
                    @endforeach
                </select>
            </div>
            <div class="action-btns">
                <button type="submit" name="action" value="approve" class="btn-approve">✓ Terima</button>
                <button type="submit" name="action" value="reject" class="btn-reject">✗ Tolak</button>
                <a href="{{ route('pendaftar.index') }}" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

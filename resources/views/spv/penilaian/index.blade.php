@extends('layouts.app')
@section('title', 'Penilaian')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Penilaian</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0 0 0.25rem;}
.page-header p{color:#6B7280;font-size:0.9rem;margin:0;}
.penilaian-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;}
@media(max-width:767px){.penilaian-grid{grid-template-columns:1fr;}}
.penilaian-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.mhs-info{display:flex;align-items:center;gap:0.875rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid #F3F4F6;}
.mhs-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #C7D2FE;flex-shrink:0;}
.mhs-avatar-init{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:#fff;flex-shrink:0;}
.mhs-name{font-size:0.95rem;font-weight:700;color:#1E1B4B;margin:0 0 0.15rem;}
.mhs-low{font-size:0.78rem;color:#6B7280;margin:0;}
.form-group{margin-bottom:1rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.form-label .req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.6rem 0.9rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
.btn-nilai{background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.6rem 1.5rem;font-weight:600;font-size:0.875rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;width:100%;margin-top:0.5rem;}
.btn-nilai:hover{opacity:0.88;}
.nilai-badge{display:inline-flex;align-items:center;gap:0.4rem;background:#ECFDF5;color:#065F46;font-size:0.875rem;font-weight:700;padding:0.4rem 1rem;border-radius:8px;margin-bottom:0.75rem;}
.keterangan-box{background:#F5F3FF;border:1px solid #DDD6FE;border-radius:8px;padding:0.75rem 1rem;font-size:0.85rem;color:#4C1D95;line-height:1.6;}
.empty-state{text-align:center;padding:4rem 1rem;color:#6B7280;background:#fff;border:1px solid #E0E7FF;border-radius:12px;}
.error-alert{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.875rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#DC2626;}
.error-alert ul{margin:0.4rem 0 0;padding-left:1.25rem;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Penilaian Mahasiswa</h1>
    <p>Berikan nilai akhir untuk mahasiswa yang telah menyelesaikan magang.</p>
</div>

@if(session('errorForm'))
<div class="error-alert"><strong>Terdapat kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach@endforeach</ul></div>
@endif

@if($data->isEmpty())
<div class="empty-state"><p>Belum ada mahasiswa yang menyelesaikan magang.</p></div>
@else
<div class="penilaian-grid">
    @foreach($data as $item)
    <div class="penilaian-card">
        <div class="mhs-info">
            @if($item->mahasiswa?->foto_mhs && file_exists(public_path('images/'.$item->mahasiswa->foto_mhs)))
                <img src="{{ asset('images/'.$item->mahasiswa->foto_mhs) }}" alt="{{ $item->mahasiswa->nama_mhs }}" class="mhs-avatar">
            @else
                <div class="mhs-avatar-init">{{ strtoupper(substr($item->mahasiswa?->nama_mhs ?? 'M',0,1)) }}</div>
            @endif
            <div>
                <p class="mhs-name">{{ $item->mahasiswa?->nama_mhs ?? '—' }}</p>
                <p class="mhs-low">{{ $item->lowongan?->nama_low ?? '—' }}</p>
            </div>
        </div>

        @if($item->nilai !== null)
            {{-- Sudah dinilai --}}
            <div class="nilai-badge">⭐ Nilai: {{ $item->nilai }}</div>
            <div class="keterangan-box">{{ $item->keterangan }}</div>
            <form action="{{ route('spv.score', $item->mag_id) }}" method="POST" style="margin-top:0.875rem;">
                @csrf
                <div class="form-group">
                    <label class="form-label">Ubah Nilai <span class="req">*</span></label>
                    <input type="number" name="nilai" class="form-control-c" value="{{ $item->nilai }}" min="0" max="100" step="0.1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan <span class="req">*</span></label>
                    <textarea name="keterangan" class="form-control-c" rows="2" required>{{ $item->keterangan }}</textarea>
                </div>
                <button type="submit" class="btn-nilai">Perbarui Nilai</button>
            </form>
        @else
            {{-- Belum dinilai --}}
            <form action="{{ route('spv.score', $item->mag_id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nilai (0–100) <span class="req">*</span></label>
                    <input type="number" name="nilai" class="form-control-c" placeholder="Contoh: 85" min="0" max="100" step="0.1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan <span class="req">*</span></label>
                    <textarea name="keterangan" class="form-control-c" rows="3" placeholder="Tuliskan evaluasi singkat kinerja mahasiswa..." required></textarea>
                </div>
                <button type="submit" class="btn-nilai">Simpan Nilai</button>
            </form>
        @endif
    </div>
    @endforeach
</div>
@endif
@endsection

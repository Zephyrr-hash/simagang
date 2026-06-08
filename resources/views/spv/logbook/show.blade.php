@extends('layouts.app')
@section('title', 'Logbook Mahasiswa')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('supervisor.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spv.index') }}">Logbook</a></li>
    <li class="breadcrumb-item active">{{ $mhs->nama_mhs }}</li>
</ol></nav>
@endsection
@push('styles')
<style>
.detail-grid{display:grid;grid-template-columns:280px 1fr;gap:1.25rem;max-width:1000px;}
@media(max-width:767px){.detail-grid{grid-template-columns:1fr;}}
.card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;padding:1.5rem;}
.card-title{font-size:1rem;font-weight:700;color:#1E1B4B;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:2px solid #EEF2FF;}
.mhs-avatar{width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #C7D2FE;display:block;margin:0 auto 0.75rem;}
.mhs-avatar-init{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:700;color:#fff;margin:0 auto 0.75rem;}
.info-row{display:flex;align-items:flex-start;gap:0.5rem;padding:0.5rem 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:0.75rem;font-weight:600;color:#9CA3AF;min-width:90px;flex-shrink:0;padding-top:1px;}
.info-value{color:#1E1B4B;font-weight:500;}
.skill-badge{display:inline-block;background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:600;padding:0.15rem 0.55rem;border-radius:20px;margin:0.1rem;}
.log-item{background:#F8F7FF;border:1px solid #E0E7FF;border-radius:10px;padding:1rem 1.25rem;margin-bottom:0.875rem;}
.log-date{font-size:0.78rem;font-weight:600;color:#4F46E5;margin-bottom:0.4rem;}
.log-kegiatan{font-size:0.9rem;font-weight:600;color:#1E1B4B;margin-bottom:0.4rem;}
.log-desc{font-size:0.85rem;color:#374151;line-height:1.6;margin-bottom:0.5rem;}
.log-saran{font-size:0.82rem;color:#6B7280;font-style:italic;margin-bottom:0.75rem;}
.catatan-form{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:9px;padding:1rem;}
.catatan-form label{display:block;font-size:0.78rem;font-weight:600;color:#065F46;margin-bottom:0.4rem;}
.catatan-form textarea{width:100%;padding:0.6rem 0.9rem;border:1.5px solid #A7F3D0;border-radius:8px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#fff;outline:none;resize:vertical;transition:border-color 0.2s;}
.catatan-form textarea:focus{border-color:#059669;box-shadow:0 0 0 3px rgba(5,150,105,0.1);}
.btn-catatan{background:linear-gradient(135deg,#059669,#10B981);color:#fff;border:none;border-radius:8px;padding:0.55rem 1.25rem;font-weight:600;font-size:0.8rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;margin-top:0.75rem;}
.btn-catatan:hover{opacity:0.88;}
.existing-catatan{background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;padding:0.75rem 1rem;font-size:0.85rem;color:#065F46;}
.existing-catatan strong{display:block;font-size:0.75rem;margin-bottom:0.25rem;}
.empty-state{text-align:center;padding:2rem 1rem;color:#6B7280;}
</style>
@endpush
@section('content')
<div class="detail-grid">
    {{-- Profil Mahasiswa --}}
    <div class="card">
        <h2 class="card-title">Profil Mahasiswa</h2>
        @if($mhs->foto_mhs && file_exists(public_path('images/'.$mhs->foto_mhs)))
            <img src="{{ asset('images/'.$mhs->foto_mhs) }}" alt="{{ $mhs->nama_mhs }}" class="mhs-avatar">
        @else
            <div class="mhs-avatar-init">{{ strtoupper(substr($mhs->nama_mhs,0,1)) }}</div>
        @endif
        <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $mhs->nama_mhs }}</span></div>
        <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $mhs->NIM ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Jurusan</span><span class="info-value">{{ $mhs->jurusan?->jurusan ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Status</span><span class="info-value">{{ $mhs->status?->status ?? '—' }}</span></div>
        @if(isset($mag) && $mag)
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #EEF2FF;">
            <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#6B7280;margin-bottom:0.6rem;">Detail Magang</p>
            <div class="info-row"><span class="info-label">Lowongan</span><span class="info-value">{{ $mag->lowongan?->nama_low ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Perusahaan</span><span class="info-value">{{ $mag->lowongan?->mitra?->nama_mitra ?? '—' }}</span></div>
            @if($mag->tgl_mulai)
            <div class="info-row"><span class="info-label">Mulai</span><span class="info-value">{{ \Carbon\Carbon::parse($mag->tgl_mulai)->format('d/m/Y') }}</span></div>
            <div class="info-row"><span class="info-label">Selesai</span><span class="info-value">{{ $mag->tgl_selesai ? \Carbon\Carbon::parse($mag->tgl_selesai)->format('d/m/Y') : '—' }}</span></div>
            @endif
            @if($mag->dosen)
            <div class="info-row"><span class="info-label">Dospem</span><span class="info-value">{{ $mag->dosen->nama_dosen }}</span></div>
            @endif
        </div>
        @endif
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

    {{-- Daftar Logbook --}}
    <div class="card">
        <h2 class="card-title">Logbook Harian ({{ $data->count() }} entri)</h2>
        @forelse($data as $log)
        <div class="log-item">
            <p class="log-date">📅 {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}</p>
            <p class="log-kegiatan">{{ $log->kegiatan }}</p>
            <p class="log-desc">{{ $log->deskripsi_log }}</p>
            <p class="log-saran">💡 {{ $log->saran }}</p>

            @if($log->catatan_spv)
                <div class="existing-catatan">
                    <strong>✅ Catatan Anda:</strong>
                    {{ $log->catatan_spv }}
                </div>
            @else
                <div class="catatan-form">
                    <form action="{{ route('spv.catatan', $log->id) }}" method="POST">
                        @csrf
                        <label>Berikan Catatan:</label>
                        <textarea name="catatan_spv" rows="2" placeholder="Tulis catatan atau arahan untuk mahasiswa..."></textarea>
                        <button type="submit" class="btn-catatan">Simpan Catatan</button>
                    </form>
                </div>
            @endif
        </div>
        @empty
        <div class="empty-state"><p>Belum ada entri logbook dari mahasiswa ini.</p></div>
        @endforelse
    </div>
</div>
@endsection

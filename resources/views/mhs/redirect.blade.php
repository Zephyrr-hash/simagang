@extends('layouts.app')
@section('title', 'Akses Ditolak')
@section('content')
<div style="text-align:center;padding:4rem 1rem;">
    <div style="font-size:4rem;margin-bottom:1rem;">🔒</div>
    <h2 style="font-size:1.5rem;font-weight:700;color:#1E1B4B;margin-bottom:0.5rem;">Akses Terbatas</h2>
    <p style="color:#6B7280;margin-bottom:1.5rem;">Anda belum memiliki magang yang aktif untuk mengakses halaman ini.</p>
    <a href="{{ route('mahasiswa.home') }}" style="background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border-radius:10px;padding:0.65rem 1.5rem;font-weight:600;text-decoration:none;">
        Kembali ke Dashboard
    </a>
</div>
@endsection

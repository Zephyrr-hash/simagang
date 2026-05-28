@extends('layouts.app')
@section('title', 'Lowongan Saya')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Lowongan</li>
</ol></nav>
@endsection
@push('styles')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;}
.page-header h1{font-size:1.4rem;font-weight:700;color:#1E1B4B;margin:0;}
.btn-add{display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.25rem;font-weight:600;font-size:0.875rem;text-decoration:none;transition:opacity 0.2s;}
.btn-add:hover{opacity:0.88;color:#fff;}
.low-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}
@media(max-width:991px){.low-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:575px){.low-grid{grid-template-columns:1fr;}}
.low-card{background:#fff;border:1px solid #E0E7FF;border-radius:12px;overflow:hidden;transition:box-shadow 0.2s,transform 0.2s;}
.low-card:hover{box-shadow:0 8px 24px rgba(79,70,229,0.12);transform:translateY(-2px);}
.low-card-img{width:100%;height:160px;object-fit:cover;display:block;}
.low-card-img-placeholder{width:100%;height:160px;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:2.5rem;}
.low-card-body{padding:1rem 1.25rem;}
.low-card-badge{display:inline-block;background:#EEF2FF;color:#4F46E5;font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;margin-bottom:0.5rem;text-transform:uppercase;}
.low-card-title{font-size:0.95rem;font-weight:700;color:#1E1B4B;margin-bottom:0.5rem;line-height:1.3;}
.low-card-meta{font-size:0.8rem;color:#6B7280;margin-bottom:0.75rem;}
.low-card-kuota{display:inline-flex;align-items:center;gap:0.3rem;background:#ECFDF5;color:#059669;font-size:0.78rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;margin-bottom:0.75rem;}
.low-card-kuota.full{background:#FEF2F2;color:#EF4444;}
.low-card-actions{display:flex;gap:0.5rem;}
.btn-sm-edit{display:inline-flex;align-items:center;gap:0.3rem;background:#EEF2FF;color:#4F46E5;border:none;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;}
.btn-sm-edit:hover{background:#E0E7FF;color:#4F46E5;}
.btn-sm-del{display:inline-flex;align-items:center;gap:0.3rem;background:#FEF2F2;color:#EF4444;border:none;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.78rem;font-weight:600;cursor:pointer;transition:background 0.15s;font-family:'Inter',sans-serif;}
.btn-sm-del:hover{background:#FEE2E2;}
.empty-state{text-align:center;padding:4rem 1rem;color:#6B7280;background:#fff;border:1px solid #E0E7FF;border-radius:12px;}
.empty-state svg{width:48px;height:48px;color:#D1D5DB;margin-bottom:0.75rem;}
</style>
@endpush
@section('content')
<div class="page-header">
    <h1>Lowongan Saya</h1>
    <a href="{{ route('lowongan.create') }}" class="btn-add">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Buat Lowongan
    </a>
</div>

@if($low->isEmpty())
<div class="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/></svg>
    <p>Belum ada lowongan. <a href="{{ route('lowongan.create') }}" style="color:#4F46E5;font-weight:600;">Buat lowongan pertama Anda.</a></p>
</div>
@else
<div class="low-grid">
    @foreach($low as $item)
    <div class="low-card">
        @if($item->foto_low && file_exists(public_path('images/'.$item->foto_low)))
            <img src="{{ asset('images/'.$item->foto_low) }}" alt="{{ $item->nama_low }}" class="low-card-img">
        @else
            <div class="low-card-img-placeholder">🏢</div>
        @endif
        <div class="low-card-body">
            @if($item->kategori)<span class="low-card-badge">{{ $item->kategori->kategori }}</span>@endif
            <h3 class="low-card-title">{{ $item->nama_low }}</h3>
            <p class="low-card-meta">📍 {{ $item->lokasi }} &bull; ⏱ {{ $item->durasi }} bulan</p>
            <div class="low-card-kuota {{ $item->jumlah_mhs == 0 ? 'full' : '' }}">
                {{ $item->jumlah_mhs == 0 ? '🔴 Kuota Penuh' : '🟢 '.$item->jumlah_mhs.' Kuota Tersisa' }}
            </div>
            <div class="low-card-actions">
                <a href="{{ route('lowongan.edit', $item->id) }}" class="btn-sm-edit">Edit</a>
                <form action="{{ route('lowongan.destroy', $item->id) }}" method="POST" id="del-low-{{ $item->id }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-sm-del" onclick="confirmDelLow({{ $item->id }}, '{{ addslashes($item->nama_low) }}')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
@push('scripts')
<script>
function confirmDelLow(id, name) {
    Swal.fire({title:'Hapus Lowongan?',text:`"${name}" akan dihapus permanen.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#EF4444',cancelButtonColor:'#6B7280',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('del-low-'+id).submit();});
}
</script>
@endpush

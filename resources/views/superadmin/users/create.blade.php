@extends('layouts.app')

@section('title', 'Tambah User — Superadmin')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('superadmin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Kelola User</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .form-card { background:#fff;border:1px solid #E2E8F0;border-radius:14px;overflow:hidden;max-width:640px; }
    .form-card-header { background:linear-gradient(135deg,#0EA5E9,#0284C7);padding:1.25rem 1.75rem;color:#fff; }
    .form-card-header h1 { font-size:1.1rem;font-weight:700;margin:0 0 .2rem; }
    .form-card-header p  { font-size:.82rem;opacity:.85;margin:0; }
    .form-card-body { padding:1.75rem; }
    .form-group { margin-bottom:1.25rem; }
    .form-label { display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.4rem; }
    .form-label .req { color:#EF4444;margin-left:2px; }
    .form-control-custom { width:100%;padding:.65rem 1rem;border:1.5px solid #E2E8F0;border-radius:9px;font-size:.875rem;color:#0F172A;background:#FAFAFA;outline:none;transition:border-color .2s,box-shadow .2s,background .2s; }
    .form-control-custom:focus { border-color:#0EA5E9;background:#fff;box-shadow:0 0 0 3px rgba(14,165,233,.1); }
    .invalid-feedback { font-size:.78rem;color:#EF4444;margin-top:.3rem; }
    .form-actions { display:flex;gap:.75rem;align-items:center;padding-top:1.25rem;border-top:1px solid #F1F5F9;margin-top:.5rem; }
    .btn-submit { background:linear-gradient(135deg,#0EA5E9,#0284C7);color:#fff;border:none;border-radius:9px;padding:.65rem 1.75rem;font-weight:600;font-size:.9rem;cursor:pointer;transition:opacity .2s; }
    .btn-submit:hover { opacity:.88; }
    .btn-cancel { background:#fff;color:#6B7280;border:1.5px solid #CBD5E1;border-radius:9px;padding:.65rem 1.25rem;font-weight:600;font-size:.9rem;text-decoration:none;transition:all .2s; }
    .btn-cancel:hover { background:#F8FAFC;color:#374151; }
    .error-alert { background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.85rem;color:#DC2626; }
    .error-alert ul { margin:.4rem 0 0;padding-left:1.25rem; }
    .depart-group { display:none; }
</style>
@endpush

@section('content')

<div class="form-card">
    <div class="form-card-header">
        <h1>Tambah User Baru</h1>
        <p>Superadmin dapat membuat akun untuk semua role.</p>
    </div>
    <div class="form-card-body">

        @if(session('errorForm'))
        <div class="error-alert">
            <strong>Terdapat kesalahan:</strong>
            <ul>
                @foreach(session('errorForm') as $messages)
                    @foreach($messages as $msg)<li>{{ $msg }}</li>@endforeach
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap <span class="req">*</span></label>
                <input type="text" id="name" name="name"
                    class="form-control-custom @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email <span class="req">*</span></label>
                <input type="email" id="email" name="email"
                    class="form-control-custom @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">Role <span class="req">*</span></label>
                <select id="role_id" name="role_id"
                    class="form-control-custom @error('role_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->role }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Departemen dropdown (untuk dosen & mahasiswa) --}}
            <div class="form-group depart-group" id="depart-group">
                <label for="depart_id" class="form-label">Departemen</label>
                <select id="depart_id" name="depart_id" class="form-control-custom">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departemen as $d)
                        <option value="{{ $d->id }}" {{ old('depart_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->nama_depart }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password <span class="req">*</span></label>
                <input type="password" id="password" name="password"
                    class="form-control-custom @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan User</button>
                <a href="{{ route('superadmin.users.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tampilkan dropdown departemen hanya untuk role Dosen (3) dan Mahasiswa (5)
document.getElementById('role_id').addEventListener('change', function() {
    var group = document.getElementById('depart-group');
    group.style.display = (this.value == 3 || this.value == 5) ? 'block' : 'none';
});
// Trigger on load jika old() terisi
(function() {
    var v = document.getElementById('role_id').value;
    var group = document.getElementById('depart-group');
    if (v == 3 || v == 5) group.style.display = 'block';
})();
</script>
@endpush

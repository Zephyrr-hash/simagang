@extends('layouts.app')

@section('title', 'Edit User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kelola User</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .form-card {
        background: #fff;
        border: 1px solid #E0E7FF;
        border-radius: 14px;
        overflow: hidden;
        max-width: 640px;
    }
    .form-card-header {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        padding: 1.25rem 1.75rem;
        color: #fff;
    }
    .form-card-header h1 { font-size: 1.1rem; font-weight: 700; margin: 0 0 0.2rem; }
    .form-card-header p  { font-size: 0.82rem; opacity: 0.85; margin: 0; }
    .form-card-body { padding: 1.75rem; }

    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block; font-size: 0.8rem; font-weight: 600;
        color: #374151; margin-bottom: 0.4rem;
    }
    .form-label .required { color: #EF4444; margin-left: 2px; }
    .form-control-custom {
        width: 100%; padding: 0.65rem 1rem;
        border: 1.5px solid #E5E7EB; border-radius: 9px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        color: #1E1B4B; background: #FAFAFA; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .form-control-custom:focus {
        border-color: #4F46E5; background: #fff;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }
    .form-control-custom.is-invalid { border-color: #EF4444; }
    .invalid-feedback { font-size: 0.78rem; color: #EF4444; margin-top: 0.3rem; }

    .form-actions {
        display: flex; gap: 0.75rem; align-items: center;
        padding-top: 1.25rem; border-top: 1px solid #F3F4F6; margin-top: 0.5rem;
    }
    .btn-submit {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff; border: none; border-radius: 9px;
        padding: 0.65rem 1.75rem; font-weight: 600; font-size: 0.9rem;
        cursor: pointer; transition: opacity 0.2s; font-family: 'Inter', sans-serif;
    }
    .btn-submit:hover { opacity: 0.88; }
    .btn-cancel {
        background: #fff; color: #6B7280; border: 1.5px solid #D1D5DB;
        border-radius: 9px; padding: 0.65rem 1.25rem; font-weight: 600;
        font-size: 0.9rem; text-decoration: none; transition: all 0.2s;
    }
    .btn-cancel:hover { background: #F9FAFB; color: #374151; }

    .error-alert {
        background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px;
        padding: 0.875rem 1rem; margin-bottom: 1.25rem; font-size: 0.85rem; color: #DC2626;
    }
    .error-alert ul { margin: 0.4rem 0 0; padding-left: 1.25rem; }
    .error-alert li { margin-bottom: 0.2rem; }

    .info-note {
        background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 9px;
        padding: 0.75rem 1rem; font-size: 0.82rem; color: #1E40AF;
        margin-bottom: 1.25rem; display: flex; align-items: flex-start; gap: 0.5rem;
    }
    .info-note svg { flex-shrink: 0; width: 16px; height: 16px; margin-top: 1px; }
</style>
@endpush

@section('content')

<div class="form-card">
    <div class="form-card-header">
        <h1>Edit User</h1>
        <p>Ubah data akun pengguna: {{ $user->name }}</p>
    </div>
    <div class="form-card-body">

        <div class="info-note">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            Password tidak ditampilkan di sini. Kosongkan field password jika tidak ingin mengubahnya.
        </div>

        {{-- Error Messages --}}
        @if(session('errorForm'))
        <div class="error-alert">
            <strong>Terdapat kesalahan:</strong>
            <ul>
                @foreach(session('errorForm') as $field => $messages)
                    @foreach($messages as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control-custom @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-control-custom @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" placeholder="nama@email.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">Role <span class="required">*</span></label>
                <select id="role_id" name="role_id" class="form-control-custom @error('role_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($role as $r)
                        <option value="{{ $r->id }}" {{ old('role_id', $user->role_id) == $r->id ? 'selected' : '' }}>
                            {{ $r->role }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>

    </div>
</div>

@endsection

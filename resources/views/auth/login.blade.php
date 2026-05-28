@extends('layouts.guest')

@section('title', 'Masuk — SIMAGANG')

@push('styles')
<style>
    /* ===== Reset & Base ===== */
    *, *::before, *::after {
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
    }

    /* ===== Split Screen Container ===== */
    .login-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* ===== Panel Kiri — Branding ===== */
    .panel-left {
        width: 50%;
        background: linear-gradient(135deg, #4F46E5 0%, #6D28D9 50%, #7C3AED 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 2.5rem;
        position: relative;
        overflow: hidden;
    }

    /* Dekoratif: lingkaran blur di background */
    .panel-left::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 320px;
        height: 320px;
        background: rgba(255, 255, 255, 0.07);
        border-radius: 50%;
        pointer-events: none;
    }

    .panel-left::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -60px;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .brand-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: #ffffff;
        max-width: 380px;
    }

    /* Logo icon */
    .brand-logo {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .brand-logo svg {
        width: 44px;
        height: 44px;
        color: #ffffff;
    }

    .brand-name {
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 0.25rem;
        color: #ffffff;
    }

    .brand-tagline {
        font-size: 1rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 1.5rem;
        letter-spacing: 0.3px;
    }

    .brand-divider {
        width: 48px;
        height: 3px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 2px;
        margin: 0 auto 1.5rem;
    }

    .brand-description {
        font-size: 0.9rem;
        font-weight: 400;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }

    /* Ilustrasi dekoratif SVG */
    .brand-illustration {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        opacity: 0.9;
    }

    /* Feature badges */
    .feature-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .feature-badge {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.3rem 0.75rem;
        border-radius: 100px;
        backdrop-filter: blur(4px);
    }

    /* ===== Panel Kanan — Form Login ===== */
    .panel-right {
        width: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 2.5rem;
    }

    .login-form-container {
        width: 100%;
        max-width: 400px;
    }

    .login-heading {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1E1B4B;
        margin-bottom: 0.4rem;
        letter-spacing: -0.3px;
    }

    .login-subheading {
        font-size: 0.9rem;
        color: #6B7280;
        font-weight: 400;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    /* Alert error */
    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #DC2626;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-error svg {
        flex-shrink: 0;
        width: 16px;
        height: 16px;
    }

    /* Form group */
    .form-group-custom {
        margin-bottom: 1.25rem;
    }

    .form-label-custom {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
        letter-spacing: 0.2px;
    }

    /* Input wrapper dengan icon */
    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
        display: flex;
        align-items: center;
    }

    .input-icon-wrapper .input-icon svg {
        width: 18px;
        height: 18px;
    }

    .input-icon-wrapper .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }

    .input-icon-wrapper .toggle-password:hover {
        color: #4F46E5;
    }

    .input-icon-wrapper .toggle-password svg {
        width: 18px;
        height: 18px;
    }

    .form-input-custom {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.75rem;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: #1E1B4B;
        background: #FAFAFA;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        outline: none;
    }

    .form-input-custom:focus {
        border-color: #4F46E5;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-input-custom::placeholder {
        color: #C4C9D4;
        font-weight: 400;
    }

    /* Password input — ruang untuk toggle icon */
    .form-input-password {
        padding-right: 2.75rem;
    }

    /* Tombol Masuk */
    .btn-login {
        width: 100%;
        padding: 0.8rem 1rem;
        background: #4F46E5;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
        margin-top: 0.5rem;
        letter-spacing: 0.2px;
    }

    .btn-login:hover {
        background: #4338CA;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
        transform: translateY(-1px);
    }

    .btn-login:active {
        background: #3730A3;
        transform: translateY(0);
        box-shadow: none;
    }

    /* Footer form */
    .login-footer {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.8rem;
        color: #9CA3AF;
    }

    .login-footer a {
        color: #4F46E5;
        text-decoration: none;
        font-weight: 500;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    /* ===== Responsive: Mobile ===== */
    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
        }

        .panel-left {
            display: none; /* Sembunyikan panel kiri di mobile */
        }

        .panel-right {
            width: 100%;
            min-height: 100vh;
            padding: 2rem 1.5rem;
        }

        .login-form-container {
            max-width: 100%;
        }

        .login-heading {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 992px) and (min-width: 769px) {
        .panel-left {
            width: 45%;
        }

        .panel-right {
            width: 55%;
        }

        .brand-name {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">

    {{-- ===== Panel Kiri: Branding ===== --}}
    <div class="panel-left">
        <div class="brand-content">

            {{-- Logo Icon --}}
            <div class="brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
            </div>

            {{-- Nama & Tagline --}}
            <h1 class="brand-name">SIMAGANG</h1>
            <p class="brand-tagline">Sistem Informasi Magang</p>
            <div class="brand-divider"></div>
            <p class="brand-description">
                Platform terpadu untuk mengelola program magang mahasiswa — mulai dari pendaftaran, bimbingan, logbook, hingga penilaian akhir.
            </p>

            {{-- Ilustrasi SVG Dekoratif --}}
            <div class="brand-illustration">
                <svg viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <!-- Kartu dokumen utama -->
                    <rect x="60" y="30" width="180" height="130" rx="12" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.25)" stroke-width="1.5"/>
                    <!-- Header kartu -->
                    <rect x="60" y="30" width="180" height="36" rx="12" fill="rgba(255,255,255,0.18)"/>
                    <rect x="60" y="54" width="180" height="12" fill="rgba(255,255,255,0.18)"/>
                    <!-- Ikon di header -->
                    <circle cx="84" cy="48" r="8" fill="rgba(255,255,255,0.3)"/>
                    <rect x="98" y="43" width="60" height="5" rx="2.5" fill="rgba(255,255,255,0.5)"/>
                    <rect x="98" y="51" width="40" height="4" rx="2" fill="rgba(255,255,255,0.3)"/>
                    <!-- Baris konten -->
                    <rect x="76" y="78" width="148" height="6" rx="3" fill="rgba(255,255,255,0.25)"/>
                    <rect x="76" y="90" width="120" height="6" rx="3" fill="rgba(255,255,255,0.2)"/>
                    <rect x="76" y="102" width="135" height="6" rx="3" fill="rgba(255,255,255,0.2)"/>
                    <rect x="76" y="114" width="90" height="6" rx="3" fill="rgba(255,255,255,0.15)"/>
                    <!-- Tombol aksi -->
                    <rect x="76" y="130" width="60" height="18" rx="9" fill="rgba(255,255,255,0.3)"/>
                    <rect x="144" y="130" width="60" height="18" rx="9" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                    <!-- Kartu kecil kiri bawah -->
                    <rect x="20" y="110" width="70" height="55" rx="8" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                    <circle cx="35" cy="126" r="7" fill="rgba(255,255,255,0.2)"/>
                    <rect x="46" y="122" width="32" height="4" rx="2" fill="rgba(255,255,255,0.3)"/>
                    <rect x="46" y="129" width="22" height="3" rx="1.5" fill="rgba(255,255,255,0.2)"/>
                    <rect x="26" y="140" width="52" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
                    <rect x="26" y="148" width="40" height="4" rx="2" fill="rgba(255,255,255,0.12)"/>
                    <!-- Kartu kecil kanan bawah -->
                    <rect x="210" y="110" width="70" height="55" rx="8" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                    <circle cx="225" cy="126" r="7" fill="rgba(255,255,255,0.2)"/>
                    <rect x="236" y="122" width="32" height="4" rx="2" fill="rgba(255,255,255,0.3)"/>
                    <rect x="236" y="129" width="22" height="3" rx="1.5" fill="rgba(255,255,255,0.2)"/>
                    <rect x="216" y="140" width="52" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
                    <rect x="216" y="148" width="40" height="4" rx="2" fill="rgba(255,255,255,0.12)"/>
                    <!-- Titik dekoratif -->
                    <circle cx="150" cy="185" r="3" fill="rgba(255,255,255,0.4)"/>
                    <circle cx="162" cy="185" r="3" fill="rgba(255,255,255,0.2)"/>
                    <circle cx="138" cy="185" r="3" fill="rgba(255,255,255,0.2)"/>
                </svg>
            </div>

            {{-- Feature Badges --}}
            <div class="feature-badges">
                <span class="feature-badge">📋 Lowongan Magang</span>
                <span class="feature-badge">📝 Logbook Harian</span>
                <span class="feature-badge">🎓 Bimbingan Dosen</span>
                <span class="feature-badge">⭐ Penilaian</span>
            </div>

        </div>
    </div>

    {{-- ===== Panel Kanan: Form Login ===== --}}
    <div class="panel-right">
        <div class="login-form-container">

            {{-- Heading --}}
            <h2 class="login-heading">Selamat Datang Kembali</h2>
            <p class="login-subheading">Masuk ke akun Anda untuk melanjutkan</p>

            {{-- Error Flash Message --}}
            @if(session('error'))
                <div class="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                {{-- Input Email --}}
                <div class="form-group-custom">
                    <label for="email" class="form-label-custom">Alamat Email</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input-custom"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                </div>

                {{-- Input Password --}}
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input-custom form-input-password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan/sembunyikan password">
                            {{-- Icon Eye (default: tampilkan) --}}
                            <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            {{-- Icon Eye Slash (hidden: sembunyikan) --}}
                            <svg id="iconEyeSlash" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tombol Masuk --}}
                <button type="submit" class="btn-login">
                    Masuk
                </button>

            </form>

            {{-- Footer --}}
            <div class="login-footer">
                <p style="margin: 0;">
                    &copy; {{ date('Y') }} SIMAGANG &mdash; Sistem Informasi Magang
                </p>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Toggle show/hide password
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const iconEye = document.getElementById('iconEye');
    const iconEyeSlash = document.getElementById('iconEyeSlash');

    toggleBtn.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        iconEye.style.display = isPassword ? 'none' : 'block';
        iconEyeSlash.style.display = isPassword ? 'block' : 'none';
    });

    // Tampilkan SweetAlert jika ada session error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '{{ session('error') }}',
            confirmButtonColor: '#4F46E5',
            confirmButtonText: 'Coba Lagi',
        });
    @endif
</script>
@endpush

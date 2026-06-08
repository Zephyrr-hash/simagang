<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIMAGANG')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F3FF;
            display: flex;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background-color: #1E1B4B;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s ease;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        /* Logo area */
        .sidebar-logo {
            padding: 1.5rem 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .sidebar-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo-icon svg { width: 20px; height: 20px; color: #fff; }

        .sidebar-logo-text {
            font-size: 1.125rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.05em;
        }

        /* User info */
        .sidebar-user {
            padding: 0.75rem 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar-avatar-initials {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar-user-info { overflow: hidden; }

        .sidebar-user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            margin-top: 1px;
        }

        /* Divider */
        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.08);
            margin: 0.25rem 1.25rem;
            flex-shrink: 0;
        }

        /* Nav menu */
        .sidebar-nav {
            padding: 0.5rem 0.75rem;
            flex: 1;
        }

        .sidebar-nav-label {
            font-size: 0.6875rem;
            font-weight: 600;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.5rem 0.5rem 0.25rem;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: rgba(255,255,255,0.75);
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.15s ease, color 0.15s ease;
            margin-bottom: 2px;
        }

        .sidebar-nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            text-decoration: none;
        }

        .sidebar-nav-item.active {
            background: #4F46E5;
            color: #fff;
        }

        .sidebar-nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.85;
        }

        .sidebar-nav-item.active svg { opacity: 1; }

        /* Bottom nav (profil & logout) */
        .sidebar-bottom {
            padding: 0.5rem 0.75rem 1rem;
            flex-shrink: 0;
        }

        /* ===== OVERLAY (mobile) ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
        }

        .sidebar-overlay.show { display: block; }

        /* ===== MAIN CONTENT ===== */
        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            border-bottom: 1px solid #E0E7FF;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }

        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            padding: 0.375rem;
            border-radius: 6px;
            cursor: pointer;
            color: #6B7280;
            transition: background 0.15s;
        }

        .hamburger-btn:hover { background: #F3F4F6; }
        .hamburger-btn svg { width: 22px; height: 22px; display: block; }

        /* Breadcrumb */
        .topbar-breadcrumb {
            font-size: 0.875rem;
            color: #6B7280;
        }

        .topbar-breadcrumb .breadcrumb {
            margin: 0;
            padding: 0;
            background: none;
            font-size: 0.875rem;
        }

        .topbar-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            color: #D1D5DB;
        }

        .topbar-breadcrumb .breadcrumb-item a {
            color: #4F46E5;
            text-decoration: none;
        }

        .topbar-breadcrumb .breadcrumb-item.active { color: #374151; font-weight: 500; }

        /* User dropdown topbar */
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }

        .topbar-user-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: 1px solid #E0E7FF;
            border-radius: 8px;
            padding: 0.375rem 0.75rem 0.375rem 0.5rem;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            text-decoration: none;
            color: #374151;
        }

        .topbar-user-btn:hover {
            background: #F5F3FF;
            border-color: #C7D2FE;
            color: #374151;
            text-decoration: none;
        }

        .topbar-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .topbar-user-avatar-initials {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6875rem;
            font-weight: 600;
            color: #fff;
        }

        .topbar-user-name {
            font-size: 0.875rem;
            font-weight: 500;
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-user-chevron { width: 14px; height: 14px; color: #9CA3AF; }

        /* Dropdown menu */
        .topbar-dropdown { position: relative; }

        .topbar-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1px solid #E0E7FF;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 180px;
            z-index: 1050;
            overflow: hidden;
        }

        .topbar-dropdown-menu.show { display: block; }

        .topbar-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .topbar-dropdown-item:hover { background: #F5F3FF; color: #4F46E5; text-decoration: none; }
        .topbar-dropdown-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .topbar-dropdown-divider { height: 1px; background: #E0E7FF; margin: 0.25rem 0; }
        .topbar-dropdown-item.text-danger:hover { background: #FEF2F2; color: #EF4444; }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 1.5rem;
            flex: 1;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .hamburger-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar-user-name { display: none; }
        }

        @media (max-width: 575.98px) {
            .page-content { padding: 1rem; }
            .topbar { padding: 0 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ===== SIDEBAR OVERLAY (mobile) ===== --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar" id="sidebar" role="navigation" aria-label="Navigasi utama">

    {{-- Logo --}}
    <a href="{{ route(Auth::check() ? (
        Auth::user()->role_id == 1 ? 'depart.home' :
        (Auth::user()->role_id == 2 ? 'mitra.home' :
        (Auth::user()->role_id == 3 ? 'dospem.home' :
        (Auth::user()->role_id == 4 ? 'supervisor.home' : 'mahasiswa.home')))
    ) : 'login') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
        </div>
        <span class="sidebar-logo-text">SIMAGANG</span>
    </a>

    {{-- User Info --}}
    @auth
    @php
        $user = Auth::user();
        $roleId = (int) $user->role_id;

        // Ambil data profil berdasarkan role
        $profileData = match($roleId) {
            \App\Models\Role::DEPARTEMEN => \App\Models\Departemen::where('user_id', $user->id)->first(),
            \App\Models\Role::MITRA      => \App\Models\Mitra::where('user_id', $user->id)->first(),
            \App\Models\Role::DOSPEM     => \App\Models\Dosen::where('user_id', $user->id)->first(),
            \App\Models\Role::SUPERVISOR => \App\Models\Supervisor::where('user_id', $user->id)->first(),
            \App\Models\Role::MAHASISWA  => \App\Models\Mahasiswa::where('user_id', $user->id)->first(),
            default => null,
        };

        [$fotoField, $namaField, $roleLabel] = match($roleId) {
            \App\Models\Role::DEPARTEMEN => ['foto_depart', 'nama_depart', 'Departemen'],
            \App\Models\Role::MITRA      => ['foto_mitra',  'nama_mitra',  'Mitra'],
            \App\Models\Role::DOSPEM     => ['foto_dosen',  'nama_dosen',  'Dosen Pembimbing'],
            \App\Models\Role::SUPERVISOR => ['foto_spv',    'nama_spv',    'Supervisor'],
            \App\Models\Role::MAHASISWA  => ['foto_mhs',    'nama_mhs',    'Mahasiswa'],
            default => [null, null, 'User'],
        };

        $foto = ($fotoField && $profileData?->$fotoField) ? $profileData->$fotoField : null;
        $nama = ($namaField && $profileData?->$namaField) ? $profileData->$namaField : $user->name;
        $initials = strtoupper(substr($nama, 0, 1) . (str_contains($nama, ' ') ? substr(strrchr($nama, ' '), 1, 1) : ''));
    @endphp
    <div class="sidebar-user">
        @if($foto && file_exists(public_path('images/' . $foto)))
            <img src="{{ asset('images/' . $foto) }}"
                 alt="Foto {{ $nama }}"
                 class="sidebar-avatar">
        @else
            <div class="sidebar-avatar-initials" aria-hidden="true">{{ $initials }}</div>
        @endif
        <div class="sidebar-user-info">
            <div class="sidebar-user-name" title="{{ $nama }}">{{ $nama }}</div>
            <div class="sidebar-user-role">{{ $roleLabel }}</div>
        </div>
    </div>
    @endauth

    <div class="sidebar-divider"></div>

    {{-- Navigasi Dinamis Berdasarkan Role --}}
    @auth
    <nav class="sidebar-nav" aria-label="Menu navigasi">
        <div class="sidebar-nav-label">Menu</div>

        {{-- DEPARTEMEN (role 1) --}}
        @if($roleId === \App\Models\Role::DEPARTEMEN)
            <a href="{{ route('depart.home') }}"
               class="sidebar-nav-item {{ request()->routeIs('depart.home') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('depart.home') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('users.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('users.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Kelola User
            </a>
            <a href="{{ route('depart.mhs') }}"
               class="sidebar-nav-item {{ request()->routeIs('depart.mhs') || request()->routeIs('depart.detailMhs') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('depart.mhs') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
                Data Mahasiswa
            </a>
            <a href="{{ route('pengajuan.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('pengajuan.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('pengajuan.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Pengajuan Dospem
            </a>
        @endif

        {{-- MITRA (role 2) --}}
        @if($roleId === \App\Models\Role::MITRA)
            <a href="{{ route('mitra.home') }}"
               class="sidebar-nav-item {{ request()->routeIs('mitra.home') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('mitra.home') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('lowongan.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('lowongan.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('lowongan.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                </svg>
                Lowongan
            </a>
            <a href="{{ route('pendaftar.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('pendaftar.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('pendaftar.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                Pendaftar
            </a>
            <a href="{{ route('magang.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('magang.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('magang.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
                Mahasiswa Magang
            </a>
        @endif

        {{-- DOSEN PEMBIMBING (role 3) --}}
        @if($roleId === \App\Models\Role::DOSPEM)
            <a href="{{ route('dospem.home') }}"
               class="sidebar-nav-item {{ request()->routeIs('dospem.home') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('dospem.home') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('project.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('project.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('project.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                Project
            </a>
        @endif

        {{-- SUPERVISOR (role 4) --}}
        @if($roleId === \App\Models\Role::SUPERVISOR)
            <a href="{{ route('supervisor.home') }}"
               class="sidebar-nav-item {{ request()->routeIs('supervisor.home') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('supervisor.home') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('project.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('project.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('project.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                Project
            </a>
            <a href="{{ route('spv.penilaian') }}"
               class="sidebar-nav-item {{ request()->routeIs('spv.penilaian') || request()->routeIs('spv.score') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('spv.penilaian') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
                Penilaian
            </a>
        @endif

        {{-- MAHASISWA (role 5) --}}
        @if($roleId === \App\Models\Role::MAHASISWA)
            <a href="{{ route('mahasiswa.home') }}"
               class="sidebar-nav-item {{ request()->routeIs('mahasiswa.home') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('mahasiswa.home') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>
            <a href="{{ url('/') }}"
               class="sidebar-nav-item {{ request()->is('/') ? 'active' : '' }}"
               aria-current="{{ request()->is('/') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                Cari Lowongan
            </a>
            <a href="{{ route('lowongan.diajukan') }}"
               class="sidebar-nav-item {{ request()->routeIs('lowongan.diajukan') || request()->routeIs('lowongan.apply') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('lowongan.diajukan') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Pengajuan Saya
            </a>
            <a href="{{ route('project.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('project.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('project.*') ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                Project
            </a>
        @endif
    </nav>
    @endauth

    <div class="sidebar-divider"></div>

    {{-- Profil & Logout --}}
    @auth
    <div class="sidebar-bottom">
        <a href="{{ route('profile.index') }}"
           class="sidebar-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('profile.*') ? 'page' : 'false' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Profil Saya
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <button type="button"
                onclick="document.getElementById('sidebar-logout-form').submit()"
                class="sidebar-nav-item w-100"
                style="border:none; cursor:pointer; text-align:left;"
                aria-label="Keluar dari aplikasi">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
            </svg>
            Keluar
        </button>
    </div>
    @endauth

</aside>
{{-- ===== END SIDEBAR ===== --}}

{{-- ===== MAIN WRAPPER ===== --}}
<div class="main-wrapper">

    {{-- TOPBAR --}}
    <header class="topbar" role="banner">
        <div class="topbar-left">
            {{-- Hamburger (mobile) --}}
            <button class="hamburger-btn"
                    id="hamburgerBtn"
                    onclick="toggleSidebar()"
                    aria-label="Toggle navigasi"
                    aria-expanded="false"
                    aria-controls="sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb">
                @yield('breadcrumb')
            </nav>
        </div>

        {{-- User dropdown --}}
        @auth
        <div class="topbar-right">
            <div class="topbar-dropdown" id="topbarDropdown">
                <button class="topbar-user-btn"
                        onclick="toggleTopbarDropdown()"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-controls="topbarDropdownMenu"
                        type="button">
                    @if($foto && file_exists(public_path('images/' . $foto)))
                        <img src="{{ asset('images/' . $foto) }}"
                             alt="Foto {{ $nama }}"
                             class="topbar-user-avatar">
                    @else
                        <div class="topbar-user-avatar-initials" aria-hidden="true">{{ $initials }}</div>
                    @endif
                    <span class="topbar-user-name">{{ $nama }}</span>
                    <svg class="topbar-user-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div class="topbar-dropdown-menu" id="topbarDropdownMenu" role="menu" aria-labelledby="topbarDropdown">
                    <a href="{{ route('profile.index') }}" class="topbar-dropdown-item" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Profil Saya
                    </a>
                    <div class="topbar-dropdown-divider" role="separator"></div>
                    <button type="button"
                            onclick="document.getElementById('sidebar-logout-form').submit()"
                            class="topbar-dropdown-item text-danger"
                            role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        Keluar
                    </button>
                </div>
            </div>
        </div>
        @endauth
    </header>
    {{-- END TOPBAR --}}

    {{-- PAGE CONTENT --}}
    <main class="page-content" id="main-content" role="main">
        @yield('content')
    </main>
    {{-- END PAGE CONTENT --}}

</div>
{{-- ===== END MAIN WRAPPER ===== --}}

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@stack('scripts')

<script>
    // ===== SIDEBAR TOGGLE (mobile) =====
    function toggleSidebar() {
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const btn      = document.getElementById('hamburgerBtn');
        const isOpen   = sidebar.classList.contains('open');

        if (isOpen) {
            closeSidebar();
        } else {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            btn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const btn     = document.getElementById('hamburgerBtn');

        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        btn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    // Tutup sidebar saat resize ke desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });

    // ===== TOPBAR DROPDOWN =====
    function toggleTopbarDropdown() {
        const menu = document.getElementById('topbarDropdownMenu');
        const btn  = document.querySelector('[aria-controls="topbarDropdownMenu"]');
        const isOpen = menu.classList.contains('show');

        if (isOpen) {
            menu.classList.remove('show');
            btn.setAttribute('aria-expanded', 'false');
        } else {
            menu.classList.add('show');
            btn.setAttribute('aria-expanded', 'true');
        }
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('topbarDropdown');
        const menu     = document.getElementById('topbarDropdownMenu');
        const btn      = document.querySelector('[aria-controls="topbarDropdownMenu"]');

        if (dropdown && !dropdown.contains(e.target)) {
            menu && menu.classList.remove('show');
            btn  && btn.setAttribute('aria-expanded', 'false');
        }
    });

    // Tutup dropdown dengan Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const menu = document.getElementById('topbarDropdownMenu');
            const btn  = document.querySelector('[aria-controls="topbarDropdownMenu"]');
            menu && menu.classList.remove('show');
            btn  && btn.setAttribute('aria-expanded', 'false');
        }
    });

    // ===== SWEETALERT2 FLASH MESSAGES =====
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        confirmButtonColor: '#4F46E5',
        confirmButtonText: 'OK',
        timer: 4000,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#EF4444',
        confirmButtonText: 'Tutup',
    });
    @endif

    @if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        text: @json(session('warning')),
        confirmButtonColor: '#F59E0B',
        confirmButtonText: 'OK',
    });
    @endif

    @if(session('info'))
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: @json(session('info')),
        confirmButtonColor: '#3B82F6',
        confirmButtonText: 'OK',
    });
    @endif
</script>

</body>
</html>

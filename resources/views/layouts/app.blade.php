
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') · Scholarify</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mentor.css') }}">

    <style>
        /* =====================================
           1. MAIN THEME
        ===================================== */

        .shell.scholar-shell {
            --maroon: #650f2b;
            --rose: #a13c5b;
            --cream: #fbf6f7;
            --dark: #40101f;
            --muted: #927e86;
            --border: #f0e4e8;

            display: flex;
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;

            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--dark);
        }

        .scholar-shell * {
            box-sizing: border-box;
        }

        /* =====================================
           2. SIDEBAR
        ===================================== */

        .scholar-shell .sidebar {
            width: 260px;
            flex: 0 0 260px;

            height: 100vh;
            height: 100dvh;

            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            flex-direction: column;

            background: var(--maroon);
            color: white;
            border-right: none;

            box-shadow: 5px 0 25px rgba(65,16,31,.07);

            padding: 22px 15px;

            overflow: hidden;

            transition:
                width .28s ease,
                flex-basis .28s ease,
                padding .28s ease;
        }

        /* =====================================
           3. SIDEBAR BRAND
        ===================================== */

        .scholar-shell .brand {
            flex-shrink: 0;

            display: flex;
            align-items: center;
            gap: 12px;

            color: white;
            text-decoration: none;

            font-size: 17px;
            font-weight: 800;
            letter-spacing: .5px;

            padding: 5px 10px 24px;

            border-bottom: 1px solid rgba(255,255,255,.15);

            transition: all .2s ease;
        }

        .scholar-shell .brand-mark {
            width: 43px;
            height: 43px;
            min-width: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: white;
            color: var(--maroon);
            border-radius: 13px;

            font-size: 17px;
            font-weight: 800;
        }

        .scholar-shell .brand-description {
            display: block;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 1px;
            color: #e5c5d0;
            margin-top: 3px;
        }

        /* =====================================
           4. NAVIGATION SCROLL AREA
        ===================================== */

        .scholar-shell .nav {
            flex: 1 1 auto;
            min-height: 0;

            display: flex;
            flex-direction: column;

            padding: 18px 3px 12px;

            overflow-x: hidden;
            overflow-y: auto;

            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.32) transparent;

            scrollbar-gutter: stable;
        }

        /* Scrollbar Chrome / Edge */

        .scholar-shell .nav::-webkit-scrollbar {
            width: 6px;
        }

        .scholar-shell .nav::-webkit-scrollbar-track {
            background: transparent;
            margin: 5px 0;
        }

        .scholar-shell .nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.25);
            border-radius: 20px;
            border: 1px solid transparent;
            background-clip: padding-box;
            transition: background .2s ease;
        }

        .scholar-shell .nav:hover::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.48);
            background-clip: padding-box;
        }

        .scholar-shell .nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,.7);
            background-clip: padding-box;
        }

        /* Judul kategori */

        .scholar-shell .nav-title {
            color: #d9aebb;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;

            padding: 12px 13px 10px;

            flex-shrink: 0;
        }

        /* Link navigasi */

        .scholar-shell .nav a {
            display: flex;
            align-items: center;
            gap: 13px;

            color: #f2dfe5;
            text-decoration: none;

            padding: 12px 13px;
            margin-bottom: 5px;

            min-height: 44px;
            flex-shrink: 0;

            border-radius: 10px;

            font-size: 13px;
            font-weight: 500;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .scholar-shell .nav a svg {
            width: 19px;
            height: 19px;
            min-width: 19px;

            opacity: .9;
        }

        .scholar-shell .nav a:hover {
            background: rgba(255,255,255,.12);
            color: white;
            transform: translateX(2px);
        }

        .scholar-shell .nav a.active {
            background: #fff;
            color: var(--maroon);
            font-weight: 800;
            box-shadow: 0 4px 15px rgba(0,0,0,.1);
        }

        .scholar-shell .nav a.active svg {
            opacity: 1;
        }

        /* =====================================
           5. SIDEBAR PROFILE
        ===================================== */

        .scholar-shell .sidebar-foot {
            flex-shrink: 0;

            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.12);

            border-radius: 13px;
            padding: 14px;

            color: #e8cbd4;
            font-size: 11px;
            line-height: 1.8;

            margin-top: 10px;

            overflow-wrap: anywhere;
        }

        .scholar-shell .sidebar-foot strong {
            display: block;
            color: white;
            font-size: 13px;
            font-weight: 800;
        }

        /* =====================================
           6. DESKTOP COLLAPSED SIDEBAR
        ===================================== */

        .scholar-shell.sidebar-collapsed .sidebar {
            width: 76px;
            flex-basis: 76px;
            padding: 22px 9px;
        }

        .scholar-shell.sidebar-collapsed .brand {
            justify-content: center;
            padding: 5px 0 24px;
        }

        .scholar-shell.sidebar-collapsed .brand > span:last-child {
            display: none;
        }

        .scholar-shell.sidebar-collapsed .nav {
            padding-left: 0;
            padding-right: 0;
        }

        .scholar-shell.sidebar-collapsed .nav-title {
            display: none;
        }

        .scholar-shell.sidebar-collapsed .nav a {
            justify-content: center;
            padding: 12px 8px;
            gap: 0;
        }

        .scholar-shell.sidebar-collapsed .nav a span {
            display: none;
        }

        .scholar-shell.sidebar-collapsed .nav a svg {
            width: 21px;
            height: 21px;
        }

        .scholar-shell.sidebar-collapsed .nav a:hover {
            transform: none;
        }

        .scholar-shell.sidebar-collapsed .sidebar-foot {
            display: none;
        }

        /* =====================================
           7. MAIN CONTENT
        ===================================== */

        .scholar-shell .main {
            display: flex;
            flex-direction: column;

            flex: 1 1 auto;
            width: 0;
            min-width: 0;
            min-height: 100vh;

            background: var(--cream);
            margin-left: 0 !important;
        }

        /* =====================================
           8. TOPBAR
        ===================================== */

        .scholar-shell .topbar {
            min-height: 76px;
            flex-shrink: 0;

            background: white;
            border-bottom: 1px solid var(--border);

            padding: 12px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;

            box-shadow: 0 3px 15px rgba(65,16,31,.025);
        }

        .scholar-shell .topbar > strong {
            color: var(--dark) !important;
            font-size: 15px;
            font-weight: 800 !important;
            margin-right: auto;
        }

        /* =====================================
           9. HAMBURGER BUTTON
        ===================================== */

        .scholar-shell .menu-btn {
            flex-shrink: 0;

            background: var(--cream);
            color: var(--maroon);

            border: 1px solid var(--border);
            border-radius: 9px;

            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            transition: all .2s ease;
        }

        .scholar-shell .menu-btn svg {
            display: block;
            transition: transform .2s ease;
        }

        .scholar-shell .menu-btn:hover {
            background: #f5e5eb;
            border-color: #e8cbd4;
        }

        .scholar-shell .menu-btn:focus-visible {
            outline: 3px solid rgba(161,60,91,.25);
            outline-offset: 2px;
        }

        /* =====================================
           10. TOPBAR USER
        ===================================== */

        .scholar-shell .topbar-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .scholar-shell .avatar {
            width: 42px;
            height: 42px;
            min-width: 42px;

            border-radius: 50%;

            background: #f5e5eb;
            color: var(--maroon);

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 800;
            font-size: 16px;

            overflow: hidden;
            border: 2px solid #f0dce3;
        }

        .scholar-shell .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* =====================================
           11. LOGOUT
        ===================================== */

        .scholar-shell .btn.btn-ghost {
            background: white;
            border: 1px solid var(--border);
            color: var(--maroon);
            border-radius: 9px;
            font-weight: 700;
            padding: 9px 15px;
            cursor: pointer;
        }

        .scholar-shell .btn.btn-ghost:hover {
            background: #fbf0f3;
            color: var(--rose);
        }

        /* =====================================
           12. PAGE CONTENT
        ===================================== */

        .scholar-shell .content {
            flex: 1 0 auto;
            width: 100%;

            padding: 30px;
            min-height: calc(100vh - 76px);
        }

        /* PAGE HEAD */

        .scholar-shell .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .scholar-shell .page-head h1 {
            color: var(--dark);
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            margin: 0 0 8px;
        }

        .scholar-shell .page-head p {
            color: var(--muted);
            font-size: 13px;
            margin: 0;
            line-height: 1.7;
        }

        /* =====================================
           13. CARDS
        ===================================== */

        .scholar-shell .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(65,16,31,.035);
            padding: 22px;
            margin-bottom: 20px;
        }

        .scholar-shell .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 18px;
        }

        .scholar-shell .card-head h2 {
            color: var(--dark);
            font-size: 17px;
            font-weight: 800;
            margin: 0;
        }

        .scholar-shell .card-head a {
            color: var(--rose);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
        }

        /* =====================================
           14. BUTTONS
        ===================================== */

        .scholar-shell .btn {
            background: var(--maroon);
            color: white;
            border: 1px solid var(--maroon);
            border-radius: 9px;
            padding: 10px 17px;
            font-weight: 700;
            font-size: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .2s;
        }

        .scholar-shell .btn:hover {
            background: var(--rose);
            border-color: var(--rose);
            color: white;
        }

        .scholar-shell .btn-outline {
            background: white;
            color: var(--maroon);
            border: 1px solid var(--maroon);
        }

        .scholar-shell .btn-outline:hover {
            background: var(--maroon);
            color: white;
        }

        /* =====================================
           15. TABLE
        ===================================== */

        .scholar-shell table {
            border-collapse: collapse;
            width: 100%;
        }

        .scholar-shell table th {
            background: #fbf0f3;
            color: var(--maroon);
            font-size: 12px;
            font-weight: 800;
            padding: 13px;
            text-align: left;
        }

        .scholar-shell table td {
            color: #59414a;
            font-size: 12px;
            padding: 13px;
            border-bottom: 1px solid var(--border);
        }

        .scholar-shell table tr:hover td {
            background: #fdf9fa;
        }

        /* =====================================
           16. FORM
        ===================================== */

        .scholar-shell input,
        .scholar-shell select,
        .scholar-shell textarea {
            border-color: #eadce1;
            border-radius: 9px;
        }

        .scholar-shell input:focus,
        .scholar-shell select:focus,
        .scholar-shell textarea:focus {
            border-color: var(--rose);
            outline: none;
            box-shadow: 0 0 0 3px rgba(161,60,91,.1);
        }

        /* =====================================
           17. ALERT
        ===================================== */

        .scholar-shell .alert {
            border-radius: 11px;
            padding: 14px 17px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .scholar-shell .alert-success {
            background: #edf6ef;
            border: 1px solid #d5e9d9;
            color: #356844;
        }

        .scholar-shell .alert-danger {
            background: #fff0f0;
            border: 1px solid #f1d4d4;
            color: #a12c38;
        }

        .scholar-shell .alert-info {
            background: #f7f0f4;
            border: 1px solid #eadce1;
            color: var(--maroon);
        }

        .scholar-shell .muted {
            color: var(--muted);
        }

        /* =====================================
           18. MOBILE SIDEBAR OVERLAY
        ===================================== */

        .scholar-shell .sidebar-overlay {
            display: none;
        }

        /* =====================================
           19. TABLET
        ===================================== */

        @media(max-width: 900px) {

            .scholar-shell .sidebar {
                width: 240px;
                flex-basis: 240px;
            }

            .scholar-shell.sidebar-collapsed .sidebar {
                width: 76px;
                flex-basis: 76px;
            }

            .scholar-shell .topbar {
                padding: 12px 20px;
            }

            .scholar-shell .content {
                padding: 24px 20px;
            }
        }

        /* =====================================
           20. MOBILE DRAWER
        ===================================== */

        @media(max-width: 768px) {

            .shell.scholar-shell {
                display: flex;
                width: 100%;
                min-height: 100vh;
                min-height: 100dvh;
                overflow-x: hidden;
            }

            /* Sidebar menjadi drawer */

            .scholar-shell .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;

                width: min(285px, 86vw);
                height: 100vh;
                height: 100dvh;

                flex: none;

                z-index: 1100;

                padding: 22px 15px;

                transform: translateX(-105%);
                visibility: hidden;

                transition:
                    transform .28s ease,
                    visibility .28s ease;

                box-shadow: 8px 0 30px rgba(0,0,0,.15);
            }

            /* Sidebar terbuka */

            .scholar-shell.mobile-sidebar-open .sidebar {
                transform: translateX(0);
                visibility: visible;
            }

            /* Mode collapsed desktop tidak berlaku di mobile */

            .scholar-shell.sidebar-collapsed .sidebar {
                width: min(285px, 86vw);
                flex-basis: auto;
                padding: 22px 15px;
            }

            .scholar-shell.sidebar-collapsed .brand {
                justify-content: flex-start;
                padding: 5px 10px 24px;
            }

            .scholar-shell.sidebar-collapsed .brand > span:last-child {
                display: block;
            }

            .scholar-shell.sidebar-collapsed .nav-title {
                display: block;
            }

            .scholar-shell.sidebar-collapsed .nav a {
                justify-content: flex-start;
                padding: 12px 13px;
                gap: 13px;
            }

            .scholar-shell.sidebar-collapsed .nav a span {
                display: inline;
            }

            .scholar-shell.sidebar-collapsed .sidebar-foot {
                display: block;
            }

            /* Overlay */

            .scholar-shell .sidebar-overlay {
                position: fixed;
                inset: 0;

                z-index: 1090;

                background: rgba(35,10,19,.48);
                backdrop-filter: blur(2px);

                opacity: 0;
                visibility: hidden;

                display: block;

                transition:
                    opacity .25s ease,
                    visibility .25s ease;
            }

            .scholar-shell.mobile-sidebar-open .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }

            /* Main */

            .scholar-shell .main {
                width: 100%;
                flex: 1 1 100%;
                min-width: 0;
            }

            .scholar-shell .topbar {
                min-height: 68px;
                padding: 10px 15px;
                gap: 12px;
            }

            .scholar-shell .topbar > strong {
                font-size: 14px;
            }

            .scholar-shell .content {
                padding: 20px 15px;
                min-height: calc(100vh - 68px);
            }

            .scholar-shell .page-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .scholar-shell .page-head h1 {
                font-size: 23px;
            }
        }

        @media(max-width: 480px) {

            .scholar-shell .topbar-user {
                gap: 8px;
            }

            .scholar-shell .avatar {
                width: 35px;
                height: 35px;
                min-width: 35px;
            }

            .scholar-shell .btn.btn-ghost {
                padding: 8px 10px;
                font-size: 11px;
            }

            .scholar-shell .card {
                padding: 16px;
            }

            .scholar-shell .menu-btn {
                width: 39px;
                height: 39px;
            }
        }

        /* Kurangi animasi jika diminta sistem pengguna */

        @media(prefers-reduced-motion: reduce) {
            .scholar-shell *,
            .scholar-shell *::before,
            .scholar-shell *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('head')
</head>

<body>

@php
    $u = auth()->user();

    $ic = fn($d) =>
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$d.'</svg>';

    $icons = [
        'home' => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/>',

        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',

        'award' => '<circle cx="12" cy="9" r="6"/><path d="M8.5 14L7 22l5-3 5 3-1.5-8"/>',

        'file' => '<path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8z"/><path d="M14 3v5h5"/>',

        'check' => '<path d="M20 6L9 17l-5-5"/>',

        'card' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/>',

        'megaphone' => '<path d="M3 11v2a1 1 0 001 1h3l7 4V6L7 10H4a1 1 0 00-1 1z"/><path d="M18 8a5 5 0 010 8"/>',

        'users' => '<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5"/><path d="M16 4.5a3.5 3.5 0 010 7M22 20c0-2.5-1.8-4.2-4.5-5"/>',

        'shield' => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/>',

        'list' => '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',

        'layout-dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',

        'calendar-days' => '<rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01M16 17h.01"/>',

        'clipboard-check' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3h6v1.5"/><path d="m9 13 2 2 4-4"/>',

        'chart-no-axes-column' => '<rect x="4" y="12" width="4" height="8" rx="1"/><rect x="10" y="7" width="4" height="13" rx="1"/><rect x="16" y="3" width="4" height="17" rx="1"/>',

        'file-check' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="m8 15 2 2 5-5"/>',

    ];

    $item = function ($route, $label, $icon, $pattern = null) use ($ic, $icons) {

        $active = request()->routeIs($pattern ?? $route);

        return '<a href="'.e(route($route)).'"
                    title="'.e($label).'"
                    aria-label="'.e($label).'"
                    class="'.($active ? 'active' : '').'">'
                .$ic($icons[$icon])
                .'<span>'.e($label).'</span>
            </a>';
    };
@endphp


<div class="shell scholar-shell" id="scholarShell">

    {{-- =====================================
         SIDEBAR
    ====================================== --}}

    <aside class="sidebar" id="sidebar">

        {{-- BRAND --}}

        <a href="{{ route('dashboard') }}"
           class="brand"
           title="Scholarify">

            <span class="brand-mark">SB</span>

            <span>

                SCHOLARIFY

                <small class="brand-description">
                    SCHOLARSHIP SYSTEM
                </small>

            </span>

        </a>


        {{-- NAVIGATION --}}

        <nav class="nav" aria-label="Navigasi utama">

            @if($u->role === 'mahasiswa')

                <div class="nav-title">
                    Menu Mahasiswa
                </div>

                {!! $item('mahasiswa.dashboard', 'Beranda', 'home') !!}

                {!! $item('mahasiswa.profil.edit', 'Data mahasiswa', 'user') !!}

                {!! $item('mahasiswa.beasiswa.index', 'Beasiswa dibuka', 'award', 'mahasiswa.beasiswa.*') !!}

                {!! $item('mahasiswa.pendaftaran.index', 'Pendaftaran saya', 'file', 'mahasiswa.pendaftaran.*') !!}

                {!! $item('mahasiswa.hasil', 'Hasil & penempatan', 'check') !!}

                {!! $item('mahasiswa.monitoring', 'Monitoring saya', 'list') !!}

                {!! $item('mahasiswa.ktm', 'KTM digital', 'card') !!}


            
@elseif($u->role === 'mentor')

    <div class="nav-title">
        Menu Mentor
    </div>

    {!! $item('mentor.dashboard', 'Dashboard', 'layout-dashboard', 'mentor.dashboard') !!}

    {!! $item('mentor.mahasiswa.index', 'Mahasiswa Binaan', 'users', 'mentor.mahasiswa.*') !!}

    {!! $item('mentor.kegiatan.index', 'Kegiatan Pembinaan', 'calendar-days', 'mentor.kegiatan.*') !!}

    {!! $item('mentor.monitoring.index', 'Monitoring Kehadiran', 'clipboard-check', 'mentor.monitoring.index') !!}

    {!! $item('mentor.rekap.index', 'Rekap Monitoring', 'chart-no-axes-column', 'mentor.rekap.*') !!}

    {!! $item('mentor.evaluasi.index', 'Rekomendasi Mahasiswa', 'file-check', 'mentor.evaluasi.*') !!}


            @elseif($u->role === 'admin')

                <div class="nav-title">
                    Menu Penyelenggara
                </div>

                {!! $item('admin.dashboard', 'Ringkasan', 'home') !!}

                {!! $item('admin.beasiswa.index', 'Kelola beasiswa', 'award', 'admin.beasiswa.*') !!}

                {!! $item('admin.pendaftaran.index', 'Kelola pendaftaran', 'file', 'admin.pendaftaran.*') !!}

                {!! $item('admin.pengumuman.index', 'Pengumuman', 'megaphone', 'admin.pengumuman.*') !!}

                {!! $item('admin.penempatan.index', 'Penerimaan & penempatan', 'users', 'admin.penempatan.*') !!}

                {!! $item('admin.evaluasi.index', 'Evaluasi beasiswa', 'check', 'admin.evaluasi.*') !!}

                {!! $item('admin.akun.index', 'Kelola akun staf', 'user', 'admin.akun.*') !!}

            @endif

        </nav>


        {{-- SIDEBAR USER --}}

        <div class="sidebar-foot">

            <strong>{{ $u->name }}</strong>

            {{ $u->roleLabel() }}

        </div>

    </aside>


    {{-- MOBILE OVERLAY --}}

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
        aria-hidden="true"
    ></div>


    {{-- =====================================
         MAIN CONTENT
    ====================================== --}}

    <div class="main">


        {{-- TOPBAR --}}

        <header class="topbar">

            <button
                class="menu-btn"
                id="menuBtn"
                type="button"
                aria-label="Buka sidebar"
                aria-controls="sidebar"
                aria-expanded="true"
                title="Buka / Tutup Sidebar"
            >

                <svg
                    width="23"
                    height="23"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    aria-hidden="true"
                >
                    <path d="M4 6h16"/>
                    <path d="M4 12h16"/>
                    <path d="M4 18h16"/>
                </svg>

            </button>


            <strong>
                @yield('title', 'Dashboard')
            </strong>


            {{-- USER TOPBAR --}}

            <div class="topbar-user">

                <div class="avatar">

                    @if(
                        $u->role === 'mahasiswa'
                        && $u->profile
                        && $u->profile->foto_url
                    )

                        <img
                            src="{{ $u->profile->foto_url }}"
                            alt="Foto profil"
                        >

                    @else

                        {{ strtoupper(mb_substr($u->name, 0, 1)) }}

                    @endif

                </div>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        class="btn btn-ghost btn-sm"
                        type="submit"
                    >
                        Keluar
                    </button>

                </form>

            </div>

        </header>


        {{-- =================================
             PAGE CONTENT
        ================================== --}}

        <main class="content">

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-danger">

                    <ul style="margin:0;padding-left:20px">

                        @foreach($errors->all() as $e)

                            <li>{{ $e }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>


{{-- =====================================
     JAVASCRIPT
====================================== --}}

<script src="{{ asset('js/app.js') }}"></script>

<script>
(function () {

    const shell = document.getElementById('scholarShell');
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const overlay = document.getElementById('sidebarOverlay');

    if (!shell || !sidebar || !menuBtn || !overlay) {
        return;
    }

    const mobileQuery = window.matchMedia('(max-width: 768px)');

    /*
     * Bersihkan handler langsung pada tombol dari
     * script lama agar toggle tidak berjalan dua kali.
     */
    const cleanButton = menuBtn.cloneNode(true);

    menuBtn.parentNode.replaceChild(cleanButton, menuBtn);

    function updateButton() {

        const isMobile = mobileQuery.matches;

        const isExpanded = isMobile
            ? shell.classList.contains('mobile-sidebar-open')
            : !shell.classList.contains('sidebar-collapsed');

        cleanButton.setAttribute(
            'aria-expanded',
            isExpanded ? 'true' : 'false'
        );

        cleanButton.setAttribute(
            'aria-label',
            isExpanded ? 'Tutup sidebar' : 'Buka sidebar'
        );

    }

    function closeMobileSidebar() {

        shell.classList.remove('mobile-sidebar-open');
        document.body.classList.remove('sidebar-lock');

        updateButton();

    }

    function toggleSidebar() {

        if (mobileQuery.matches) {

            shell.classList.toggle('mobile-sidebar-open');

            document.body.classList.toggle(
                'sidebar-lock',
                shell.classList.contains('mobile-sidebar-open')
            );

        } else {

            shell.classList.toggle('sidebar-collapsed');

        }

        updateButton();

    }

    /*
     * Tombol hamburger.
     */

    cleanButton.addEventListener('click', toggleSidebar);

    /*
     * Klik overlay untuk menutup sidebar mobile.
     */

    overlay.addEventListener('click', closeMobileSidebar);

    /*
     * Klik menu pada mobile otomatis menutup sidebar.
     */

    sidebar.querySelectorAll('.nav a').forEach(function (link) {

        link.addEventListener('click', function () {

            if (mobileQuery.matches) {
                closeMobileSidebar();
            }

        });

    });

    /*
     * Tombol Escape untuk menutup sidebar mobile.
     */

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape'
            && shell.classList.contains('mobile-sidebar-open')
        ) {
            closeMobileSidebar();
        }

    });

    /*
     * Ketika ukuran layar berubah,
     * reset kondisi sidebar sesuai perangkat.
     */

    function handleResize() {

        if (mobileQuery.matches) {

            shell.classList.remove('sidebar-collapsed');

        } else {

            closeMobileSidebar();
            shell.classList.remove('mobile-sidebar-open');

        }

        updateButton();

    }

    if (typeof mobileQuery.addEventListener === 'function') {

        mobileQuery.addEventListener('change', handleResize);

    } else {

        mobileQuery.addListener(handleResize);

    }

    updateButton();

})();
</script>

@stack('scripts')

</body>
</html>

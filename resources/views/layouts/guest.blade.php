<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · SI Beasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth">
    <section class="auth-side">
        <a href="{{ route('home') }}" class="brand" style="padding:0"><span class="brand-mark">SB</span> SI Beasiswa</a>
        <div>
            <h2>Satu akun untuk seluruh proses beasiswa Anda.</h2>
            <p>Dari pendaftaran hingga KTM digital, pantau setiap tahap langsung dari dashboard.</p>
            <ol>
                <li>Registrasi dan lengkapi data</li>
                <li>Daftar dan unggah berkas</li>
                <li>Verifikasi dan seleksi</li>
                <li>Pengumuman, penempatan, dan KTM digital</li>
            </ol>
        </div>
        <small style="color:var(--maroon-200)">© {{ date('Y') }} SI Beasiswa</small>
    </section>
    <section class="auth-form">
        <div class="auth-box">
            @yield('content')
        </div>
    </section>
</div>
</body>
</html>

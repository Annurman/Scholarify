
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SI Beasiswa | Scholarify</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* =================================
           GLOBAL
        ================================= */

        .landing-page {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            color: #35121f;
            background: #fff;
        }

        /* =================================
           NAVIGATION
        ================================= */

        .landing-page .modern-nav {
            min-height: 90px;
            padding: 15px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            background: #fff;
            position: relative;
            z-index: 10;
        }

        .landing-page .modern-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: #650f2b;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .landing-page .modern-brand small {
            display: block;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0;
            color: #806d75;
            margin-top: 4px;
        }

        .landing-page .modern-logo {
            width: 54px;
            height: 54px;
            border-radius: 15px;
            background: #650f2b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .landing-page .modern-nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .landing-page .modern-nav-links a,
        .landing-page .modern-login {
            text-decoration: none;
            color: #49313b;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .landing-page .modern-nav-links a:hover,
        .landing-page .modern-login:hover {
            color: #a13c5b;
        }

        .landing-page .modern-nav-actions {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .landing-page .modern-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 25px;
            border-radius: 10px;
            background: #650f2b;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: .2s;
        }

        .landing-page .modern-btn:hover {
            background: #8d2948;
            transform: translateY(-2px);
        }

        /* =================================
           HERO SECTION
        ================================= */

        .landing-page .modern-hero {
            display: grid;
            grid-template-columns: 0.95fr 1.15fr;
            align-items: start;
            gap: 55px;

            padding: 45px 7% 65px;
            background: #fbf6f7;
            min-height: 0;
        }

        /* TEXT */

        .landing-page .hero-content {
            width: 100%;
            max-width: 550px;
            padding-top: 0;
        }

        .landing-page .hero-label {
            display: inline-block;
            color: #a13c5b;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .landing-page .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 3.2vw, 47px);
            line-height: 1.38;
            letter-spacing: -1px;
            font-weight: 700;

            margin: 0 0 22px;
            color: #40101f;
        }

        .landing-page .hero-content h1 span {
            display: block;
            color: #a13c5b;
        }

        .landing-page .hero-content > p {
            max-width: 480px;
            color: #806d75;
            font-size: 14px;
            line-height: 2;
            margin: 0 0 25px;
        }

        /* BUTTONS */

        .landing-page .hero-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 22px;
        }

        .landing-page .hero-link {
            color: #650f2b;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .landing-page .hero-note {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
            color: #806d75;
            font-size: 12px;
        }

        .landing-page .hero-note span {
            color: #a13c5b;
            font-weight: 800;
        }

        /* IMAGE */

        .landing-page .hero-image-wrap {
            width: 100%;
            height: 410px;
            margin-top: 65px;
            position: relative;
            overflow: hidden;
            border-radius: 18px;
        }

        .landing-page .hero-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 18px;
        }

        /* =================================
           INTRO SECTION
        ================================= */

        .landing-page .intro-section {
            padding: 85px 8%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 70px;
            align-items: center;
        }

        .landing-page .section-label {
            display: inline-block;
            color: #a13c5b;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .landing-page .intro-section h2,
        .landing-page .section-heading h2 {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            line-height: 1.4;
            color: #40101f;
            margin: 0;
        }

        .landing-page .intro-description p {
            font-size: 14px;
            line-height: 2;
            color: #806d75;
        }

        /* =================================
           PROGRAM SECTION
        ================================= */

        .landing-page .program-section {
            padding: 75px 8%;
            background: #fbf6f7;
        }

        .landing-page .section-heading {
            margin-bottom: 35px;
        }

        .landing-page .section-heading > div > p {
            color: #806d75;
            font-size: 14px;
        }

        .landing-page .program-card {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(65, 16, 31, .07);
        }

        .landing-page .program-image {
            min-height: 350px;
            position: relative;
        }

        .landing-page .program-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }

        .landing-page .program-tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #650f2b;
            color: white;
            border-radius: 30px;
            padding: 9px 15px;
            font-size: 11px;
            font-weight: 700;
        }

        .landing-page .program-content {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .landing-page .program-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: #40101f;
            margin: 5px 0 15px;
        }

        .landing-page .program-content > p {
            font-size: 14px;
            line-height: 1.9;
            color: #806d75;
        }

        .landing-page .program-info {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0 25px;
        }

        .landing-page .program-info small {
            display: block;
            color: #927e86;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .landing-page .program-info strong {
            color: #650f2b;
            font-size: 13px;
        }

        /* =================================
           PROCESS SECTION
        ================================= */

        .landing-page .process-section {
            padding: 85px 8%;
        }

        .landing-page .centered {
            text-align: center;
        }

        .landing-page .process-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 45px;
        }

        .landing-page .process-card {
            padding: 30px;
            border: 1px solid #f0e4e8;
            border-radius: 16px;
            position: relative;
            background: white;
            transition: .2s;
        }

        .landing-page .process-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(65, 16, 31, .07);
        }

        .landing-page .process-number {
            color: #c18b9d;
            font-size: 13px;
            font-weight: 800;
        }

        .landing-page .process-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: #fbf0f3;
            color: #8d2948;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            margin: 20px 0;
        }

        .landing-page .process-card h3 {
            color: #40101f;
            font-size: 17px;
        }

        .landing-page .process-card p {
            color: #806d75;
            font-size: 13px;
            line-height: 1.8;
        }

        /* =================================
           ANNOUNCEMENT
        ================================= */

        .landing-page .announcement-section {
            padding: 65px 8%;
            background: #fbf6f7;
        }

        .landing-page .announcement-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .landing-page .announcement-icon {
            width: 42px;
            height: 42px;
            background: #fbf0f3;
            color: #a13c5b;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .landing-page .announcement-item strong {
            color: #40101f;
            font-size: 14px;
        }

        .landing-page .announcement-item p {
            color: #806d75;
            font-size: 12px;
            margin-bottom: 0;
        }

        .landing-page .announcement-item > small {
            margin-left: auto;
            color: #927e86;
            font-size: 11px;
            white-space: nowrap;
        }

        /* =================================
           FOOTER
        ================================= */

        .landing-page .modern-footer {
            background: #40101f;
            color: white;
            padding: 45px 8%;
            text-align: center;
        }

        .landing-page .footer-brand {
            justify-content: center;
            color: white;
        }

        .landing-page .footer-brand small {
            color: #e1c5cf;
        }

        .landing-page .footer-brand .modern-logo {
            background: #fff;
            color: #650f2b;
        }

        .landing-page .modern-footer p {
            color: #e1c5cf;
            font-size: 13px;
            margin: 22px 0;
        }

        .landing-page .modern-footer > small {
            color: #cbaab6;
            font-size: 11px;
        }

        /* =================================
           RESPONSIVE
        ================================= */

        @media (max-width: 950px) {
            .landing-page .modern-nav {
                flex-wrap: wrap;
            }

            .landing-page .modern-nav-links {
                gap: 18px;
            }

            .landing-page .modern-hero {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
                padding: 40px 5%;
            }

            .landing-page .hero-content h1 {
                font-size: 37px;
            }

            .landing-page .hero-image-wrap {
                height: 340px;
                margin-top: 60px;
            }
        }

        @media (max-width: 700px) {
            .landing-page .modern-nav {
                padding: 15px 5%;
            }

            .landing-page .modern-nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .landing-page .modern-nav-actions {
                gap: 12px;
            }

            .landing-page .modern-hero {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 40px 6%;
            }

            .landing-page .hero-content {
                max-width: 100%;
            }

            .landing-page .hero-content h1 {
                font-size: 39px;
                line-height: 1.3;
            }

            .landing-page .hero-image-wrap {
                height: 280px;
                margin-top: 0;
            }

            .landing-page .intro-section,
            .landing-page .program-card {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .landing-page .intro-section {
                padding: 60px 6%;
            }

            .landing-page .program-section,
            .landing-page .process-section,
            .landing-page .announcement-section {
                padding: 60px 6%;
            }

            .landing-page .process-grid {
                grid-template-columns: 1fr;
            }

            .landing-page .program-image {
                min-height: 250px;
            }

            .landing-page .program-content {
                padding: 25px;
            }

            .landing-page .announcement-item {
                flex-wrap: wrap;
            }
        }

    </style>
</head>

<body class="landing-page">

<!-- NAVIGATION -->

<nav class="modern-nav">

    <a href="{{ route('home') }}" class="modern-brand">
        <span class="modern-logo">SB</span>

        <span>
            SCHOLARIFY
            <small>Scholarship Information System</small>
        </span>
    </a>

    <div class="modern-nav-links">
        <a href="#tentang">Tentang</a>
        <a href="#program">Program Beasiswa</a>
        <a href="#alur">Alur Pendaftaran</a>
    </div>

    <div class="modern-nav-actions">

        @auth
            <a href="{{ route('dashboard') }}" class="modern-btn">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="modern-login">
                Masuk
            </a>

            <a href="{{ route('register') }}" class="modern-btn">
                Daftar Sekarang
            </a>
        @endauth

    </div>

</nav>

@php
    $program = $beasiswa->first();
@endphp

<!-- HERO SECTION -->

<header class="modern-hero">

    <div class="hero-content">

        <span class="hero-label">
            ✦ PROGRAM BEASISWA MAHASISWA
        </span>

        <h1>
            Wujudkan Potensi,
            <span>Raih Masa Depan</span>
            yang Lebih Baik.
        </h1>

        <p>
            Kesempatan untuk berkembang, meraih pendidikan
            yang lebih baik, dan menjadi generasi yang
            memberikan dampak positif.
        </p>

        <div class="hero-actions">

            @guest
                <a href="{{ route('register') }}" class="modern-btn hero-btn">
                    Mulai Pendaftaran →
                </a>

                <a href="#tentang" class="hero-link">
                    Pelajari lebih lanjut
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="modern-btn hero-btn">
                    Buka Dashboard →
                </a>
            @endguest

        </div>

        <div class="hero-note">
            <span>✓</span> Pendaftaran online
            <span>✓</span> Proses transparan
        </div>

    </div>

    <div class="hero-image-wrap">

        <img
            src="{{ asset('images/graduation.jpeg') }}"
            alt="Ilustrasi perayaan kelulusan mahasiswa"
            class="hero-image"
        >

    </div>

</header>

<!-- INTRO SECTION -->

<section class="intro-section" id="tentang">

    <div class="intro-heading">

        <span class="section-label">
            TENTANG PROGRAM
        </span>

        <h2>
            Lebih dari sekadar bantuan pendidikan.
        </h2>

    </div>

    <div class="intro-description">

        <p>
            Program beasiswa ini hadir untuk mendukung mahasiswa
            dalam mengembangkan potensi akademik maupun nonakademik.
            Penerima beasiswa juga akan mengikuti kegiatan pembinaan
            dan monitoring secara berkala.
        </p>

    </div>

</section>

<!-- PROGRAM SECTION -->

<section class="program-section" id="program">

    <div class="section-heading">

        <div>
            <span class="section-label">
                KESEMPATAN BEASISWA
            </span>

            <h2>Program Beasiswa</h2>

            <p>
                Kenali program dan persiapkan pendaftaranmu.
            </p>
        </div>

    </div>

    @if($program)

        <div class="program-card">

            <div class="program-image">

                <img
                    src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=85"
                    alt="Mahasiswa sedang belajar bersama"
                >

                <span class="program-tag">
                    PROGRAM UTAMA
                </span>

            </div>

            <div class="program-content">

                <span class="section-label">
                    PROGRAM BEASISWA
                </span>

                <h3>{{ $program->nama }}</h3>

                <p>
                    {{ \Illuminate\Support\Str::limit($program->deskripsi, 220) }}
                </p>

                <div class="program-info">

                    <div>
                        <small>Kuota penerima</small>

                        <strong>
                            {{ $program->kuota }} Mahasiswa
                        </strong>
                    </div>

                    <div>
                        <small>Batas pendaftaran</small>

                        <strong>
                            {{ $program->tgl_tutup->translatedFormat('d F Y') }}
                        </strong>
                    </div>

                </div>

                @guest
                    <a href="{{ route('register') }}" class="modern-btn">
                        Daftar Beasiswa →
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="modern-btn">
                        Lihat Dashboard →
                    </a>
                @endguest

            </div>

        </div>

    @else

        <div class="empty">
            <h3>Program beasiswa belum tersedia</h3>
            Silakan kunjungi halaman ini kembali.
        </div>

    @endif

</section>

<!-- PROCESS SECTION -->

<section class="process-section" id="alur">

    <div class="section-heading centered">

        <span class="section-label">
            LANGKAH MENUJU MASA DEPAN
        </span>

        <h2>Bagaimana Cara Mendaftar?</h2>

        <p>
            Ikuti tahapan pendaftaran beasiswa dengan mudah.
        </p>

    </div>

    <div class="process-grid">

        <div class="process-card">

            <span class="process-number">01</span>

            <div class="process-icon">♙</div>

            <h3>Buat Akun</h3>

            <p>
                Daftarkan akun dan lengkapi identitas mahasiswa.
            </p>

        </div>

        <div class="process-card">

            <span class="process-number">02</span>

            <div class="process-icon">▤</div>

            <h3>Lengkapi Berkas</h3>

            <p>
                Isi formulir dan unggah dokumen persyaratan.
            </p>

        </div>

        <div class="process-card">

            <span class="process-number">03</span>

            <div class="process-icon">✓</div>

            <h3>Proses Seleksi</h3>

            <p>
                Tunggu proses verifikasi dan hasil seleksi.
            </p>

        </div>

    </div>

</section>

<!-- ANNOUNCEMENT SECTION -->

@if($pengumuman->isNotEmpty())

<section class="announcement-section">

    <div class="section-heading">

        <div>
            <span class="section-label">
                INFORMASI TERBARU
            </span>

            <h2>Pengumuman</h2>
        </div>

    </div>

    @foreach($pengumuman as $p)

        <div class="announcement-item">

            <div class="announcement-icon">
                ✦
            </div>

            <div>
                <strong>{{ $p->judul }}</strong>

                <p>
                    {{ $p->beasiswa->nama }}
                </p>
            </div>

            <small>
                {{ $p->tgl_publish->translatedFormat('d F Y') }}
            </small>

        </div>

    @endforeach

</section>

@endif

<!-- FOOTER -->

<footer class="modern-footer">

    <div class="modern-brand footer-brand">

        <span class="modern-logo">SB</span>

        <span>
            SCHOLARIFY
            <small>Scholarship Information System</small>
        </span>

    </div>

    <p>
        Sistem Informasi Pendaftaran dan Pengelolaan
        Beasiswa Mahasiswa.
    </p>

    <small>
        © {{ date('Y') }} Scholarify. All rights reserved.
    </small>

</footer>

</body>
</html>

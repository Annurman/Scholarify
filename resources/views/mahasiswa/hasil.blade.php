
@extends('layouts.app')

@section('title', 'Hasil & Penempatan')

@section('content')

<style>
    /* =========================================
       1. HALAMAN UTAMA
    ========================================= */

    .hasil-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .hasil-hero {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        color: #fff;
        border-radius: 20px;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .hasil-hero::after {
        content: '✦';
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 100px;
        color: rgba(255,255,255,.10);
        pointer-events: none;
    }

    .hasil-hero h1 {
        color: #FFFFFF !important;
        margin: 0 0 9px;
        font-size: 27px;
        font-weight: 800;
    }

    .hasil-hero p {
        color: #FCEEF2;
        margin: 0;
        max-width: 550px;
        font-size: 13px;
        line-height: 1.7;
    }

    /* =========================================
       2. KARTU BEASISWA
    ========================================= */

    .hasil-card {
        background: #FFFFFF;
        border: 1px solid #F0E2E7;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 5px 18px rgba(101,15,43,.04);
    }

    .hasil-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-bottom: 17px;
        border-bottom: 1px solid #F2E7EA;
        margin-bottom: 18px;
    }

    .hasil-card-head h2 {
        color: #40101F;
        font-size: 19px;
        font-weight: 800;
        margin: 0;
    }

    .hasil-date {
        color: #987985;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        text-align: right;
        flex-shrink: 0;
    }

    /* =========================================
       3. PANEL STATUS UTAMA
    ========================================= */

    .hasil-status-panel {
        display: grid;
        grid-template-columns: 62px minmax(0, 1fr);
        align-items: center;
        gap: 16px;
        border: 1px solid;
        border-radius: 15px;
        padding: 21px 24px;
        margin: 12px 0 8px;
        text-align: left;
    }

    .hasil-status-icon {
        width: 62px;
        height: 62px;
        min-width: 62px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hasil-status-icon svg {
        width: 34px;
        height: 34px;
        display: block;
    }

    .hasil-status-content {
        min-width: 0;
    }

    .hasil-status-kicker {
        display: block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.2px;
        margin-bottom: 6px;
    }

    .hasil-status-title {
        font-size: 23px;
        font-weight: 900;
        line-height: 1.3;
        margin: 0 0 7px;
    }

    .hasil-status-description {
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    /* =========================================
       4. STATUS LULUS - HIJAU
    ========================================= */

    .hasil-status-panel.success {
        background: #ECFDF3;
        border-color: #A6F4C5;
        color: #027A48;
    }

    .hasil-status-panel.success .hasil-status-icon {
        background: #16A34A;
        color: #FFFFFF;
    }

    .hasil-status-panel.success .hasil-status-kicker,
    .hasil-status-panel.success .hasil-status-title {
        color: #027A48;
    }

    .hasil-status-panel.success .hasil-status-description {
        color: #05603A;
    }

    /* =========================================
       5. STATUS TIDAK LULUS - MERAH
    ========================================= */

    .hasil-status-panel.danger {
        background: #FFF1F0;
        border-color: #FDA29B;
        color: #B42318;
    }

    .hasil-status-panel.danger .hasil-status-icon {
        background: #D92D20;
        color: #FFFFFF;
    }

    .hasil-status-panel.danger .hasil-status-kicker,
    .hasil-status-panel.danger .hasil-status-title {
        color: #B42318;
    }

    .hasil-status-panel.danger .hasil-status-description {
        color: #912018;
    }

    /* =========================================
       6. STATUS BEASISWA DICABUT - MERAH
    ========================================= */

    .hasil-status-panel.revoked {
        background: #FFF1F0;
        border-color: #FDA29B;
        color: #B42318;
    }

    .hasil-status-panel.revoked .hasil-status-icon {
        background: #D92D20;
        color: #FFFFFF;
    }

    .hasil-status-panel.revoked .hasil-status-kicker,
    .hasil-status-panel.revoked .hasil-status-title {
        color: #B42318;
    }

    .hasil-status-panel.revoked .hasil-status-description {
        color: #912018;
    }

    /* =========================================
       7. MENUNGGU PENGUMUMAN - KUNING
    ========================================= */

    .hasil-status-panel.pending {
        background: #FFF8E9;
        border-color: #F1E3BD;
        color: #896313;
    }

    .hasil-status-panel.pending .hasil-status-icon {
        background: #986A0A;
        color: #FFFFFF;
    }

    .hasil-status-panel.pending .hasil-status-kicker,
    .hasil-status-panel.pending .hasil-status-title {
        color: #896313;
    }

    .hasil-status-panel.pending .hasil-status-description {
        color: #765614;
    }

    /* =========================================
       8. PESAN DARI PENYELENGGARA
    ========================================= */

    .hasil-announcement {
        margin-top: 20px;
        padding-top: 17px;
        border-top: 1px solid #F0E2E7;
    }

    .hasil-announcement-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 12px;
    }

    .hasil-announcement-title h3 {
        color: #650F2B;
        font-size: 13px;
        font-weight: 800;
        margin: 0;
    }

    .announcement-line {
        width: 4px;
        height: 17px;
        background: #A13C5B;
        border-radius: 5px;
        flex-shrink: 0;
    }

    .hasil-announcement h4 {
        color: #40101F;
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 12px;
        line-height: 1.5;
    }

    .hasil-announcement-body {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin: 0;
    }

    .hasil-announcement-body p {
        color: #6F5962;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
        text-align: left;
        overflow-wrap: break-word;
        white-space: pre-line;
    }

    /* =========================================
       9. FOOTER INFORMASI PENERIMA
    ========================================= */

    .hasil-recipient-footer {
        margin-top: 18px;
        padding: 19px 21px;
        background: #F8FAF9;
        border: 1px solid #E1EAE5;
        border-radius: 13px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .hasil-footer-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .hasil-footer-label {
        display: block;
        color: #819188;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .9px;
        margin-bottom: 6px;
    }

    .hasil-footer-value {
        color: #253D31;
        font-size: 14px;
        font-weight: 700;
    }

    .hasil-active-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 12px;
        background: #DCFCE7;
        color: #166534;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .hasil-active-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #16A34A;
    }

    .hasil-footer-divider {
        border: 0;
        border-top: 1px solid #E1EAE5;
        margin: 0;
    }

    .hasil-placement-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .hasil-placement-grid strong {
        color: #253D31;
        font-size: 13px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .hasil-placement-pending {
        color: #64756B;
        font-size: 12px;
        line-height: 1.7;
        margin: 0;
    }

    .hasil-footer-ktm {
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        background: #166534;
        color: #FFFFFF !important;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .hasil-footer-ktm:hover {
        background: #14532D;
    }

    /* =========================================
       10. HALAMAN KOSONG
    ========================================= */

    .hasil-empty {
        text-align: center;
        padding: 35px 20px;
    }

    .hasil-empty h3 {
        color: #650F2B;
        font-size: 17px;
        margin: 0 0 8px;
    }

    /* =========================================
       11. RESPONSIVE MOBILE
    ========================================= */

    @media(max-width: 600px) {

        .hasil-hero {
            padding: 23px;
        }

        .hasil-hero h1 {
            font-size: 22px;
        }

        .hasil-card {
            padding: 18px;
        }

        .hasil-card-head {
            align-items: flex-start;
            gap: 8px;
        }

        .hasil-card-head h2 {
            font-size: 16px;
        }

        .hasil-date {
            font-size: 10px;
            white-space: normal;
        }

        .hasil-status-panel {
            grid-template-columns: 48px minmax(0, 1fr);
            padding: 18px;
            gap: 13px;
        }

        .hasil-status-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
        }

        .hasil-status-icon svg {
            width: 28px;
            height: 28px;
        }

        .hasil-status-title {
            font-size: 19px;
        }

        .hasil-status-description {
            font-size: 12px;
        }

        .hasil-recipient-footer {
            padding: 16px;
        }

        .hasil-placement-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        .hasil-announcement h4 {
            font-size: 14px;
        }
    }
</style>


<div class="hasil-page">

    {{-- =====================================
         HEADER HALAMAN
    ====================================== --}}

    <div class="hasil-hero">

        <h1>Hasil Seleksi & Penempatan</h1>

        <p>
            Pantau hasil seleksi beasiswa, informasi kelompok pembinaan,
            mentor, serta KTM digital Anda melalui halaman ini.
        </p>

    </div>


    {{-- =====================================
         DAFTAR PENDAFTARAN BEASISWA
    ====================================== --}}

    @forelse($pendaftaran as $p)

        @php
            $umum = $p->diumumkan();

            // Mengambil pengumuman terbaru untuk beasiswa terkait.
            $pengumumanBeasiswa = $pengumuman
                ->where('beasiswa_id', $p->beasiswa_id)
                ->sortByDesc('tgl_publish')
                ->first();
        @endphp


        <div class="hasil-card">

            {{-- HEADER KARTU --}}
            <div class="hasil-card-head">

                <h2>{{ $p->beasiswa->nama }}</h2>

                @if($umum && $pengumumanBeasiswa)

                    <span class="hasil-date">
                        Dipublikasikan:
                        {{ $pengumumanBeasiswa->tgl_publish->translatedFormat('d M Y, H:i') }}
                        WIB
                    </span>

                @endif

            </div>


            {{-- =================================
                 STATUS UTAMA
            ================================== --}}

            {{-- PRIORITAS 1: BEASISWA DICABUT --}}
            @if($p->status_beasiswa === 'dicabut')

                <div class="hasil-status-panel revoked">

                    <div class="hasil-status-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M6 6L18 18M18 6L6 18"
                                stroke="currentColor"
                                stroke-width="3"
                                stroke-linecap="round"
                            />
                        </svg>

                    </div>

                    <div class="hasil-status-content">

                        <span class="hasil-status-kicker">
                            STATUS PENERIMA BEASISWA
                        </span>

                        <h3 class="hasil-status-title">
                            BEASISWA DICABUT
                        </h3>

                        <p class="hasil-status-description">
                            Status penerima beasiswa Anda telah dicabut
                            oleh penyelenggara. Akses pembinaan dan KTM
                            digital telah dinonaktifkan.
                        </p>

                    </div>

                </div>


            {{-- PRIORITAS 2: BELUM DIUMUMKAN --}}
            @elseif(! $umum)

                <div class="hasil-status-panel pending">

                    <div class="hasil-status-icon">
                        <span style="font-size: 22px; font-weight: 900;">
                            ...
                        </span>
                    </div>

                    <div class="hasil-status-content">

                        <span class="hasil-status-kicker">
                            INFORMASI HASIL SELEKSI
                        </span>

                        <h3 class="hasil-status-title">
                            MENUNGGU PENGUMUMAN
                        </h3>

                        <p class="hasil-status-description">
                            Hasil seleksi beasiswa belum diumumkan.
                            Silakan periksa kembali halaman ini setelah
                            penyelenggara menerbitkan pengumuman resmi.
                        </p>

                    </div>

                </div>


            {{-- PRIORITAS 3: LULUS --}}
            @elseif($p->status === 'lulus')

                <div class="hasil-status-panel success">

                    <div class="hasil-status-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M5 12L10 17L20 7"
                                stroke="currentColor"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                    <div class="hasil-status-content">

                        <span class="hasil-status-kicker">
                            HASIL SELEKSI BEASISWA
                        </span>

                        <h3 class="hasil-status-title">
                            SELAMAT! ANDA DINYATAKAN LULUS
                        </h3>

                        <p class="hasil-status-description">
                            Anda berhasil lolos seleksi dan dinyatakan
                            sebagai penerima beasiswa.
                        </p>

                    </div>

                </div>


            {{-- PRIORITAS 4: TIDAK LULUS --}}
            @elseif($p->status === 'tidak_lulus')

                <div class="hasil-status-panel danger">

                    <div class="hasil-status-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M6 6L18 18M18 6L6 18"
                                stroke="currentColor"
                                stroke-width="3"
                                stroke-linecap="round"
                            />
                        </svg>

                    </div>

                    <div class="hasil-status-content">

                        <span class="hasil-status-kicker">
                            HASIL SELEKSI BEASISWA
                        </span>

                        <h3 class="hasil-status-title">
                            MOHON MAAF, ANDA BELUM LULUS
                        </h3>

                        <p class="hasil-status-description">
                            Anda belum berhasil lolos seleksi beasiswa ini.
                            Terima kasih telah mengikuti seluruh proses
                            seleksi yang diselenggarakan.
                        </p>

                    </div>

                </div>


            {{-- PRIORITAS 5: STATUS LAINNYA --}}
            @else

                <div class="hasil-status-panel pending">

                    <div class="hasil-status-icon">
                        <span style="font-size: 22px; font-weight: 900;">
                            ...
                        </span>
                    </div>

                    <div class="hasil-status-content">

                        <span class="hasil-status-kicker">
                            STATUS PENDAFTARAN
                        </span>

                        <h3 class="hasil-status-title">
                            {{ strtoupper(\App\Models\Pendaftaran::label($p->status)) }}
                        </h3>

                        <p class="hasil-status-description">
                            Pendaftaran Anda masih dalam proses.
                        </p>

                    </div>

                </div>

            @endif


            {{-- =================================
                 PESAN DARI PENYELENGGARA
            ================================== --}}

            @if(
                $umum
                && $p->status_beasiswa !== 'dicabut'
                && $pengumumanBeasiswa
            )

                <div class="hasil-announcement">

                    <div class="hasil-announcement-title">

                        <span class="announcement-line"></span>

                        <h3>Pesan dari Penyelenggara</h3>

                    </div>

                    <h4>
                        {{ $pengumumanBeasiswa->judul }}
                    </h4>

                    @php
                        $paragrafPengumuman = preg_split(
                            '/\R\s*\R+/',
                            trim((string) $pengumumanBeasiswa->isi)
                        );
                    @endphp

                    <div class="hasil-announcement-body">

                        @foreach($paragrafPengumuman as $paragraf)

                            @if(trim($paragraf) !== '')

                                <p>{{ trim($paragraf) }}</p>

                            @endif

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- =================================
                 FOOTER INFORMASI PENERIMA
            ================================== --}}

            @if(
                $umum
                && $p->status === 'lulus'
                && $p->status_beasiswa !== 'dicabut'
            )

                <div class="hasil-recipient-footer">

                    {{-- STATUS PENERIMA --}}
                    <div class="hasil-footer-status">

                        <div>

                            <span class="hasil-footer-label">
                                STATUS PENERIMA BEASISWA
                            </span>

                            <strong class="hasil-footer-value">
                                Penerima Beasiswa
                            </strong>

                        </div>

                        <span class="hasil-active-badge">

                            <span class="hasil-active-dot"></span>

                            {{ ucfirst($p->status_beasiswa ?? 'aktif') }}

                        </span>

                    </div>


                    <hr class="hasil-footer-divider">


                    {{-- INFORMASI PENEMPATAN --}}
                    <div>

                        <span class="hasil-footer-label">
                            PENEMPATAN KELOMPOK PEMBINAAN
                        </span>

                        @if($p->kelompok)

                            <div class="hasil-placement-grid">

                                <div>

                                    <span class="hasil-footer-label">
                                        Kelompok
                                    </span>

                                    <strong>
                                        {{ $p->kelompok->nama_kelompok }}
                                    </strong>

                                </div>

                                <div>

                                    <span class="hasil-footer-label">
                                        Mentor
                                    </span>

                                    <strong>
                                        {{ $p->kelompok->mentor->name ?? $p->kelompok->pembina ?? '-' }}
                                    </strong>

                                </div>

                                <div>

                                    <span class="hasil-footer-label">
                                        Jadwal
                                    </span>

                                    <strong>
                                        {{ $p->kelompok->jadwal ?: '-' }}
                                    </strong>

                                </div>

                            </div>

                        @else

                            <p class="hasil-placement-pending">
                                Penempatan kelompok pembinaan belum ditetapkan.
                                Informasi kelompok dan mentor akan ditampilkan
                                setelah admin menyelesaikan proses penempatan.
                            </p>

                        @endif

                    </div>


                    {{-- KTM DIGITAL --}}
                    @if($p->kelompok)

                        @if($p->ktm && $p->ktm->status === 'aktif')

                            <a
                                class="hasil-footer-ktm"
                                href="{{ route('mahasiswa.ktm') }}"
                            >
                                Lihat KTM Digital →
                            </a>

                        @else

                            <p class="hasil-placement-pending">
                                KTM digital Anda sedang diproses oleh Admin.
                            </p>

                        @endif

                    @endif

                </div>

            @endif

        </div>


    @empty

        <div class="hasil-card">

            <div class="hasil-empty">

                <h3>Belum Ada Pendaftaran</h3>

                <p class="hasil-status-description" style="color: #856F78;">
                    Anda belum memiliki riwayat pendaftaran beasiswa.
                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection


@extends('layouts.app')

@section('title', 'Monitoring Saya')

@section('content')

<style>
    /* =========================================
       1. HALAMAN MONITORING
    ========================================= */

    .monitor-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
        color: #40101F;
    }

    /* =========================================
       2. HEADER HALAMAN
    ========================================= */

    .monitor-hero {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        padding: 30px;
        border-radius: 20px;
        color: white;
    }

    .monitor-hero h1 {
        color: #FFFFFF !important;
        font-size: 27px;
        font-weight: 800;
        margin: 0 0 9px;
    }

    .monitor-hero p {
        color: #FCEEF2;
        margin: 0;
        font-size: 13px;
        line-height: 1.7;
        max-width: 550px;
    }

    /* =========================================
       3. KARTU MONITORING
    ========================================= */

    .monitor-card {
        background: #fff;
        border: 1px solid #F0E2E7;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 5px 18px rgba(101,15,43,.04);
    }

    .monitor-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-bottom: 16px;
        border-bottom: 1px solid #F2E7EA;
        margin-bottom: 18px;
    }

    .monitor-head h2 {
        color: #40101F;
        font-size: 19px;
        font-weight: 800;
        margin: 0;
    }

    /* =========================================
       4. INFORMASI KELOMPOK
    ========================================= */

    .monitor-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .monitor-info-item {
        background: #FBF6F7;
        padding: 17px;
        border-radius: 12px;
        min-width: 0;
    }

    .monitor-info-item small {
        color: #927783;
        display: block;
        font-size: 12px;
        margin-bottom: 7px;
    }

    .monitor-info-item strong {
        color: #650F2B;
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    /* =========================================
       5. STATUS BEASISWA DICABUT
    ========================================= */

    .monitor-revoked {
        background: #FFF5F4;
        border: 1px solid #FDA29B;
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: flex-start;
        gap: 17px;
    }

    .monitor-revoked-icon {
        width: 55px;
        height: 55px;
        min-width: 55px;
        background: #D92D20;
        color: #FFFFFF;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .monitor-revoked-content {
        min-width: 0;
    }

    .monitor-revoked-label {
        display: block;
        color: #B42318;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 7px;
    }

    .monitor-revoked h2 {
        color: #B42318;
        font-size: 21px;
        font-weight: 900;
        margin: 0 0 8px;
    }

    .monitor-revoked p {
        color: #912018;
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
    }

    .monitor-revoked-note {
        margin-top: 14px !important;
        padding-top: 13px;
        border-top: 1px solid #F5C7C3;
        font-size: 12px !important;
        color: #A12D35 !important;
    }

    /* =========================================
       6. TABEL MONITORING
    ========================================= */

    .monitor-table {
        width: 100%;
        overflow-x: auto;
    }

    .monitor-table table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .monitor-table th {
        background: #FBF6F7;
        color: #650F2B;
        font-size: 13px;
        text-align: left;
        padding: 14px;
        white-space: nowrap;
    }

    .monitor-table td {
        padding: 15px 14px;
        border-bottom: 1px solid #F2E7EA;
        color: #604C55;
        font-size: 13px;
        vertical-align: top;
    }

    .monitor-table tr:last-child td {
        border-bottom: none;
    }

    .monitor-table td strong {
        color: #650F2B;
    }

    /* =========================================
       7. EMPTY STATE
    ========================================= */

    .monitor-empty {
        text-align: center;
        padding: 35px 15px;
        color: #856F78;
        line-height: 1.7;
        font-size: 13px;
    }

    .monitor-empty h3 {
        color: #650F2B;
        font-size: 16px;
        margin: 0 0 8px;
    }

    /* =========================================
       8. RESPONSIVE
    ========================================= */

    @media(max-width: 600px) {

        .monitor-hero {
            padding: 23px;
        }

        .monitor-hero h1 {
            font-size: 22px;
        }

        .monitor-card {
            padding: 18px;
        }

        .monitor-info {
            grid-template-columns: 1fr;
        }

        .monitor-revoked {
            padding: 18px;
            gap: 13px;
        }

        .monitor-revoked-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
        }

        .monitor-revoked h2 {
            font-size: 17px;
        }

        .monitor-revoked p {
            font-size: 12px;
        }
    }
</style>


<div class="monitor-page">

    {{-- =====================================
         HEADER
    ====================================== --}}

    <div class="monitor-hero">

        <h1>Monitoring Saya</h1>

        <p>
            Pantau perkembangan kehadiran dan keaktifan Anda
            selama mengikuti kegiatan pembinaan beasiswa.
        </p>

    </div>


    {{-- =====================================
         PRIORITAS 1: BEASISWA DICABUT
    ====================================== --}}

    @if($pendaftaran && $pendaftaran->status_beasiswa === 'dicabut')

        <div class="monitor-card">

            <div class="monitor-revoked">

                <div class="monitor-revoked-icon">

                    <svg
                        width="27"
                        height="27"
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

                <div class="monitor-revoked-content">

                    <span class="monitor-revoked-label">
                        INFORMASI STATUS BEASISWA
                    </span>

                    <h2>
                        STATUS BEASISWA DICABUT
                    </h2>

                    <p>
                        Status Anda sebagai penerima beasiswa
                        telah dicabut oleh penyelenggara beasiswa.
                        Oleh karena itu, Anda tidak lagi terdaftar
                        sebagai peserta aktif dalam kelompok pembinaan.
                    </p>

                    <p class="monitor-revoked-note">
                        Informasi kelompok, mentor, jadwal pembinaan,
                        serta riwayat monitoring tidak lagi ditampilkan
                        pada halaman ini.
                    </p>

                </div>

            </div>

        </div>


    {{-- =====================================
         PRIORITAS 2: BELUM ADA PENEMPATAN
    ====================================== --}}

    @elseif(!$pendaftaran || !$pendaftaran->kelompok)

        <div class="monitor-card monitor-empty">

            <h3>Belum Ada Data Monitoring</h3>

            Riwayat monitoring akan tersedia setelah Anda
            dinyatakan lolos dan ditempatkan ke kelompok pembinaan.

        </div>


    {{-- =====================================
         PRIORITAS 3: PESERTA AKTIF
    ====================================== --}}

    @else

        {{-- INFORMASI PEMBINAAN --}}

        <div class="monitor-card">

            <div class="monitor-head">

                <h2>Informasi Pembinaan</h2>

                <span class="badge badge-aktif">
                    {{ ucfirst($pendaftaran->status_beasiswa ?? 'aktif') }}
                </span>

            </div>


            <div class="monitor-info">

                <div class="monitor-info-item">

                    <small>Nama Kelompok</small>

                    <strong>
                        {{ $pendaftaran->kelompok->nama_kelompok }}
                    </strong>

                </div>


                <div class="monitor-info-item">

                    <small>Nama Mentor</small>

                    <strong>
                        {{ $pendaftaran->kelompok->mentor->name ?? $pendaftaran->kelompok->pembina ?? '-' }}
                    </strong>

                </div>


                <div class="monitor-info-item">

                    <small>Program Beasiswa</small>

                    <strong>
                        {{ $pendaftaran->beasiswa->nama }}
                    </strong>

                </div>


                <div class="monitor-info-item">

                    <small>Jadwal Pembinaan</small>

                    <strong>
                        {{ $pendaftaran->kelompok->jadwal ?: '-' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- RIWAYAT KEHADIRAN DAN KEAKTIFAN --}}

        <div class="monitor-card">

            <div class="monitor-head">

                <h2>Riwayat Kehadiran & Keaktifan</h2>

            </div>


            @if($pendaftaran->monitoring->isEmpty())

                <div class="monitor-empty">

                    <h3>Belum Ada Catatan Monitoring</h3>

                    Mentor belum menambahkan catatan kehadiran
                    dan keaktifan Anda.

                </div>


            @else

                <div class="monitor-table">

                    <table>

                        <thead>

                            <tr>
                                <th>No.</th>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Kehadiran</th>
                                <th>Keaktifan</th>
                                <th>Catatan Mentor</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach(
                                $pendaftaran->monitoring->sortByDesc(
                                    fn($m) => $m->kegiatan->tanggal ?? null
                                ) as $m
                            )

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        <strong>
                                            {{ $m->kegiatan->judul ?? '-' }}
                                        </strong>
                                    </td>


                                    <td>
                                        {{ $m->kegiatan->tanggal?->format('d M Y') ?? '-' }}
                                    </td>


                                    <td>
                                        {{ ucfirst(str_replace('_', ' ', $m->kehadiran)) }}
                                    </td>


                                    <td>
                                        {{ ucfirst(str_replace('_', ' ', $m->keaktifan)) }}
                                    </td>


                                    <td>
                                        {{ $m->catatan ?: '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    @endif

</div>

@endsection

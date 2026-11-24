
@extends('layouts.app')

@section('title', 'Pendaftaran Saya')

@section('content')

<style>
    /* =========================================
       1. HALAMAN PENDAFTARAN
    ========================================= */

    .registration-page {
        max-width: 1100px;
        margin: 0 auto;
        color: #40101F;
    }

    /* =========================================
       2. HEADER
    ========================================= */

    .registration-heading {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        padding: 30px;
        border-radius: 18px;
        margin-bottom: 25px;
    }

    .registration-heading h1 {
        color: #FFFFFF !important;
        font-size: 25px;
        margin: 0 0 9px;
        font-weight: 800;
    }

    .registration-heading p {
        color: #FBF0F3;
        font-size: 14px;
        margin: 0;
        line-height: 1.7;
    }

    /* =========================================
       3. SUMMARY
    ========================================= */

    .registration-summary {
        display: flex;
        align-items: center;
        gap: 15px;
        background: white;
        border: 1px solid #F0DDE3;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 22px;
    }

    .summary-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 13px;
        font-size: 23px;
    }

    .summary-text small {
        display: block;
        color: #987985;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .summary-text strong {
        color: #650F2B;
        font-size: 23px;
    }

    /* =========================================
       4. KARTU PENDAFTARAN
    ========================================= */

    .registration-card {
        background: white;
        border: 1px solid #F0DDE3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(101,15,43,.05);
    }

    .registration-card-head {
        padding: 22px 25px;
        border-bottom: 1px solid #F2E3E7;
    }

    .registration-card-head h2 {
        color: #650F2B;
        font-size: 17px;
        margin: 0 0 5px;
    }

    .registration-card-head p {
        color: #987985;
        font-size: 12px;
        margin: 0;
    }

    /* =========================================
       5. TABEL PENDAFTARAN
    ========================================= */

    .registration-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .registration-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .registration-table th {
        background: #FFF8FA;
        color: #8B2949;
        text-align: left;
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .registration-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #F5E9ED;
        color: #765966;
        font-size: 13px;
    }

    .registration-table tbody tr:hover {
        background: #FFFAFB;
    }

    .registration-table tbody tr:last-child td {
        border-bottom: none;
    }

    .registration-table td strong {
        color: #650F2B;
    }

    /* =========================================
       6. NOMOR PENDAFTARAN
    ========================================= */

    .registration-number {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 9px;
        font-weight: 800;
        margin-right: 9px;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* =========================================
       7. STATUS BEASISWA DICABUT
    ========================================= */

    .registration-status-revoked {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 7px 12px;

        background: #FFF1F0;
        border: 1px solid #FDA29B;
        color: #B42318;

        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .registration-status-revoked .revoked-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #D92D20;
        flex-shrink: 0;
    }

    /* =========================================
       8. TOMBOL DETAIL
    ========================================= */

    .detail-button {
        display: inline-block;
        padding: 9px 15px;
        background: #650F2B;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .detail-button:hover {
        background: #A13C5B;
        color: white;
        transform: translateY(-1px);
    }

    /* =========================================
       9. EMPTY STATE
    ========================================= */

    .registration-empty {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 16px;
    }

    .registration-empty h3 {
        color: #650F2B;
        font-size: 17px;
        margin: 0 0 8px;
    }

    .registration-empty p {
        color: #987985;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .empty-link {
        display: inline-block;
        padding: 11px 18px;
        background: #650F2B;
        color: white;
        text-decoration: none;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
    }

    .empty-link:hover {
        background: #A13C5B;
        color: white;
    }

    /* =========================================
       10. RESPONSIVE
    ========================================= */

    @media(max-width: 650px) {

        .registration-heading {
            padding: 23px 20px;
        }

        .registration-heading h1 {
            font-size: 21px;
        }

        .registration-card-head {
            padding: 18px;
        }

        .registration-summary {
            padding: 17px;
        }
    }
</style>


<div class="registration-page">

    {{-- =====================================
         HEADER
    ====================================== --}}

    <div class="registration-heading">

        <h1>Riwayat Pendaftaran Saya</h1>

        <p>
            Pantau seluruh proses pendaftaran beasiswa dan lihat
            perkembangan status seleksi yang sedang kamu ikuti.
        </p>

    </div>


    {{-- =====================================
         SUMMARY
    ====================================== --}}

    <div class="registration-summary">

        <div class="summary-icon">▤</div>

        <div class="summary-text">

            <small>Total Pendaftaran</small>

            <strong>{{ $pendaftaran->count() }}</strong>

        </div>

    </div>


    {{-- =====================================
         KARTU DAFTAR PENDAFTARAN
    ====================================== --}}

    <div class="registration-card">

        <div class="registration-card-head">

            <h2>Daftar Pendaftaran</h2>

            <p>
                Informasi riwayat dan status pendaftaran beasiswamu.
            </p>

        </div>


        {{-- BELUM ADA PENDAFTARAN --}}
        @if($pendaftaran->isEmpty())

            <div class="registration-empty">

                <div class="empty-icon">♡</div>

                <h3>Belum Ada Pendaftaran</h3>

                <p>
                    Kamu belum mendaftarkan diri pada program beasiswa.
                    Yuk, lihat informasi beasiswa yang tersedia!
                </p>

                <a
                    href="{{ route('mahasiswa.beasiswa.index') }}"
                    class="empty-link"
                >
                    Lihat Beasiswa →
                </a>

            </div>


        {{-- DATA PENDAFTARAN --}}
        @else

            <div class="registration-table-wrap">

                <table class="registration-table">

                    <thead>

                        <tr>
                            <th>Beasiswa</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status Pendaftaran</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pendaftaran as $i => $p)

                            @php
                                // Pencabutan harus diprioritaskan.
                                $dicabut = $p->status_beasiswa === 'dicabut';
                            @endphp

                            <tr>

                                {{-- NAMA BEASISWA --}}
                                <td>

                                    <span class="registration-number">
                                        {{ $i + 1 }}
                                    </span>

                                    <strong>
                                        {{ $p->beasiswa->nama }}
                                    </strong>

                                </td>


                                {{-- TANGGAL PENGAJUAN --}}
                                <td>

                                    {{ $p->submitted_at
                                        ? $p->submitted_at->translatedFormat('d M Y')
                                        : 'Belum diajukan' }}

                                </td>


                                {{-- STATUS PENDAFTARAN --}}
                                <td>

                                    @if($dicabut)

                                        <span class="registration-status-revoked">

                                            <span class="revoked-dot"></span>

                                            Beasiswa Dicabut

                                        </span>

                                    @else

                                        <x-status-badge
                                            :status="$p->status_publik"
                                        />

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <a
                                        class="detail-button"
                                        href="{{ route('mahasiswa.pendaftaran.show', $p) }}"
                                    >
                                        Lihat Detail →
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection


@extends('layouts.app')

@section('title', 'Ringkasan')

@section('content')

<style>
    /* =========================================
       1. STATUS HASIL SELEKSI
    ========================================= */

    .dashboard-admin-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .dashboard-admin-status.lulus {
        background: #E7F7ED;
        color: #237A45;
    }

    .dashboard-admin-status.tidak-lulus {
        background: #FCE9EC;
        color: #B4233C;
    }

    .dashboard-admin-status.lainnya {
        background: #FFF5DD;
        color: #986A0A;
    }

    /* =========================================
       2. STATUS BEASISWA
    ========================================= */

    .dashboard-admin-beasiswa {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .dashboard-admin-beasiswa.aktif {
        background: #E7F7ED;
        color: #237A45;
    }

    .dashboard-admin-beasiswa.dicabut {
        background: #FCE9EC;
        color: #B4233C;
    }

    .dashboard-admin-beasiswa.belum-aktif {
        background: #F3F4F6;
        color: #6B7280;
    }

    .dashboard-admin-beasiswa .status-dot {
        width: 7px;
        height: 7px;
        background: currentColor;
        border-radius: 50%;
    }

    /* =========================================
       3. TABEL PENDAFTARAN TERBARU
    ========================================= */

    .dashboard-admin-table {
        min-width: 800px;
    }

    .dashboard-admin-table th {
        white-space: nowrap;
    }

    .dashboard-admin-table td {
        vertical-align: middle;
    }

    .dashboard-admin-table tbody tr:hover {
        background: #FFFAFB;
    }

    .dashboard-admin-table .student-name {
        color: #650F2B;
        font-weight: 700;
    }

    .dashboard-admin-table .student-detail {
        display: block;
        color: #927E86;
        font-size: 11px;
        margin-top: 5px;
    }

    .dashboard-admin-table .student-revoked {
        background: #FFFAFA;
    }

    /* =========================================
       4. KETERANGAN STATISTIK
    ========================================= */

    .dashboard-admin-note {
        color: #927E86;
        font-size: 11px;
        margin-top: 9px;
        line-height: 1.6;
    }

    /* =========================================
       5. RESPONSIVE
    ========================================= */

    @media(max-width: 600px) {
        .dashboard-admin-table {
            min-width: 800px;
        }
    }
</style>


{{-- =========================================
     HEADER
========================================= --}}

<div class="page-head">

    <div>
        <h1>Ringkasan</h1>

        <p>
            Kondisi pendaftaran beasiswa saat ini.
        </p>
    </div>

</div>


{{-- =========================================
     STATISTIK
========================================= --}}

<div class="stats">

    <div class="stat">

        <div class="num">
            {{ $stats['beasiswa'] }}
        </div>

        <div class="lbl">
            Beasiswa dibuka
        </div>

    </div>


    <div class="stat">

        <div class="num">
            {{ $stats['mahasiswa'] }}
        </div>

        <div class="lbl">
            Mahasiswa terdaftar
        </div>

    </div>


    <div class="stat">

        <div class="num">
            {{ $stats['menunggu'] }}
        </div>

        <div class="lbl">
            Perlu ditindaklanjuti
        </div>

    </div>


    <div class="stat">

        <div class="num">
            {{ $stats['lulus'] }}
        </div>

        <div class="lbl">
            Lulus seleksi
        </div>

    </div>

</div>

<p class="dashboard-admin-note">
    Statistik lulus menunjukkan hasil keputusan seleksi,
    termasuk mahasiswa yang status penerima beasiswanya
    kemudian dicabut.
</p>


{{-- =========================================
     PENDAFTARAN TERBARU DAN REKAP STATUS
========================================= --}}

<div class="grid grid-side">


    {{-- =====================================
         PENDAFTARAN TERBARU
    ====================================== --}}

    <div class="card table-wrap">

        <div class="card-head">

            <h2>Pendaftaran Terbaru</h2>

            <a href="{{ route('admin.pendaftaran.index') }}">
                Lihat semua
            </a>

        </div>


        @if($terbaru->isEmpty())

            <div class="empty">

                Belum ada pendaftaran yang diajukan.

            </div>

        @else

            <table class="dashboard-admin-table">

                <thead>

                    <tr>

                        <th>Mahasiswa</th>

                        <th>Beasiswa</th>

                        <th>Hasil Seleksi</th>

                        <th>Status Beasiswa</th>

                        <th></th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($terbaru as $p)

                        @php
                            $statusSeleksi = $p->status;
                            $statusBeasiswa = $p->status_beasiswa;
                        @endphp


                        <tr class="{{ $statusBeasiswa === 'dicabut' ? 'student-revoked' : '' }}">

                            {{-- MAHASISWA --}}
                            <td>

                                <strong class="student-name">

                                    {{ $p->user->profile->nama_lengkap ?? $p->user->name }}

                                </strong>

                                <small class="student-detail">

                                    {{ $p->user->profile->nim ?? '-' }}

                                </small>

                            </td>


                            {{-- BEASISWA --}}
                            <td>

                                {{ $p->beasiswa->nama }}

                            </td>


                            {{-- HASIL SELEKSI --}}
                            <td>

                                @if($statusSeleksi === 'lulus')

                                    <span class="dashboard-admin-status lulus">
                                        Lulus
                                    </span>

                                @elseif($statusSeleksi === 'tidak_lulus')

                                    <span class="dashboard-admin-status tidak-lulus">
                                        Tidak Lulus
                                    </span>

                                @else

                                    <span class="dashboard-admin-status lainnya">
                                        {{ \App\Models\Pendaftaran::label($statusSeleksi) }}
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS BEASISWA --}}
                            <td>

                                @if($statusBeasiswa === 'dicabut')

                                    <span class="dashboard-admin-beasiswa dicabut">

                                        <span class="status-dot"></span>

                                        Dicabut

                                    </span>

                                @elseif($statusBeasiswa === 'aktif')

                                    <span class="dashboard-admin-beasiswa aktif">

                                        <span class="status-dot"></span>

                                        Aktif

                                    </span>

                                @elseif($statusSeleksi === 'lulus')

                                    <span class="dashboard-admin-beasiswa belum-aktif">
                                        Belum aktif
                                    </span>

                                @else

                                    <span class="dashboard-admin-beasiswa belum-aktif">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <a
                                    class="btn btn-outline btn-sm"
                                    href="{{ route('admin.pendaftaran.show', $p) }}"
                                >
                                    Periksa
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div style="padding-top:1rem">

                <a
                    href="{{ route('admin.pendaftaran.index') }}"
                    style="font-size:12px;color:#A13C5B;font-weight:700;text-decoration:none;"
                >
                    Kelola seluruh pendaftaran →
                </a>

            </div>

        @endif

    </div>


    {{-- =====================================
         REKAP PER STATUS
    ====================================== --}}

    <div class="card">

        <div class="card-head">

            <h2>Per Status Seleksi</h2>

        </div>


        @foreach(\App\Models\Pendaftaran::LABEL as $k => $label)

            <div
                class="list-item"
                style="padding:.55rem 0"
            >

                <x-status-badge :status="$k" />

                <strong>
                    {{ $perStatus[$k] ?? 0 }}
                </strong>

            </div>

        @endforeach


        <p class="dashboard-admin-note">
            Rekap ini berdasarkan status proses dan hasil seleksi,
            bukan status aktif penerima beasiswa.
        </p>

    </div>

</div>

@endsection

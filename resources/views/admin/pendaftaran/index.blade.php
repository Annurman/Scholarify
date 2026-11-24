
@extends('layouts.app')

@section('title', 'Verifikasi & Seleksi')

@section('content')

<style>
    /* =========================================
       1. STATUS HASIL SELEKSI
    ========================================= */

    .admin-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-status.lulus {
        background: #E7F7ED;
        color: #237A45;
    }

    .admin-status.tidak-lulus {
        background: #FCE9EC;
        color: #B4233C;
    }

    .admin-status.lainnya {
        background: #FFF5DD;
        color: #986A0A;
    }

    /* =========================================
       2. STATUS BEASISWA
    ========================================= */

    .admin-beasiswa-status {
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

    .admin-beasiswa-status.aktif {
        background: #E7F7ED;
        color: #237A45;
    }

    .admin-beasiswa-status.dicabut {
        background: #FCE9EC;
        color: #B4233C;
    }

    .admin-beasiswa-status.belum-aktif {
        background: #F3F4F6;
        color: #6B7280;
    }

    .admin-beasiswa-status .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    /* =========================================
       3. INFORMASI TABEL
    ========================================= */

    .admin-registration-table {
        min-width: 950px;
    }

    .admin-registration-table th {
        white-space: nowrap;
    }

    .admin-registration-table td {
        vertical-align: middle;
    }

    .admin-registration-table tbody tr:hover {
        background: #FFFAFB;
    }

    .admin-registration-table .student-name {
        color: #650F2B;
        font-weight: 700;
    }

    .admin-registration-table .student-detail {
        display: block;
        color: #927E86;
        font-size: 11px;
        margin-top: 5px;
    }

    .admin-registration-table .student-revoked {
        background: #FFFAFA;
    }

    .admin-registration-table .btn-sm {
        white-space: nowrap;
    }

    /* =========================================
       4. RESPONSIVE
    ========================================= */

    @media(max-width: 600px) {
        .admin-registration-table {
            min-width: 950px;
        }
    }
</style>


<div class="page-head">

    <div>
        <h1>Verifikasi & Seleksi</h1>

        <p>
            Periksa berkas pendaftar, lalu nilai dan
            tentukan kelulusan serta status penerima beasiswa.
        </p>
    </div>

</div>


{{-- =========================================
     FILTER PENDAFTARAN
========================================= --}}

<form method="GET" class="card inline-form">

    <input
        class="form-control"
        style="max-width:240px"
        name="q"
        value="{{ request('q') }}"
        placeholder="Cari nama atau NIM"
    >


    <select
        class="form-control"
        style="max-width:240px"
        name="beasiswa_id"
    >

        <option value="">
            Semua beasiswa
        </option>

        @foreach($beasiswaList as $b)

            <option
                value="{{ $b->id }}"
                @selected(request('beasiswa_id') == $b->id)
            >
                {{ $b->nama }}
            </option>

        @endforeach

    </select>


    <select
        class="form-control"
        style="max-width:200px"
        name="status"
    >

        <option value="">
            Semua (tanpa draft)
        </option>

        @foreach(\App\Models\Pendaftaran::LABEL as $k => $l)

            <option
                value="{{ $k }}"
                @selected(request('status') === $k)
            >
                {{ $l }}
            </option>

        @endforeach

    </select>


    <button class="btn" type="submit">
        Terapkan
    </button>

    <a
        class="btn btn-ghost"
        href="{{ route('admin.pendaftaran.index') }}"
    >
        Reset
    </a>

</form>


{{-- =========================================
     TABEL PENDAFTARAN
========================================= --}}

<div class="card table-wrap">

    @if($pendaftaran->isEmpty())

        <div class="empty">

            <h3>Tidak ada data</h3>

            Ubah filter untuk melihat pendaftar lain.

        </div>

    @else

        <table class="admin-registration-table">

            <thead>

                <tr>

                    <th>Mahasiswa</th>

                    <th>Beasiswa</th>

                    <th>Diajukan</th>

                    <th>Nilai</th>

                    <th>Hasil Seleksi</th>

                    <th>Status Beasiswa</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                @foreach($pendaftaran as $p)

                    @php
                        // Memeriksa status hasil seleksi.
                        $statusSeleksi = $p->status;

                        // Memeriksa status penerima beasiswa.
                        $statusBeasiswa = $p->status_beasiswa;

                        // Pencabutan tidak mengubah riwayat kelulusan.
                        $dicabut = $statusBeasiswa === 'dicabut';
                    @endphp


                    <tr class="{{ $dicabut ? 'student-revoked' : '' }}">

                        {{-- MAHASISWA --}}
                        <td>

                            <strong class="student-name">
                                {{ $p->user->profile->nama_lengkap ?? $p->user->name }}
                            </strong>

                            <small class="student-detail">
                                {{ $p->user->profile->nim ?? '-' }}
                                · IPK
                                {{ $p->user->profile->ipk ?? '-' }}
                            </small>

                        </td>


                        {{-- BEASISWA --}}
                        <td>
                            {{ $p->beasiswa->nama }}
                        </td>


                        {{-- TANGGAL DIAJUKAN --}}
                        <td>

                            {{ $p->submitted_at
                                ? $p->submitted_at->translatedFormat('d M Y')
                                : '-' }}

                        </td>


                        {{-- NILAI SELEKSI --}}
                        <td>
                            {{ $p->nilai_seleksi ?? '-' }}
                        </td>


                        {{-- HASIL SELEKSI --}}
                        <td>

                            @if($statusSeleksi === 'lulus')

                                <span class="admin-status lulus">
                                    Lulus
                                </span>

                            @elseif($statusSeleksi === 'tidak_lulus')

                                <span class="admin-status tidak-lulus">
                                    Tidak Lulus
                                </span>

                            @else

                                <span class="admin-status lainnya">
                                    {{ \App\Models\Pendaftaran::label($statusSeleksi) }}
                                </span>

                            @endif

                        </td>


                        {{-- STATUS PENERIMA BEASISWA --}}
                        <td>

                            @if($statusBeasiswa === 'dicabut')

                                <span class="admin-beasiswa-status dicabut">

                                    <span class="status-dot"></span>

                                    Dicabut

                                </span>

                            @elseif($statusBeasiswa === 'aktif')

                                <span class="admin-beasiswa-status aktif">

                                    <span class="status-dot"></span>

                                    Aktif

                                </span>

                            @else

                                <span class="admin-beasiswa-status belum-aktif">
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


        {{-- PAGINATION --}}
        <div style="padding-top:1rem">

            {{ $pendaftaran->links('pagination.simple') }}

        </div>

    @endif

</div>

@endsection

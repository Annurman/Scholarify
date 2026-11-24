
@extends('layouts.app')

@section('title', 'Penempatan & KTM')

@section('content')

<style>
    /* =========================================
       1. STATUS PESERTA
    ========================================= */

    .placement-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .placement-status.aktif {
        background: #E7F7ED;
        color: #237A45;
    }

    .placement-status.dicabut {
        background: #FCE9EC;
        color: #B4233C;
    }

    .placement-status .dot {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
    }

    /* =========================================
       2. TABEL PESERTA
    ========================================= */

    .placement-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .placement-table th {
        background: #FBF6F7;
        color: #650F2B;
        font-size: 12px;
        text-align: left;
        padding: 14px;
        white-space: nowrap;
    }

    .placement-table td {
        padding: 15px 14px;
        border-bottom: 1px solid #F2E7EA;
        color: #604C55;
        font-size: 12px;
        vertical-align: middle;
    }

    .placement-table tr:last-child td {
        border-bottom: none;
    }

    .placement-table tbody tr:hover {
        background: #FFFAFB;
    }

    .placement-table td strong {
        color: #650F2B;
    }

    .placement-table small {
        display: block;
        margin-top: 5px;
        color: #927E86;
        font-size: 11px;
    }

    /* =========================================
       3. INFORMASI KTM
    ========================================= */

    .placement-ktm-active {
        display: inline-block;
        background: #E7F7ED;
        color: #237A45;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .placement-ktm-pending {
        display: inline-block;
        background: #F3F4F6;
        color: #6B7280;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* =========================================
       4. KELOMPOK PEMBINAAN
    ========================================= */

    .placement-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 16px 0;
        border-bottom: 1px solid #F2E7EA;
    }

    .placement-group-item:last-child {
        border-bottom: none;
    }

    .placement-group-item strong {
        color: #650F2B;
        font-size: 13px;
    }

    .placement-group-item small {
        display: block;
        color: #927E86;
        font-size: 11px;
        line-height: 1.7;
        margin-top: 5px;
    }

    /* =========================================
       5. INFORMASI KOSONG
    ========================================= */

    .placement-empty {
        text-align: center;
        padding: 35px 18px;
        color: #856F78;
        font-size: 13px;
        line-height: 1.7;
    }

    .placement-empty h3 {
        color: #650F2B;
        font-size: 16px;
        margin: 0 0 8px;
    }

    /* =========================================
       6. FORM
    ========================================= */

    .placement-form-section {
        margin-bottom: 17px;
    }

    .placement-form-section:last-child {
        margin-bottom: 0;
    }

    /* =========================================
       7. RESPONSIVE
    ========================================= */

    @media(max-width: 600px) {
        .placement-group-item {
            align-items: flex-start;
        }
    }
</style>


{{-- =========================================
     HEADER
========================================= --}}

<div class="page-head">

    <div>
        <h1>Penempatan & KTM</h1>

        <p>
            Tempatkan peserta yang lulus dan masih memenuhi
            syarat ke kelompok pembinaan, lalu terbitkan KTM digital.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('admin.penempatan.ktm') }}"
        data-confirm="Terbitkan KTM untuk semua peserta lulus yang masih memenuhi syarat dan sudah ditempatkan?"
    >
        @csrf

        <button class="btn" type="submit">
            Terbitkan KTM Digital
        </button>

    </form>

</div>


{{-- =========================================
     FILTER BEASISWA
========================================= --}}

<form method="GET" class="card inline-form">

    <select
        name="beasiswa_id"
        class="form-control"
        style="max-width:300px"
    >

        <option value="">
            Program Beasiswa
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

    <button class="btn btn-outline" type="submit">
        Filter
    </button>

    <a
        href="{{ route('admin.penempatan.index') }}"
        class="btn btn-ghost"
    >
        Reset
    </a>

</form>


{{-- =========================================
     PESERTA DAN KELOMPOK
========================================= --}}

<div class="grid grid-side">

    {{-- =====================================
         PESERTA LULUS
    ====================================== --}}

    <div>

        @php
            /*
             * Hanya peserta dengan hasil seleksi Lulus
             * yang belum dicabut yang dapat ditempatkan.
             *
             * Status penerima NULL tetap diperbolehkan
             * untuk peserta yang belum diaktifkan.
             */
            $pesertaTersedia = $peserta->filter(function ($p) {
                return $p->status === 'lulus'
                    && $p->status_beasiswa !== 'dicabut';
            });
        @endphp


        <form
            method="POST"
            action="{{ route('admin.penempatan.simpan') }}"
            class="card table-wrap"
        >

            @csrf

            <div class="card-head">

                <div>
                    <h2>Peserta Lulus</h2>

                    <small>
                        {{ $pesertaTersedia->count() }}
                        peserta memenuhi syarat penempatan
                    </small>
                </div>

                <button class="btn btn-sm" type="submit">
                    Simpan Penempatan
                </button>

            </div>


            @if($pesertaTersedia->isEmpty())

                <div class="placement-empty">

                    <h3>Belum Ada Peserta Lulus</h3>

                    Belum ada mahasiswa yang memenuhi
                    syarat untuk ditempatkan ke kelompok pembinaan.

                </div>

            @else

                <table class="placement-table">

                    <thead>

                        <tr>

                            <th>Mahasiswa</th>

                            <th>Beasiswa</th>

                            <th>Kelompok</th>

                            <th>KTM</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pesertaTersedia as $p)

                            <tr>

                                {{-- MAHASISWA --}}
                                <td>

                                    <strong>
                                        {{ $p->user->profile->nama_lengkap ?? $p->user->name }}
                                    </strong>

                                    <small>
                                        {{ $p->user->profile->nim ?? '-' }}
                                    </small>

                                </td>


                                {{-- BEASISWA --}}
                                <td>
                                    {{ $p->beasiswa->nama }}
                                </td>


                                {{-- PENEMPATAN KELOMPOK --}}
                                <td>

                                    <select
                                        name="kelompok[{{ $p->id }}]"
                                        class="form-control"
                                        style="min-width:160px"
                                    >

                                        <option value="">
                                            Belum ditempatkan
                                        </option>

                                        @foreach($allKelompok[$p->beasiswa_id] ?? [] as $k)

                                            <option
                                                value="{{ $k->id }}"
                                                @selected((int) $p->kelompok_id === (int) $k->id)
                                            >

                                                {{ $k->nama_kelompok }}
                                                ({{ $k->anggota_count }}/{{ $k->kuota }})

                                            </option>

                                        @endforeach

                                    </select>

                                </td>


                                {{-- STATUS KTM --}}
                                <td>

                                    @if($p->ktm && $p->ktm->status === 'aktif')

                                        <span class="placement-ktm-active">
                                            {{ $p->ktm->nomor_ktm }}
                                        </span>

                                    @else

                                        <span class="placement-ktm-pending">
                                            Belum Terbit
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @endif

        </form>

    </div>


    {{-- =====================================
         KELOMPOK PEMBINAAN
    ====================================== --}}

    <div>

        <div class="card">

            <div class="card-head">

                <h2>Kelompok Pembinaan</h2>

            </div>


            @forelse($kelompok as $k)

                <div class="placement-group-item">

                    <div>

                        <strong>
                            {{ $k->nama_kelompok }}
                        </strong>

                        <small>

                            {{ $k->beasiswa->nama }}

                            <br>

                            Mentor:
                            {{ $k->mentor->name ?? $k->pembina }}

                            <br>

                            {{ $k->anggota_count }}/{{ $k->kuota }}
                            anggota aktif

                        </small>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('admin.kelompok.destroy', $k) }}"
                        data-confirm="Hapus kelompok ini?"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            type="submit"
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            @empty

                <div class="placement-empty">

                    <h3>Belum Ada Kelompok</h3>

                    Tambahkan kelompok pembinaan melalui formulir di bawah.

                </div>

            @endforelse

        </div>


        {{-- =================================
             TAMBAH KELOMPOK
        ================================== --}}

        <form
            method="POST"
            action="{{ route('admin.kelompok.store') }}"
            class="card"
        >

            @csrf

            <div class="card-head">

                <h2>Tambah Kelompok</h2>

            </div>


            <div class="form-group">

                <label>Beasiswa</label>

                <select
                    name="beasiswa_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Pilih beasiswa
                    </option>

                    @foreach($beasiswaList as $b)

                        <option value="{{ $b->id }}">
                            {{ $b->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label>Nama Kelompok</label>

                <input
                    name="nama_kelompok"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group">

                <label>Mentor Kelompok</label>

                <select
                    name="mentor_id"
                    class="form-control"
                >

                    <option value="">
                        Belum ditentukan
                    </option>

                    @foreach($mentors as $mentor)

                        <option value="{{ $mentor->id }}">
                            {{ $mentor->name }}
                        </option>

                    @endforeach

                </select>

                <div class="hint">
                    Hanya akun dengan role Mentor yang dapat
                    ditugaskan ke kelompok ini.
                </div>

            </div>


            <div class="form-group">

                <label>Jadwal</label>

                <input
                    name="jadwal"
                    class="form-control"
                    placeholder="Setiap Sabtu, 08.00 - 10.00"
                >

            </div>


            <div class="form-group">

                <label>Kuota</label>

                <input
                    type="number"
                    min="1"
                    name="kuota"
                    class="form-control"
                    required
                >

            </div>


            <button class="btn btn-block" type="submit">
                Tambah Kelompok
            </button>

        </form>

    </div>

</div>

@endsection

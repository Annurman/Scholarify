
@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')

@php
    $draft = $pendaftaran->status === 'draft';
    $perluRevisi = $pendaftaran->status === 'perlu_revisi';
    $bolehMengubahBerkas = $draft || $perluRevisi;
    $siapAjukan = $berkas->count() === count($jenis)
        && ! $berkas->contains(fn ($item) => $item->status_verifikasi === 'tidak_valid')
        && ($draft || $berkas->contains(fn ($item) => $item->status_verifikasi === 'menunggu'));
@endphp

<style>
    .detail-page {
        max-width: 1100px;
        margin: 0 auto;
        color: #40101F;
    }

    .detail-hero {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        padding: 28px;
        border-radius: 18px;
        margin-bottom: 24px;
    }

    .detail-hero .label {
        display: inline-block;
        padding: 6px 12px;
        background: rgba(255,255,255,.16);
        color: white;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .detail-hero h1 {
        color: #FFFFFF !important;
        font-size: 24px;
        margin: 0 0 8px;
        font-weight: 800;
    }

    .detail-hero p {
        color: #FBF0F3;
        margin: 0;
        font-size: 13px;
        line-height: 1.7;
    }

    .detail-card {
        background: white;
        border: 1px solid #F0DDE3;
        border-radius: 17px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(101,15,43,.04);
    }

    .detail-card-head {
        padding: 21px 24px;
        border-bottom: 1px solid #F2E3E7;
        background: #FFFAFB;
    }

    .detail-card-head h2 {
        color: #650F2B;
        font-size: 16px;
        margin: 0 0 5px;
    }

    .detail-card-head p {
        color: #987985;
        font-size: 12px;
        margin: 0;
    }

    .detail-card-body {
        padding: 22px 24px;
    }

    .document-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 20px 0;
        border-bottom: 1px solid #F5E9ED;
    }

    .document-item:first-child {
        padding-top: 0;
    }

    .document-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .document-info {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        min-width: 0;
    }

    .document-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 11px;
        font-size: 19px;
    }

    .document-info strong {
        display: block;
        color: #650F2B;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .document-info small {
        color: #987985;
        font-size: 11px;
    }

    .document-info a {
        color: #A13C5B;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .document-info a:hover {
        text-decoration: underline;
    }

    .document-note {
        display: block;
        color: #B4233C;
        font-size: 11px;
        margin-top: 7px;
    }

    .document-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .upload-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .upload-form input[type="file"] {
        max-width: 210px;
        font-size: 11px;
        color: #765966;
    }

    .upload-form input[type="file"]::file-selector-button {
        background: #FBF0F3;
        color: #650F2B;
        border: 1px solid #EAD5DC;
        border-radius: 7px;
        padding: 7px 9px;
        margin-right: 7px;
        cursor: pointer;
    }

    .action-button {
        border: none;
        display: inline-block;
        padding: 9px 13px;
        border-radius: 8px;
        background: #650F2B;
        color: white;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .action-button:hover {
        background: #A13C5B;
        color: white;
    }

    .action-button.danger {
        background: #FFF0F0;
        color: #B4233C;
        border: 1px solid #F5D2D8;
    }

    .action-button.danger:hover {
        background: #FCE1E5;
    }

    .status-label {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        margin-top: 5px;
    }

    .status-label.menunggu {
        background: #FFF5DD;
        color: #986A0A;
    }

    .status-label.valid {
        background: #E7F7ED;
        color: #237A45;
    }

    .status-label.tidak_valid {
        background: #FCE9EC;
        color: #B4233C;
    }

    .submit-card {
        padding: 23px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .submit-card h3 {
        color: #650F2B;
        font-size: 15px;
        margin: 0 0 6px;
    }

    .submit-card p {
        color: #987985;
        font-size: 12px;
        margin: 0;
        line-height: 1.6;
    }

    .submit-button {
        background: #650F2B;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 12px 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .submit-button:hover:not(:disabled) {
        background: #A13C5B;
    }

    .submit-button:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .alert-rejection {
        background: #FFF0F0;
        border: 1px solid #F5D2D8;
        color: #9F2439;
        padding: 17px 20px;
        border-radius: 12px;
        margin-bottom: 22px;
        font-size: 13px;
        line-height: 1.7;
    }

    .result-link {
        display: block;
        padding: 20px 24px;
        color: #650F2B;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .result-link:hover {
        background: #FFFAFB;
    }

    @media(max-width: 700px) {
        .detail-hero {
            padding: 23px 20px;
        }

        .detail-hero h1 {
            font-size: 20px;
        }

        .detail-card-body {
            padding: 18px;
        }

        .document-item {
            align-items: flex-start;
            flex-direction: column;
        }

        .document-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .upload-form {
            width: 100%;
        }

        .submit-card {
            padding: 20px;
            align-items: stretch;
            flex-direction: column;
        }

        .submit-button {
            width: 100%;
        }
    }
</style>

<div class="detail-page">

    <div class="detail-hero">
        <span class="label">DETAIL PENDAFTARAN</span>
        <h1>{{ $pendaftaran->beasiswa->nama }}</h1>
        <p>
            Lengkapi dokumen persyaratan dan pantau proses pendaftaran
            beasiswamu melalui halaman ini.
        </p>
        <div style="margin-top:15px">
            <x-status-badge :status="$pendaftaran->status_publik" />
        </div>
    </div>

    @if($pendaftaran->status === 'ditolak')
        <div class="alert-rejection">
            <strong>Pendaftaran Ditolak</strong><br>
            {{ $pendaftaran->catatan ?: 'Berkas tidak memenuhi persyaratan.' }}
        </div>
    @endif

    @if($perluRevisi)
        <div class="alert-rejection">
            <strong>Perlu Perbaikan Dokumen</strong><br>
            Admin menemukan dokumen yang perlu diperbaiki. Ganti hanya dokumen berstatus Tidak Valid, baca catatan admin, lalu ajukan kembali pendaftaran Anda.
        </div>
    @endif

    <div class="detail-card">

    @if($bolehMengubahBerkas)
    <form
        id="upload-semua-form"
        method="POST"
        action="{{ route('mahasiswa.pendaftaran.upload', $pendaftaran) }}"
        enctype="multipart/form-data"
    >
        @csrf
    </form>
@endif  
        <div class="detail-card-head">
            <h2>Dokumen Persyaratan</h2>
            <p>Unggah dokumen sesuai persyaratan yang telah ditentukan.</p>
            <p style="margin-top:6px">
                Format PDF/JPG/PNG, maksimal 2 MB per berkas.
            </p>
        </div>

        <div class="detail-card-body">

{{-- CARD DOKUMEN PERSYARATAN --}}
<div class="detail-card">

    <div class="detail-card-head">
        <h2>Dokumen Persyaratan</h2>
        <p>Unggah dokumen sesuai persyaratan yang telah ditentukan.</p>
        <p style="margin-top:6px">
            Format PDF/JPG/PNG, maksimal 2 MB per berkas.
        </p>
    </div>

    <div class="detail-card-body">

        {{-- FORM UPLOAD SEMUA --}}
        @if($bolehMengubahBerkas)
            <form
                id="upload-semua-form"
                method="POST"
                action="{{ route('mahasiswa.pendaftaran.upload', $pendaftaran) }}"
                enctype="multipart/form-data"
            >
                @csrf
            </form>
        @endif

        {{-- DAFTAR DOKUMEN --}}
        @foreach($jenis as $key => $label)

            @php
                $b = $berkas[$key] ?? null;
            @endphp

            <div class="document-item">

                <div class="document-info">
                    <div class="document-icon">▤</div>

                    <div>
                        <strong>{{ $label }}</strong>

                        @if($b)

                            <a href="{{ $b->url }}"
                               target="_blank"
                               rel="noopener">
                                Lihat berkas →
                            </a>

                            <br>

                            <span class="status-label {{ $b->status_verifikasi }}">
                                {{ [
                                    'menunggu' => 'Menunggu Verifikasi',
                                    'valid' => 'Valid',
                                    'tidak_valid' => 'Tidak Valid'
                                ][$b->status_verifikasi] ?? $b->status_verifikasi }}
                            </span>

                            @if($b->catatan)
                                <span class="document-note">
                                    Catatan admin: {{ $b->catatan }}
                                </span>
                            @endif

                        @else

                            <small>Belum ada dokumen yang diunggah.</small>

                        @endif
                    </div>
                </div>

                {{-- INPUT FILE --}}
                @if($bolehMengubahBerkas && ($draft || ($perluRevisi && $b && $b->status_verifikasi === 'tidak_valid')))

                    <div class="document-actions">

                        <div class="upload-form">
                            <input
                                type="file"
                                id="file-{{ $key }}"
                                name="files[{{ $key }}]"
                                form="upload-semua-form"
                                accept=".pdf,.jpg,.jpeg,.png"
                            >
                        </div>

                        {{-- HAPUS BERKAS --}}
                        @if($b && $draft)

                            <form
                                method="POST"
                                action="{{ route('mahasiswa.berkas.destroy', $b) }}"
                                data-confirm="Hapus berkas ini?"
                            >
                                @csrf
                                @method('DELETE')

                                <button class="action-button danger" type="submit">
                                    Hapus
                                </button>
                            </form>

                        @endif

                    </div>

                @endif

            </div>

        @endforeach

        {{-- TOMBOL UNGGAH SEMUA --}}
        @if($bolehMengubahBerkas)

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:15px;
                flex-wrap:wrap;
                margin-top:25px;
                padding-top:20px;
                border-top:1px solid #F2E3E7;
            ">

                <div>
                    <strong style="color:#650F2B;font-size:13px;">
                        Siap Mengunggah Dokumen?
                    </strong>

                    <p style="color:#987985;font-size:11px;margin:5px 0 0;">
                        Pilih seluruh dokumen yang ingin diunggah,
                        kemudian tekan tombol di samping.
                    </p>
                </div>

                <button
                    type="submit"
                    form="upload-semua-form"
                    class="action-button"
                >
                    Unggah Semua Berkas →
                </button>

            </div>

        @endif

    </div>
</div>


{{-- CARD AJUKAN PENDAFTARAN --}}
@if($bolehMengubahBerkas)

    <div class="detail-card">

        <div class="submit-card">

            <div>
                <h3>
                    {{ $perluRevisi
                        ? 'Sudah Memperbaiki Dokumen?'
                        : 'Sudah Melengkapi Semua Berkas?' }}
                </h3>

                <p>
                    @if($perluRevisi)
                        Pastikan semua dokumen yang tidak valid sudah diganti.
                        Dokumen yang sudah valid tidak perlu diunggah ulang.
                    @else
                        Periksa kembali dokumenmu sebelum mengajukan pendaftaran.
                        Setelah diajukan, dokumen hanya dapat diubah apabila
                        admin meminta revisi.
                    @endif
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('mahasiswa.pendaftaran.ajukan', $pendaftaran) }}"
                data-confirm="{{ $perluRevisi
                    ? 'Ajukan ulang dokumen hasil revisi?'
                    : 'Ajukan pendaftaran sekarang?' }}"
            >
                @csrf

                <button
                    class="submit-button"
                    type="submit"
                    @disabled(! $siapAjukan)
                >
                    {{ $perluRevisi
                        ? 'Ajukan Ulang Pendaftaran →'
                        : 'Ajukan Pendaftaran →' }}
                </button>
            </form>

        </div>

    </div>

@endif


    @if(in_array($pendaftaran->status_publik, ['lulus', 'tidak_lulus']))

        <div class="detail-card">
            <a href="{{ route('mahasiswa.hasil') }}" class="result-link">
                Lihat Hasil Seleksi dan Penempatan →
            </a>
        </div>

    @endif

</div>

@endsection

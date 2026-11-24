
@extends('layouts.app')
@section('title', 'KTM Digital')

@section('content')
<style>
    .ktm-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .ktm-hero {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        padding: 28px;
        border-radius: 20px;
    }

    .ktm-hero h1 {
        color: #fff !important;
        font-size: 26px;
        margin: 0 0 8px;
    }

    .ktm-hero p {
        color: #FCEEF2;
        margin: 0;
        line-height: 1.7;
    }

    .ktm-card {
        position: relative;
        overflow: hidden;
        max-width: 650px;
        width: 100%;
        min-height: 340px;
        margin: 5px auto;
        padding: 27px;
        border-radius: 22px;
        color: #fff;
        background: linear-gradient(130deg, #650F2B 0%, #8D2445 60%, #A13C5B 100%);
        box-shadow: 0 15px 35px rgba(101,15,43,.20);
        box-sizing: border-box;
    }

    .ktm-card::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 50%;
        right: -85px;
        top: -115px;
    }

    .ktm-card::after {
        content: "";
        position: absolute;
        width: 210px;
        height: 210px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 50%;
        right: -55px;
        bottom: -125px;
    }

    .ktm-card-content {
        position: relative;
        z-index: 1;
    }

    .ktm-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,.25);
        padding-bottom: 17px;
        margin-bottom: 23px;
    }

    .ktm-brand {
        font-size: 17px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .ktm-brand small {
        display: block;
        font-size: 10px;
        font-weight: 400;
        letter-spacing: 2px;
        color: #F7DDE5;
        margin-top: 4px;
    }

    .ktm-label {
        text-align: right;
        font-size: 11px;
        color: #FCEEF2;
        max-width: 170px;
    }

    .ktm-main {
        display: grid;
        grid-template-columns: 112px 1fr 86px;
        gap: 20px;
        align-items: center;
    }

    .ktm-photo {
        width: 108px;
        height: 135px;
        border-radius: 12px;
        background: #F9E9EE;
        color: #650F2B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 700;
        overflow: hidden;
        border: 3px solid rgba(255,255,255,.65);
    }

    .ktm-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ktm-identity {
        min-width: 0;
    }

    .ktm-identity .ktm-caption {
        font-size: 10px;
        color: #F4C9D5;
        letter-spacing: 1.5px;
        margin-bottom: 7px;
    }

    .ktm-identity .ktm-name {
        font-size: 20px;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 13px;
        overflow-wrap: anywhere;
    }

    .ktm-identity .ktm-detail {
        font-size: 12px;
        color: #FCEEF2;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .ktm-qr {
        width: 86px;
        height: 86px;
        background: white;
        padding: 5px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .ktm-qr img {
        max-width: 100%;
        height: auto;
    }

    .ktm-qr canvas {
        max-width: 100%;
        height: auto;
    }

    .ktm-qr-label {
        text-align: center;
        font-size: 9px;
        color: #FCEEF2;
        margin-top: 7px;
    }

    .ktm-footer {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        border-top: 1px solid rgba(255,255,255,.25);
        margin-top: 23px;
        padding-top: 15px;
        font-size: 11px;
        color: #FCEEF2;
    }

    .ktm-footer strong {
        color: #fff;
    }

    .ktm-note {
        max-width: 650px;
        width: 100%;
        margin: 0 auto;
        color: #806B74;
        font-size: 13px;
        line-height: 1.7;
    }

    .ktm-empty {
        background: white;
        padding: 40px 20px;
        border-radius: 18px;
        border: 1px solid #F0E2E7;
        text-align: center;
    }

    .ktm-empty h3 {
        color: #650F2B;
        margin: 0 0 9px;
    }

    .ktm-empty p {
        color: #856F78;
        margin: 0;
        line-height: 1.7;
    }

    .ktm-print {
        background: #650F2B;
        color: white;
        border: none;
        padding: 11px 18px;
        border-radius: 9px;
        cursor: pointer;
        font-weight: 600;
    }

    .ktm-print:hover {
        background: #A13C5B;
    }

    @media(max-width: 600px) {
        .ktm-hero { padding: 22px; }
        .ktm-hero h1 { font-size: 22px; }
        .ktm-card { padding: 19px; min-height: auto; }
        .ktm-main {
            grid-template-columns: 85px 1fr;
            gap: 13px;
        }
        .ktm-photo { width: 82px; height: 110px; }
        .ktm-identity .ktm-name { font-size: 16px; }
        .ktm-qr-area {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 5px;
        }
        .ktm-qr-label { text-align: left; }
    }

    @media print {
        @page {
            size: A4;
            margin: 15mm;
        }

        body * {
            visibility: hidden;
        }

        .ktm-card, .ktm-card * {
            visibility: visible;
        }

        .ktm-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 650px;
            box-shadow: none;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<div class="ktm-page">

    <div class="ktm-hero no-print">
        <h1>KTM Digital</h1>
        <p>
            Kartu identitas digital penerima beasiswa.
            Anda dapat mencetak atau menyimpannya dalam format PDF.
        </p>
    </div>

    @if(! $pendaftaran)

        <div class="ktm-empty">
            <h3>KTM Digital Belum Tersedia</h3>
            <p>
                KTM akan diterbitkan oleh admin setelah Anda dinyatakan
                lulus dan ditempatkan di kelompok pembinaan.
            </p>
        </div>

    @else

        @php
            $pr = $pendaftaran->user->profile;
            $ktm = $pendaftaran->ktm;
        @endphp

        <div class="ktm-card">
            <div class="ktm-card-content">

                <div class="ktm-card-head">
                    <div class="ktm-brand">
                        SCHOLARIFY
                        <small>DIGITAL STUDENT CARD</small>
                    </div>

                    <div class="ktm-label">
                        KARTU TANDA MAHASISWA
                        <br>
                        PENERIMA BEASISWA
                    </div>
                </div>

                <div class="ktm-main">

                    <div class="ktm-photo">
                        @if($pr->foto_url)
                            <img src="{{ $pr->foto_url }}" alt="Foto mahasiswa">
                        @else
                            {{ strtoupper(mb_substr($pr->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>

                    <div class="ktm-identity">
                        <div class="ktm-caption">IDENTITAS MAHASISWA</div>

                        <div class="ktm-name">
                            {{ $pr->nama_lengkap }}
                        </div>

                        <div class="ktm-detail">
                            NIM: {{ $pr->nim }}<br>
                            Program Studi: {{ $pr->prodi }}<br>
                            Kelompok: {{ $pendaftaran->kelompok->nama_kelompok ?? '-' }}
                        </div>
                    </div>

                    <div class="ktm-qr-area">
                        <div>
                            <div class="ktm-qr" id="qr"></div>
                            <div class="ktm-qr-label">Scan untuk verifikasi</div>
                        </div>
                    </div>

                </div>

                <div class="ktm-footer">
                    <span>
                        No. KTM:
                        <strong>{{ $ktm->nomor_ktm }}</strong>
                    </span>

                    <span>
                        Berlaku sampai:
                        <strong>{{ $ktm->berlaku_sampai->translatedFormat('d M Y') }}</strong>
                    </span>
                </div>

            </div>
        </div>

        <div class="ktm-note no-print">
            <button class="ktm-print" onclick="window.print()">
                Cetak / Simpan PDF
            </button>
            <p>
                Pindai QR Code untuk memeriksa keaslian KTM digital Anda.
                Saat mencetak, aktifkan opsi background graphics agar warna kartu ikut tercetak.
            </p>
        </div>

    @endif

</div>
@endsection

@if($pendaftaran)
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qrElement = document.getElementById('qr');

        if (qrElement) {
            new QRCode(qrElement, {
                text: @json(route('ktm.verifikasi', $pendaftaran->ktm->nomor_ktm)),
                width: 76,
                height: 76,
                colorDark: '#4A0C19',
                colorLight: '#ffffff'
            });
        }
    });
</script>
@endpush
@endif

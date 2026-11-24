
@extends('layouts.app')

@section('title', 'Beasiswa Dibuka')

@section('content')

<style>
    .scholarship-page {
        max-width: 1100px;
        margin: 0 auto;
        color: #40101F;
    }

    .scholarship-heading {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        padding: 30px;
        border-radius: 18px;
        color: white;
        margin-bottom: 28px;
    }

    .scholarship-heading .heading-label {
        display: inline-block;
        background: rgba(255,255,255,.17);
        padding: 6px 13px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .scholarship-heading h1 {
        color: #FFFFFF !important;
        font-size: 25px;
        margin: 0 0 9px;
        font-weight: 800;
    }

    .scholarship-heading p {
        color: #FBF0F3;
        margin: 0;
        font-size: 14px;
        line-height: 1.7;
    }

    .scholarship-card {
        background: white;
        border: 1px solid #F0DDE3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(101,15,43,.05);
        margin-bottom: 22px;
    }

    .scholarship-card-top {
        padding: 26px;
        background: linear-gradient(120deg, #FFF8FA, #FBF0F3);
        border-bottom: 1px solid #F0DDE3;
    }

    .scholarship-tag {
        display: inline-block;
        background: #F2DDE4;
        color: #8B2949;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 13px;
    }

    .scholarship-card h2 {
        color: #650F2B;
        font-size: 22px;
        margin: 0 0 16px;
        font-weight: 800;
    }

    .scholarship-info {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 1px solid #F0DDE3;
        padding: 9px 13px;
        border-radius: 9px;
        font-size: 12px;
        color: #6D3A4B;
    }

    .info-item strong {
        color: #650F2B;
    }

    .scholarship-body {
        padding: 26px;
    }

    .detail-section {
        margin-bottom: 24px;
    }

    .detail-section h3 {
        color: #650F2B;
        font-size: 15px;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .detail-section h3 span {
        width: 27px;
        height: 27px;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .detail-section p {
        color: #765966;
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
    }

    .requirements-box {
        background: #FFFAFB;
        border: 1px solid #F0DDE3;
        border-radius: 12px;
        padding: 18px;
    }

    .requirements-box p {
        white-space: pre-line;
    }

    .scholarship-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #F2E3E7;
    }

    .footer-note {
        font-size: 12px;
        color: #987985;
        line-height: 1.6;
    }

    .scholarship-button {
        display: inline-block;
        background: #650F2B;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 12px 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .scholarship-button:hover {
        background: #A13C5B;
        color: white;
        transform: translateY(-2px);
    }

    .scholarship-button.outline {
        background: white;
        color: #650F2B;
        border: 1px solid #A13C5B;
    }

    .scholarship-button.outline:hover {
        background: #FBF0F3;
        color: #650F2B;
    }

    .empty-scholarship {
        background: white;
        border: 1px solid #F0DDE3;
        border-radius: 18px;
        padding: 45px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        background: #FBF0F3;
        color: #A13C5B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 16px;
    }

    .empty-scholarship h3 {
        color: #650F2B;
        margin: 0 0 8px;
    }

    .empty-scholarship p {
        color: #987985;
        font-size: 13px;
        margin: 0;
    }

    @media(max-width: 650px) {
        .scholarship-heading {
            padding: 23px 20px;
        }

        .scholarship-heading h1 {
            font-size: 21px;
        }

        .scholarship-card-top,
        .scholarship-body {
            padding: 20px;
        }

        .scholarship-card h2 {
            font-size: 19px;
        }

        .scholarship-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .scholarship-button {
            text-align: center;
        }
    }
</style>

<div class="scholarship-page">

    <div class="scholarship-heading">
        <span class="heading-label">PROGRAM BEASISWA</span>
        <h1>Temukan Peluang Beasiswamu</h1>
        <p>
            Raih kesempatan untuk mengembangkan potensi dan prestasimu.
            Pelajari informasi serta persyaratan sebelum melakukan pendaftaran.
        </p>
    </div>

    @forelse($beasiswa as $b)

        <div class="scholarship-card">

            <div class="scholarship-card-top">
                <span class="scholarship-tag">✦ PROGRAM BEASISWA</span>

                <h2>{{ $b->nama }}</h2>

                <div class="scholarship-info">
                    <div class="info-item">
                        <span>♙</span>
                        <span>Kuota: <strong>{{ $b->kuota }} penerima</strong></span>
                    </div>

                    <div class="info-item">
                        <span>▣</span>
                        <span>Ditutup:
                            <strong>{{ $b->tgl_tutup->translatedFormat('d F Y') }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="scholarship-body">

                <div class="detail-section">
                    <h3><span>i</span> Tentang Beasiswa</h3>
                    <p>{{ $b->deskripsi }}</p>
                </div>

                <div class="detail-section">
                    <h3><span>✓</span> Persyaratan Pendaftaran</h3>

                    <div class="requirements-box">
                        <p>{{ $b->persyaratan }}</p>
                    </div>
                </div>

                <div class="scholarship-footer">

                    <div class="footer-note">
                        Pastikan data profil dan dokumen persyaratanmu<br>
                        sudah lengkap sebelum mendaftar.
                    </div>

                    @if(isset($terdaftar[$b->id]))

                        <a class="scholarship-button outline"
                           href="{{ route('mahasiswa.pendaftaran.show', $terdaftar[$b->id]) }}">
                            Lihat Pendaftaran →
                        </a>

                    @else

                        <form method="POST"
                              action="{{ route('mahasiswa.beasiswa.daftar', $b) }}">
                            @csrf

                            <button class="scholarship-button" type="submit">
                                Daftar Beasiswa →
                            </button>
                        </form>

                    @endif

                </div>

            </div>
        </div>

    @empty

        <div class="empty-scholarship">
            <div class="empty-icon">♡</div>
            <h3>Belum Ada Beasiswa yang Dibuka</h3>
            <p>
                Saat ini belum ada program beasiswa yang tersedia.
                Silakan periksa kembali halaman ini secara berkala.
            </p>
        </div>

    @endforelse

</div>

@endsection

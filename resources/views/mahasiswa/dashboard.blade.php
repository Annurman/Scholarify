
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<style>
    /* =========================================
       1. DASHBOARD UTAMA
    ========================================= */

    .mhs-dashboard {
        color: #40101f;
    }

    .mhs-dashboard * {
        box-sizing: border-box;
    }

    /* =========================================
       2. WELCOME CARD
    ========================================= */

    .mhs-dashboard .welcome-card {
        background: linear-gradient(120deg, #650f2b, #9d3b5b);
        border-radius: 20px;
        padding: 35px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 25px;
        margin-bottom: 28px;
        overflow: hidden;
        position: relative;
    }

    .mhs-dashboard .welcome-card h1 {
        font-size: 27px;
        font-weight: 800;
        margin: 0 0 10px;
        color: white;
    }

    .mhs-dashboard .welcome-card p {
        font-size: 14px;
        line-height: 1.8;
        color: #f8e8ed;
        margin: 0;
        max-width: 520px;
    }

    .mhs-dashboard .welcome-tag {
        display: inline-block;
        background: rgba(255,255,255,.15);
        padding: 7px 13px;
        border-radius: 30px;
        font-size: 11px;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .mhs-dashboard .welcome-button {
        display: inline-block;
        background: white;
        color: #650f2b;
        text-decoration: none;
        padding: 12px 19px;
        border-radius: 9px;
        font-weight: 700;
        font-size: 13px;
        margin-top: 20px;
    }

    .mhs-dashboard .welcome-button:hover {
        background: #fbeef2;
    }

    .mhs-dashboard .welcome-decoration {
        width: 135px;
        height: 135px;
        min-width: 135px;
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        color: #f7dce5;
        background: rgba(255,255,255,.08);
    }

    /* =========================================
       3. SUMMARY / STATISTIK
    ========================================= */

    .mhs-dashboard .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .mhs-dashboard .summary-card {
        background: white;
        border: 1px solid #f1e4e8;
        border-radius: 15px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 5px 18px rgba(65,16,31,.03);
    }

    .mhs-dashboard .summary-icon {
        width: 49px;
        height: 49px;
        min-width: 49px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background: #fbf0f3;
    }

    .mhs-dashboard .summary-card:nth-child(2) .summary-icon {
        background: #f9f1e9;
    }

    .mhs-dashboard .summary-card:nth-child(3) .summary-icon {
        background: #edf4ee;
    }

    .mhs-dashboard .summary-card small {
        color: #927e86;
        font-size: 12px;
        display: block;
        margin-bottom: 6px;
    }

    .mhs-dashboard .summary-card strong {
        font-size: 23px;
        color: #650f2b;
    }

    /* =========================================
       4. DASHBOARD CARD
    ========================================= */

    .mhs-dashboard .dashboard-card {
        background: white;
        border: 1px solid #f1e4e8;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 18px rgba(65,16,31,.03);
        margin-bottom: 22px;
        min-width: 0;
    }

    .mhs-dashboard .dashboard-card h2 {
        color: #40101f;
        font-size: 17px;
        margin: 0;
        font-weight: 800;
    }

    .mhs-dashboard .card-description {
        color: #927e86;
        font-size: 12px;
        margin-top: 7px;
        line-height: 1.6;
    }

    /* =========================================
       5. PERJALANAN BEASISWA
       TIMELINE / STEPPER
    ========================================= */

    .mhs-dashboard .steps-wrapper {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        margin-top: 30px;
        padding-bottom: 10px;
        scrollbar-width: thin;
        scrollbar-color: #DCC5CE transparent;
    }

    .mhs-dashboard .steps {
        display: flex;
        align-items: flex-start;
        position: relative;
        width: 100%;
        min-width: max(100%, calc(var(--steps-count, 4) * 135px));
        gap: 0;
    }

    .mhs-dashboard .step {
        flex: 1 1 0;
        min-width: 0;
        position: relative;

        background: transparent;
        padding: 0 8px;

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;

        color: #927e86;
        font-size: 12px;
        font-weight: 600;
    }

    /* GARIS PENGHUBUNG LURUS */
    .mhs-dashboard .step:not(:last-child)::after {
        content: "";
        position: absolute;

        top: 17px;

        left: calc(50% + 18px);
        right: calc(-50% + 18px);

        height: 3px;
        background: #EADCE1;

        border-radius: 10px;
        z-index: 0;
    }

    /* GARIS UNTUK TAHAPAN SELESAI */
    .mhs-dashboard .step.done:not(:last-child)::after {
        background: #650f2b;
    }

    /* LINGKARAN NOMOR */
    .mhs-dashboard .step i {
        position: relative;
        z-index: 2;

        width: 36px;
        height: 36px;
        min-width: 36px;

        border-radius: 50%;
        background: #EADCE1;
        color: #650f2b;

        display: flex;
        justify-content: center;
        align-items: center;

        font-style: normal;
        font-weight: 800;
        font-size: 12px;
    }

    /* TAHAPAN SELESAI */
    .mhs-dashboard .step.done {
        background: transparent;
        color: #650f2b;
    }

    .mhs-dashboard .step.done i {
        background: #650f2b;
        color: white;
    }

    .mhs-dashboard .step span {
        display: block;
        max-width: 140px;
        line-height: 1.5;
        overflow-wrap: break-word;
    }

    /* =========================================
       6. CONTENT GRID
    ========================================= */

    .mhs-dashboard .content-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 22px;
    }

    .mhs-dashboard .card-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .mhs-dashboard .card-heading a {
        text-decoration: none;
        color: #a13c5b;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* =========================================
       7. PENDAFTARAN SAYA
    ========================================= */

    .mhs-dashboard .registration-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 17px 0;
        border-bottom: 1px solid #f2e9ec;
    }

    .mhs-dashboard .registration-item:last-child {
        border-bottom: none;
    }

    .mhs-dashboard .registration-item strong {
        display: block;
        font-size: 13px;
        color: #40101f;
        margin-bottom: 6px;
    }

    .mhs-dashboard .registration-item small {
        color: #927e86;
        font-size: 11px;
    }

    .mhs-dashboard .registration-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mhs-dashboard .btn-outline {
        border: 1px solid #650f2b;
        border-radius: 8px;
        color: #650f2b;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        padding: 8px 13px;
        white-space: nowrap;
    }

    .mhs-dashboard .btn-outline:hover {
        background: #650f2b;
        color: white;
    }

    /* BADGE BEASISWA DICABUT */
    .mhs-dashboard .registration-status-revoked {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;

        background: #FEE4E2;
        color: #B42318;

        border: 1px solid #FDA29B;
        border-radius: 20px;

        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .mhs-dashboard .registration-status-revoked span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #D92D20;
    }

    /* =========================================
       8. PENGUMUMAN
    ========================================= */

    .mhs-dashboard .announcement-item {
        padding: 16px 0;
        border-bottom: 1px solid #f2e9ec;
        display: flex;
        gap: 13px;
    }

    .mhs-dashboard .announcement-item:last-child {
        border-bottom: none;
    }

    .mhs-dashboard .announcement-icon {
        width: 37px;
        height: 37px;
        min-width: 37px;
        border-radius: 10px;
        background: #fbf0f3;
        color: #a13c5b;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .mhs-dashboard .announcement-item strong {
        font-size: 12px;
        color: #40101f;
    }

    .mhs-dashboard .announcement-item p {
        font-size: 11px;
        color: #927e86;
        line-height: 1.7;
        margin: 6px 0 0;
    }

    /* =========================================
       9. EMPTY STATE
    ========================================= */

    .mhs-dashboard .empty-state {
        text-align: center;
        padding: 30px 15px;
        color: #927e86;
        font-size: 13px;
    }

    .mhs-dashboard .empty-state h3 {
        font-size: 15px;
        color: #650f2b;
        margin: 0 0 7px;
    }

    /* =========================================
       10. PROFILE ALERT
    ========================================= */

    .mhs-dashboard .profile-alert {
        background: #fff8ed;
        border: 1px solid #f1dfbd;
        border-radius: 12px;
        padding: 16px 20px;
        color: #785b2b;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .mhs-dashboard .profile-alert a {
        color: #650f2b;
        font-weight: 800;
    }

    /* =========================================
       11. RESPONSIVE TABLET
    ========================================= */

    @media(max-width: 850px) {

        .mhs-dashboard .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .mhs-dashboard .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================================
       12. RESPONSIVE MOBILE
    ========================================= */

    @media(max-width: 600px) {

        .mhs-dashboard .welcome-card {
            padding: 25px;
        }

        .mhs-dashboard .welcome-card h1 {
            font-size: 22px;
        }

        .mhs-dashboard .welcome-decoration {
            display: none;
        }

        .mhs-dashboard .summary-grid {
            grid-template-columns: 1fr;
        }

        .mhs-dashboard .registration-item {
            align-items: flex-start;
            flex-direction: column;
        }

        .mhs-dashboard .registration-actions {
            width: 100%;
            justify-content: space-between;
        }

        .mhs-dashboard .dashboard-card {
            padding: 19px;
        }
    }
</style>


<div class="mhs-dashboard">

    {{-- =====================================
         WELCOME
    ====================================== --}}

    <div class="welcome-card">

        <div>

            <span class="welcome-tag">
                SCHOLARIFY STUDENT PORTAL
            </span>

            <h1>
                Halo, {{ auth()->user()->name }}! 👋
            </h1>

            <p>
                Selamat datang di dashboard Scholarify.
                Pantau proses pendaftaran dan informasi beasiswa
                kamu melalui halaman ini.
            </p>

            <a
                href="{{ route('mahasiswa.beasiswa.index') }}"
                class="welcome-button"
            >
                Lihat Program Beasiswa →
            </a>

        </div>

        <div class="welcome-decoration">
            ✦
        </div>

    </div>


    {{-- =====================================
         ALERT PROFIL
    ====================================== --}}

    @unless($profil)

        <div class="profile-alert">

            <strong>Lengkapi profilmu!</strong>

            <br>

            Data mahasiswa kamu belum lengkap.

            <a href="{{ route('mahasiswa.profil.edit') }}">
                Lengkapi sekarang →
            </a>

        </div>

    @endunless


    {{-- =====================================
         SUMMARY
    ====================================== --}}

    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon">📄</div>

            <div>
                <small>Total Pendaftaran</small>
                <strong>{{ $pendaftaran->count() }}</strong>
            </div>

        </div>

        <div class="summary-card">

            <div class="summary-icon">🎓</div>

            <div>
                <small>Program Beasiswa</small>
                <strong>1</strong>
            </div>

        </div>

        <div class="summary-card">

            <div class="summary-icon">📢</div>

            <div>
                <small>Pengumuman</small>
                <strong>{{ $pengumuman->count() }}</strong>
            </div>

        </div>

    </div>


    {{-- =====================================
         PERJALANAN BEASISWA
    ====================================== --}}

    <div class="dashboard-card">

        <div>

            <h2>Perjalanan Beasiswa Saya</h2>

            <p class="card-description">
                Pantau tahapan yang perlu kamu lalui dalam program beasiswa.
            </p>

        </div>

        <div class="steps-wrapper">

            <div
                class="steps"
                style="--steps-count: {{ max(1, count($steps)) }};"
            >

                @foreach($steps as $i => $s)

                    <div class="step {{ $s[1] ? 'done' : '' }}">

                        <i>
                            {{ $s[1] ? '✓' : $i + 1 }}
                        </i>

                        <span>
                            {{ $s[0] }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </div>


    {{-- =====================================
         PENDAFTARAN & PENGUMUMAN
    ====================================== --}}

    <div class="content-grid">

        {{-- PENDAFTARAN SAYA --}}

        <div class="dashboard-card">

            <div class="card-heading">

                <div>

                    <h2>Pendaftaran Saya</h2>

                    <p class="card-description">
                        Informasi pendaftaran beasiswa kamu.
                    </p>

                </div>

                <a href="{{ route('mahasiswa.pendaftaran.index') }}">
                    Lihat Semua →
                </a>

            </div>


            @forelse($pendaftaran->take(4) as $p)

                @php
                    /*
                     * Pencabutan harus diprioritaskan daripada
                     * status seleksi yang sebelumnya Lulus.
                     */
                    $dicabut = $p->status_beasiswa === 'dicabut';
                @endphp

                <div class="registration-item">

                    <div>

                        <strong>
                            {{ $p->beasiswa->nama }}
                        </strong>

                        <small>
                            Didaftarkan pada
                            {{ $p->created_at->translatedFormat('d M Y') }}
                        </small>

                    </div>


                    <div class="registration-actions">

                        @if($dicabut)

                            {{-- STATUS KHUSUS PENCABUTAN --}}

                            <span class="registration-status-revoked">
                                <span></span>
                                Beasiswa Dicabut
                            </span>

                        @else

                            {{-- STATUS NORMAL --}}

                            <x-status-badge :status="$p->status_publik" />

                        @endif


                        <a
                            class="btn-outline"
                            href="{{ route('mahasiswa.pendaftaran.show', $p) }}"
                        >
                            Detail
                        </a>

                    </div>

                </div>

            @empty

                <div class="empty-state">

                    <h3>Belum Ada Pendaftaran</h3>

                    Kamu belum mendaftarkan diri ke program beasiswa.

                    <br><br>

                    <a
                        href="{{ route('mahasiswa.beasiswa.index') }}"
                        class="btn-outline"
                    >
                        Mulai Pendaftaran
                    </a>

                </div>

            @endforelse

        </div>


        {{-- PENGUMUMAN --}}

        <div class="dashboard-card">

            <div class="card-heading">

                <div>

                    <h2>Pengumuman</h2>

                    <p class="card-description">
                        Informasi terbaru dari penyelenggara.
                    </p>

                </div>

            </div>


            @forelse($pengumuman as $a)

                <div class="announcement-item">

                    <div class="announcement-icon">
                        ✦
                    </div>

                    <div>

                        <strong>
                            {{ $a->judul }}
                        </strong>

                        <p>
                            {{ \Illuminate\Support\Str::limit($a->isi, 90) }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="empty-state">

                    Belum ada pengumuman untuk beasiswa yang kamu ikuti.

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection

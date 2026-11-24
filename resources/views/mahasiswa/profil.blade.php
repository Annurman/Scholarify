@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')

<style>
    .profile-page {
        max-width: 1050px;
        margin: 0 auto;
        color: #40101F;
    }

    .profile-heading {
        background: linear-gradient(120deg, #650F2B, #A13C5B);
        color: white;
        padding: 30px;
        border-radius: 18px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .profile-heading h1 {
        font-size: 25px;
        margin: 0 0 8px;
        font-weight: 800;
    }

    .profile-heading p {
    margin: 0;
    color: #FBF0F3;
    font-size: 14px;
    line-height: 1.6;
    max-width: 600px;
}

    .profile-heading .heading-label {
        display: inline-block;
        background: rgba(255,255,255,.15);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .profile-form {
        background: #FFFFFF;
        border: 1px solid #F0DDE3;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 8px 25px rgba(101,15,43,.05);
    }

    .form-section {
        margin-bottom: 28px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #F2E3E7;
    }

    .section-number {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FBF0F3;
        color: #A13C5B;
        border-radius: 10px;
        font-weight: 800;
    }

    .section-heading h3 {
        margin: 0;
        font-size: 16px;
        color: #650F2B;
    }

    .section-heading p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #987985;
    }

    .profile-form .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 17px;
    }

    .profile-form .form-row-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .profile-form .form-group {
        margin-bottom: 17px;
    }

    .profile-form label {
        display: block;
        color: #5D2638;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .profile-form .form-control {
        width: 100%;
        min-height: 44px;
        padding: 11px 13px;
        border: 1px solid #EAD5DC;
        border-radius: 9px;
        background: #FFFCFD;
        color: #40101F;
        font: inherit;
        font-size: 13px;
        box-sizing: border-box;
        transition: .2s;
    }

    .profile-form .form-control:focus {
        outline: none;
        border-color: #A13C5B;
        box-shadow: 0 0 0 3px rgba(161,60,91,.10);
        background: white;
    }

    .profile-form textarea.form-control {
        min-height: 95px;
        resize: vertical;
    }

    .profile-form .hint {
        color: #987985;
        font-size: 12px;
        margin-top: 8px;
    }

    .photo-preview {
        width: 95px;
        height: 115px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #F5E5EA;
        display: block;
        margin-bottom: 12px;
    }

    .photo-empty {
        width: 95px;
        height: 115px;
        border-radius: 12px;
        background: #FBF0F3;
        color: #A13C5B;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin-bottom: 12px;
        font-size: 11px;
        font-weight: 700;
    }

    .photo-empty span {
        font-size: 27px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #F2E3E7;
        padding-top: 22px;
        margin-top: 10px;
    }

    .save-button {
        border: none;
        background: #650F2B;
        color: white;
        padding: 12px 24px;
        border-radius: 9px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: .2s;
    }

    .save-button:hover {
        background: #A13C5B;
        transform: translateY(-1px);
    }

    @media(max-width: 700px) {
        .profile-form {
            padding: 20px 16px;
        }

        .profile-form .form-row,
        .profile-form .form-row-3 {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .profile-heading {
            padding: 23px 20px;
        }

        .profile-heading h1 {
            font-size: 25px;
            margin: 0 0 8px;
            font-weight: 800;
            color: #FFFFFF;
}
    }
</style>

<div class="profile-page">

    <div class="profile-heading">
        <span class="heading-label">PROFIL MAHASISWA</span>
        <h1 style="color: #FFFFFF !important;">Lengkapi Data Dirimu</h1>
        <p>
            Pastikan seluruh informasi yang kamu masukkan sudah benar.
            Data ini akan digunakan untuk proses pendaftaran beasiswa
            dan pembuatan Kartu Tanda Mahasiswa digital.
        </p>
    </div>

    <form method="POST"
        action="{{ route('mahasiswa.profil.update') }}"
        enctype="multipart/form-data"
        class="profile-form">

        @csrf
        @method('PUT')

        @php
            $v = fn($k, $d = '') => old($k, $profil->$k ?? $d);
        @endphp

        <div class="form-section">
            <div class="section-heading">
                <div class="section-number">01</div>
                <div>
                    <h3>Identitas Mahasiswa</h3>
                    <p>Masukkan informasi identitas diri sesuai data resmi.</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>NIM</label>
                    <input class="form-control" name="nim"
                        value="{{ $v('nim') }}" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input class="form-control" name="nama_lengkap"
                        value="{{ $v('nama_lengkap', auth()->user()->name) }}" required>
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L" @selected($v('jenis_kelamin') === 'L')>Laki-laki</option>
                        <option value="P" @selected($v('jenis_kelamin') === 'P')>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input class="form-control" name="tempat_lahir"
                        value="{{ $v('tempat_lahir') }}" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', optional($profil?->tanggal_lahir)->format('Y-m-d')) }}"
                        required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-heading">
                <div class="section-number">02</div>
                <div>
                    <h3>Informasi Akademik</h3>
                    <p>Lengkapi informasi perkuliahan yang sedang ditempuh.</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fakultas</label>
                    <input class="form-control" name="fakultas"
                        value="{{ $v('fakultas') }}" required>
                </div>

                <div class="form-group">
                    <label>Program Studi</label>
                    <input class="form-control" name="prodi"
                        value="{{ $v('prodi') }}" required>
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group">
                    <label>Semester</label>
                    <input type="number" min="1" max="14"
                        class="form-control" name="semester"
                        value="{{ $v('semester') }}" required>
                </div>

                <div class="form-group">
                    <label>IPK</label>
                    <input type="number" step="0.01" min="0" max="4"
                        class="form-control" name="ipk"
                        value="{{ $v('ipk') }}" required>
                </div>

                <div class="form-group">
                    <label>Nomor HP</label>
                    <input class="form-control" name="no_hp"
                        value="{{ $v('no_hp') }}" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-heading">
                <div class="section-number">03</div>
                <div>
                    <h3>Alamat dan Pas Foto</h3>
                    <p>Informasi tambahan untuk melengkapi profil dan KTM digital.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea class="form-control" name="alamat"
                        required>{{ $v('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label>Pas Foto</label>

                @if($profil?->foto_url)
                    <img src="{{ $profil->foto_url }}" alt="Foto mahasiswa"
                        class="photo-preview">
                @else
                    <div class="photo-empty">
                        <span>♙</span>
                        Belum ada foto
                    </div>
                @endif

                <input type="file" name="foto" accept="image/*"
                    class="form-control">

                <div class="hint">
                    Gunakan foto JPG atau PNG dengan ukuran maksimal 2 MB.
                    Foto akan ditampilkan pada KTM digital.
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button class="save-button" type="submit">
                Simpan Data Mahasiswa
            </button>
        </div>

    </form>
</div>

@endsection

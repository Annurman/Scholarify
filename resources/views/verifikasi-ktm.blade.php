@extends('layouts.guest')
@section('title', 'Verifikasi KTM')
@section('content')
    <h1>Verifikasi KTM digital</h1>
    <p class="muted">Nomor: {{ $nomor }}</p>
    @if($ktm)
        @php $p = $ktm->pendaftaran; $pr = $p->user->profile; $aktif = $ktm->berlaku_sampai->isFuture(); @endphp
        <div class="alert {{ $aktif ? 'alert-success' : 'alert-danger' }}">
            {{ $aktif ? 'KTM valid dan masih berlaku.' : 'KTM ini sudah kedaluwarsa.' }}
        </div>
        <dl class="dl">
            <dt>Nama</dt><dd>{{ $pr->nama_lengkap }}</dd>
            <dt>NIM</dt><dd>{{ $pr->nim }}</dd>
            <dt>Program studi</dt><dd>{{ $pr->prodi }}</dd>
            <dt>Beasiswa</dt><dd>{{ $p->beasiswa->nama }}</dd>
            <dt>Berlaku sampai</dt><dd>{{ $ktm->berlaku_sampai->translatedFormat('d F Y') }}</dd>
        </dl>
    @else
        <div class="alert alert-danger">KTM dengan nomor ini tidak ditemukan.</div>
    @endif
    <p style="margin-top:1.5rem"><a href="{{ route('home') }}">Kembali ke beranda</a></p>
@endsection

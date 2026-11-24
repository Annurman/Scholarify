@extends('layouts.app')
@section('title', $beasiswa->exists ? 'Ubah beasiswa' : 'Tambah beasiswa')
@section('content')
    <div class="page-head"><div><h1>{{ $beasiswa->exists ? 'Ubah beasiswa' : 'Tambah beasiswa' }}</h1></div></div>

    <form method="POST" class="card" action="{{ $beasiswa->exists ? route('admin.beasiswa.update', $beasiswa) : route('admin.beasiswa.store') }}">
        @csrf
        @if($beasiswa->exists) @method('PUT') @endif

        <div class="form-group"><label>Nama beasiswa</label><input class="form-control" name="nama" value="{{ old('nama', $beasiswa->nama) }}" required></div>
        <div class="form-group"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" required>{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea></div>
        <div class="form-group"><label>Persyaratan</label><textarea class="form-control" name="persyaratan" required>{{ old('persyaratan', $beasiswa->persyaratan) }}</textarea><div class="hint">Satu persyaratan per baris.</div></div>
        <div class="form-row form-row-3">
            <div class="form-group"><label>Kuota penerima</label><input type="number" min="1" class="form-control" name="kuota" value="{{ old('kuota', $beasiswa->kuota) }}" required></div>
            <div class="form-group"><label>Tanggal buka</label><input type="date" class="form-control" name="tgl_buka" value="{{ old('tgl_buka', optional($beasiswa->tgl_buka)->format('Y-m-d')) }}" required></div>
            <div class="form-group"><label>Tanggal tutup</label><input type="date" class="form-control" name="tgl_tutup" value="{{ old('tgl_tutup', optional($beasiswa->tgl_tutup)->format('Y-m-d')) }}" required></div>
        </div>
        <div class="form-group" style="max-width:240px"><label>Status</label>
            <select class="form-control" name="status">
                <option value="dibuka" @selected(old('status', $beasiswa->status) === 'dibuka')>Dibuka</option>
                <option value="ditutup" @selected(old('status', $beasiswa->status) === 'ditutup')>Ditutup</option>
            </select>
        </div>
        <div class="actions"><button class="btn" type="submit">Simpan</button><a class="btn btn-ghost" href="{{ route('admin.beasiswa.index') }}">Batal</a></div>
    </form>
@endsection

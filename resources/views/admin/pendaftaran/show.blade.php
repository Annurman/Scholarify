@extends('layouts.app')
@section('title', 'Periksa pendaftaran')
@section('content')
    @php $pr = $pendaftaran->user->profile; $s = $pendaftaran->status; @endphp
    <div class="page-head">
        <div><h1>{{ $pr->nama_lengkap ?? $pendaftaran->user->name }}</h1><p>{{ $pendaftaran->beasiswa->nama }}</p></div>
        <div class="actions"><x-status-badge :status="$s" /><a class="btn btn-ghost btn-sm" href="{{ route('admin.pendaftaran.index') }}">Kembali</a></div>
    </div>

    @if($s === 'perlu_revisi')
        <div class="alert alert-info">Mahasiswa sedang memperbaiki dokumen yang ditandai tidak valid. Verifikasi ulang tersedia setelah mahasiswa mengajukan revisi.</div>
    @endif

    <div class="grid grid-2">
        <div class="card">
            <div class="card-head"><h2>Data mahasiswa</h2></div>
            @if($pr)
            <dl class="dl">
                <dt>NIM</dt><dd>{{ $pr->nim }}</dd>
                <dt>Fakultas / prodi</dt><dd>{{ $pr->fakultas }} / {{ $pr->prodi }}</dd>
                <dt>Semester</dt><dd>{{ $pr->semester }}</dd>
                <dt>IPK</dt><dd>{{ $pr->ipk }}</dd>
                <dt>Tempat, tgl lahir</dt><dd>{{ $pr->tempat_lahir }}, {{ $pr->tanggal_lahir->translatedFormat('d F Y') }}</dd>
                <dt>No. HP</dt><dd>{{ $pr->no_hp }}</dd>
                <dt>Email</dt><dd>{{ $pendaftaran->user->email }}</dd>
                <dt>Alamat</dt><dd>{{ $pr->alamat }}</dd>
            </dl>
            @else
                <p class="muted">Mahasiswa belum melengkapi data.</p>
            @endif
        </div>

        <div class="card">
            <div class="card-head"><h2>Berkas</h2></div>
            @forelse($pendaftaran->berkas as $b)
                <div class="list-item" style="display:block">
                    <div style="display:flex;justify-content:space-between;gap:.5rem;flex-wrap:wrap">
                        <strong>{{ $b->nama_jenis }}</strong>
                        <a href="{{ $b->url }}" target="_blank" rel="noopener">Buka berkas</a>
                    </div>
                    @if(in_array($s, ['diajukan', 'terverifikasi', 'ditolak']) || ($s === 'perlu_revisi' && $b->status_verifikasi !== 'tidak_valid'))
                    <form method="POST" action="{{ route('admin.berkas.update', $b) }}" class="inline-form" style="margin-top:.5rem">
                        @csrf @method('PATCH')
                        <select name="status_verifikasi" class="form-control" style="width:auto">
                            <option value="valid" @selected($b->status_verifikasi === 'valid')>Valid</option>
                            <option value="tidak_valid" @selected($b->status_verifikasi === 'tidak_valid')>Tidak valid</option>
                        </select>
                        <input name="catatan" class="form-control" style="flex:1;min-width:140px" placeholder="Alasan wajib jika tidak valid" value="{{ $b->catatan }}">
                        <button class="btn btn-outline btn-sm" type="submit">Simpan</button>
                    </form>
                    <span class="badge badge-{{ $b->status_verifikasi }}" style="margin-top:.4rem">{{ ['menunggu'=>'Menunggu','valid'=>'Valid','tidak_valid'=>'Tidak valid'][$b->status_verifikasi] }}</span>
                    @endif
                </div>
            @empty
                <div class="empty">Belum ada berkas.</div>
            @endforelse
        </div>
    </div>

    @if(in_array($s, ['diajukan', 'terverifikasi', 'ditolak']))
    <div class="card">
        <div class="card-head"><h2>Hasil verifikasi</h2></div>
        <form method="POST" action="{{ route('admin.pendaftaran.verifikasi', $pendaftaran) }}" class="inline-form">
            @csrf @method('PATCH')
            <select name="status" class="form-control" style="width:auto">
                <option value="terverifikasi" @selected($s !== 'ditolak')>Terverifikasi</option>
                <option value="ditolak" @selected($s === 'ditolak')>Tolak pendaftaran</option>
            </select>
            <input name="catatan" class="form-control" style="flex:1;min-width:200px" placeholder="Catatan untuk mahasiswa (wajib bila ditolak)" value="{{ old('catatan', $pendaftaran->catatan) }}">
            <button class="btn" type="submit">Simpan verifikasi</button>
        </form>
        <div class="hint">Pendaftaran hanya bisa diverifikasi bila semua berkas berstatus valid.</div>
    </div>
    @endif

    @if(in_array($s, ['terverifikasi', 'lulus', 'tidak_lulus']))
    <div class="card">
        <div class="card-head"><h2>Seleksi</h2></div>
        <form method="POST" action="{{ route('admin.pendaftaran.seleksi', $pendaftaran) }}" class="inline-form">
            @csrf @method('PATCH')
            <input type="number" step="0.01" min="0" max="100" name="nilai_seleksi" class="form-control" style="width:160px" placeholder="Nilai (0-100)" value="{{ old('nilai_seleksi', $pendaftaran->nilai_seleksi) }}" required>
            <select name="status" class="form-control" style="width:auto">
                <option value="lulus" @selected($s !== 'tidak_lulus')>Lulus</option>
                <option value="tidak_lulus" @selected($s === 'tidak_lulus')>Tidak lulus</option>
            </select>
            <button class="btn" type="submit">Simpan hasil seleksi</button>
        </form>
        <div class="hint">Hasil baru terlihat oleh mahasiswa setelah pengumuman dipublikasikan.</div>
    </div>
    @endif
@endsection

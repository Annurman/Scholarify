@extends('layouts.app')
@section('title', 'Pengumuman')
@section('content')
    <div class="page-head"><div><h1>Pengumuman</h1><p>Hasil seleksi tampil ke mahasiswa setelah ada pengumuman yang waktu publikasinya sudah lewat.</p></div></div>

    <div class="grid grid-side">
        <div class="card">
            <div class="card-head"><h2>Daftar pengumuman</h2></div>
            @forelse($pengumuman as $p)
                <div class="list-item" style="align-items:flex-start">
                    <div>
                        <strong>{{ $p->judul }}</strong>
                        <span class="badge {{ $p->tgl_publish->isFuture() ? 'badge-draft' : 'badge-lulus' }}" style="margin-left:.4rem">{{ $p->tgl_publish->isFuture() ? 'Terjadwal' : 'Terbit' }}</span><br>
                        <small>{{ $p->beasiswa->nama }} · {{ $p->tgl_publish->translatedFormat('d M Y H:i') }}</small>
                        <p class="pre muted" style="margin:.3rem 0 0">{{ $p->isi }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $p) }}" data-confirm="Hapus pengumuman ini?">@csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </div>
            @empty
                <div class="empty"><h3>Belum ada pengumuman</h3>Buat pengumuman melalui formulir di samping.</div>
            @endforelse
        </div>

        <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="card" style="align-self:start">
            @csrf
            <div class="card-head"><h2>Buat pengumuman</h2></div>
            <div class="form-group"><label>Beasiswa</label>
                <select name="beasiswa_id" class="form-control" required>
                    <option value="">Pilih beasiswa</option>
                    @foreach($beasiswaList as $b)<option value="{{ $b->id }}" @selected(old('beasiswa_id') == $b->id)>{{ $b->nama }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label>Judul</label><input name="judul" class="form-control" value="{{ old('judul') }}" required></div>
            <div class="form-group"><label>Isi</label><textarea name="isi" class="form-control" required>{{ old('isi') }}</textarea></div>
            <div class="form-group"><label>Waktu publikasi</label><input type="datetime-local" name="tgl_publish" class="form-control" value="{{ old('tgl_publish', now()->format('Y-m-d\TH:i')) }}" required></div>
            <button class="btn btn-block" type="submit">Simpan pengumuman</button>
        </form>
    </div>
@endsection

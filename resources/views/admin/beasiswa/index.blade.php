@extends('layouts.app')
@section('title', 'Kelola beasiswa')
@section('content')
    <div class="page-head">
        <div><h1>Kelola beasiswa</h1><p>Atur program beasiswa, kuota, dan masa pendaftaran.</p></div>
        @if($beasiswa->isEmpty())<a class="btn" href="{{ route('admin.beasiswa.create') }}">Tambah program beasiswa</a>@endif
    </div>
    <div class="card table-wrap">
        @if($beasiswa->isEmpty())
            <div class="empty"><h3>Belum ada beasiswa</h3>Tambahkan program beasiswa pertama.</div>
        @else
        <table>
            <thead><tr><th>Nama</th><th>Periode</th><th>Kuota</th><th>Pendaftar</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @foreach($beasiswa as $b)
                <tr>
                    <td><strong>{{ $b->nama }}</strong></td>
                    <td>{{ $b->tgl_buka->format('d M Y') }} – {{ $b->tgl_tutup->format('d M Y') }}</td>
                    <td>{{ $b->kuota }}</td>
                    <td>{{ $b->pendaftaran_count }}</td>
                    <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-outline btn-sm" href="{{ route('admin.beasiswa.edit', $b) }}">Ubah</a>
                            <form method="POST" action="{{ route('admin.beasiswa.destroy', $b) }}" data-confirm="Hapus beasiswa ini?">@csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection

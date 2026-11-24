@extends('layouts.app')
@section('title', 'Kelola Akun Staf')
@section('content')
    <div class="page-head">
        <div>
            <h1>Kelola Akun Staf</h1>
            <p>Kelola akun internal penyelenggara beasiswa dan mentor pembinaan.</p>
        </div>
        <a class="btn" href="{{ route('admin.akun.create') }}">Tambah akun</a>
    </div>

    <div class="card table-wrap">
        @if($akun->isEmpty())
            <div class="empty"><h3>Belum ada akun staf</h3>Tambahkan akun Admin atau Mentor untuk mulai mengelola Scholarify.</div>
        @else
            <table>
                <thead>
                    <tr><th>Nama</th><th>Email</th><th>Role</th><th>Dibuat</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($akun as $a)
                        <tr>
                            <td><strong>{{ $a->name }}</strong></td>
                            <td>{{ $a->email }}</td>
                            <td>{{ $a->roleLabel() }}</td>
                            <td>{{ $a->created_at?->format('d M Y') ?? '-' }}</td>
                            <td><span class="badge {{ $a->is_active ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $a->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-outline btn-sm" href="{{ route('admin.akun.edit', $a) }}">Ubah</a>
                                    @if($a->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.akun.toggle', $a) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-ghost btn-sm" type="submit">{{ $a->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.akun.destroy', $a) }}" data-confirm="Hapus akun ini? Akun yang memiliki riwayat monitoring tidak dapat dihapus.">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                        </form>
                                    @else
                                        <span class="muted">Akun Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

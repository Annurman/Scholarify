@extends('layouts.guest')

@section('title', 'Pengumuman Beasiswa')

@section('content')
    <h1>Pengumuman Beasiswa</h1>

    @forelse($pengumuman as $item)
        <div class="card">
            <h3>{{ $item->judul }}</h3>

            <p>{{ $item->beasiswa->nama }}</p>

            <p>
                {{ $item->tgl_publish->translatedFormat('d F Y H:i') }}
            </p>

            <p>{{ $item->isi }}</p>
        </div>
    @empty
        <p>Belum ada pengumuman.</p>
    @endforelse

    {{ $pengumuman->links() }}
@endsection

@extends('layouts.app')
@section('title', 'Dashboard Mentor')
@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Mentor</h1>
        <p class="mt-1 text-sm text-gray-500">
            Ringkasan aktivitas dan perkembangan mahasiswa binaan Anda.
        </p>
    </div>

    @include('mentor.partials.kelompok-filter')

    @if (!$selected)
        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
            <h3 class="font-semibold text-gray-700">Belum ada kelompok binaan</h3>
            <p class="mt-2 text-sm text-gray-500">
                Kelompok binaan akan muncul setelah Anda ditugaskan sebagai mentor.
            </p>
        </div>
    @else

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Mahasiswa Binaan</p>
                <h2 class="mt-2 text-3xl font-bold text-indigo-600">
                    {{ $anggota->count() }}
                </h2>
                <p class="mt-1 text-xs text-gray-400">Mahasiswa aktif dalam kelompok</p>
            </div>

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Kegiatan</p>
                <h2 class="mt-2 text-3xl font-bold text-blue-600">
                    {{ $totalKegiatan }}
                </h2>
                <p class="mt-1 text-xs text-gray-400">Kegiatan pembinaan tercatat</p>
            </div>

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Data Monitoring</p>
                <h2 class="mt-2 text-3xl font-bold text-emerald-600">
                    {{ $totalMonitoring }}
                </h2>
                <p class="mt-1 text-xs text-gray-400">Catatan monitoring tersimpan</p>
            </div>

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Rekomendasi</p>
                <h2 class="mt-2 text-3xl font-bold text-amber-600">
                    {{ $evaluasi->count() }}
                </h2>
                <p class="mt-1 text-xs text-gray-400">Rekomendasi yang tercatat</p>
            </div>

        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Mahasiswa Binaan</h3>
                    <a href="{{ route('mentor.mahasiswa.index', ['kelompok' => $selected->id]) }}"
                       class="text-sm font-semibold text-indigo-600 hover:underline">
                        Lihat semua
                    </a>
                </div>

                @forelse ($anggota->take(5) as $p)
                    <div class="flex items-center justify-between border-b py-3 last:border-0">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $p->user->name ?? 'Nama belum tersedia' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                ID Pendaftaran: {{ $p->id }}
                            </p>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                            Aktif
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-500">
                        Belum ada mahasiswa aktif.
                    </p>
                @endforelse
            </div>

            <div class="rounded-xl border bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Kegiatan Terbaru</h3>
                    <a href="{{ route('mentor.kegiatan.index', ['kelompok' => $selected->id]) }}"
                       class="text-sm font-semibold text-indigo-600 hover:underline">
                        Lihat semua
                    </a>
                </div>

                @forelse ($kegiatan as $item)
                    <div class="border-b py-3 last:border-0">
                        <p class="font-semibold text-gray-800">{{ $item->judul }}</p>
                        <p class="mt-1 text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </p>
                        @if ($item->catatan)
                            <p class="mt-2 text-sm text-gray-600">{{ $item->catatan }}</p>
                        @endif
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-500">
                        Belum ada kegiatan pembinaan.
                    </p>
                @endforelse
            </div>

        </div>

        <div class="rounded-xl border bg-indigo-50 p-5">
            <h3 class="font-bold text-indigo-900">Akses Cepat</h3>
            <p class="mt-1 text-sm text-indigo-700">
                Kelola kegiatan dan pantau perkembangan mahasiswa binaan.
            </p>

            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('mentor.mahasiswa.index', ['kelompok' => $selected->id]) }}"
                   class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm">
                    Mahasiswa Binaan
                </a>

                <a href="{{ route('mentor.kegiatan.index', ['kelompok' => $selected->id]) }}"
                   class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm">
                    Kelola Kegiatan
                </a>

                <a href="{{ route('mentor.monitoring.index', ['kelompok' => $selected->id]) }}"
                   class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm">
                    Input Monitoring
                </a>
            </div>
        </div>

    @endif
</div>
@endsection

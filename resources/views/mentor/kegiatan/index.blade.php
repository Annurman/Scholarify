
@extends('layouts.app')
@section('title', 'Dashboard Mentor')
@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kegiatan Pembinaan</h1>
        <p class="mt-1 text-sm text-gray-500">
            Buat dan kelola agenda pembinaan mahasiswa.
        </p>
    </div>

    @include('mentor.partials.kelompok-filter')

    @if (session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (!$selected)
        <div class="rounded-xl border bg-white p-8 text-center text-gray-500">
            Belum ada kelompok binaan.
        </div>
    @else

        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <h3 class="font-bold text-gray-800">Tambah Kegiatan</h3>
            <p class="mt-1 text-sm text-gray-500">
                Masukkan informasi kegiatan pembinaan yang akan dilaksanakan.
            </p>

            <form action="{{ route('mentor.kegiatan.store') }}"
                  method="POST"
                  class="mt-5 space-y-4">
                @csrf

                <input type="hidden" name="kelompok_id" value="{{ $selected->id }}">

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">
                        Nama Kegiatan
                    </label>
                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        required
                        maxlength="150"
                        placeholder="Contoh: Evaluasi Akademik Bulanan"
                        class="w-full rounded-lg border-gray-300 text-sm"
                    >
                    @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">
                        Tanggal Kegiatan
                    </label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal') }}"
                        required
                        class="w-full rounded-lg border-gray-300 text-sm"
                    >
                    @error('tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-gray-700">
                        Catatan Kegiatan
                    </label>
                    <textarea
                        name="catatan"
                        rows="3"
                        maxlength="2000"
                        placeholder="Tuliskan deskripsi atau tujuan kegiatan..."
                        class="w-full rounded-lg border-gray-300 text-sm"
                    >{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    Simpan Kegiatan
                </button>
            </form>
        </div>

        <div class="rounded-xl border bg-white shadow-sm">
            <div class="border-b p-5">
                <h3 class="font-bold text-gray-800">Daftar Kegiatan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $kegiatan->count() }} kegiatan tercatat.
                </p>
            </div>

            <div class="divide-y">
                @forelse ($kegiatan as $item)
                    <div class="p-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    {{ $item->judul }}
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </p>
                            </div>

                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                {{ $item->monitoring->count() }} data monitoring
                            </span>
                        </div>

                        @if ($item->catatan)
                            <p class="mt-3 text-sm text-gray-600">
                                {{ $item->catatan }}
                            </p>
                        @endif

                        <a href="{{ route('mentor.monitoring.index', ['kelompok' => $selected->id]) }}"
                           class="mt-3 inline-block text-sm font-semibold text-indigo-600 hover:underline">
                            Input monitoring kegiatan
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-gray-500">
                        Belum ada kegiatan pembinaan.
                    </div>
                @endforelse
            </div>
        </div>

    @endif
</div>
@endsection

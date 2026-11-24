
@extends('layouts.app')
@section('title', 'Dashboard Mentor')
@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Monitoring Kehadiran</h1>
        <p class="mt-1 text-sm text-gray-500">
            Catat kehadiran dan keaktifan mahasiswa pada kegiatan pembinaan.
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
    @elseif ($anggota->isEmpty())
        <div class="rounded-xl border bg-white p-8 text-center text-gray-500">
            Belum ada mahasiswa aktif yang dapat dimonitoring.
        </div>
    @elseif ($kegiatan->isEmpty())
        <div class="rounded-xl border bg-white p-8 text-center">
            <h3 class="font-semibold text-gray-800">Belum ada kegiatan</h3>
            <p class="mt-2 text-sm text-gray-500">
                Tambahkan kegiatan pembinaan terlebih dahulu sebelum mengisi monitoring.
            </p>
            <a href="{{ route('mentor.kegiatan.index', ['kelompok' => $selected->id]) }}"
               class="mt-4 inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                Tambah Kegiatan
            </a>
        </div>
    @else

        @foreach ($kegiatan as $activity)
            <div class="overflow-hidden rounded-xl border bg-white shadow-sm">

                <div class="border-b bg-gray-50 p-5">
                    <h3 class="font-bold text-gray-800">{{ $activity->judul }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}
                    </p>
                    @if ($activity->catatan)
                        <p class="mt-2 text-sm text-gray-600">{{ $activity->catatan }}</p>
                    @endif
                </div>

                <form action="{{ route('mentor.monitoring.store', $activity) }}"
                      method="POST">
                    @csrf

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white text-gray-600">
                                <tr>
                                    <th class="px-4 py-3">Mahasiswa</th>
                                    <th class="px-4 py-3">Kehadiran</th>
                                    <th class="px-4 py-3">Keaktifan</th>
                                    <th class="px-4 py-3">Catatan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @foreach ($anggota as $index => $p)
                                    @php
                                        $record = $activity->monitoring
                                            ->firstWhere('pendaftaran_id', $p->id);
                                    @endphp

                                    <tr>
                                        <td class="px-4 py-4 font-semibold text-gray-800">
                                            {{ $p->user->name ?? 'Nama belum tersedia' }}
                                            <input
                                                type="hidden"
                                                name="monitoring[{{ $index }}][pendaftaran_id]"
                                                value="{{ $p->id }}"
                                            >
                                        </td>

                                        <td class="min-w-[150px] px-4 py-4">
                                            <select
                                                name="monitoring[{{ $index }}][kehadiran]"
                                                required
                                                class="w-full rounded-lg border-gray-300 text-sm"
                                            >
                                                @foreach ([
                                                    'hadir' => 'Hadir',
                                                    'izin' => 'Izin',
                                                    'sakit' => 'Sakit',
                                                    'tidak_hadir' => 'Tidak Hadir'
                                                ] as $value => $label)
                                                    <option
                                                        value="{{ $value }}"
                                                        @selected(old("monitoring.$index.kehadiran", $record->kehadiran ?? 'hadir') === $value)
                                                    >
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="min-w-[160px] px-4 py-4">
                                            <select
                                                name="monitoring[{{ $index }}][keaktifan]"
                                                required
                                                class="w-full rounded-lg border-gray-300 text-sm"
                                            >
                                                @foreach ([
                                                    'aktif' => 'Aktif',
                                                    'cukup_aktif' => 'Cukup Aktif',
                                                    'kurang_aktif' => 'Kurang Aktif',
                                                    'tidak_aktif' => 'Tidak Aktif'
                                                ] as $value => $label)
                                                    <option
                                                        value="{{ $value }}"
                                                        @selected(old("monitoring.$index.keaktifan", $record->keaktifan ?? 'aktif') === $value)
                                                    >
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="min-w-[200px] px-4 py-4">
                                            <input
                                                type="text"
                                                name="monitoring[{{ $index }}][catatan]"
                                                value="{{ old("monitoring.$index.catatan", $record->catatan ?? '') }}"
                                                maxlength="1000"
                                                placeholder="Catatan opsional"
                                                class="w-full rounded-lg border-gray-300 text-sm"
                                            >
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end border-t p-4">
                        <button type="submit"
                                class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                            Simpan Monitoring
                        </button>
                    </div>
                </form>
            </div>
        @endforeach

    @endif
</div>
@endsection

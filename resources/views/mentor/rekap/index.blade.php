
@extends('layouts.app')
@section('title', 'Dashboard Mentor')
@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rekap Monitoring</h1>
        <p class="mt-1 text-sm text-gray-500">
            Lihat riwayat kehadiran dan keaktifan mahasiswa berdasarkan kegiatan.
        </p>
    </div>

    @include('mentor.partials.kelompok-filter')

    @if (!$selected)
        <div class="rounded-xl border bg-white p-8 text-center text-gray-500">
            Belum ada kelompok binaan.
        </div>
    @else

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border bg-white p-5">
                <p class="text-sm text-gray-500">Mahasiswa Aktif</p>
                <p class="mt-2 text-2xl font-bold text-indigo-600">
                    {{ $anggota->count() }}
                </p>
            </div>

            <div class="rounded-xl border bg-white p-5">
                <p class="text-sm text-gray-500">Total Kegiatan</p>
                <p class="mt-2 text-2xl font-bold text-blue-600">
                    {{ $kegiatan->count() }}
                </p>
            </div>

            <div class="rounded-xl border bg-white p-5">
                <p class="text-sm text-gray-500">Total Catatan Monitoring</p>
                <p class="mt-2 text-2xl font-bold text-emerald-600">
                    {{ $kegiatan->sum(fn ($item) => $item->monitoring->count()) }}
                </p>
            </div>
        </div>

        <div class="space-y-5">
            @forelse ($kegiatan as $activity)
                <div class="overflow-hidden rounded-xl border bg-white shadow-sm">

                    <div class="flex flex-wrap items-center justify-between gap-3 border-b bg-gray-50 p-5">
                        <div>
                            <h3 class="font-bold text-gray-800">
                                {{ $activity->judul }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}
                            </p>
                        </div>

                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                            {{ $activity->monitoring->count() }} catatan
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white text-gray-600">
                                <tr>
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3">Kehadiran</th>
                                    <th class="px-5 py-3">Keaktifan</th>
                                    <th class="px-5 py-3">Catatan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse ($activity->monitoring as $record)
                                    <tr>
                                        <td class="px-5 py-4 font-semibold text-gray-800">
                                            {{ $record->pendaftaran->user->name ?? 'Nama belum tersedia' }}
                                        </td>

                                        <td class="px-5 py-4">
                                            {{ ucfirst(str_replace('_', ' ', $record->kehadiran)) }}
                                        </td>

                                        <td class="px-5 py-4">
                                            {{ ucfirst(str_replace('_', ' ', $record->keaktifan)) }}
                                        </td>

                                        <td class="px-5 py-4 text-gray-600">
                                            {{ $record->catatan ?: '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                                            Belum ada monitoring untuk kegiatan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            @empty
                <div class="rounded-xl border bg-white p-8 text-center text-gray-500">
                    Belum ada kegiatan pembinaan.
                </div>
            @endforelse
        </div>

    @endif
</div>
@endsection

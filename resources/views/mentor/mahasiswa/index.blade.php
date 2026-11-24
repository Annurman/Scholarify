
@extends('layouts.app')
@section('title', 'Dashboard Mentor')
@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Mahasiswa Binaan</h1>
        <p class="mt-1 text-sm text-gray-500">
            Daftar mahasiswa penerima beasiswa yang berada dalam kelompok binaan Anda.
        </p>
    </div>

    @include('mentor.partials.kelompok-filter')

    @if (!$selected)
        <div class="rounded-xl border bg-white p-8 text-center text-gray-500">
            Belum ada kelompok binaan.
        </div>
    @else
        <div class="rounded-xl border bg-white shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b p-5">
                <div>
                    <h3 class="font-bold text-gray-800">Daftar Mahasiswa</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Total {{ $anggota->count() }} mahasiswa aktif
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-3">No.</th>
                            <th class="px-5 py-3">Nama Mahasiswa</th>
                            <th class="px-5 py-3">ID Pendaftaran</th>
                            <th class="px-5 py-3">Status Beasiswa</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($anggota as $index => $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-4">{{ $index + 1 }}</td>
                                <td class="px-5 py-4 font-semibold text-gray-800">
                                    {{ $p->user->name ?? 'Nama belum tersedia' }}
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    #{{ $p->id }}
                                </td>
                                <td class="px-5 py-4">
                                    @if ($p->status_beasiswa === 'aktif')
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Belum diaktifkan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-500">
                                    Belum ada mahasiswa aktif dalam kelompok ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    @endif
</div>
@endsection

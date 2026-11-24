
@extends('layouts.app')

@section('title', 'Dashboard Mentor')

@section('content')
<div class="mentor-page space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rekomendasi Mahasiswa</h1>
        <p class="mt-1 text-sm text-gray-500">
            Sampaikan hasil evaluasi dan rekomendasi perkembangan mahasiswa kepada penyelenggara beasiswa.
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
            Belum ada mahasiswa aktif yang dapat dievaluasi.
        </div>
    @else

        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <h3 class="font-bold text-gray-800">Daftar Mahasiswa</h3>
            <p class="mt-1 text-sm text-gray-500">
                Pilih mahasiswa untuk memberikan rekomendasi.
            </p>

            <div class="mt-5 space-y-5">
                @foreach ($anggota as $p)
                    <div class="rounded-xl border p-5">

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-gray-800">
                                    {{ $p->user->name ?? 'Nama belum tersedia' }}
                                </h4>
                                <p class="mt-1 text-xs text-gray-500">
                                    ID Pendaftaran: #{{ $p->id }}
                                </p>
                            </div>

                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Penerima aktif
                            </span>
                        </div>

                        <form
                            action="{{ route('mentor.rekomendasi.store', $p) }}"
                            method="POST"
                            class="mt-5 space-y-4"
                        >
                            @csrf

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Jenis Rekomendasi
                                </label>

                                <select
                                    name="rekomendasi"
                                    required
                                    class="w-full rounded-lg border-gray-300 text-sm"
                                >
                                    <option value="">Pilih rekomendasi</option>
                                    <option value="pembinaan_lanjut">
                                        Pembinaan Lanjutan
                                    </option>
                                    <option value="peringatan">
                                        Peringatan
                                    </option>
                                    <option value="evaluasi_pencabutan">
                                        Evaluasi Pencabutan
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Alasan dan Hasil Evaluasi
                                </label>

                                <textarea
                                    name="alasan"
                                    rows="3"
                                    maxlength="2000"
                                    required
                                    placeholder="Jelaskan alasan rekomendasi berdasarkan hasil pembinaan dan monitoring..."
                                    class="w-full rounded-lg border-gray-300 text-sm"
                                ></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    Kirim Rekomendasi
                                </button>
                            </div>
                        </form>

                    </div>
                @endforeach
            </div>
        </div>

    @endif
</div>
@endsection

<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\EvaluasiBeasiswa;
use App\Models\KegiatanPembinaan;
use App\Models\MonitoringPembinaan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Mengambil kelompok binaan milik mentor.
     */
    private function getKelompok(Request $request)
    {
        return $request->user()
            ->kelompokBinaan()
            ->withCount('anggota')
            ->with('beasiswa')
            ->get();
    }

    /**
     * Mengambil kelompok yang dipilih beserta mahasiswa aktif.
     */
    private function getDataKelompok(Request $request)
    {
        $kelompok = $this->getKelompok($request);

        $selected = $kelompok->firstWhere(
            'id',
            (int) $request->query('kelompok')
        ) ?? $kelompok->first();

        $anggota = collect();

        if ($selected) {
            $anggota = $selected->anggota()
                ->where('status', 'lulus')
                ->where(function ($query) {
                    $query->whereNull('status_beasiswa')
                        ->orWhere('status_beasiswa', '!=', 'dicabut');
                })
                ->with([
                    'user.profile',
                    'monitoring' => function ($query) {
                        $query->latest();
                    },
                ])
                ->get();
        }

        return [
            'kelompok' => $kelompok,
            'selected' => $selected,
            'anggota' => $anggota,
        ];
    }

    /**
     * Dashboard mentor.
     */
    
public function dashboard(Request $request)
{
    $data = $this->getDataKelompok($request);

    $kegiatan = collect();
    $totalKegiatan = 0;
    $totalMonitoring = 0;
    $evaluasi = collect();

    if ($data['selected']) {
        $kegiatan = $data['selected']->kegiatan()
            ->with('monitoring.pendaftaran.user.profile')
            ->latest('tanggal')
            ->take(5)
            ->get();

        $totalKegiatan = $data['selected']->kegiatan()->count();

        $totalMonitoring = $data['selected']->kegiatan()
            ->withCount('monitoring')
            ->get()
            ->sum('monitoring_count');

        $evaluasi = EvaluasiBeasiswa::whereIn(
            'pendaftaran_id',
            $data['anggota']->pluck('id')
        )->get();
    }

    return view('mentor.dashboard', array_merge($data, [
        'kegiatan' => $kegiatan,
        'totalKegiatan' => $totalKegiatan,
        'totalMonitoring' => $totalMonitoring,
        'evaluasi' => $evaluasi,
    ]));
}


    /**
     * Halaman daftar mahasiswa binaan.
     */
    public function mahasiswa(Request $request)
    {
        $data = $this->getDataKelompok($request);

        return view('mentor.mahasiswa.index', $data);
    }

    /**
     * Halaman daftar kegiatan pembinaan.
     */
    public function kegiatan(Request $request)
    {
        $data = $this->getDataKelompok($request);

        $kegiatan = collect();

        if ($data['selected']) {
            $kegiatan = $data['selected']->kegiatan()
                ->with('monitoring.pendaftaran.user.profile')
                ->latest('tanggal')
                ->get();
        }

        return view('mentor.kegiatan.index', array_merge($data, [
            'kegiatan' => $kegiatan,
        ]));
    }

    /**
     * Halaman monitoring kehadiran dan keaktifan.
     */
    public function index(Request $request)
    {
        $data = $this->getDataKelompok($request);

        $kegiatan = collect();

        if ($data['selected']) {
            $kegiatan = $data['selected']->kegiatan()
                ->with('monitoring.pendaftaran.user.profile')
                ->latest('tanggal')
                ->get();
        }

        return view('mentor.monitoring.index', array_merge($data, [
            'kegiatan' => $kegiatan,
        ]));
    }

    /**
     * Halaman rekap monitoring.
     */
    public function rekap(Request $request)
    {
        $data = $this->getDataKelompok($request);

        $kegiatan = collect();

        if ($data['selected']) {
            $kegiatan = $data['selected']->kegiatan()
                ->with('monitoring.pendaftaran.user.profile')
                ->latest('tanggal')
                ->get();
        }

        return view('mentor.rekap.index', array_merge($data, [
            'kegiatan' => $kegiatan,
        ]));
    }

    /**
     * Halaman rekomendasi mahasiswa.
     */
    public function evaluasi(Request $request)
    {
        $data = $this->getDataKelompok($request);

        $evaluasi = collect();

        if ($data['selected'] && $data['anggota']->isNotEmpty()) {
            $evaluasi = EvaluasiBeasiswa::whereIn(
                'pendaftaran_id',
                $data['anggota']->pluck('id')
            )->latest()->get();
        }

        return view('mentor.evaluasi.index', array_merge($data, [
            'evaluasi' => $evaluasi,
        ]));
    }

    /**
     * Menambahkan kegiatan pembinaan.
     */
    public function storeKegiatan(Request $request)
    {
        $data = $request->validate([
            'kelompok_id' => 'required|integer',
            'judul' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $kelompok = $request->user()
            ->kelompokBinaan()
            ->findOrFail($data['kelompok_id']);

        KegiatanPembinaan::create($data);

        return redirect()
            ->route('mentor.kegiatan.index', ['kelompok' => $kelompok->id])
            ->with('success', 'Kegiatan pembinaan berhasil ditambahkan.');
    }

    /**
     * Menyimpan monitoring kehadiran dan keaktifan.
     */
    public function storeMonitoring(Request $request, KegiatanPembinaan $kegiatan)
    {
        $kelompok = $request->user()
            ->kelompokBinaan()
            ->findOrFail($kegiatan->kelompok_id);

        $data = $request->validate([
            'monitoring' => 'required|array',
            'monitoring.*.pendaftaran_id' => 'required|integer',
            'monitoring.*.kehadiran' => 'required|in:hadir,izin,sakit,tidak_hadir',
            'monitoring.*.keaktifan' => 'required|in:aktif,cukup_aktif,kurang_aktif,tidak_aktif',
            'monitoring.*.catatan' => 'nullable|string|max:1000',
        ]);

        $anggotaIds = $kelompok->anggota()
            ->where('status', 'lulus')
            ->where(function ($query) {
                $query->whereNull('status_beasiswa')
                    ->orWhere('status_beasiswa', '!=', 'dicabut');
            })
            ->pluck('id')
            ->all();

        DB::transaction(function () use (
            $data,
            $kegiatan,
            $anggotaIds,
            $request
        ) {
            foreach ($data['monitoring'] as $item) {
                abort_unless(
                    in_array((int) $item['pendaftaran_id'], $anggotaIds, true),
                    403,
                    'Mahasiswa bukan anggota aktif kelompok binaan Anda.'
                );

                MonitoringPembinaan::updateOrCreate(
                    [
                        'kegiatan_id' => $kegiatan->id,
                        'pendaftaran_id' => $item['pendaftaran_id'],
                    ],
                    [
                        'mentor_id' => $request->user()->id,
                        'kehadiran' => $item['kehadiran'],
                        'keaktifan' => $item['keaktifan'],
                        'catatan' => $item['catatan'] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('mentor.monitoring.index', [
                'kelompok' => $kelompok->id,
            ])
            ->with('success', 'Monitoring berhasil disimpan.');
    }

    /**
     * Menyimpan rekomendasi mentor.
     */
    public function storeRekomendasi(Request $request, Pendaftaran $pendaftaran)
    {
        $kelompok = $request->user()
            ->kelompokBinaan()
            ->whereKey($pendaftaran->kelompok_id)
            ->firstOrFail();

        abort_unless(
            $pendaftaran->status === 'lulus'
            && $pendaftaran->status_beasiswa !== 'dicabut',
            403,
            'Mahasiswa tidak lagi termasuk penerima beasiswa aktif.'
        );

        $data = $request->validate([
            'rekomendasi' => 'required|in:pembinaan_lanjut,peringatan,evaluasi_pencabutan',
            'alasan' => 'required|string|max:2000',
        ]);

        EvaluasiBeasiswa::create([
            'pendaftaran_id' => $pendaftaran->id,
            'mentor_id' => $request->user()->id,
            'rekomendasi' => $data['rekomendasi'],
            'alasan' => $data['alasan'],
        ]);

        return redirect()
            ->route('mentor.evaluasi.index', [
                'kelompok' => $kelompok->id,
            ])
            ->with('success', 'Rekomendasi berhasil dikirim kepada penyelenggara beasiswa.');
    }
}

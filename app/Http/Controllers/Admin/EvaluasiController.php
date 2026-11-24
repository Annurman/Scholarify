<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluasiBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    public function index()
    {
        $evaluasi = EvaluasiBeasiswa::with(['pendaftaran.user.profile', 'mentor', 'adminPemutus'])->latest()->paginate(20);
        return view('admin.evaluasi.index', compact('evaluasi'));
    }

   public function putuskan(Request $request, EvaluasiBeasiswa $evaluasi)
{
    $data = $request->validate([
        'keputusan_admin' => 'required|in:dipertahankan,dicabut',
        'catatan_admin' => 'required|string|max:2000',
    ]);

    DB::transaction(function () use ($evaluasi, $data) {

        $evaluasi->update([
            'keputusan_admin' => $data['keputusan_admin'],
            'diputuskan_oleh' => auth()->id(),
            'catatan_admin' => $data['catatan_admin'],
            'diputuskan_pada' => now(),
        ]);

        $pendaftaran = $evaluasi->pendaftaran;

        $dicabut = $data['keputusan_admin'] === 'dicabut';

        $pendaftaran->update([
            'status_beasiswa' => $dicabut ? 'dicabut' : 'aktif',
             'kelompok_id' => $dicabut
            ? null
            : $pendaftaran->kelompok_id,
        ]);

        if ($pendaftaran->ktm) {
            $pendaftaran->ktm->update([
                'status' => $dicabut ? 'dicabut' : 'aktif',
            ]);
        }
    });

    return back()->with(
        'success',
        'Keputusan evaluasi berhasil disimpan.'
    );
}
}

<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profil = $user->profile;
        $pendaftaran = $user->pendaftaran()->with(['beasiswa', 'ktm'])->latest()->get();

        $steps = [
            ['Registrasi & login', true],
            ['Data mahasiswa', (bool) $profil],
            ['Pendaftaran', $pendaftaran->isNotEmpty()],
            ['Verifikasi & seleksi', $pendaftaran->contains(fn ($p) => in_array($p->status, ['terverifikasi', 'lulus', 'tidak_lulus']))],
            ['Pengumuman', $pendaftaran->contains(fn ($p) => in_array($p->status, ['lulus', 'tidak_lulus']) && $p->diumumkan())],
            ['Penempatan', $pendaftaran->contains(fn ($p) => $p->status === 'lulus' && $p->kelompok_id && $p->diumumkan())],
            ['KTM digital', $pendaftaran->contains(fn ($p) => (bool) $p->ktm)],
        ];

        $pengumuman = Pengumuman::terbit()->with('beasiswa')
            ->whereIn('beasiswa_id', $pendaftaran->pluck('beasiswa_id'))
            ->latest('tgl_publish')->take(3)->get();

        return view('mahasiswa.dashboard', compact('profil', 'pendaftaran', 'steps', 'pengumuman'));
    }

    public function hasil(Request $request)
    {
        $pendaftaran = $request->user()->pendaftaran()->with(['beasiswa', 'kelompok', 'ktm'])->latest()->get();

        $pengumuman = Pengumuman::terbit()->with('beasiswa')
            ->whereIn('beasiswa_id', $pendaftaran->pluck('beasiswa_id'))
            ->latest('tgl_publish')->get();

        return view('mahasiswa.hasil', compact('pendaftaran', 'pengumuman'));
    }


    public function monitoring(Request $request)
    {
        $pendaftaran = $request->user()->pendaftaran()
            ->with(['beasiswa', 'kelompok', 'monitoring.kegiatan'])
            ->where('status', 'lulus')->latest()->first();
        return view('mahasiswa.monitoring', compact('pendaftaran'));
    }

    
public function ktm(Request $request)
{
    $pendaftaran = $request->user()->pendaftaran()
        ->with([
            'beasiswa',
            'kelompok',
            'ktm',
            'user.profile'
        ])

        // Hanya mahasiswa yang dinyatakan lulus
        ->where('status', 'lulus')

        // Tidak boleh sudah dicabut beasiswanya
        ->where(function ($query) {
            $query->whereNull('status_beasiswa')
                ->orWhere('status_beasiswa', '!=', 'dicabut');
        })

        // KTM harus tersedia dan masih aktif
        ->whereHas('ktm', function ($query) {
            $query->where('status', 'aktif');
        })

        ->latest()
        ->first();

    return view('mahasiswa.ktm', compact('pendaftaran'));
}

}

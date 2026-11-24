<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        return view('admin.pengumuman', [
            'pengumuman' => Pengumuman::with('beasiswa')->latest('tgl_publish')->get(),
            'beasiswaList' => Beasiswa::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'beasiswa_id' => 'required|exists:beasiswa,id',
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'tgl_publish' => 'required|date',
        ]);
        Pengumuman::create($data);

        return back()->with('success', 'Pengumuman disimpan. Hasil seleksi tampil ke mahasiswa setelah waktu publikasi.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman dihapus.');
    }
}

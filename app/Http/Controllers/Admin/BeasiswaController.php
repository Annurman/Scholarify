<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index()
    {
        $beasiswa = Beasiswa::withCount('pendaftaran')->latest()->take(1)->get();

        return view('admin.beasiswa.index', compact('beasiswa'));
    }

    public function create()
    {
        if (Beasiswa::exists()) {
            return redirect()->route('admin.beasiswa.index')->with('error', 'Sistem ini hanya mengelola satu program beasiswa. Ubah data program yang sudah tersedia.');
        }
        return view('admin.beasiswa.form', ['beasiswa' => new Beasiswa(['status' => 'dibuka'])]);
    }

    public function store(Request $request)
    {
        if (Beasiswa::exists()) {
            return redirect()->route('admin.beasiswa.index')->with('error', 'Hanya satu program beasiswa yang dapat dibuat. Silakan ubah program yang sudah ada.');
        }
        Beasiswa::create($this->validated($request));

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function edit(Beasiswa $beasiswa)
    {
        return view('admin.beasiswa.form', compact('beasiswa'));
    }

    public function update(Request $request, Beasiswa $beasiswa)
    {
        $beasiswa->update($this->validated($request));

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Beasiswa $beasiswa)
    {
        if ($beasiswa->pendaftaran()->exists()) {
            return back()->with('error', 'Beasiswa sudah memiliki pendaftar. Tutup pendaftaran saja, jangan dihapus.');
        }
        $beasiswa->delete();

        return back()->with('success', 'Beasiswa dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'persyaratan' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'tgl_buka' => 'required|date',
            'tgl_tutup' => 'required|date|after_or_equal:tgl_buka',
            'status' => 'required|in:dibuka,ditutup',
        ]);
    }
}

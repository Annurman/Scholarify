<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user.profile', 'beasiswa'])->latest('submitted_at');

        if ($request->filled('beasiswa_id')) {
            $query->where('beasiswa_id', $request->beasiswa_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', '!=', 'draft');
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('user', function ($u) use ($q) {
                $u->where('name', 'like', "%{$q}%")
                    ->orWhereHas('profile', fn ($p) => $p->where('nim', 'like', "%{$q}%"));
            });
        }

        return view('admin.pendaftaran.index', [
            'pendaftaran' => $query->paginate(15)->withQueryString(),
            'beasiswaList' => Beasiswa::orderBy('nama')->get(),
        ]);
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user.profile', 'beasiswa', 'berkas', 'kelompok']);

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function updateBerkas(Request $request, Berkas $berkas)
    {
        $pendaftaran = $berkas->pendaftaran;
        abort_unless(in_array($pendaftaran->status, ['diajukan', 'perlu_revisi', 'terverifikasi', 'ditolak'], true), 403);
        if ($pendaftaran->status === 'perlu_revisi' && $berkas->status_verifikasi === 'tidak_valid') {
            abort(403, 'Dokumen yang sedang menunggu revisi tidak dapat diubah statusnya sebelum mahasiswa mengunggah pengganti.');
        }

        $data = $request->validate([
            'status_verifikasi' => 'required|in:valid,tidak_valid',
            'catatan' => 'required_if:status_verifikasi,tidak_valid|nullable|string|max:255',
        ], [
            'catatan.required_if' => 'Berikan alasan agar mahasiswa mengetahui dokumen yang harus diperbaiki.',
        ]);

        if ($data['status_verifikasi'] === 'valid') {
            $data['catatan'] = null;
        }

        $berkas->update($data);

        if ($data['status_verifikasi'] === 'tidak_valid') {
            $pendaftaran->update(['status' => 'perlu_revisi']);
        }

        return back()->with('success', $data['status_verifikasi'] === 'tidak_valid'
            ? 'Dokumen ditandai tidak valid. Mahasiswa sekarang dapat mengunggah revisi.'
            : 'Status berkas diperbarui.');
    }

    public function verifikasi(Request $request, Pendaftaran $pendaftaran)
    {
        $data = $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
            'catatan' => 'required_if:status,ditolak|nullable|string|max:500',
        ]);
        abort_unless(in_array($pendaftaran->status, ['diajukan', 'terverifikasi', 'ditolak']), 403);

        if ($data['status'] === 'terverifikasi') {
            $berkas = $pendaftaran->berkas;
            if ($berkas->count() < count(Berkas::JENIS) || $berkas->contains(fn ($b) => $b->status_verifikasi !== 'valid')) {
                return back()->with('error', 'Semua berkas harus berstatus valid sebelum pendaftaran diverifikasi.');
            }
        }

        $pendaftaran->update(['status' => $data['status'], 'catatan' => $data['catatan'] ?? null]);

        return back()->with('success', 'Hasil verifikasi disimpan.');
    }

    public function seleksi(Request $request, Pendaftaran $pendaftaran)
    {
        $data = $request->validate([
            'nilai_seleksi' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:lulus,tidak_lulus',
        ]);
        abort_unless(in_array($pendaftaran->status, ['terverifikasi', 'lulus', 'tidak_lulus']), 403);

        if ($data['status'] === 'lulus') {
            $terisi = Pendaftaran::where('beasiswa_id', $pendaftaran->beasiswa_id)
                ->where('status', 'lulus')->where('id', '!=', $pendaftaran->id)->count();
            if ($terisi >= $pendaftaran->beasiswa->kuota) {
                return back()->with('error', 'Kuota kelulusan beasiswa ini sudah penuh.');
            }
        }

        $update = ['nilai_seleksi' => $data['nilai_seleksi'], 'status' => $data['status']];
        $update['status_beasiswa'] = $data['status'] === 'lulus' ? 'aktif' : null;
        if ($data['status'] === 'tidak_lulus') {
            $update['kelompok_id'] = null;
        }
        $pendaftaran->update($update);

        return back()->with('success', 'Hasil seleksi disimpan.');
    }
}

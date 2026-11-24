<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PendaftaranController extends Controller
{
    /** Daftar beasiswa yang sedang dibuka. */
    public function beasiswa(Request $request)
    {
        $beasiswa = Beasiswa::terbuka()->orderBy('tgl_tutup')->take(1)->get();
        $terdaftar = $request->user()->pendaftaran()->pluck('id', 'beasiswa_id');

        return view('mahasiswa.beasiswa', compact('beasiswa', 'terdaftar'));
    }

    public function daftar(Request $request, Beasiswa $beasiswa)
    {
        if (! $request->user()->profile) {
            return redirect()->route('mahasiswa.profil.edit')->with('error', 'Lengkapi data mahasiswa terlebih dahulu sebelum mendaftar.');
        }
        if (! $beasiswa->isOpen()) {
            return back()->with('error', 'Pendaftaran beasiswa ini sedang ditutup.');
        }

        $pendaftaran = Pendaftaran::firstOrCreate(
            ['user_id' => $request->user()->id, 'beasiswa_id' => $beasiswa->id],
            ['status' => 'draft']
        );

        return redirect()->route('mahasiswa.pendaftaran.show', $pendaftaran)
            ->with('success', 'Silakan unggah seluruh berkas persyaratan, lalu ajukan pendaftaran.');
    }

    public function index(Request $request)
    {
        $pendaftaran = $request->user()->pendaftaran()->with('beasiswa')->latest()->get();

        return view('mahasiswa.pendaftaran.index', compact('pendaftaran'));
    }

    public function show(Request $request, Pendaftaran $pendaftaran)
    {
        $this->own($request, $pendaftaran);
        $pendaftaran->load(['beasiswa', 'berkas', 'kelompok']);

        return view('mahasiswa.pendaftaran.show', [
            'pendaftaran' => $pendaftaran,
            'berkas' => $pendaftaran->berkas->keyBy('jenis_berkas'),
            'jenis' => Berkas::JENIS,
        ]);
    }

    public function upload(Request $request, Pendaftaran $pendaftaran)
{
    $this->own($request, $pendaftaran);

    $status = $pendaftaran->status;

    abort_unless(
        in_array($status, ['draft', 'perlu_revisi'], true),
        403,
        'Berkas tidak dapat diubah pada tahap pendaftaran ini.'
    );

    // Jenis dokumen yang diperbolehkan.
    $jenisDiizinkan = array_keys(Berkas::JENIS);

    // Validasi seluruh file sebelum menyimpan satu pun.
    $request->validate([
        'files' => 'required|array|min:1',
        'files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ], [
        'files.required' => 'Pilih minimal satu dokumen untuk diunggah.',
        'files.min' => 'Pilih minimal satu dokumen untuk diunggah.',
        'files.*.required' => 'Dokumen tidak boleh kosong.',
        'files.*.mimes' => 'Format dokumen harus PDF, JPG, atau PNG.',
        'files.*.max' => 'Ukuran setiap dokumen maksimal 2 MB.',
    ]);

    $files = $request->file('files', []);

    // Memastikan nama jenis dokumen sesuai konfigurasi.
    $jenisTidakDikenal = array_diff(array_keys($files), $jenisDiizinkan);

    if (! empty($jenisTidakDikenal)) {
        throw ValidationException::withMessages([
            'files' => 'Terdapat jenis dokumen yang tidak dikenali.',
        ]);
    }

    // Ambil dokumen lama berdasarkan jenisnya.
    $berkasLama = $pendaftaran->berkas()
        ->get()
        ->keyBy('jenis_berkas');

    // Validasi aturan revisi sebelum menyimpan file.
    foreach ($files as $jenis => $file) {
        $lama = $berkasLama->get($jenis);

        if (
            $status === 'perlu_revisi'
            && (! $lama || $lama->status_verifikasi !== 'tidak_valid')
        ) {
            throw ValidationException::withMessages([
                "files.$jenis" => 'Pada tahap revisi, Anda hanya boleh mengganti dokumen yang ditandai tidak valid oleh admin.',
            ]);
        }
    }

    $pathBaru = [];
    $pathLama = [];

    try {
        // Simpan seluruh file ke storage.
        foreach ($files as $jenis => $file) {
            $path = $file->store(
                'berkas/' . $pendaftaran->id,
                'public'
            );

            if (! $path) {
                foreach ($pathBaru as $pathTersimpan) {
                    Storage::disk('public')->delete($pathTersimpan);
                }

                return back()->with(
                    'error',
                    'Salah satu dokumen gagal disimpan. Silakan coba kembali.'
                );
            }

            $pathBaru[$jenis] = $path;

            $lama = $berkasLama->get($jenis);

            if ($lama && $lama->file_path) {
                $pathLama[$jenis] = $lama->file_path;
            }
        }

        // Perbarui seluruh data dokumen sekaligus.
        DB::transaction(function () use ($pendaftaran, $pathBaru) {
            foreach ($pathBaru as $jenis => $path) {
                $pendaftaran->berkas()->updateOrCreate(
                    ['jenis_berkas' => $jenis],
                    [
                        'file_path' => $path,
                        'status_verifikasi' => 'menunggu',
                        'catatan' => null,
                    ]
                );
            }
        });

    } catch (\Throwable $e) {
        // Bersihkan file baru jika penyimpanan database gagal.
        foreach ($pathBaru as $path) {
            Storage::disk('public')->delete($path);
        }

        throw $e;
    }

    // Hapus file lama setelah database berhasil diperbarui.
    foreach ($pathLama as $path) {
        Storage::disk('public')->delete($path);
    }

    $jumlah = count($pathBaru);

    return back()->with(
        'success',
        $jumlah . ' dokumen berhasil diunggah sekaligus.'
    );
}

    public function hapusBerkas(Request $request, Berkas $berkas)
    {
        $pendaftaran = $berkas->pendaftaran;
        $this->own($request, $pendaftaran);
        abort_unless($pendaftaran->status === 'draft', 403, 'Dokumen hanya dapat dihapus sebelum pendaftaran diajukan.');

        Storage::disk('public')->delete($berkas->file_path);
        $berkas->delete();

        return back()->with('success', 'Berkas dihapus.');
    }

    public function ajukan(Request $request, Pendaftaran $pendaftaran)
    {
        $this->own($request, $pendaftaran);
        abort_unless(in_array($pendaftaran->status, ['draft', 'perlu_revisi'], true), 403);

        $berkas = $pendaftaran->berkas;
        if ($berkas->count() < count(Berkas::JENIS)) {
            return back()->with('error', 'Lengkapi semua berkas persyaratan sebelum mengajukan.');
        }

        if ($pendaftaran->status === 'draft' && ! $pendaftaran->beasiswa->isOpen()) {
            return back()->with('error', 'Masa pendaftaran beasiswa ini sudah berakhir.');
        }

        if ($pendaftaran->status === 'perlu_revisi') {
            if ($berkas->contains(fn ($item) => $item->status_verifikasi === 'tidak_valid')) {
                return back()->with('error', 'Masih ada dokumen yang belum diperbaiki. Periksa catatan admin pada setiap dokumen.');
            }

            if (! $berkas->contains(fn ($item) => $item->status_verifikasi === 'menunggu')) {
                return back()->with('error', 'Unggah kembali dokumen yang diminta admin sebelum mengajukan revisi.');
            }
        }

        $isRevision = $pendaftaran->status === 'perlu_revisi';

        $pendaftaran->update([
            'status' => 'diajukan',
            'submitted_at' => now(),
            'catatan' => null,
        ]);

        return back()->with('success', $isRevision
            ? 'Revisi berhasil diajukan kembali. Admin akan memeriksa dokumen Anda.'
            : 'Pendaftaran berhasil diajukan. Admin akan memeriksa dokumen Anda.');
    }

    private function own(Request $request, Pendaftaran $pendaftaran): void
    {
        abort_unless($pendaftaran->user_id === $request->user()->id, 403);
    }
}

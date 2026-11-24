<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\KelompokPembinaan;
use App\Models\KtmDigital;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenempatanController extends Controller
{
    public function index(Request $request)
    {
        $kelompok = KelompokPembinaan::with(['beasiswa', 'mentor'])->withCount('anggota')
            ->when($request->filled('beasiswa_id'), fn ($q) => $q->where('beasiswa_id', $request->beasiswa_id))
            ->orderBy('beasiswa_id')->get();

        $peserta = Pendaftaran::with(['user.profile', 'beasiswa', 'ktm'])->where('status', 'lulus')
            ->when($request->filled('beasiswa_id'), fn ($q) => $q->where('beasiswa_id', $request->beasiswa_id))
            ->orderBy('beasiswa_id')->get();

        return view('admin.penempatan', [
            'kelompok' => $kelompok,
            'peserta' => $peserta,
            'beasiswaList' => Beasiswa::orderBy('nama')->get(),
            'allKelompok' => KelompokPembinaan::withCount('anggota')->get()->groupBy('beasiswa_id'),
            'mentors' => User::where('role', 'mentor')->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function storeKelompok(Request $request)
    {
        $data = $request->validate([
            'beasiswa_id' => 'required|exists:beasiswa,id',
            'nama_kelompok' => 'required|string|max:100',
            'pembina' => 'nullable|string|max:100',
            'mentor_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'mentor')->where('is_active', true)),
            ],
            'jadwal' => 'nullable|string|max:150',
            'kuota' => 'required|integer|min:1',
        ]);
        if (!empty($data['mentor_id'])) {
            $mentor = User::where('role', 'mentor')->where('is_active', true)->findOrFail($data['mentor_id']);
            $data['pembina'] = $mentor->name;
        }
        $data['pembina'] = $data['pembina'] ?? 'Belum ditentukan';
        KelompokPembinaan::create($data);

        return back()->with('success', 'Kelompok pembinaan ditambahkan.');
    }

    public function destroyKelompok(KelompokPembinaan $kelompok)
    {
        if ($kelompok->kegiatan()->exists()) {
            return back()->with('error', 'Kelompok memiliki riwayat kegiatan atau monitoring dan tidak dapat dihapus.');
        }

        $kelompok->delete();

        return back()->with('success', 'Kelompok dihapus. Anggotanya kembali berstatus belum ditempatkan.');
    }

    public function simpan(Request $request)
    {
        $input = collect($request->input('kelompok', []));
        $ids = $input->keys()->all();

        $pendaftaran = Pendaftaran::whereIn('id', $ids)->where('status', 'lulus')->get()->keyBy('id');
        $kelompok = KelompokPembinaan::all()->keyBy('id');

        $hitung = [];
        foreach ($input as $pid => $kid) {
            if (! $kid || ! $pendaftaran->has($pid)) {
                continue;
            }
            if (! $kelompok->has($kid) || $kelompok[$kid]->beasiswa_id !== $pendaftaran[$pid]->beasiswa_id) {
                return back()->with('error', 'Kelompok tidak sesuai dengan beasiswa peserta.');
            }
            $hitung[$kid] = ($hitung[$kid] ?? 0) + 1;
        }

        foreach ($hitung as $kid => $jumlah) {
            $diLuar = Pendaftaran::where('kelompok_id', $kid)->whereNotIn('id', $ids)->count();
            if ($jumlah + $diLuar > $kelompok[$kid]->kuota) {
                return back()->with('error', "Kuota {$kelompok[$kid]->nama_kelompok} terlampaui.");
            }
        }

        foreach ($input as $pid => $kid) {
            if ($pendaftaran->has($pid)) {
                $pendaftaran[$pid]->update(['kelompok_id' => $kid ?: null]);
            }
        }

        return back()->with('success', 'Penempatan disimpan.');
    }

    public function terbitkanKtm()
    {
        $daftar = Pendaftaran::where('status', 'lulus')->whereNotNull('kelompok_id')->doesntHave('ktm')->get();

        foreach ($daftar as $p) {
            KtmDigital::create([
                'pendaftaran_id' => $p->id,
                'nomor_ktm' => 'KTM-' . now()->format('Y') . '-' . str_pad($p->id, 5, '0', STR_PAD_LEFT),
                'berlaku_sampai' => now()->addYear()->toDateString(),
            ]);
        }

        return back()->with('success', $daftar->count() . ' KTM digital berhasil diterbitkan.');
    }
}

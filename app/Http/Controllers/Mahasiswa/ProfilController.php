<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function edit(Request $request)
    {
        return view('mahasiswa.profil', ['profil' => $request->user()->profile]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $profil = $user->profile;

        $data = $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswa_profiles', 'nim')->ignore($profil?->id)],
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:80',
            'tanggal_lahir' => 'required|date|before:today',
            'fakultas' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'semester' => 'required|integer|min:1|max:14',
            'ipk' => 'required|numeric|min:0|max:4',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($profil?->foto) {
                Storage::disk('public')->delete($profil->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto', 'public');
        } else {
            unset($data['foto']);
        }

        $user->profile()->updateOrCreate([], $data);

        return redirect()->route('mahasiswa.beasiswa.index')->with('success', 'Data mahasiswa berhasil disimpan.');
    }
}

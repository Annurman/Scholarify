<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    private const STAFF_ROLES = ['admin', 'mentor'];

    public function index()
    {
        return view('admin.akun.index', [
            'akun' => User::whereIn('role', self::STAFF_ROLES)->orderBy('role')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.akun.form', ['akun' => new User(['is_active' => true, 'role' => 'mentor'])]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(self::STAFF_ROLES)],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.akun.index')->with('success', 'Akun staf berhasil dibuat.');
    }

    public function edit(User $akun)
    {
        abort_unless(in_array($akun->role, self::STAFF_ROLES, true), 404);

        return view('admin.akun.form', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        abort_unless(in_array($akun->role, self::STAFF_ROLES, true), 404);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($akun->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(self::STAFF_ROLES)],
        ]);

        if ($akun->id === $request->user()->id
            && ($data['role'] !== $akun->role || ! $request->boolean('is_active'))) {
            return back()->withErrors(['role' => 'Anda tidak dapat mengubah role atau menonaktifkan akun yang sedang digunakan.'])->withInput();
        }

        $hasMentorHistory = $akun->kelompokBinaan()->exists()
            || $akun->monitoringSebagaiMentor()->exists()
            || $akun->evaluasiSebagaiMentor()->exists();

        if ($akun->role === 'mentor' && $data['role'] !== 'mentor' && $hasMentorHistory) {
            return back()->withErrors([
                'role' => 'Akun mentor memiliki penugasan atau riwayat pembinaan. Pindahkan penugasan terlebih dahulu dan pertahankan role Mentor agar riwayat tetap konsisten.',
            ])->withInput();
        }

        if ($akun->role === 'mentor' && $akun->is_active && ! $request->boolean('is_active') && $akun->kelompokBinaan()->exists()) {
            return back()->withErrors([
                'is_active' => 'Pindahkan penugasan kelompok sebelum menonaktifkan mentor ini.',
            ])->withInput();
        }

        $akun->name = $data['name'];
        $akun->email = $data['email'];
        $akun->role = $data['role'];
        $akun->is_active = $request->boolean('is_active');

        if (! empty($data['password'])) {
            $akun->password = Hash::make($data['password']);
        }

        $akun->save();

        return redirect()->route('admin.akun.index')->with('success', 'Akun staf berhasil diperbarui.');
    }

    public function destroy(User $akun)
    {
        abort_unless(in_array($akun->role, self::STAFF_ROLES, true), 404);
        abort_if($akun->id === auth()->id(), 403, 'Anda tidak dapat menghapus akun yang sedang digunakan.');

        if ($akun->kelompokBinaan()->exists()
            || $akun->monitoringSebagaiMentor()->exists()
            || $akun->evaluasiSebagaiMentor()->exists()) {
            return back()->with('error', 'Akun memiliki penugasan atau riwayat monitoring. Nonaktifkan akun atau pindahkan penugasannya, jangan hapus riwayat.');
        }

        $akun->delete();

        return back()->with('success', 'Akun staf berhasil dihapus.');
    }

    public function toggle(User $akun)
    {
        abort_unless(in_array($akun->role, self::STAFF_ROLES, true), 404);
        abort_if($akun->id === auth()->id(), 403, 'Anda tidak dapat menonaktifkan akun yang sedang digunakan.');

        if ($akun->role === 'mentor' && $akun->is_active && $akun->kelompokBinaan()->exists()) {
            return back()->with('error', 'Pindahkan penugasan kelompok sebelum menonaktifkan mentor ini.');
        }

        $akun->update(['is_active' => ! $akun->is_active]);

        return back()->with('success', 'Akun berhasil ' . ($akun->is_active ? 'diaktifkan.' : 'dinonaktifkan.'));
    }
}

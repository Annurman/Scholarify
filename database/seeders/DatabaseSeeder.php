<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\KelompokPembinaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@beasiswa.test'],
            ['name' => 'Admin Beasiswa', 'password' => Hash::make('password'), 'role' => 'admin', 'is_active' => true]
        );
        $mentor = User::updateOrCreate(
            ['email' => 'mentor@beasiswa.test'],
            ['name' => 'Mentor Pembinaan', 'password' => Hash::make('password'), 'role' => 'mentor', 'is_active' => true]
        );

        $mhs = User::updateOrCreate(
            ['email' => 'mahasiswa@beasiswa.test'],
            ['name' => 'Andi Pratama', 'password' => Hash::make('password'), 'role' => 'mahasiswa', 'is_active' => true]
        );
        $mhs->profile()->updateOrCreate([], [
            'nim' => '2021010001', 'nama_lengkap' => 'Andi Pratama', 'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bekasi', 'tanggal_lahir' => '2003-05-14', 'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika', 'semester' => 5, 'ipk' => 3.65,
            'no_hp' => '081234567890', 'alamat' => 'Jl. Mawar No. 12, Bekasi',
        ]);

        $b1 = Beasiswa::updateOrCreate(
            ['nama' => 'Beasiswa Prestasi Akademik'],
            [
                'nama' => 'Beasiswa Prestasi Akademik',
                'deskripsi' => 'Beasiswa untuk mahasiswa dengan capaian akademik unggul, mencakup biaya pendidikan satu semester dan program pembinaan karakter.',
                'persyaratan' => "Mahasiswa aktif minimal semester 3\nIPK minimal 3.25\nTidak sedang menerima beasiswa lain",
                'kuota' => 20, 'tgl_buka' => now()->subDays(3), 'tgl_tutup' => now()->addDays(30), 'status' => 'dibuka',
            ]
        );
        foreach (['Kelompok Alpha' => 'Dr. Budi Santoso', 'Kelompok Beta' => 'Dra. Siti Rahma'] as $nama => $pembina) {
            KelompokPembinaan::updateOrCreate(
                ['beasiswa_id' => $b1->id, 'nama_kelompok' => $nama],
                [
                    'pembina' => $pembina,
                    'mentor_id' => $nama === 'Kelompok Alpha' ? $mentor->id : null,
                    'jadwal' => 'Setiap Sabtu, 08.00 - 10.00 WIB',
                    'kuota' => 10,
                ]
            );
        }
    }
}

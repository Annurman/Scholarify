<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class InitialAdminSeeder extends Seeder
{
    public function run(): void
    {
        $name = trim((string) env('INITIAL_ADMIN_NAME'));
        $email = strtolower(trim((string) env('INITIAL_ADMIN_EMAIL')));
        $password = (string) env('INITIAL_ADMIN_PASSWORD');

        if (
            $name === '' ||
            $email === '' ||
            strlen($password) < 12
        ) {
            throw new RuntimeException(
                'Initial admin environment variables belum lengkap atau password kurang dari 12 karakter.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->command?->info('Initial admin account berhasil dibuat.');
    }
}

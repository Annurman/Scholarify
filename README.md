# Scholarify — Sistem Informasi Beasiswa

Scholarify adalah aplikasi pengelolaan beasiswa untuk satu perusahaan penyelenggara. Aplikasi menggunakan Laravel 10 dan memiliki tiga role utama.

## Role aplikasi

- **Mahasiswa** — registrasi, melengkapi profil, mendaftar beasiswa, memperbaiki dokumen yang tidak valid, memantau progres, dan melihat hasil monitoring.
- **Admin / Penyelenggara Beasiswa** — mengelola program beasiswa, pendaftaran, verifikasi dokumen, seleksi, penerimaan, penempatan, pengumuman, serta akun internal Admin dan Mentor.
- **Mentor** — memantau peserta yang ditempatkan pada kelompok binaannya, mencatat kegiatan, kehadiran, keaktifan, dan mengirim rekomendasi evaluasi.

Tidak ada role Superadmin maupun pengelolaan multi-perusahaan. Admin perusahaan mengelola akun internal melalui menu **Kelola Akun Staf**.

## Persyaratan

- PHP 8.1 atau lebih baru beserta ekstensi Laravel yang dibutuhkan.
- Composer.
- MySQL atau MariaDB.
- Node.js dan NPM untuk build asset frontend.

## Instalasi lokal

1. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database.
2. Install dependensi PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Buat application key dan database:

   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

4. Build asset dan jalankan aplikasi:

   ```bash
   npm run build
   php artisan serve
   ```

## Migrasi dari versi sebelumnya

Sebelum menjalankan migrasi pada database yang sudah berisi data, buat backup database terlebih dahulu. Jalankan:

```bash
php artisan migrate
```

Migrasi `2026_11_15_000001_normalize_user_roles` akan mengubah akun lama sebagai berikut:

- Akun `superadmin` menjadi `admin`.
- Akun `admin` dengan `is_mentor = true` menjadi role `mentor`.
- Kolom lama `is_mentor` dihapus setelah datanya dipindahkan ke kolom `role`.

Migrasi ini tidak menghapus akun mahasiswa, pendaftaran, berkas, kelompok, ataupun riwayat monitoring.

## Akun demo

Akun berikut dibuat ketika menjalankan seeder pada database baru. Password demo adalah `password`.

| Role | Email |
|---|---|
| Admin | `admin@beasiswa.test` |
| Mentor | `mentor@beasiswa.test` |
| Mahasiswa | `mahasiswa@beasiswa.test` |

Ganti password akun demo sebelum aplikasi dipakai di lingkungan nyata.

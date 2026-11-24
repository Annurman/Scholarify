<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_profiles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('nim', 20)->unique();
            $t->string('nama_lengkap', 100);
            $t->enum('jenis_kelamin', ['L', 'P']);
            $t->string('tempat_lahir', 80);
            $t->date('tanggal_lahir');
            $t->string('fakultas', 100);
            $t->string('prodi', 100);
            $t->unsignedTinyInteger('semester');
            $t->decimal('ipk', 3, 2);
            $t->string('no_hp', 20);
            $t->text('alamat');
            $t->string('foto')->nullable();
            $t->timestamps();
        });

        Schema::create('beasiswa', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 150);
            $t->text('deskripsi');
            $t->text('persyaratan');
            $t->unsignedInteger('kuota');
            $t->date('tgl_buka');
            $t->date('tgl_tutup');
            $t->string('status', 20)->default('dibuka'); // dibuka | ditutup
            $t->timestamps();
        });

        Schema::create('kelompok_pembinaan', function (Blueprint $t) {
            $t->id();
            $t->foreignId('beasiswa_id')->constrained('beasiswa')->cascadeOnDelete();
            $t->string('nama_kelompok', 100);
            $t->string('pembina', 100);
            $t->string('jadwal', 150)->nullable();
            $t->unsignedInteger('kuota');
            $t->timestamps();
        });

        Schema::create('pendaftaran', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('beasiswa_id')->constrained('beasiswa')->cascadeOnDelete();
            $t->string('status', 20)->default('draft'); // draft|diajukan|terverifikasi|ditolak|lulus|tidak_lulus
            $t->decimal('nilai_seleksi', 5, 2)->nullable();
            $t->text('catatan')->nullable();
            $t->foreignId('kelompok_id')->nullable()->constrained('kelompok_pembinaan')->nullOnDelete();
            $t->timestamp('submitted_at')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'beasiswa_id']);
        });

        Schema::create('berkas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $t->string('jenis_berkas', 50);
            $t->string('file_path');
            $t->string('status_verifikasi', 20)->default('menunggu'); // menunggu|valid|tidak_valid
            $t->string('catatan')->nullable();
            $t->timestamps();
            $t->unique(['pendaftaran_id', 'jenis_berkas']);
        });

        Schema::create('pengumuman', function (Blueprint $t) {
            $t->id();
            $t->foreignId('beasiswa_id')->constrained('beasiswa')->cascadeOnDelete();
            $t->string('judul', 200);
            $t->text('isi');
            $t->dateTime('tgl_publish');
            $t->timestamps();
        });

        Schema::create('ktm_digital', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pendaftaran_id')->unique()->constrained('pendaftaran')->cascadeOnDelete();
            $t->string('nomor_ktm', 30)->unique();
            $t->date('berlaku_sampai');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ktm_digital');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('berkas');
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('kelompok_pembinaan');
        Schema::dropIfExists('beasiswa');
        Schema::dropIfExists('mahasiswa_profiles');
    }
};

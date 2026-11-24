<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_mentor')->default(false)->after('role');
        });

        Schema::table('kelompok_pembinaan', function (Blueprint $table) {
            $table->foreignId('mentor_id')->nullable()->after('pembina')->constrained('users')->nullOnDelete();
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('status_beasiswa', 20)->nullable()->after('status');
        });

        Schema::create('kegiatan_pembinaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok_pembinaan')->cascadeOnDelete();
            $table->string('judul', 150);
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('monitoring_pembinaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan_pembinaan')->cascadeOnDelete();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->string('kehadiran', 25)->default('hadir');
            $table->string('keaktifan', 25)->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['kegiatan_id', 'pendaftaran_id']);
        });

        Schema::create('evaluasi_beasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->string('rekomendasi', 30); // pembinaan_lanjut | peringatan | evaluasi_pencabutan
            $table->text('alasan');
            $table->string('keputusan_admin', 25)->default('menunggu'); // menunggu | dipertahankan | dicabut
            $table->foreignId('diputuskan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('diputuskan_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_beasiswa');
        Schema::dropIfExists('monitoring_pembinaan');
        Schema::dropIfExists('kegiatan_pembinaan');
        Schema::table('pendaftaran', fn (Blueprint $table) => $table->dropColumn('status_beasiswa'));
        Schema::table('kelompok_pembinaan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mentor_id');
        });
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('is_mentor'));
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = ['user_id', 'beasiswa_id', 'status', 'nilai_seleksi', 'catatan', 'kelompok_id', 'submitted_at', 'status_beasiswa'];

    protected $casts = ['submitted_at' => 'datetime'];

    public const LABEL = [
        'draft' => 'Draft',
        'diajukan' => 'Menunggu verifikasi',
        'perlu_revisi' => 'Perlu revisi berkas',
        'terverifikasi' => 'Terverifikasi',
        'ditolak' => 'Ditolak',
        'lulus' => 'Lulus',
        'tidak_lulus' => 'Tidak lulus',
    ];

    public static function label(string $status): string
    {
        return self::LABEL[$status] ?? $status;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokPembinaan::class, 'kelompok_id');
    }

    public function monitoring()
    {
        return $this->hasMany(MonitoringPembinaan::class, 'pendaftaran_id');
    }

    public function evaluasi()
    {
        return $this->hasMany(EvaluasiBeasiswa::class, 'pendaftaran_id');
    }

    public function ktm()
    {
        return $this->hasOne(KtmDigital::class);
    }

    /** Hasil seleksi baru tampil ke mahasiswa setelah pengumuman dipublikasikan. */
    public function diumumkan(): bool
    {
        return Pengumuman::where('beasiswa_id', $this->beasiswa_id)
            ->where('tgl_publish', '<=', now())->exists();
    }

    public function getStatusPublikAttribute(): string
    {
        if (in_array($this->status, ['lulus', 'tidak_lulus']) && ! $this->diumumkan()) {
            return 'terverifikasi';
        }
        return $this->status;
    }
}

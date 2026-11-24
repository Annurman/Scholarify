<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = ['pendaftaran_id', 'jenis_berkas', 'file_path', 'status_verifikasi', 'catatan'];

    public const JENIS = [
        'ktp' => 'Fotokopi KTP',
        'khs' => 'Kartu Hasil Studi (KHS)',
        'surat_aktif' => 'Surat Keterangan Aktif Kuliah',
        'surat_rekomendasi' => 'Surat Rekomendasi',
        'motivasi' => 'Surat Motivasi',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getNamaJenisAttribute(): string
    {
        return self::JENIS[$this->jenis_berkas] ?? $this->jenis_berkas;
    }
}

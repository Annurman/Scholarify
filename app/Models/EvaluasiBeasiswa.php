<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiBeasiswa extends Model
{
    protected $table = 'evaluasi_beasiswa';
    protected $fillable = ['pendaftaran_id', 'mentor_id', 'rekomendasi', 'alasan', 'keputusan_admin', 'diputuskan_oleh', 'catatan_admin', 'diputuskan_pada'];
    protected $casts = ['diputuskan_pada' => 'datetime'];

    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id'); }
    public function mentor() { return $this->belongsTo(User::class, 'mentor_id'); }
    public function adminPemutus() { return $this->belongsTo(User::class, 'diputuskan_oleh'); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringPembinaan extends Model
{
    protected $table = 'monitoring_pembinaan';
    protected $fillable = ['kegiatan_id', 'pendaftaran_id', 'mentor_id', 'kehadiran', 'keaktifan', 'catatan'];

    public function kegiatan() { return $this->belongsTo(KegiatanPembinaan::class, 'kegiatan_id'); }
    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id'); }
    public function mentor() { return $this->belongsTo(User::class, 'mentor_id'); }
}

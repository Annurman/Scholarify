<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanPembinaan extends Model
{
    protected $table = 'kegiatan_pembinaan';
    protected $fillable = ['kelompok_id', 'judul', 'tanggal', 'catatan'];
    protected $casts = ['tanggal' => 'date'];

    public function kelompok() { return $this->belongsTo(KelompokPembinaan::class, 'kelompok_id'); }
    public function monitoring() { return $this->hasMany(MonitoringPembinaan::class, 'kegiatan_id'); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokPembinaan extends Model
{
    protected $table = 'kelompok_pembinaan';

    protected $fillable = ['beasiswa_id', 'nama_kelompok', 'pembina', 'mentor_id', 'jadwal', 'kuota'];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function kegiatan()
    {
        return $this->hasMany(KegiatanPembinaan::class, 'kelompok_id');
    }

    public function anggota()
    {
        return $this->hasMany(Pendaftaran::class, 'kelompok_id');
    }
}

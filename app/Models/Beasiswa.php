<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $table = 'beasiswa';

    protected $fillable = ['nama', 'deskripsi', 'persyaratan', 'kuota', 'tgl_buka', 'tgl_tutup', 'status'];

    protected $casts = ['tgl_buka' => 'date', 'tgl_tutup' => 'date'];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function kelompok()
    {
        return $this->hasMany(KelompokPembinaan::class);
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'dibuka'
            && $this->tgl_buka && $this->tgl_tutup
            && today()->between($this->tgl_buka, $this->tgl_tutup);
    }

    public function scopeTerbuka($query)
    {
        return $query->where('status', 'dibuka')
            ->whereDate('tgl_buka', '<=', today())
            ->whereDate('tgl_tutup', '>=', today());
    }
}

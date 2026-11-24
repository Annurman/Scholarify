<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = ['beasiswa_id', 'judul', 'isi', 'tgl_publish'];

    protected $casts = ['tgl_publish' => 'datetime'];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    public function scopeTerbit($query)
    {
        return $query->where('tgl_publish', '<=', now());
    }
}

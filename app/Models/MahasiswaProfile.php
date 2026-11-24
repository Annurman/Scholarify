<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MahasiswaProfile extends Model
{
    protected $fillable = [
        'user_id', 'nim', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'fakultas', 'prodi', 'semester', 'ipk', 'no_hp', 'alamat', 'foto',
    ];

    protected $casts = ['tanggal_lahir' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? Storage::disk('public')->url($this->foto) : null;
    }
}

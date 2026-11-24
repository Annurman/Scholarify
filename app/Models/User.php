<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function profile()
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function kelompokBinaan()
    {
        return $this->hasMany(KelompokPembinaan::class, 'mentor_id');
    }

    public function monitoringSebagaiMentor()
    {
        return $this->hasMany(MonitoringPembinaan::class, 'mentor_id');
    }

    public function evaluasiSebagaiMentor()
    {
        return $this->hasMany(EvaluasiBeasiswa::class, 'mentor_id');
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'mentor' => 'mentor.monitoring.index',
            default => 'mahasiswa.dashboard',
        };
    }

    public function roleLabel(): string
    {
        return [
            'admin' => 'Penyelenggara Beasiswa',
            'mentor' => 'Mentor',
            'mahasiswa' => 'Mahasiswa',
        ][$this->role] ?? $this->role;
    }
}

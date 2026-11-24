<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KtmDigital extends Model
{
    protected $table = 'ktm_digital';

    protected $fillable = ['pendaftaran_id', 'nomor_ktm', 'berlaku_sampai', 'status'];

    protected $casts = ['berlaku_sampai' => 'date'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}


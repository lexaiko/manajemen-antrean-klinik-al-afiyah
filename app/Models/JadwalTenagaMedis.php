<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTenagaMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenaga_medis_id', 'hari', 'jam_mulai', 'jam_selesai'
    ];

    public function tenagaMedis()
    {
        return $this->belongsTo(TenagaMedis::class);
    }
}

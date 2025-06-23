<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik_pasien',
        'tanggal_kunjungan',
        'nomor_antrian',
        'nama_pasien',
        'alamat_pasien',
        'jenis_kelamin',
        'tanggal_lahir',
        'status',
        'pembayaran',
        'nomor_whatsapp',
        'keluhan',
        'poli_id'
    ];

    public function polis()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }


}

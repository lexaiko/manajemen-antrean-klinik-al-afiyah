<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable = [
        'registered_by', 'tenaga_medis_id', 'tanggal_kunjungan',
        'nomor_antrian', 'nama_pasien', 'nik_pasien', 'alamat_pasien',
        'jenis_kelamin', 'tanggal_lahir', 'status', 'pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function tenagaMedis()
    {
        return $this->belongsTo(TenagaMedis::class);
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class);
    }
}

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
        'keluhan'
    ];
    public function pegawais()
    {
        return $this->belongsTo(User::class, 'pegawais_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }
}

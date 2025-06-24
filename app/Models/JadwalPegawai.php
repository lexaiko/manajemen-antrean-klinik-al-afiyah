<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPegawai extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pegawais';

    protected $fillable = [
        'pegawai_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $appends = ['difference'];

    public function getJamMulaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getJamSelesaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    // Hapus relasi role karena tidak lagi dipakai
    // public function role() { ... }
}

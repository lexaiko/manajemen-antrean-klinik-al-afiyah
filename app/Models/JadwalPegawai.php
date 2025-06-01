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
        'role_id',
        'hari',
        'jam_mulai',
        'jam_selesai'
    ];

    protected $appends = ['difference'];

    const WEEK_DAYS = [
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
        'Minggu' => 'Minggu',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->jam_selesai)->diffInMinutes($this->jam_mulai);
    }

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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function isJadwalAvailable($hari, $jamMulai, $jamSelesai, $tenagaMedisId)
    {
        return !self::where('hari', $hari)
            ->where('pegawai_id', $tenagaMedisId)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                    ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('jam_mulai', '<', $jamMulai)
                            ->where('jam_selesai', '>', $jamSelesai);
                    });
            })
            ->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Antrian extends Model
{
    use HasFactory;
    public $incrementing = false; // ⛔ Karena UUID bukan auto-increment
    protected $keyType = 'string'; // ✅ UUID adalah string

    protected $fillable = [
        'nik_pasien',
        'tanggal_kunjungan',
        'nomor_antrian',
        'nama_pasien',        
        'jenis_kelamin',        
        'status',
        'pembayaran',
        'nomor_whatsapp',
        'keluhan',
        'poli_id'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function polis()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }


}

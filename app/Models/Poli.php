<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_poli',
    ];

    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'poli_id');
    }
}

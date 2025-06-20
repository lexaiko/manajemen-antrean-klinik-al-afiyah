<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'judul', 'konten', 'gambar'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

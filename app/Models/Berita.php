<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;


    protected $table = 'beritas';
    protected $primaryKey = "id";
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'tgl_published',
        'nama_published',
        'gambar'
    ];
}

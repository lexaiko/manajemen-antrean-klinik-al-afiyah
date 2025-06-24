<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'nomor_telepon',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Jadwal Pegawai
    public function pegawais()
    {
        return $this->hasMany(JadwalPegawai::class, 'pegawai_id');
    }

    // HAPUS relasi ke Role lama
    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    // Relasi ke Antrian
    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'registered_by');
    }

    // Relasi ke Artikel
    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'admin_id');
    }
}

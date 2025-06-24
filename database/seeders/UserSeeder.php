<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 DB::table('users')->insert([
            [
                'name' => 'Eko Bagus Susanto',
                'email' => 'kaguyachi@outlook.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // ganti dengan password aman
                'remember_token' => Str::random(10),
                'jenis_kelamin' => 'L', // atau 'P'
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Farhan',
                'email' => 'farhan@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // ganti dengan password aman
                'remember_token' => Str::random(10),
                'jenis_kelamin' => 'L', // atau 'P'
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ilham',
                'email' => 'ilham@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // ganti dengan password aman
                'remember_token' => Str::random(10),
                'jenis_kelamin' => 'L', // atau 'P'
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Zila',
                'email' => 'zila@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // ganti dengan password aman
                'remember_token' => Str::random(10),
                'jenis_kelamin' => 'P', // atau 'L'
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

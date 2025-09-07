<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = [
            'admin klinik',
            'dokter umum',
            'dokter gigi',
            'perawat',
            'bidan'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        // Users + role
        $users = [
            [
                'name' => 'Eko Bagus Susanto',
                'email' => 'kaguyachi@outlook.com',
                'jenis_kelamin' => 'L',
                'role' => 'admin klinik',
            ],
            [
                'name' => 'Farhan',
                'email' => 'farhan@gmail.com',
                'jenis_kelamin' => 'L',
                'role' => 'dokter umum',
            ],
            [
                'name' => 'Ilham',
                'email' => 'ilham@gmail.com',
                'jenis_kelamin' => 'L',
                'role' => 'dokter gigi',
            ],
            [
                'name' => 'Zila',
                'email' => 'zila@gmail.com',
                'jenis_kelamin' => 'P',
                'role' => 'bidan',
            ],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']], // biar ga duplikat
                [
                    'name' => $u['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('admin123'),
                    'remember_token' => Str::random(10),
                    'jenis_kelamin' => $u['jenis_kelamin'],
                ]
            );

            $user->assignRole($u['role']);
        }
    }
}

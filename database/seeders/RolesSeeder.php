<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin klinik',
        'guard_name' => 'web']);
        Role::create(['name' => 'dokter umum',
        'guard_name' => 'web']);
        Role::create(['name' => 'dokter gigi',
        'guard_name' => 'web']);
        Role::create(['name' => 'perawat',
        'guard_name' => 'web']);
        Role::create(['name' => 'bidan',
        'guard_name' => 'web']);
    }
}

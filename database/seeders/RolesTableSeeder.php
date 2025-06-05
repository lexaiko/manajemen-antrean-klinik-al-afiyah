<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nama_role' => 'admin',
            ],
            [
                'nama_role' => 'perawat',
            ],
            [
                'nama_role' => 'bidan',
            ],
            [
                'nama_role' => 'dokter umum',
            ],
            [
                'nama_role' => 'dokter gigi',
            ],
            
        ]);
    }
}

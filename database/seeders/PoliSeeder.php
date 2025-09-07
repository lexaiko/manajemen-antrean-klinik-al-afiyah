<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poli::create(['nama_poli' => 'Poli Umum']);
        Poli::create(['nama_poli' => 'Poli Gigi']);
        Poli::create(['nama_poli' => 'Poli KIA']);
    }
}


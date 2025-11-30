<?php

namespace Database\Factories;

use App\Models\JadwalPegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalPegawaiFactory extends Factory
{
    protected $model = JadwalPegawai::class;

    public function definition(): array
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return [
            'pegawai_id' => User::factory()->create(['jenis_kelamin' => 'L']),
            'hari' => fake()->randomElement($hari),
            'jam_mulai' => fake()->time('H:i:s', '12:00:00'),
            'jam_selesai' => fake()->time('H:i:s', '17:00:00'),
        ];
    }

    /**
     * State untuk jadwal pagi.
     */
    public function pagi(): static
    {
        return $this->state(fn (array $attributes) => [
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '12:00:00',
        ]);
    }

    /**
     * State untuk jadwal siang.
     */
    public function siang(): static
    {
        return $this->state(fn (array $attributes) => [
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '17:00:00',
        ]);
    }

    /**
     * State untuk hari tertentu.
     */
    public function hari(string $hari): static
    {
        return $this->state(fn (array $attributes) => [
            'hari' => $hari,
        ]);
    }
}

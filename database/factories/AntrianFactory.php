<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Antrian;
use App\Models\Poli;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrian>
 */
class AntrianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Antrian::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik_pasien' => $this->faker->numerify('################'), // 16 digit NIK
            'nama_pasien' => $this->faker->name(),
            'tanggal_kunjungan' => $this->faker->dateTimeBetween('today', '+1 week')->format('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'status' => $this->faker->randomElement(['antri', 'dilayani', 'selesai', 'ditangguhkan']),
            'pembayaran' => $this->faker->randomElement(['umum', 'bpjs', 'mwcnu']),
            'nomor_whatsapp' => $this->faker->numerify('08##########'),
            'keluhan' => $this->faker->sentence(6),
            'nomor_antrian' => $this->faker->regexify('[A-Z]{2,3}[0-9]{3}'),
            'poli_id' => Poli::factory(),
        ];
    }

    /**
     * Indicate that the antrian is for today
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the antrian is waiting (antri)
     */
    public function waiting(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'antri',
        ]);
    }

    /**
     * Indicate that the antrian is being served (dilayani)
     */
    public function beingServed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dilayani',
        ]);
    }

    /**
     * Indicate that the antrian is completed (selesai)
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}

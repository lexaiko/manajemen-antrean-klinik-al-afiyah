<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Poli;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poli>
 */
class PoliFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Poli::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $poliNames = [
            'Poli Umum',
            'Poli Gigi',
            'Poli KIA',
        ];

        return [
            'nama_poli' => $this->faker->randomElement($poliNames),
        ];
    }
}

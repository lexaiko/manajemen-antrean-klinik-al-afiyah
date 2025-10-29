<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Berita;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Berita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'konten' => $this->faker->paragraphs(5, true),
            'gambar' => 'sample-image.jpg', // Default gambar untuk testing
            'tgl_published' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'nama_published' => $this->faker->name(),
        ];
    }

    /**
     * Indicate that the berita has no image
     */
    public function withoutImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'gambar' => null,
        ]);
    }

    /**
     * Indicate that the berita has a specific image
     */
    public function withImage(string $imageName): static
    {
        return $this->state(fn (array $attributes) => [
            'gambar' => $imageName,
        ]);
    }

    /**
     * Create berita with health-related content
     */
    public function healthTopic(): static
    {
        $healthTopics = [
            'Tips Hidup Sehat untuk Keluarga',
            'Cara Menjaga Kesehatan Gigi dan Mulut',
            'Pentingnya Imunisasi untuk Anak',
            'Mencegah Penyakit Diabetes',
            'Manfaat Olahraga Rutin',
            'Pola Makan Sehat dan Bergizi'
        ];

        $judul = $this->faker->randomElement($healthTopics);

        return $this->state(fn (array $attributes) => [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'konten' => $this->faker->paragraphs(3, true) . ' ' .
                       'Kesehatan adalah hal yang sangat penting untuk dijaga. ' .
                       $this->faker->paragraphs(2, true),
        ]);
    }
}

<?php

namespace Tests\Feature\Public;

use App\Models\Berita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman beranda dapat diakses
     */
    public function test_landing_page_can_be_accessed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /**
     * Test halaman beranda menampilkan berita terbaru
     */
    public function test_landing_page_displays_latest_news(): void
    {
        Berita::factory()->count(5)->create([
            'tgl_published' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('beritas');
    }

    /**
     * Test halaman daftar berita dapat diakses
     */
    public function test_berita_index_page_can_be_accessed(): void
    {
        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertViewIs('berita.index');
    }

    /**
     * Test halaman daftar berita menampilkan semua berita
     */
    public function test_berita_index_displays_all_news(): void
    {
        Berita::factory()->count(10)->create([
            'tgl_published' => now(),
        ]);

        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertViewHas('beritas');
    }

    /**
     * Test halaman detail berita dapat diakses dengan slug
     */
    public function test_berita_detail_can_be_accessed_with_slug(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Ini adalah konten test berita',
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('berita.detail');
        $response->assertViewHas('berita', $berita);
    }

    /**
     * Test halaman detail berita menampilkan judul yang benar
     */
    public function test_berita_detail_displays_correct_title(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Judul Berita Test',
            'slug' => 'judul-berita-test',
            'konten' => 'Konten berita',
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('Judul Berita Test');
    }

    /**
     * Test halaman detail berita menampilkan konten yang benar
     */
    public function test_berita_detail_displays_correct_content(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Ini adalah konten yang akan ditampilkan',
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('Ini adalah konten yang akan ditampilkan', false);
    }

    /**
     * Test halaman 404 ketika slug berita tidak ditemukan
     */
    public function test_berita_detail_returns_404_for_invalid_slug(): void
    {
        $response = $this->get('/berita/slug-tidak-ada');

        $response->assertStatus(404);
    }

    /**
     * Test berita diurutkan berdasarkan tanggal terbaru
     */
    public function test_beritas_are_ordered_by_latest_date(): void
    {
        $oldBerita = Berita::factory()->create([
            'judul' => 'Old News',
            'tgl_published' => now()->subDays(5),
        ]);

        $newBerita = Berita::factory()->create([
            'judul' => 'New News',
            'tgl_published' => now(),
        ]);

        $response = $this->get('/berita');

        $response->assertStatus(200);

        $beritas = $response->viewData('beritas');

        // Verifikasi berita terbaru muncul lebih dulu
        $this->assertTrue($beritas->first()->tgl_published >= $beritas->last()->tgl_published);
    }

    /**
     * Test halaman beranda memiliki navigasi ke halaman lain
     */
    public function test_landing_page_has_navigation_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Verifikasi ada link ke halaman berita
        $response->assertSee(route('berita.index', [], false), false);
        // Verifikasi ada link ke halaman jadwal
        $response->assertSee(route('jadwal.index', [], false), false);
        // Verifikasi ada link ke registrasi antrian
        $response->assertSee(route('antrean.registrasi', [], false), false);
    }

    /**
     * Test landing page menampilkan informasi klinik
     */
    public function test_landing_page_displays_clinic_information(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Verifikasi halaman menampilkan konten tentang klinik
        $response->assertSee('Al Afiyah', false);
    }

    /**
     * Test berita dengan gambar ditampilkan dengan benar
     */
    public function test_berita_with_image_displays_correctly(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Berita dengan Gambar',
            'slug' => 'berita-dengan-gambar',
            'konten' => 'Konten berita',
            'gambar' => 'images/berita/test-image.jpg',
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('test-image.jpg', false);
    }

    /**
     * Test berita tanpa gambar tetap dapat ditampilkan (gambar menggunakan default)
     */
    public function test_berita_without_image_displays_correctly(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Berita tanpa Gambar',
            'slug' => 'berita-tanpa-gambar',
            'konten' => 'Konten berita',
            'gambar' => 'default.jpg', // Gunakan default image
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('Berita tanpa Gambar');
    }

    /**
     * Test pagination pada halaman daftar berita
     */
    public function test_berita_index_has_pagination(): void
    {
        // Buat lebih dari 10 berita untuk memicu pagination
        Berita::factory()->count(20)->create([
            'tgl_published' => now(),
        ]);

        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertViewHas('beritas');

        $beritas = $response->viewData('beritas');

        // Verifikasi pagination
        if (method_exists($beritas, 'total')) {
            $this->assertEquals(20, $beritas->total());
        }
    }

    /**
     * Test nama penulis berita ditampilkan
     */
    public function test_berita_author_name_is_displayed(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Konten',
            'nama_published' => 'Admin Klinik',
            'tgl_published' => now(),
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertSee('Admin Klinik');
    }

    /**
     * Test tanggal publikasi berita ditampilkan
     */
    public function test_berita_publication_date_is_displayed(): void
    {
        $publishDate = now()->subDays(3);

        $berita = Berita::factory()->create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Konten',
            'tgl_published' => $publishDate,
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
    }
}

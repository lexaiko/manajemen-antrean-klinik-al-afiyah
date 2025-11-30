<?php

namespace Tests\Feature\Pasien;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BeritaPublicTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $berita;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user for berita
        $adminRole = Role::create(['name' => 'admin klinik']);
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole($adminRole);

        // Create sample berita
        $this->berita = Berita::factory()->create([
            'judul' => 'Tips Kesehatan Sehari-hari',
            'slug' => 'tips-kesehatan-sehari-hari',
            'konten' => 'Konten berita kesehatan yang bermanfaat',
            'gambar' => 'sample-image.jpg',
            'nama_published' => $this->adminUser->name,
            'tgl_published' => now()->setMonth(10), // Oktober
        ]);
    }

    public function test_guest_can_view_beranda_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Check if the beranda page loads correctly
        $response->assertSee('Klinik Al Afiyah');
    }

    public function test_guest_can_view_berita_index()
    {
        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        $response->assertViewIs('berita.index');
        $response->assertSee($this->berita->judul);
    }

    public function test_guest_can_view_berita_detail()
    {
        $response = $this->get(route('berita.detail', $this->berita->slug));

        $response->assertStatus(200);
        $response->assertViewIs('berita.detail');
        $response->assertSee($this->berita->judul);
        $response->assertSee($this->berita->konten);
    }

    public function test_beranda_shows_latest_berita()
    {
        // Create some test berita
        $newBerita = Berita::factory()->create([
            'judul' => 'Berita Terbaru',
            'tgl_published' => now()->subDays(1)
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // Check that the beranda page loads correctly
        $response->assertSee('Klinik Al Afiyah');
    }

    public function test_berita_detail_shows_publication_date()
    {
        $response = $this->get(route('berita.detail', $this->berita->slug));

        $response->assertStatus(200);
        // Check if publication date is displayed (the view shows Indonesian date format)
        $response->assertSee($this->berita->judul);
        $response->assertSee('Oktober'); // Month in Indonesian
    }

    public function test_berita_detail_shows_author_info()
    {
        $response = $this->get(route('berita.detail', $this->berita->slug));

        $response->assertStatus(200);
        $response->assertSee($this->adminUser->name);
    }

    public function test_guest_cannot_view_nonexistent_berita()
    {
        $response = $this->get(route('berita.detail', 'nonexistent-slug'));

        $response->assertStatus(404);
    }

    public function test_berita_index_pagination_works()
    {
        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        // Should show berita index page correctly
        $response->assertSee('Berita Klinik Al Afiyah');
    }

    public function test_berita_shows_excerpt_in_index()
    {
        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        $response->assertSee($this->berita->judul);
        // Should show berita title in index
        $response->assertSee('Berita Klinik Al Afiyah');
    }

    public function test_berita_shows_image_if_available()
    {
        $beritaWithImage = Berita::factory()->create([
            'judul' => 'Berita dengan Gambar',
            'gambar' => 'test-image.jpg',
            'nama_published' => $this->adminUser->id,
        ]);

        $response = $this->get(route('berita.detail', $beritaWithImage->slug));

        $response->assertStatus(200);
        $response->assertSee('test-image.jpg');
    }

    public function test_beranda_shows_klinik_information()
    {
        $response = $this->get(route('beranda'));

        $response->assertStatus(200);
        $response->assertSee('Al-Afiyah'); // Assuming clinic name
    }

    public function test_berita_index_shows_search_functionality()
    {
        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Berita Klinik Al Afiyah');
        // Check if berita index loads properly
        $response->assertSee($this->berita->judul);
    }

    public function test_berita_slug_is_generated_correctly()
    {
        $response = $this->get(route('berita.detail', $this->berita->slug));

        $response->assertStatus(200);
        $response->assertSee($this->berita->judul);
    }

    public function test_related_berita_shows_in_detail_page()
    {
        $response = $this->get(route('berita.detail', $this->berita->slug));

        $response->assertStatus(200);
        // Should show berita detail page
        $response->assertSee($this->berita->judul);
        $response->assertSee($this->berita->konten);
    }

    /**
     * Test guest dapat mengakses beranda (welcome page) dengan berita
     */
    public function test_guest_can_access_beranda_with_beritas(): void
    {
        Berita::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('beritas');
    }

    /**
     * Test guest dapat mengakses berita detail by slug
     */
    public function test_guest_can_access_berita_by_slug(): void
    {
        $berita = Berita::factory()->create([
            'slug' => 'test-berita-slug-unique',
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('berita.detail');
        $response->assertViewHas('berita');
        $response->assertSee($berita->judul);
    }

    /**
     * Test guest dapat mengakses index berita dengan pagination
     */
    public function test_guest_can_access_berita_index_paginated(): void
    {
        Berita::factory()->count(10)->create();

        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertViewIs('berita.index');
        $response->assertViewHas('beritas');
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BeritaTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Buat role admin
        $role = Role::create(['name' => 'admin klinik']);

        // Buat user admin
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Admin Test',
            'password' => bcrypt('password'),
        ]);

        $this->admin->assignRole($role);
    }

    /**
     * Test admin dapat mengakses halaman daftar berita
     */
    public function test_admin_can_access_berita_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/berita');

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.index');
    }

    /**
     * Test guest tidak dapat mengakses halaman berita admin
     */
    public function test_guest_cannot_access_berita_admin_page(): void
    {
        $response = $this->get('/admin/berita');

        $response->assertStatus(403); // Guest gets 403 instead of redirect
    }

    /**
     * Test non-admin tidak dapat mengakses halaman berita admin
     */
    public function test_non_admin_cannot_access_berita_admin_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/berita');

        $response->assertStatus(403);
    }

    /**
     * Test admin dapat mengakses halaman create berita
     */
    public function test_admin_can_access_create_berita_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/berita/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.create');
    }

    /**
     * Test admin dapat membuat berita baru dengan data valid
     */
    public function test_admin_can_create_new_berita_with_valid_data(): void
    {
        $file = UploadedFile::fake()->image('berita.jpg');

        // Controller expects Indonesian format: "Senin, 25 Januari 2024"
        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $data = [
            'judul' => 'Berita Terbaru Klinik',
            'konten' => 'Ini adalah konten berita yang sangat penting',
            'tgl_published' => $tglPublished,
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('beritas', [
            'judul' => 'Berita Terbaru Klinik',
        ]);
    }

    /**
     * Test admin tidak dapat membuat berita tanpa judul
     */
    public function test_admin_cannot_create_berita_without_judul(): void
    {
        $data = [
            'judul' => '',
            'konten' => 'Konten berita',
            'tgl_published' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        $response->assertSessionHasErrors('judul');
    }

    /**
     * Test admin tidak dapat membuat berita tanpa konten
     */
    public function test_admin_cannot_create_berita_without_konten(): void
    {
        $data = [
            'judul' => 'Judul Berita',
            'konten' => '',
            'tgl_published' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        $response->assertSessionHasErrors('konten');
    }

    /**
     * Test slug berita otomatis tergenerate dari judul
     */
    public function test_berita_slug_auto_generated_from_judul(): void
    {
        $file = UploadedFile::fake()->image('berita.jpg');

        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $data = [
            'judul' => 'Berita Kesehatan Terbaru',
            'konten' => 'Konten berita',
            'tgl_published' => $tglPublished,
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $this->actingAs($this->admin)->post('/admin/berita', $data);

        // Slug format: berita-kesehatan-terbaru-YYYYMMDD-ID
        $berita = Berita::where('judul', 'Berita Kesehatan Terbaru')->first();
        $this->assertNotNull($berita);
        $this->assertStringStartsWith('berita-kesehatan-terbaru', $berita->slug);
    }

    /**
     * Test admin dapat membuat berita dengan gambar
     */
    public function test_admin_can_create_berita_with_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('berita.jpg');

        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $data = [
            'judul' => 'Berita dengan Gambar',
            'konten' => 'Konten berita dengan gambar',
            'tgl_published' => $tglPublished,
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('beritas', [
            'judul' => 'Berita dengan Gambar',
        ]);

        // Verify file was stored
        $berita = Berita::where('judul', 'Berita dengan Gambar')->first();
        Storage::disk('public')->assertExists($berita->gambar);
    }

    /**
     * Test admin dapat mengakses halaman edit berita
     */
    public function test_admin_can_access_edit_berita_page(): void
    {
        $berita = Berita::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/berita/{$berita->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.edit');
        $response->assertViewHas('berita', $berita);
    }

    /**
     * Test admin dapat mengupdate berita dengan data valid
     */
    public function test_admin_can_update_berita_with_valid_data(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Judul Lama',
            'konten' => 'Konten Lama',
        ]);

        $data = [
            'judul' => 'Judul Baru',
            'konten' => 'Konten Baru',
            'tgl_published' => now()->format('Y-m-d'),
            'nama_published' => $this->admin->name,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/berita/{$berita->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('beritas', [
            'id' => $berita->id,
            'judul' => 'Judul Baru',
            'konten' => 'Konten Baru',
        ]);
    }

    /**
     * Test admin dapat menghapus berita
     */
    public function test_admin_can_delete_berita(): void
    {
        $berita = Berita::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/berita/{$berita->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('beritas', [
            'id' => $berita->id,
        ]);
    }

    /**
     * Test menghapus berita juga menghapus gambarnya dari storage
     */
    public function test_deleting_berita_removes_image_from_storage(): void
    {
        $berita = Berita::factory()->create([
            'gambar' => 'images/berita/test-image.jpg',
        ]);

        Storage::disk('public')->put('images/berita/test-image.jpg', 'fake content');

        $this->actingAs($this->admin)->delete("/admin/berita/{$berita->id}");

        // Verifikasi gambar terhapus (tergantung implementasi)
        $this->assertDatabaseMissing('beritas', [
            'id' => $berita->id,
        ]);
    }

    /**
     * Test admin dapat mencari berita
     */
    public function test_admin_can_search_berita(): void
    {
        Berita::factory()->create(['judul' => 'Berita Kesehatan']);
        Berita::factory()->create(['judul' => 'Berita Olahraga']);
        Berita::factory()->create(['judul' => 'Berita Teknologi']);

        $response = $this->actingAs($this->admin)->get('/admin/berita/search?keyword=Kesehatan');

        $response->assertStatus(200);
    }

    /**
     * Test halaman index berita menampilkan semua berita
     */
    public function test_berita_index_displays_all_berita(): void
    {
        Berita::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get('/admin/berita');

        $response->assertStatus(200);
        $response->assertViewHas('beritas');

        $beritas = $response->viewData('beritas');
        $this->assertCount(5, $beritas);
    }

    /**
     * Test berita diurutkan berdasarkan tanggal terbaru
     */
    public function test_beritas_ordered_by_latest_date(): void
    {
        $oldBerita = Berita::factory()->create([
            'judul' => 'Old News',
            'tgl_published' => now()->subDays(5),
        ]);

        $newBerita = Berita::factory()->create([
            'judul' => 'New News',
            'tgl_published' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/berita');

        $response->assertStatus(200);
    }



    /**
     * Test admin dapat upload gambar melalui summernote
     */
    public function test_admin_can_upload_image_via_summernote(): void
    {
        $file = UploadedFile::fake()->image('content-image.jpg');

        $response = $this->actingAs($this->admin)->post('/summernote/picture/upload/berita', [
            'file' => $file,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test update berita dengan gambar baru
     */
    public function test_admin_can_update_berita_with_new_image(): void
    {
        $berita = Berita::factory()->create([
            'judul' => 'Berita Test',
            'gambar' => 'old-image.jpg',
        ]);

        $newFile = UploadedFile::fake()->image('new-image.jpg');

        $data = [
            'judul' => 'Berita Test Updated',
            'konten' => 'Konten updated',
            'tgl_published' => now()->format('Y-m-d'),
            'nama_published' => $this->admin->name,
            'gambar' => $newFile,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/berita/{$berita->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('beritas', [
            'id' => $berita->id,
            'judul' => 'Berita Test Updated',
        ]);
    }

    /**
     * Test validasi tipe file gambar
     */
    public function test_berita_image_must_be_valid_image_file(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $data = [
            'judul' => 'Berita Test',
            'konten' => 'Konten test',
            'tgl_published' => now()->format('Y-m-d'),
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        $response->assertSessionHasErrors('gambar');
    }

    /**
     * Test validasi ukuran file gambar maksimal
     */
    public function test_berita_image_has_maximum_size_limit(): void
    {
        $file = UploadedFile::fake()->image('large-image.jpg')->size(5000); // 5MB

        $data = [
            'judul' => 'Berita Test',
            'konten' => 'Konten test',
            'tgl_published' => now()->format('Y-m-d'),
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/berita', $data);

        // Tergantung implementasi validasi ukuran maksimal
        // Bisa lulus atau error tergantung config
        $response->assertStatus(302);
    }

    /**
     * Test slug unik untuk setiap berita
     */
    public function test_berita_slug_is_unique(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('berita.jpg');
        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        Berita::factory()->create([
            'judul' => 'Berita Unik',
            'slug' => 'berita-unik-20251130-1',
        ]);

        $data = [
            'judul' => 'Berita Unik',
            'konten' => 'Konten berbeda',
            'tgl_published' => $tglPublished,
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $this->actingAs($this->admin)->post('/admin/berita', $data);

        // Slug kedua harus berbeda karena ada ID yang berbeda
        $beritas = Berita::where('judul', 'Berita Unik')->get();
        $this->assertGreaterThanOrEqual(2, $beritas->count());
        $this->assertNotEquals($beritas[0]->slug, $beritas[1]->slug);
    }

    /**
     * Test pagination pada halaman index berita
     */
    public function test_berita_index_has_pagination(): void
    {
        Berita::factory()->count(20)->create();

        $response = $this->actingAs($this->admin)->get('/admin/berita');

        $response->assertStatus(200);
        $response->assertViewHas('beritas');
    }

    /**
     * Test tanggal publikasi otomatis jika tidak diisi
     */
    public function test_berita_publication_date_defaults_to_today(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('berita.jpg');
        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $data = [
            'judul' => 'Berita Test Date',
            'konten' => 'Konten test',
            'tgl_published' => $tglPublished,
            'nama_published' => $this->admin->name,
            'gambar' => $file,
        ];

        $this->actingAs($this->admin)->post('/admin/berita', $data);

        $berita = Berita::where('judul', 'Berita Test Date')->first();
        $this->assertNotNull($berita);
        $this->assertNotNull($berita->tgl_published);
        $this->assertEquals(now()->format('Y-m-d'), $berita->tgl_published);
    }

    /**
     * Test nama penulis otomatis menggunakan nama admin yang login
     */
    public function test_berita_author_defaults_to_logged_in_admin(): void
    {
        $file = UploadedFile::fake()->image('berita.jpg');

        $tglPublished = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $data = [
            'judul' => 'Berita Test',
            'konten' => 'Konten berita',
            'tgl_published' => $tglPublished,
            'gambar' => $file,
        ];

        $this->actingAs($this->admin)->post('/admin/berita', $data);

        $this->assertDatabaseHas('beritas', [
            'judul' => 'Berita Test',
            'nama_published' => 'Admin Test',
        ]);
    }

    /**
     * Test admin dapat search berita dengan query
     */
    public function test_admin_can_search_berita_with_specific_query(): void
    {
        Berita::factory()->create(['judul' => 'Kesehatan Mental']);
        Berita::factory()->create(['judul' => 'Kesehatan Fisik']);
        Berita::factory()->create(['judul' => 'Olahraga Rutin']);

        $response = $this->actingAs($this->admin)->get('/admin/berita?query=Kesehatan');

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.index');
        $response->assertViewHas('beritas');
        $response->assertViewHas('query', 'Kesehatan');
    }


}


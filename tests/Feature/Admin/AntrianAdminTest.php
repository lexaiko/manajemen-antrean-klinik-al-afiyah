<?php

namespace Tests\Feature\Admin;

use App\Models\Antrian;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AntrianAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role admin
        $role = Role::create(['name' => 'admin klinik']);

        // Buat user admin
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->admin->assignRole($role);
    }

    /**
     * Test admin dapat mengakses halaman daftar antrian
     */
    public function test_admin_can_access_antrian_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/antrean');

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.index');
    }

    /**
     * Test non-admin tidak dapat mengakses halaman daftar antrian
     */
    public function test_non_admin_cannot_access_antrian_index_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/antrean');

        $response->assertStatus(403);
    }

    /**
     * Test guest tidak dapat mengakses halaman antrian admin
     */
    public function test_guest_cannot_access_antrian_admin_page(): void
    {
        $response = $this->get('/admin/antrean');

        $response->assertStatus(403); // Guest gets 403 instead of redirect
    }

    /**
     * Test admin dapat mengakses halaman create antrian
     */
    public function test_admin_can_access_create_antrian_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/antrean/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.create');
    }

    /**
     * Test admin dapat membuat antrian baru dengan data valid
     */
    public function test_admin_can_create_new_antrian_with_valid_data(): void
    {
        $poli = Poli::factory()->create(['nama_poli' => 'Poli Umum']);

        $data = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'jenis_kelamin' => 'L',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Demam dan batuk',
            'polis_id' => $poli->id,
            'pembayaran' => 'bpjs',
            'status' => 'antri',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/antrean', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'poli_id' => $poli->id,
        ]);
    }

    /**
     * Test admin tidak dapat membuat antrian tanpa NIK
     */
    public function test_admin_cannot_create_antrian_without_nik(): void
    {
        $poli = Poli::factory()->create();

        $data = [
            'nik_pasien' => '',
            'nama_pasien' => 'John Doe',
            'jenis_kelamin' => 'L',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Demam',
            'poli_id' => $poli->id,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/antrean', $data);

        $response->assertSessionHasErrors('nik_pasien');
    }

    /**
     * Test admin dapat mengakses halaman edit antrian
     */
    public function test_admin_can_access_edit_antrian_page(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/antrean/{$antrian->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.edit');
        $response->assertViewHas('antrians'); // Controller uses plural 'antrians'
    }

    /**
     * Test admin dapat mengupdate antrian dengan data valid
     */
    public function test_admin_can_update_antrian_with_valid_data(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
            'nama_pasien' => 'Old Name',
        ]);

        $data = [
            'nik_pasien' => $antrian->nik_pasien,
            'nama_pasien' => 'Updated Name',
            'jenis_kelamin' => 'P',
            'alamat_pasien' => 'Updated Address',
            'tanggal_lahir' => '1990-01-01',
            'nomor_whatsapp' => '089876543210',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Updated keluhan',
            'polis_id' => $poli->id,
            'pembayaran' => 'umum',
            'status' => 'selesai',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/antrean/{$antrian->id}/edit", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'nama_pasien' => 'Updated Name',
            'jenis_kelamin' => 'P',
        ]);
    }

    /**
     * Test admin dapat menghapus antrian
     */
    public function test_admin_can_delete_antrian(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/antrean/{$antrian->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('antrians', [
            'id' => $antrian->id,
        ]);
    }

    /**
     * Test admin dapat mengakses halaman detail antrian
     */
    public function test_admin_can_access_antrian_detail_page(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/antrean/detail/{$antrian->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.show');
    }

    /**
     * Test admin dapat mengakses halaman riwayat antrian
     */
    public function test_admin_can_access_riwayat_antrian_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/antrean/riwayat');

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.riwayat');
    }

    /**
     * Test admin dapat mengakses halaman kontrol antrian
     */
    public function test_admin_can_access_control_antrian_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/antrean/control');

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.control.index');
    }

    /**
     * Test admin dapat memanggil antrian berikutnya
     */
    public function test_admin_can_call_next_antrian(): void
    {
        $poli = Poli::factory()->create();

        Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'antri',
            'nomor_antrian' => 1,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/antrean/control/next/{$poli->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'poli_id' => $poli->id,
            'status' => 'dilayani',
        ]);
    }

    /**
     * Test admin dapat melewati antrian (skip)
     */
    public function test_admin_can_skip_antrian(): void
    {
        $poli = Poli::factory()->create();

        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'dilayani',
            'nomor_antrian' => 1,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/antrean/control/{$poli->id}/skip");

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'status' => 'skip',
        ]);
    }

    /**
     * Test admin dapat mengembalikan antrian yang dilewati
     */
    public function test_admin_can_restore_skipped_antrian(): void
    {
        $poli = Poli::factory()->create();

        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'skip',
            'nomor_antrian' => 1,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/antrean/control/restore/{$antrian->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'status' => 'antri',
        ]);
    }

    /**
     * Test admin dapat menangguhkan antrian
     */
    public function test_admin_can_suspend_antrian(): void
    {
        $poli = Poli::factory()->create();

        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'skip',
            'nomor_antrian' => 1,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/antrean/control/tangguhkan/{$antrian->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'status' => 'ditangguhkan',
        ]);
    }

    /**
     * Test admin dapat mengakses halaman monitoring
     */
    public function test_admin_can_access_monitoring_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/monitoring');

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.monitoring');
    }

    /**
     * Test admin dapat mengakses data monitoring
     */
    public function test_admin_can_access_monitoring_data(): void
    {
        $poli = Poli::factory()->create();

        Antrian::factory()->count(3)->create([
            'poli_id' => $poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/antrean/monitoring/data');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'polis' => [
                '*' => [
                    'id',
                    'nama_poli',
                    'antrians',
                ]
            ]
        ]);
    }

    /**
     * Test admin dapat mengakses halaman show antrian detail
     */
    public function test_admin_can_access_antrian_show_detail(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create(['poli_id' => $poli->id]);

        $response = $this->actingAs($this->admin)->get("/admin/antrean/detail/{$antrian->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.antrean.show');
        $response->assertViewHas('antrean');
    }
}



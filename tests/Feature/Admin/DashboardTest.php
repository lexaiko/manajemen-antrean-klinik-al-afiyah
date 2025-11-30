<?php

namespace Tests\Feature\Admin;

use App\Models\Antrian;
use App\Models\Berita;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $dokter;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role
        $adminRole = Role::create(['name' => 'admin klinik']);
        $dokterRole = Role::create(['name' => 'dokter umum']);

        // Buat user admin
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Admin Test',
            'jenis_kelamin' => 'L',
        ]);
        $this->admin->assignRole($adminRole);

        // Buat user dokter
        $this->dokter = User::factory()->create([
            'email' => 'dokter@test.com',
            'name' => 'Dr. Test',
            'jenis_kelamin' => 'L',
        ]);
        $this->dokter->assignRole($dokterRole);
    }

    /**
     * Test admin dapat mengakses dashboard
     */
    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test dokter dapat mengakses dashboard
     */
    public function test_dokter_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->dokter)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test guest tidak dapat mengakses dashboard (akan redirect atau 403)
     */
    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        // Bisa jadi 403 (Forbidden) atau redirect to login
        $this->assertContains($response->status(), [403, 302]);
    }

    /**
     * Test dashboard menampilkan variabel yang diperlukan
     */
    public function test_dashboard_has_required_variables(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalUser');
        $response->assertViewHas('totalBerita');
        $response->assertViewHas('totalAntrian');
        $response->assertViewHas('totalAntrianHariIni');
    }

    /**
     * Test dashboard menampilkan jumlah total antrian hari ini
     */
    public function test_dashboard_displays_total_antrian_today(): void
    {
        $poli = Poli::factory()->create();

        // Buat antrian hari ini
        Antrian::factory()->count(5)->create([
            'poli_id' => $poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        // Buat antrian kemarin (tidak dihitung)
        Antrian::factory()->count(3)->create([
            'poli_id' => $poli->id,
            'tanggal_kunjungan' => now()->subDay()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalAntrianHariIni');

        $totalToday = $response->viewData('totalAntrianHariIni');
        $this->assertEquals(5, $totalToday);
    }

    /**
     * Test dashboard menampilkan total user
     */
    public function test_dashboard_displays_total_user(): void
    {
        // Sudah ada 2 user dari setUp (admin dan dokter)
        User::factory()->count(5)->create([
            'jenis_kelamin' => 'L',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalUser');

        $totalUser = $response->viewData('totalUser');
        $this->assertEquals(7, $totalUser); // 2 dari setUp + 5 baru
    }

    /**
     * Test dashboard menampilkan total berita
     */
    public function test_dashboard_displays_total_berita(): void
    {
        Berita::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalBerita');

        $totalBerita = $response->viewData('totalBerita');
        $this->assertEquals(3, $totalBerita);
    }

    /**
     * Test dashboard menampilkan total antrian keseluruhan
     */
    public function test_dashboard_displays_total_antrian(): void
    {
        $poli = Poli::factory()->create();

        Antrian::factory()->count(10)->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalAntrian');

        $totalAntrian = $response->viewData('totalAntrian');
        $this->assertEquals(10, $totalAntrian);
    }

    /**
     * Test dashboard dengan data kosong tidak error
     */
    public function test_dashboard_works_with_no_data(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalUser');
        $response->assertViewHas('totalBerita');
        $response->assertViewHas('totalAntrian');
        $response->assertViewHas('totalAntrianHariIni');
    }
}

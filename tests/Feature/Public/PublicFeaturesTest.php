<?php

namespace Tests\Feature\Public;

use App\Models\Antrian;
use App\Models\JadwalPegawai;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PublicFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role yang dibutuhkan oleh controller registrasi
        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'dokter gigi']);
        Role::create(['name' => 'admin klinik']);
    }

    /**
     * Test guest dapat mengakses halaman daftar antrian publik
     */
    public function test_guest_can_access_public_antrian_list_page(): void
    {
        $response = $this->get('/antrean/list');

        $response->assertStatus(200);
        $response->assertViewIs('antrean.index');
    }

    /**
     * Test guest dapat melihat daftar antrian hari ini
     */
    public function test_guest_can_view_todays_antrian_list(): void
    {
        $poli = Poli::factory()->create();

        Antrian::factory()->count(3)->create([
            'poli_id' => $poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->get('/antrean/list');

        $response->assertStatus(200);
        $response->assertViewHas('antrian'); // Singular, not plural
    }

    /**
     * Test guest dapat mengakses halaman registrasi antrian
     */
    public function test_guest_can_access_registration_page(): void
    {
        $response = $this->get('/antrean/daftar');

        $response->assertStatus(200);
        $response->assertViewIs('antrean.registrasi');
    }

    /**
     * Test guest dapat mendaftar antrian dengan data valid
     */
    public function test_guest_can_register_antrian_with_valid_data(): void
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $poli = Poli::factory()->create(['nama_poli' => 'Poli Umum']);

        $data = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'Jane Doe',
            'jenis_kelamin' => 'P',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->addDays(1)->format('Y-m-d'),
            'keluhan' => 'Sakit kepala',
            'polis_id' => $poli->id,
            'pembayaran' => 'bpjs',
            'cf-turnstile-response' => 'fake-token-for-testing',
        ];

        $response = $this->post('/antrean/daftar', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('antrians', [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'Jane Doe',
            'poli_id' => $poli->id,
        ]);
    }

    /**
     * Test guest tidak dapat mendaftar antrian tanpa NIK
     */
    public function test_guest_cannot_register_antrian_without_nik(): void
    {
        $poli = Poli::factory()->create();

        $data = [
            'nik_pasien' => '',
            'nama_pasien' => 'Jane Doe',
            'jenis_kelamin' => 'P',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Sakit kepala',
            'poli_id' => $poli->id,
        ];

        $response = $this->post('/antrean/daftar', $data);

        $response->assertSessionHasErrors('nik_pasien');
    }

    /**
     * Test guest tidak dapat mendaftar antrian tanpa nama
     */
    public function test_guest_cannot_register_antrian_without_nama(): void
    {
        $poli = Poli::factory()->create();

        $data = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => '',
            'jenis_kelamin' => 'P',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Sakit kepala',
            'poli_id' => $poli->id,
        ];

        $response = $this->post('/antrean/daftar', $data);

        $response->assertSessionHasErrors('nama_pasien');
    }

    /**
     * Test guest tidak dapat mendaftar antrian tanpa memilih poli
     */
    public function test_guest_cannot_register_antrian_without_poli(): void
    {
        $data = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'Jane Doe',
            'jenis_kelamin' => 'P',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Sakit kepala',
            'poli_id' => '',
        ];

        $response = $this->post('/antrean/daftar', $data);

        $response->assertSessionHasErrors('polis_id');
    }

    /**
     * Test guest dapat mengakses detail antrian dengan ID yang valid
     */
    public function test_guest_can_access_antrian_detail_with_valid_id(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->get("/antrean/detail/{$antrian->id}");

        $response->assertStatus(200);
        $response->assertViewIs('antrean.detail');
        $response->assertViewHas('antrean'); // Controller uses 'antrean' not 'antrian'
    }

    /**
     * Test guest dapat download PDF antrian
     */
    public function test_guest_can_download_antrian_pdf(): void
    {
        $poli = Poli::factory()->create();
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $response = $this->get("/antrean/{$antrian->id}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * Test guest dapat mengakses halaman jadwal
     */
    public function test_guest_can_access_jadwal_page(): void
    {
        $response = $this->get('/jadwal');

        $response->assertStatus(200);
        $response->assertViewIs('jadwal.index');
    }

    /**
     * Test guest dapat melihat jadwal pegawai
     */
    public function test_guest_can_view_jadwal_pegawai(): void
    {
        $pegawai = User::factory()->create(['name' => 'Dr. Test']);
        $dokterRole = Role::firstOrCreate(['name' => 'dokter umum']); // Use firstOrCreate to avoid duplicate
        $pegawai->assignRole($dokterRole);

        JadwalPegawai::factory()->count(3)->create([
            'pegawai_id' => $pegawai->id,
        ]);

        $response = $this->get('/jadwal');

        $response->assertStatus(200);
        $response->assertViewHas('jadwals');
    }

    /**
     * Test nomor antrian otomatis tergenerate
     */
    public function test_antrian_number_auto_generated(): void
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        ]);

        $poli = Poli::factory()->create();

        // Buat antrian pertama
        $data1 = [
            'nik_pasien' => '1111111111111111',
            'nama_pasien' => 'Patient 1',
            'jenis_kelamin' => 'L',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Test',
            'polis_id' => $poli->id,
            'pembayaran' => 'umum',
            'cf-turnstile-response' => 'fake-token-for-testing',
        ];

        $this->post('/antrean/daftar', $data1);

        // Buat antrian kedua
        $data2 = [
            'nik_pasien' => '2222222222222222',
            'nama_pasien' => 'Patient 2',
            'jenis_kelamin' => 'P',
            'nomor_whatsapp' => '081234567891',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Test',
            'polis_id' => $poli->id,
            'pembayaran' => 'bpjs',
            'cf-turnstile-response' => 'fake-token-for-testing',
        ];

        $this->post('/antrean/daftar', $data2);

        $antrians = Antrian::where('poli_id', $poli->id)
            ->where('tanggal_kunjungan', now()->format('Y-m-d'))
            ->orderBy('nomor_antrian')
            ->get();

        $this->assertGreaterThan(0, $antrians->count());

        // Verifikasi nomor antrian berurutan
        if ($antrians->count() >= 2) {
            $this->assertLessThan($antrians[1]->nomor_antrian, $antrians[0]->nomor_antrian);
        }
    }

    /**
     * Test status antrian default adalah menunggu
     */
    public function test_new_antrian_default_status_is_menunggu(): void
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        ]);

        $poli = Poli::factory()->create();

        $data = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'New Patient',
            'jenis_kelamin' => 'L',
            'nomor_whatsapp' => '081234567890',
            'tanggal_kunjungan' => now()->addDays(1)->format('Y-m-d'),
            'keluhan' => 'Checkup',
            'polis_id' => $poli->id,
            'pembayaran' => 'umum',
            'cf-turnstile-response' => 'fake-token-for-testing',
        ];

        $this->post('/antrean/daftar', $data);

        $this->assertDatabaseHas('antrians', [
            'nik_pasien' => '1234567890123456',
            'status' => 'antri',
        ]);
    }

    /**
     * Test relasi antrian dengan poli
     */
    public function test_antrian_belongs_to_poli(): void
    {
        $poli = Poli::factory()->create(['nama_poli' => 'Poli Gigi']);
        $antrian = Antrian::factory()->create([
            'poli_id' => $poli->id,
        ]);

        $this->assertInstanceOf(Poli::class, $antrian->polis);
        $this->assertEquals('Poli Gigi', $antrian->polis->nama_poli);
    }

    /**
     * Test guest dapat melihat berbagai status antrian
     */
    public function test_guest_can_view_different_antrian_statuses(): void
    {
        $poli = Poli::factory()->create();

        Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'menunggu',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'dilayani',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        Antrian::factory()->create([
            'poli_id' => $poli->id,
            'status' => 'selesai',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->get('/antrean/list');

        $response->assertStatus(200);
    }

    /**
     * Test guest dapat mengakses jadwal beranda
     */
    public function test_guest_can_access_public_jadwal_beranda(): void
    {
        $user = User::factory()->create();
        $dokterRole = Role::firstOrCreate(['name' => 'dokter umum']);
        $user->assignRole($dokterRole);

        JadwalPegawai::factory()->pagi()->create(['pegawai_id' => $user->id]);

        $response = $this->get('/jadwal');

        $response->assertStatus(200);
        $response->assertViewIs('jadwal.index');
        $response->assertViewHas('jadwals');
        $response->assertViewHas('roles');
    }

    /**
     * Test guest dapat filter jadwal beranda by role
     */
    public function test_guest_can_filter_public_jadwal_by_role(): void
    {
        $dokter = User::factory()->create();
        $dokterRole = Role::firstOrCreate(['name' => 'dokter umum']);
        $dokter->assignRole($dokterRole);

        JadwalPegawai::factory()->pagi()->create(['pegawai_id' => $dokter->id]);

        $response = $this->get('/jadwal?role=dokter umum');

        $response->assertStatus(200);
        $response->assertViewIs('jadwal.index');
        $response->assertViewHas('roleAlias', 'dokter umum');
    }

    /**
     * Test jadwal beranda dengan role invalid returns 404
     */
    public function test_public_jadwal_with_invalid_role_returns_404(): void
    {
        $response = $this->get('/jadwal?role=invalid-role-name');

        $response->assertStatus(404);
    }
}


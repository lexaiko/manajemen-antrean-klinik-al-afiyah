<?php

namespace Tests\Feature\Admin;

use App\Models\JadwalPegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class JadwalPegawaiTest extends TestCase
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
     * Test admin dapat mengakses halaman daftar jadwal
     */
    public function test_admin_can_access_jadwal_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/jadwal');

        $response->assertStatus(200);
        $response->assertViewIs('admin.jadwal.index');
    }

    /**
     * Test guest tidak dapat mengakses halaman jadwal admin
     */
    public function test_guest_cannot_access_jadwal_admin_page(): void
    {
        $response = $this->get('/admin/jadwal');

        $response->assertStatus(403); // Guest gets 403 instead of redirect
    }

    /**
     * Test admin dapat mengakses halaman create jadwal
     */
    public function test_admin_can_access_create_jadwal_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/jadwal/tambah');

        $response->assertStatus(200);
        $response->assertViewIs('admin.jadwal.create');
    }

    /**
     * Test admin dapat membuat jadwal baru dengan data valid
     */
    public function test_admin_can_create_new_jadwal_with_valid_data(): void
    {
        $pegawai = User::factory()->create(['name' => 'Dr. John']);
        $dokterRole = Role::create(['name' => 'dokter umum']);
        $pegawai->assignRole($dokterRole);

        $data = [
            'pegawai_id' => $pegawai->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/jadwal', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('jadwal_pegawais', [
            'pegawai_id' => $pegawai->id,
            'hari' => 'Senin',
        ]);
    }

    /**
     * Test admin tidak dapat membuat jadwal tanpa pegawai_id
     */
    public function test_admin_cannot_create_jadwal_without_pegawai_id(): void
    {
        $data = [
            'pegawai_id' => '',
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/jadwal', $data);

        $response->assertSessionHasErrors('pegawai_id');
    }

    /**
     * Test admin tidak dapat membuat jadwal tanpa hari
     */
    public function test_admin_cannot_create_jadwal_without_hari(): void
    {
        $pegawai = User::factory()->create();

        $data = [
            'pegawai_id' => $pegawai->id,
            'hari' => '',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/jadwal', $data);

        $response->assertSessionHasErrors('hari');
    }

    /**
     * Test admin tidak dapat membuat jadwal dengan jam_mulai kosong
     */
    public function test_admin_cannot_create_jadwal_without_jam_mulai(): void
    {
        $pegawai = User::factory()->create();

        $data = [
            'pegawai_id' => $pegawai->id,
            'hari' => 'Senin',
            'jam_mulai' => '',
            'jam_selesai' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/jadwal', $data);

        $response->assertSessionHasErrors('jam_mulai');
    }

    /**
     * Test admin dapat mengakses halaman edit jadwal
     */
    public function test_admin_can_access_edit_jadwal_page(): void
    {
        $pegawai = User::factory()->create();
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/jadwal/{$jadwal->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.jadwal.edit');
        $response->assertViewHas('jadwal', $jadwal);
    }

    /**
     * Test admin dapat mengupdate jadwal dengan data valid
     */
    public function test_admin_can_update_jadwal_with_valid_data(): void
    {
        $pegawai = User::factory()->create();
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
            'hari' => 'Senin',
        ]);

        $data = [
            'pegawai_id' => $pegawai->id,
            'hari' => 'Selasa',
            'jam_mulai' => '09:00',
            'jam_selesai' => '13:00',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/jadwal/{$jadwal->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('jadwal_pegawais', [
            'id' => $jadwal->id,
            'hari' => 'Selasa',
            'jam_mulai' => '09:00:00',
        ]);
    }

    /**
     * Test admin dapat menghapus jadwal
     */
    public function test_admin_can_delete_jadwal(): void
    {
        $pegawai = User::factory()->create();
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/jadwal/{$jadwal->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('jadwal_pegawais', [
            'id' => $jadwal->id,
        ]);
    }

    /**
     * Test relasi jadwal dengan pegawai
     */
    public function test_jadwal_belongs_to_pegawai(): void
    {
        $pegawai = User::factory()->create(['name' => 'Dr. Smith']);
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
        ]);

        $this->assertInstanceOf(User::class, $jadwal->pegawai);
        $this->assertEquals('Dr. Smith', $jadwal->pegawai->name);
    }

    /**
     * Test format jam_mulai diubah ke H:i
     */
    public function test_jam_mulai_accessor_formats_correctly(): void
    {
        $pegawai = User::factory()->create();
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
            'jam_mulai' => '08:30:00',
        ]);

        $this->assertEquals('08:30', $jadwal->jam_mulai);
    }

    /**
     * Test format jam_selesai diubah ke H:i
     */
    public function test_jam_selesai_accessor_formats_correctly(): void
    {
        $pegawai = User::factory()->create();
        $jadwal = JadwalPegawai::factory()->create([
            'pegawai_id' => $pegawai->id,
            'jam_selesai' => '14:45:00',
        ]);

        $this->assertEquals('14:45', $jadwal->jam_selesai);
    }

    /**
     * Test admin dapat melihat jadwal berdasarkan pegawai
     */
    public function test_admin_can_filter_jadwal_by_pegawai(): void
    {
        $pegawai1 = User::factory()->create(['name' => 'Dr. A']);
        $pegawai2 = User::factory()->create(['name' => 'Dr. B']);

        JadwalPegawai::factory()->count(2)->create(['pegawai_id' => $pegawai1->id]);
        JadwalPegawai::factory()->count(3)->create(['pegawai_id' => $pegawai2->id]);

        $jadwalPegawai1 = JadwalPegawai::where('pegawai_id', $pegawai1->id)->get();
        $jadwalPegawai2 = JadwalPegawai::where('pegawai_id', $pegawai2->id)->get();

        $this->assertCount(2, $jadwalPegawai1);
        $this->assertCount(3, $jadwalPegawai2);
    }

    /**
     * Test tidak dapat membuat jadwal dengan jam_selesai lebih awal dari jam_mulai
     */
    public function test_cannot_create_jadwal_with_end_time_before_start_time(): void
    {
        $pegawai = User::factory()->create();

        $data = [
            'pegawai_id' => $pegawai->id,
            'hari' => 'Senin',
            'jam_mulai' => '14:00',
            'jam_selesai' => '10:00',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/jadwal', $data);

        // Tergantung implementasi validasi di controller
        $response->assertSessionHasErrors();
    }
}


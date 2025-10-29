<?php

namespace Tests\Feature\Pasien;

use App\Models\Antrian;
use App\Models\Poli;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AntrianRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $poli;

    protected function setUp(): void
    {
        parent::setUp();

        // Create required roles
        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'dokter gigi']);

        // Create a poli for testing
        $this->poli = Poli::factory()->create(['nama_poli' => 'Poli Umum']);
    }

    public function test_guest_can_view_registration_page()
    {
        $response = $this->get(route('antrean.registrasi'));

        $response->assertStatus(200);
        $response->assertViewIs('antrean.registrasi');
        $response->assertViewHas('polis');
        $response->assertViewHas('users');
        $response->assertViewHas('antrians');
    }

    public function test_guest_can_register_for_antrian_successfully()
    {
        // Mock Cloudflare Turnstile response
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $registrationData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala dan demam',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $registrationData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('antrians', [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'status' => 'antri',
            'poli_id' => $this->poli->id,
        ]);
    }

    public function test_guest_cannot_register_with_invalid_nik()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $invalidData = [
            'nik_pasien' => '123456', // Too short
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $invalidData);

        $response->assertSessionHasErrors(['nik_pasien']);
    }

    public function test_guest_cannot_register_with_past_date()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $invalidData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->subDay()->format('Y-m-d'), // Yesterday
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $invalidData);

        $response->assertSessionHasErrors(['tanggal_kunjungan']);
    }

    public function test_guest_cannot_register_with_date_more_than_one_week()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $invalidData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDays(8)->format('Y-m-d'), // More than 1 week
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $invalidData);

        $response->assertSessionHasErrors(['tanggal_kunjungan']);
    }

    public function test_guest_cannot_register_without_captcha()
    {
        $registrationData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            // No cf-turnstile-response
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $registrationData);

        $response->assertSessionHasErrors(['cf-turnstile-response']);
    }

    public function test_guest_cannot_register_with_failed_captcha()
    {
        // Mock failed Cloudflare Turnstile response
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => false
            ])
        ]);

        $registrationData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $registrationData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['turnstile']);
    }

    public function test_guest_cannot_register_with_invalid_phone_number()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $invalidData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '123', // Too short
            'keluhan' => 'Sakit kepala',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $invalidData);

        $response->assertSessionHasErrors(['nomor_whatsapp']);
    }

    public function test_guest_cannot_register_with_nonexistent_poli()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $invalidData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit kepala',
            'polis_id' => 99999, // Non-existent poli
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $invalidData);

        $response->assertSessionHasErrors(['polis_id']);
    }

    public function test_antrian_number_is_generated_correctly()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        // Create a poli with specific name to test initial generation
        $poliGigi = Poli::factory()->create(['nama_poli' => 'Poli Gigi']);

        $registrationData = [
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081234567890',
            'keluhan' => 'Sakit gigi',
            'polis_id' => $poliGigi->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ];

        $response = $this->post(route('antrean.storeRegistrasi'), $registrationData);

        $antrian = Antrian::where('nik_pasien', '1234567890123456')->first();

        // Should generate PG001 (Poli Gigi -> PG, first patient -> 001)
        $this->assertStringStartsWith('PG', $antrian->nomor_antrian);
        $this->assertStringEndsWith('001', $antrian->nomor_antrian);
    }

    public function test_multiple_registrations_increment_antrian_number()
    {
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true
            ])
        ]);

        $today = now()->format('Y-m-d');

        // First registration
        $this->post(route('antrean.storeRegistrasi'), [
            'nik_pasien' => '1111111111111111',
            'nama_pasien' => 'Patient One',
            'tanggal_kunjungan' => $today,
            'jenis_kelamin' => 'L',
            'pembayaran' => 'umum',
            'nomor_whatsapp' => '081111111111',
            'keluhan' => 'Test 1',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ]);

        // Second registration
        $this->post(route('antrean.storeRegistrasi'), [
            'nik_pasien' => '2222222222222222',
            'nama_pasien' => 'Patient Two',
            'tanggal_kunjungan' => $today,
            'jenis_kelamin' => 'P',
            'pembayaran' => 'bpjs',
            'nomor_whatsapp' => '082222222222',
            'keluhan' => 'Test 2',
            'polis_id' => $this->poli->id,
            'cf-turnstile-response' => 'fake-turnstile-response',
        ]);

        $firstAntrian = Antrian::where('nik_pasien', '1111111111111111')->first();
        $secondAntrian = Antrian::where('nik_pasien', '2222222222222222')->first();

        // Should have PU001 and PU002 (Poli Umum -> PU)
        $this->assertStringEndsWith('001', $firstAntrian->nomor_antrian);
        $this->assertStringEndsWith('002', $secondAntrian->nomor_antrian);
    }
}

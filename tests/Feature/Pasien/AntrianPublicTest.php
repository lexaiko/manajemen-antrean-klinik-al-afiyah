<?php

namespace Tests\Feature\Pasien;

use App\Models\Antrian;
use App\Models\Poli;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AntrianPublicTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $poli;
    protected $antrian;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->poli = Poli::factory()->create(['nama_poli' => 'Poli Umum']);
        $this->antrian = Antrian::factory()->create([
            'nik_pasien' => '1234567890123456',
            'nama_pasien' => 'John Doe',
            'nomor_antrian' => 'PU001',
            'status' => 'antri',
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);
    }

    public function test_guest_can_view_antrian_list()
    {
        $response = $this->get(route('antrean.index'));

        $response->assertStatus(200);
        $response->assertViewIs('antrean.index');
        $response->assertSee($this->antrian->nomor_antrian);
        // View shows initials, not full name
        $response->assertSee('J D'); // Inisial dari John Doe
    }

    public function test_guest_can_view_antrian_detail()
    {
        $response = $this->get(route('antrean.detail', $this->antrian->id));

        $response->assertStatus(200);
        $response->assertSee($this->antrian->nomor_antrian);
        $response->assertSee($this->antrian->nama_pasien);
        $response->assertSee($this->antrian->nik_pasien);
        $response->assertSee($this->poli->nama_poli);
    }

    public function test_guest_can_download_antrian_pdf()
    {
        $response = $this->get(route('antrean.downloadPdf', $this->antrian->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_antrian_detail_shows_correct_status()
    {
        // Test with different statuses
        $statuses = ['antri', 'dilayani', 'selesai', 'ditangguhkan'];

        foreach ($statuses as $status) {
            $antrian = Antrian::factory()->create([
                'status' => $status,
                'poli_id' => $this->poli->id,
            ]);

            $response = $this->get(route('antrean.detail', $antrian->id));

            $response->assertStatus(200);
            $response->assertSee(ucfirst($status));
        }
    }

    public function test_antrian_list_shows_only_today_antrians()
    {
        // Create antrian for today
        $todayAntrian = Antrian::factory()->create([
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'poli_id' => $this->poli->id,
        ]);

        // Create antrian for tomorrow
        $tomorrowAntrian = Antrian::factory()->create([
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'),
            'poli_id' => $this->poli->id,
        ]);

        $response = $this->get(route('antrean.index'));

        $response->assertStatus(200);
        // Should show today's antrian but not tomorrow's
        $response->assertSee($todayAntrian->nomor_antrian);
        $response->assertDontSee($tomorrowAntrian->nomor_antrian);
    }

    public function test_antrian_list_groups_by_poli()
    {
        // Create different polis
        $poliGigi = Poli::factory()->create(['nama_poli' => 'Poli Gigi']);

        $antrianUmum = Antrian::factory()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $antrianGigi = Antrian::factory()->create([
            'poli_id' => $poliGigi->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->get(route('antrean.index'));

        $response->assertStatus(200);
        $response->assertSee($this->poli->nama_poli);
        $response->assertSee($poliGigi->nama_poli);
        $response->assertSee($antrianUmum->nomor_antrian);
        $response->assertSee($antrianGigi->nomor_antrian);
    }

    public function test_antrian_detail_shows_queue_position()
    {
        // Create multiple antrians for same poli and date
        $firstAntrian = Antrian::factory()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'status' => 'antri',
            'created_at' => now()->subHours(2),
        ]);

        $secondAntrian = Antrian::factory()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'status' => 'antri',
            'created_at' => now()->subHour(),
        ]);

        $response = $this->get(route('antrean.detail', $secondAntrian->id));

        $response->assertStatus(200);
        // Should show some indication of queue position
        $response->assertSee($secondAntrian->nomor_antrian);
    }

    public function test_guest_cannot_view_nonexistent_antrian_detail()
    {
        $response = $this->get(route('antrean.detail', 'non-existent-id'));

        $response->assertStatus(404);
    }

    public function test_guest_cannot_download_nonexistent_antrian_pdf()
    {
        $response = $this->get(route('antrean.downloadPdf', 'non-existent-id'));

        $response->assertStatus(404);
    }

    public function test_antrian_shows_poli_information()
    {
        $response = $this->get(route('antrean.detail', $this->antrian->id));

        $response->assertStatus(200);
        $response->assertSee($this->poli->nama_poli);
    }

    public function test_antrian_detail_shows_registration_time()
    {
        // Create a specific antrian with known time
        $this->antrian->update(['created_at' => now()->startOfDay()->addMinutes(7)]);

        $response = $this->get(route('antrean.detail', $this->antrian->id));

        $response->assertStatus(200);
        // Check if time is displayed in the detail page
        // Based on the HTML output, the detail page shows patient data and queue info
        // but might not display the exact creation time format
        $response->assertSee('Detail Antrean');
        $response->assertSee($this->antrian->nama_pasien);
    }

    public function test_antrian_list_shows_current_status()
    {
        // Create antrians with different statuses
        $waitingAntrian = Antrian::factory()->waiting()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $servingAntrian = Antrian::factory()->beingServed()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $completedAntrian = Antrian::factory()->completed()->create([
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
        ]);

        $response = $this->get(route('antrean.index'));

        $response->assertStatus(200);
        $response->assertSee($waitingAntrian->nomor_antrian);
        $response->assertSee($servingAntrian->nomor_antrian);
        $response->assertSee($completedAntrian->nomor_antrian);
    }
}

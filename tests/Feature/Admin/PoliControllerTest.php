<?php

namespace Tests\Feature\Admin;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PoliControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role
        $this->adminRole = Role::create(['name' => 'admin klinik']);

        // Create admin user
        $this->adminUser = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);
        $this->adminUser->assignRole($this->adminRole);
    }

    public function test_admin_can_view_poli_index_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.poli'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.poli.index');
        $response->assertViewHas('polis');
    }

    public function test_admin_can_search_poli()
    {
        $this->actingAs($this->adminUser);

        Poli::factory()->create(['nama_poli' => 'Poli Umum']);
        Poli::factory()->create(['nama_poli' => 'Poli Gigi']);

        $response = $this->get(route('admin.poli', ['search' => 'Umum']));

        $response->assertStatus(200);
        $response->assertSee('Poli Umum');
        $response->assertDontSee('Poli Gigi');
    }

    public function test_admin_can_view_create_poli_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.poli.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.poli.create');
    }


    public function test_admin_can_create_new_poli()
    {
        $this->actingAs($this->adminUser);

        $poliData = [
            'nama_poli' => 'Poli Mata',
        ];

        $response = $this->post(route('admin.poli.store'), $poliData);

        $response->assertRedirect(route('admin.poli'));
        $response->assertSessionHas('success', 'Poli berhasil ditambahkan.');

        $this->assertDatabaseHas('polis', [
            'nama_poli' => 'Poli Mata',
        ]);
    }


    public function test_admin_cannot_create_poli_with_empty_name()
    {
        $this->actingAs($this->adminUser);

        $invalidData = [
            'nama_poli' => '',
        ];

        $response = $this->post(route('admin.poli.store'), $invalidData);

        $response->assertSessionHasErrors(['nama_poli']);
    }


    public function test_admin_can_view_edit_poli_page()
    {
        $this->actingAs($this->adminUser);

        $poli = Poli::factory()->create(['nama_poli' => 'Poli Test']);

        $response = $this->get(route('admin.poli.edit', $poli->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.poli.edit');
        $response->assertViewHas('poli', $poli);
    }


    public function test_admin_can_update_poli()
    {
        $this->actingAs($this->adminUser);

        $poli = Poli::factory()->create(['nama_poli' => 'Poli Lama']);

        $updateData = [
            'nama_poli' => 'Poli Baru',
        ];

        $response = $this->put(route('admin.poli.update', $poli->id), $updateData);

        $response->assertRedirect(route('admin.poli'));
        $response->assertSessionHas('success', 'Poli berhasil diperbarui.');

        $poli->refresh();
        $this->assertEquals('Poli Baru', $poli->nama_poli);
    }


    public function test_admin_cannot_update_poli_with_duplicate_name()
    {
        $this->actingAs($this->adminUser);

        Poli::factory()->create(['nama_poli' => 'Poli Existing']);
        $poli = Poli::factory()->create(['nama_poli' => 'Poli Test']);

        $updateData = [
            'nama_poli' => 'Poli Existing',
        ];

        $response = $this->put(route('admin.poli.update', $poli->id), $updateData);

        $response->assertSessionHasErrors(['nama_poli']);
    }


    public function test_admin_can_delete_poli()
    {
        $this->actingAs($this->adminUser);

        $poli = Poli::factory()->create(['nama_poli' => 'Poli To Delete']);

        $response = $this->delete(route('admin.poli.destroy', $poli->id));

        $response->assertRedirect(route('admin.poli'));
        $response->assertSessionHas('success', 'Poli berhasil dihapus.');

        $this->assertDatabaseMissing('polis', ['id' => $poli->id]);
    }


    public function test_non_admin_cannot_access_poli_management()
    {
        $doctorRole = Role::create(['name' => 'dokter umum']);
        $regularUser = User::factory()->create();
        $regularUser->assignRole($doctorRole);

        $this->actingAs($regularUser);

        // Test create access
        $response = $this->get(route('admin.poli.create'));
        $response->assertStatus(403);

        // Test store access
        $response = $this->post(route('admin.poli.store'), ['nama_poli' => 'Test']);
        $response->assertStatus(403);

        // Test delete access
        $poli = Poli::factory()->create();
        $response = $this->delete(route('admin.poli.destroy', $poli->id));
        $response->assertStatus(403);
    }


    public function test_poli_pagination_works_correctly()
    {
        $this->actingAs($this->adminUser);

        // Create 15 poli entries to test pagination (default is 10 per page)
        Poli::factory()->count(15)->create();

        $response = $this->get(route('admin.poli'));

        $response->assertStatus(200);
        $response->assertViewHas('polis');

        $polis = $response->viewData('polis');
        $this->assertCount(10, $polis->items()); // Should show 10 items per page
    }


    public function test_admin_can_view_poli_details_in_list()
    {
        $this->actingAs($this->adminUser);

        $poli = Poli::factory()->create(['nama_poli' => 'Poli Khusus Test']);

        $response = $this->get(route('admin.poli'));

        $response->assertStatus(200);
        $response->assertSee('Poli Khusus Test');
    }


    public function test_search_poli_with_empty_query_shows_all()
    {
        $this->actingAs($this->adminUser);

        Poli::factory()->create(['nama_poli' => 'Poli Umum']);
        Poli::factory()->create(['nama_poli' => 'Poli Gigi']);

        $response = $this->get(route('admin.poli', ['search' => '']));

        $response->assertStatus(200);
        $response->assertSee('Poli Umum');
        $response->assertSee('Poli Gigi');
    }
}

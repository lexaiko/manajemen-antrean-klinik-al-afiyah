<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
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

    public function test_admin_can_view_role_index_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.role.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.role.index');
        $response->assertViewHas('roles');
    }


    public function test_admin_can_search_roles()
    {
        $this->actingAs($this->adminUser);

        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'perawat']);

        $response = $this->get(route('admin.role.index', ['search' => 'dokter']));

        $response->assertStatus(200);
        $response->assertSee('dokter umum');
        $response->assertDontSee('perawat');
    }


    public function test_admin_can_view_create_role_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.role.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.role.create');
    }


    public function test_admin_can_create_new_role()
    {
        $this->actingAs($this->adminUser);

        $roleData = [
            'name' => 'dokter spesialis',
        ];

        $response = $this->post(route('admin.role.store'), $roleData);

        $response->assertRedirect(route('admin.role.index'));
        $response->assertSessionHas('success', 'Role berhasil ditambahkan.');

        $this->assertDatabaseHas('roles', [
            'name' => 'dokter spesialis',
        ]);
    }


    public function test_admin_cannot_create_role_with_empty_name()
    {
        $this->actingAs($this->adminUser);

        $invalidData = [
            'name' => '',
        ];

        $response = $this->post(route('admin.role.store'), $invalidData);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_admin_cannot_create_role_with_duplicate_name()
    {
        $this->actingAs($this->adminUser);

        Role::create(['name' => 'dokter gigi']);

        $duplicateData = [
            'name' => 'dokter gigi',
        ];

        $response = $this->post(route('admin.role.store'), $duplicateData);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_admin_can_view_edit_role_page()
    {
        $this->actingAs($this->adminUser);

        $role = Role::create(['name' => 'role test']);

        $response = $this->get(route('admin.role.edit', $role->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.role.edit');
        $response->assertViewHas('role', $role);
    }


    public function test_admin_can_update_role()
    {
        $this->actingAs($this->adminUser);

        $role = Role::create(['name' => 'role lama']);

        $updateData = [
            'name' => 'role baru',
        ];

        $response = $this->put(route('admin.role.update', $role->id), $updateData);

        $response->assertRedirect(route('admin.role.index'));
        $response->assertSessionHas('success', 'Role berhasil diperbarui.');

        $role->refresh();
        $this->assertEquals('role baru', $role->name);
    }


    public function test_admin_cannot_update_role_with_duplicate_name()
    {
        $this->actingAs($this->adminUser);

        Role::create(['name' => 'existing role']);
        $role = Role::create(['name' => 'test role']);

        $updateData = [
            'name' => 'existing role',
        ];

        $response = $this->put(route('admin.role.update', $role->id), $updateData);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_admin_can_update_role_with_same_name()
    {
        $this->actingAs($this->adminUser);

        $role = Role::create(['name' => 'same role']);

        $updateData = [
            'name' => 'same role', // Same name should be allowed
        ];

        $response = $this->put(route('admin.role.update', $role->id), $updateData);

        $response->assertRedirect(route('admin.role.index'));
        $response->assertSessionHas('success', 'Role berhasil diperbarui.');
    }


    public function test_admin_can_delete_role()
    {
        $this->actingAs($this->adminUser);

        $role = Role::create(['name' => 'role to delete']);

        $response = $this->delete(route('admin.role.destroy', $role->id));

        $response->assertRedirect(route('admin.role.index'));
        $response->assertSessionHas('success', 'Role berhasil dihapus.');

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }


    public function test_non_admin_cannot_access_role_management()
    {
        $doctorRole = Role::create(['name' => 'dokter umum']);
        $regularUser = User::factory()->create();
        $regularUser->assignRole($doctorRole);

        $this->actingAs($regularUser);

        // Test create access
        $response = $this->get(route('admin.role.create'));
        $response->assertStatus(403);

        // Test store access
        $response = $this->post(route('admin.role.store'), ['name' => 'Test Role']);
        $response->assertStatus(403);

        // Test delete access
        $role = Role::create(['name' => 'test role']);
        $response = $this->delete(route('admin.role.destroy', $role->id));
        $response->assertStatus(403);
    }


    public function test_role_pagination_works_correctly()
    {
        $this->actingAs($this->adminUser);

        // Create 10 roles to test pagination (default is 5 per page)
        for ($i = 1; $i <= 10; $i++) {
            Role::create(['name' => "role $i"]);
        }

        $response = $this->get(route('admin.role.index'));

        $response->assertStatus(200);
        $response->assertViewHas('roles');

        $roles = $response->viewData('roles');
        $this->assertCount(5, $roles->items()); // Should show 5 items per page (plus admin role = 6 total, but paginated)
    }


    public function test_admin_can_view_role_details_in_list()
    {
        $this->actingAs($this->adminUser);

        Role::create(['name' => 'role khusus test']);

        $response = $this->get(route('admin.role.index'));

        $response->assertStatus(200);
        $response->assertSee('role khusus test');
    }


    public function test_search_role_with_empty_query_shows_all()
    {
        $this->actingAs($this->adminUser);

        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'perawat']);

        $response = $this->get(route('admin.role.index', ['search' => '']));

        $response->assertStatus(200);
        $response->assertSee('dokter umum');
        $response->assertSee('perawat');
        $response->assertSee('admin klinik'); // Should also see the admin role
    }


    public function test_role_name_validation_enforces_max_length()
    {
        $this->actingAs($this->adminUser);

        $longRoleName = str_repeat('a', 256); // Longer than 255 characters

        $response = $this->post(route('admin.role.store'), [
            'name' => $longRoleName
        ]);

        $response->assertSessionHasErrors(['name']);
    }
}

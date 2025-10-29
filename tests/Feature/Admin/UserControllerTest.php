<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $doctorRole;
    protected $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        $this->adminRole = Role::create(['name' => 'admin klinik']);
        $this->doctorRole = Role::create(['name' => 'dokter umum']);

        // Create admin user
        $this->adminUser = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
        ]);
        $this->adminUser->assignRole($this->adminRole);
    }

    public function test_admin_can_view_user_index_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.user.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.index');
        $response->assertViewHas('users');
    }

    public function test_admin_can_search_users()
    {
        $this->actingAs($this->adminUser);

        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $response = $this->get(route('admin.user.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    public function test_admin_can_view_create_user_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.create');
        $response->assertViewHas('roles');
    }

    public function test_admin_can_create_new_user()
    {
        $this->actingAs($this->adminUser);

        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'jenis_kelamin' => 'L',
            'role' => $this->doctorRole->name,
        ];

        $response = $this->post(route('admin.user.store'), $userData);

        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('success', 'Pegawai berhasil ditambahkan.');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'jenis_kelamin' => 'L',
        ]);

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertTrue($user->hasRole($this->doctorRole->name));
    }

    public function test_admin_cannot_create_user_with_invalid_data()
    {
        $this->actingAs($this->adminUser);

        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
            'jenis_kelamin' => '',
            'role' => 'nonexistent-role',
        ];

        $response = $this->post(route('admin.user.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'jenis_kelamin', 'role']);
    }

    public function test_admin_can_view_edit_user_page()
    {
        $this->actingAs($this->adminUser);

        $user = User::factory()->create();

        $response = $this->get(route('admin.user.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user.edit');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('roles');
    }

    public function test_admin_can_update_user()
    {
        $this->actingAs($this->adminUser);

        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);
        $user->assignRole($this->doctorRole);

        $updateData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'jenis_kelamin' => 'P',
            'role' => $this->adminRole->name,
        ];

        $response = $this->put(route('admin.user.update', $user->id), $updateData);

        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('success', 'Pegawai berhasil diperbarui.');

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
        $this->assertEquals('P', $user->jenis_kelamin);
        $this->assertTrue($user->hasRole($this->adminRole->name));
        $this->assertFalse($user->hasRole($this->doctorRole->name));
    }

    public function test_admin_can_delete_user()
    {
        $this->actingAs($this->adminUser);

        $user = User::factory()->create();

        $response = $this->delete(route('admin.user.destroy', $user->id));

        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('success', 'Pegawai berhasil dihapus.');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $regularUser = User::factory()->create();
        $regularUser->assignRole($this->doctorRole);

        $this->actingAs($regularUser);

        // Test create access
        $response = $this->get(route('admin.user.create'));
        $response->assertStatus(403);

        // Test store access
        $response = $this->post(route('admin.user.store'), []);
        $response->assertStatus(403);

        // Test delete access
        $userToDelete = User::factory()->create();
        $response = $this->delete(route('admin.user.destroy', $userToDelete->id));
        $response->assertStatus(403);
    }

    public function test_admin_cannot_create_user_with_duplicate_email()
    {
        $this->actingAs($this->adminUser);

        User::factory()->create(['email' => 'duplicate@example.com']);

        $userData = [
            'name' => 'Test User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'jenis_kelamin' => 'L',
            'role' => $this->doctorRole->name,
        ];

        $response = $this->post(route('admin.user.store'), $userData);

        $response->assertSessionHasErrors(['email']);
    }
}

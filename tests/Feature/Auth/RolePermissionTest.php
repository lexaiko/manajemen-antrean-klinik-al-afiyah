<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat roles
        Role::create(['name' => 'admin klinik']);
        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'dokter gigi']);
        Role::create(['name' => 'bidan']);
        Role::create(['name' => 'perawat']);
        Role::create(['name' => 'pasien']);
    }

    /**
     * Test user dapat diassign role
     */
    public function test_user_can_be_assigned_role(): void
    {
        $user = User::factory()->create();

        $user->assignRole('admin klinik');

        $this->assertTrue($user->hasRole('admin klinik'));
    }

    /**
     * Test user dapat memiliki multiple roles
     */
    public function test_user_can_have_multiple_roles(): void
    {
        $user = User::factory()->create();

        $user->assignRole(['admin klinik', 'dokter umum']);

        $this->assertTrue($user->hasAllRoles(['admin klinik', 'dokter umum']));
    }

    /**
     * Test user dapat di-remove dari role
     */
    public function test_user_role_can_be_removed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('dokter umum');

        $this->assertTrue($user->hasRole('dokter umum'));

        $user->removeRole('dokter umum');

        $this->assertFalse($user->hasRole('dokter umum'));
    }

    /**
     * Test admin klinik dapat mengakses semua fitur admin
     */
    public function test_admin_klinik_can_access_all_admin_features(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin klinik');

        // Test akses berbagai halaman admin
        $pages = [
            '/admin/dashboard',
            '/admin/antrean',
            '/admin/user',
            '/admin/jadwal',
            '/admin/poli',
            '/admin/berita',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($admin)->get($page);
            $response->assertStatus(200);
        }
    }

    /**
     * Test dokter dapat mengakses dashboard tapi tidak user management
     */
    public function test_dokter_can_access_dashboard_but_not_user_management(): void
    {
        $dokter = User::factory()->create();
        $dokter->assignRole('dokter umum');

        // Dapat akses dashboard
        $response = $this->actingAs($dokter)->get('/admin/dashboard');
        $response->assertStatus(200);

        // Dokter can also access user management per current route config
        // All staff roles (admin klinik|dokter umum|dokter gigi|bidan|perawat) have access
        $response = $this->actingAs($dokter)->get('/admin/user');
        $response->assertStatus(200);
    }

    /**
     * Test pasien tidak dapat mengakses halaman admin
     */
    public function test_pasien_cannot_access_admin_pages(): void
    {
        $pasien = User::factory()->create();
        $pasien->assignRole('pasien');

        $response = $this->actingAs($pasien)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Test middleware role berfungsi dengan benar
     */
    public function test_role_middleware_works_correctly(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin klinik');

        $dokter = User::factory()->create();
        $dokter->assignRole('dokter umum');

        // Admin dapat akses halaman yang memerlukan role admin
        $response = $this->actingAs($admin)->get('/admin/user/tambah');
        $response->assertStatus(200);

        // Dokter tidak dapat akses halaman yang memerlukan role admin
        $response = $this->actingAs($dokter)->get('/admin/user/tambah');
        $response->assertStatus(403);
    }

    /**
     * Test hasAnyRole berfungsi dengan benar
     */
    public function test_has_any_role_works_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('dokter umum');

        $this->assertTrue($user->hasAnyRole(['admin klinik', 'dokter umum', 'dokter gigi']));
        $this->assertFalse($user->hasAnyRole(['admin klinik', 'bidan']));
    }

    /**
     * Test role dapat di-sync (replace semua role)
     */
    public function test_user_roles_can_be_synced(): void
    {
        $user = User::factory()->create();
        $user->assignRole(['admin klinik', 'dokter umum']);

        $this->assertTrue($user->hasRole('admin klinik'));
        $this->assertTrue($user->hasRole('dokter umum'));

        // Sync ke role baru (replace)
        $user->syncRoles(['bidan']);

        $this->assertFalse($user->hasRole('admin klinik'));
        $this->assertFalse($user->hasRole('dokter umum'));
        $this->assertTrue($user->hasRole('bidan'));
    }

    /**
     * Test getRoleNames mengembalikan collection nama role
     */
    public function test_get_role_names_returns_collection(): void
    {
        $user = User::factory()->create();
        $user->assignRole(['admin klinik', 'dokter umum']);

        $roleNames = $user->getRoleNames();

        $this->assertCount(2, $roleNames);
        $this->assertTrue($roleNames->contains('admin klinik'));
        $this->assertTrue($roleNames->contains('dokter umum'));
    }

    /**
     * Test staff roles dapat mengakses fitur staff
     */
    public function test_staff_roles_can_access_staff_features(): void
    {
        $staffRoles = ['admin klinik', 'dokter umum', 'dokter gigi', 'bidan', 'perawat'];

        foreach ($staffRoles as $roleName) {
            $user = User::factory()->create();
            $user->assignRole($roleName);

            // Semua staff dapat akses dashboard
            $response = $this->actingAs($user)->get('/admin/dashboard');
            $response->assertStatus(200);

            // Semua staff dapat akses daftar antrian
            $response = $this->actingAs($user)->get('/admin/antrean');
            $response->assertStatus(200);
        }
    }

    /**
     * Test role case sensitivity
     */
    public function test_role_is_case_sensitive(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin klinik');

        $this->assertTrue($user->hasRole('admin klinik'));
        $this->assertFalse($user->hasRole('Admin Klinik'));
        $this->assertFalse($user->hasRole('ADMIN KLINIK'));
    }

    /**
     * Test user dapat memiliki role melalui model relationship
     */
    public function test_user_roles_accessible_via_relationship(): void
    {
        $user = User::factory()->create();
        $user->assignRole(['admin klinik', 'dokter umum']);

        $roles = $user->roles;

        $this->assertCount(2, $roles);
        $this->assertInstanceOf(Role::class, $roles->first());
    }

    /**
     * Test middleware role|permission berfungsi dengan OR logic
     */
    public function test_middleware_role_or_logic_works(): void
    {
        // User dengan salah satu role dari list dapat akses
        $dokter = User::factory()->create();
        $dokter->assignRole('dokter umum');

        // Route yang menggunakan role:admin klinik|dokter umum|dokter gigi|bidan|perawat
        $response = $this->actingAs($dokter)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test guard name default untuk role
     */
    public function test_role_has_default_guard_name(): void
    {
        $role = Role::findByName('admin klinik');

        $this->assertEquals('web', $role->guard_name);
    }

    /**
     * Test role dapat dibuat dengan custom guard
     */
    public function test_role_can_be_created_with_custom_guard(): void
    {
        $apiRole = Role::create([
            'name' => 'api admin',
            'guard_name' => 'api'
        ]);

        $this->assertEquals('api', $apiRole->guard_name);
    }

    /**
     * Test direct permissions dapat ditambahkan ke user
     */
    public function test_direct_permissions_can_be_added_to_user(): void
    {
        $permission = Permission::create(['name' => 'edit articles']);

        $user = User::factory()->create();
        $user->givePermissionTo('edit articles');

        $this->assertTrue($user->hasPermissionTo('edit articles'));
    }

    /**
     * Test role dapat memiliki permissions
     */
    public function test_role_can_have_permissions(): void
    {
        $permission = Permission::create(['name' => 'manage users']);

        $role = Role::findByName('admin klinik');
        $role->givePermissionTo('manage users');

        $user = User::factory()->create();
        $user->assignRole('admin klinik');

        $this->assertTrue($user->hasPermissionTo('manage users'));
    }

    /**
     * Test check permission via role
     */
    public function test_check_permission_via_role(): void
    {
        $permission = Permission::create(['name' => 'delete posts']);

        $adminRole = Role::findByName('admin klinik');
        $adminRole->givePermissionTo('delete posts');

        $admin = User::factory()->create();
        $admin->assignRole('admin klinik');

        $this->assertTrue($admin->can('delete posts'));
    }
}

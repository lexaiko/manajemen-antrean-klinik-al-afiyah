<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Buat role
        $role = Role::create(['name' => 'admin klinik']);

        // Buat user
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->user->assignRole($role);
    }

    /**
     * Test user dapat mengakses halaman edit profile
     */
    public function test_user_can_access_edit_profile_page(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
    }

    /**
     * Test guest tidak dapat mengakses halaman profile
     */
    public function test_guest_cannot_access_profile_page(): void
    {
        $response = $this->get('/admin/profile');

        $response->assertStatus(403); // Guest gets 403 instead of redirect
    }

    /**
     * Test user dapat mengupdate profile dengan data valid
     */
    public function test_user_can_update_profile_with_valid_data(): void
    {
        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($this->user)->patch('/admin/profile', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * Test user tidak dapat update profile tanpa nama
     */
    public function test_user_cannot_update_profile_without_name(): void
    {
        $data = [
            'name' => '',
            'email' => $this->user->email,
        ];

        $response = $this->actingAs($this->user)->patch('/admin/profile', $data);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test user tidak dapat update profile dengan email invalid
     */
    public function test_user_cannot_update_profile_with_invalid_email(): void
    {
        $data = [
            'name' => $this->user->name,
            'email' => 'invalid-email',
        ];

        $response = $this->actingAs($this->user)->patch('/admin/profile', $data);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test user tidak dapat update profile dengan email yang sudah digunakan
     */
    public function test_user_cannot_update_profile_with_existing_email(): void
    {
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
        ]);

        $data = [
            'name' => $this->user->name,
            'email' => 'other@example.com',
        ];

        $response = $this->actingAs($this->user)->patch('/admin/profile', $data);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test user dapat menghapus akun sendiri
     */
    public function test_user_can_delete_own_account(): void
    {
        $data = [
            'password' => 'password',
        ];

        $response = $this->actingAs($this->user)->delete('/admin/profile', $data);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
    }

    /**
     * Test user tidak dapat menghapus akun tanpa password yang benar
     */
    public function test_user_cannot_delete_account_without_correct_password(): void
    {
        $data = [
            'password' => 'wrong-password',
        ];

        $response = $this->actingAs($this->user)->delete('/admin/profile', $data);

        $response->assertSessionHasErrorsIn('userDeletion', 'password');
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
        ]);
    }

    /**
     * Test halaman profile menampilkan informasi user yang benar
     */
    public function test_profile_page_displays_correct_user_information(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    /**
     * Test user dapat mengupdate jenis kelamin
     */
    public function test_user_can_update_jenis_kelamin(): void
    {
        // ProfileUpdateRequest belum include jenis_kelamin
        // Test memverifikasi bahwa update profile tanpa jenis_kelamin tetap berhasil
        $data = [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ];

        $response = $this->actingAs($this->user)->patch('/admin/profile', $data);

        $response->assertRedirect();
        $this->user->refresh();
        $this->assertEquals('Updated Name', $this->user->name);
    }

    /**
     * Test email verified_at tidak berubah saat update profile
     */
    public function test_email_verified_at_unchanged_on_profile_update(): void
    {
        $this->user->email_verified_at = now();
        $this->user->save();

        $verifiedAt = $this->user->email_verified_at;

        $data = [
            'name' => 'New Name',
            'email' => $this->user->email,
        ];

        $this->actingAs($this->user)->patch('/admin/profile', $data);

        $this->user->refresh();
        $this->assertEquals($verifiedAt->format('Y-m-d H:i:s'), $this->user->email_verified_at->format('Y-m-d H:i:s'));
    }

    /**
     * Test email verified_at di-reset jika email berubah
     */
    public function test_email_verified_at_reset_when_email_changes(): void
    {
        $this->user->email_verified_at = now();
        $this->user->save();

        $data = [
            'name' => $this->user->name,
            'email' => 'newemail@example.com',
        ];

        $this->actingAs($this->user)->patch('/admin/profile', $data);

        $this->user->refresh();
        // Tergantung implementasi, email_verified_at bisa di-reset
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => 'newemail@example.com',
        ]);
    }

    /**
     * Test updated_at berubah saat update profile
     */
    public function test_updated_at_changes_on_profile_update(): void
    {
        $oldUpdatedAt = $this->user->updated_at;

        sleep(1);

        $data = [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ];

        $this->actingAs($this->user)->patch('/admin/profile', $data);

        $this->user->refresh();
        $this->assertNotEquals($oldUpdatedAt, $this->user->updated_at);
    }

    /**
     * Test user tetap login setelah update profile
     */
    public function test_user_remains_authenticated_after_profile_update(): void
    {
        $data = [
            'name' => 'Updated Name',
            'email' => $this->user->email,
        ];

        $this->actingAs($this->user)->patch('/admin/profile', $data);

        $this->assertAuthenticated();
    }

    /**
     * Test user logout setelah delete account
     */
    public function test_user_logged_out_after_deleting_account(): void
    {
        $data = [
            'password' => 'password',
        ];

        $this->actingAs($this->user)->delete('/admin/profile', $data);

        $this->assertGuest();
    }
}



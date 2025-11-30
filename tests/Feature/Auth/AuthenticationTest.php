<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role default yang mungkin dibutuhkan
        Role::create(['name' => 'admin klinik']);
        Role::create(['name' => 'dokter umum']);
        Role::create(['name' => 'pasien']);
    }

    /**
     * Test halaman login dapat diakses
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test user dapat login dengan kredensial yang benar
     */
    public function test_users_can_authenticate_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign role ke user
        $user->assignRole('admin klinik');

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Test user tidak dapat login dengan kredensial yang salah
     */
    public function test_users_cannot_authenticate_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    /**
     * Test user tidak dapat login dengan email kosong
     */
    public function test_users_cannot_authenticate_with_empty_email(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test user tidak dapat login dengan password kosong
     */
    public function test_users_cannot_authenticate_with_empty_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    /**
     * Test user dapat logout
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Test halaman register tidak tersedia (disabled)
     */
    public function test_register_page_is_disabled(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    /**
     * Test user dapat dibuat secara manual dengan role
     */
    public function test_users_can_be_created_manually_with_role(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'jenis_kelamin' => 'L', // L = Laki-laki, P = Perempuan
        ]);

        // Assign role ke user
        $user->assignRole('pasien');

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'jenis_kelamin' => 'L',
        ]);

        // Verifikasi user memiliki role
        $this->assertTrue($user->hasRole('pasien'));
    }

    /**
     * Test email user harus unik
     */
    public function test_user_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        // Attempt to create another user with same email should fail
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test password harus di-hash saat disimpan
     */
    public function test_password_is_hashed_when_saved(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'plainpassword',
        ]);

        // Password harus di-hash, tidak disimpan plain text
        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(strlen($user->password) > 50); // bcrypt hash length
    }

    /**
     * Test user factory dapat membuat user dengan password yang valid
     */
    public function test_user_factory_creates_valid_password(): void
    {
        $user = User::factory()->create();

        // Factory harus membuat password yang valid dan ter-hash
        $this->assertNotNull($user->password);
        $this->assertTrue(strlen($user->password) > 50);

        // Test bahwa password berfungsi untuk login
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password', $user->password));
    }

    /**
     * Test user dengan role admin dapat login dan akses dashboard
     */
    public function test_admin_user_can_login_and_access_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin klinik');

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->hasRole('admin klinik'));

        // Verifikasi admin dapat akses dashboard
        $dashboardResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
    }

    /**
     * Test user dengan role dokter dapat login
     */
    public function test_dokter_user_can_login(): void
    {
        $dokter = User::factory()->create([
            'email' => 'dokter@test.com',
            'password' => bcrypt('password'),
        ]);

        $dokter->assignRole('dokter umum');

        $response = $this->post('/login', [
            'email' => 'dokter@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->hasRole('dokter umum'));
    }

    /**
     * Test user tanpa role tidak dapat akses halaman admin
     */
    public function test_user_without_role_cannot_access_admin_pages(): void
    {
        $user = User::factory()->create([
            'email' => 'norole@test.com',
            'password' => bcrypt('password'),
        ]);

        // User tidak diberi role

        $this->actingAs($user);

        // Coba akses dashboard admin
        $response = $this->get('/admin/dashboard');

        // Harus ditolak (403 Forbidden)
        $response->assertStatus(403);
    }

    /**
     * Test user dapat memiliki multiple roles
     */
    public function test_user_can_have_multiple_roles(): void
    {
        $user = User::factory()->create();

        $user->assignRole(['admin klinik', 'dokter umum']);

        $this->assertTrue($user->hasRole('admin klinik'));
        $this->assertTrue($user->hasRole('dokter umum'));
        $this->assertTrue($user->hasAnyRole(['admin klinik', 'dokter umum']));
    }

    /**
     * Test verifikasi role user setelah login
     */
    public function test_verify_user_role_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('dokter umum');

        $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $authenticatedUser = auth()->user();
        $this->assertNotNull($authenticatedUser);
        $this->assertTrue($authenticatedUser->hasRole('dokter umum'));
        $this->assertFalse($authenticatedUser->hasRole('admin klinik'));
    }

    /**
     * Test role persists setelah logout dan login kembali
     */
    public function test_role_persists_after_logout_and_login(): void
    {
        $user = User::factory()->create([
            'email' => 'persist@test.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin klinik');

        // Login pertama
        $this->post('/login', [
            'email' => 'persist@test.com',
            'password' => 'password',
        ]);

        $this->assertTrue(auth()->user()->hasRole('admin klinik'));

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Login kembali
        $this->post('/login', [
            'email' => 'persist@test.com',
            'password' => 'password',
        ]);

        // Verifikasi role masih ada
        $this->assertTrue(auth()->user()->hasRole('admin klinik'));
    }

    /**
     * Test login throttling after multiple failed attempts
     */
    public function test_login_is_throttled_after_multiple_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'throttle@test.com',
            'password' => bcrypt('password'),
        ]);

        // Make 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'throttle@test.com',
                'password' => 'wrong-password',
            ]);
        }

        // The 6th attempt should be throttled
        $response = $this->post('/login', [
            'email' => 'throttle@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');

        // Clear rate limiter for next tests
        RateLimiter::clear('throttle@test.com|127.0.0.1');
    }

    /**
     * Test throttle key is generated correctly
     */
    public function test_login_throttle_key_is_generated_correctly(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'Test@Example.com', // Mixed case
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');

        // Throttle key should be lowercase email + IP
        $throttleKey = 'test@example.com|127.0.0.1';
        $this->assertEquals(1, RateLimiter::attempts($throttleKey));

        // Clear rate limiter
        RateLimiter::clear($throttleKey);
    }

    /**
     * Test rate limiter is cleared after successful login
     */
    public function test_rate_limiter_cleared_after_successful_login(): void
    {
        User::factory()->create([
            'email' => 'clear@test.com',
            'password' => bcrypt('password'),
        ]);

        // Make a failed attempt first
        $this->post('/login', [
            'email' => 'clear@test.com',
            'password' => 'wrong-password',
        ]);

        $throttleKey = 'clear@test.com|127.0.0.1';
        $this->assertEquals(1, RateLimiter::attempts($throttleKey));

        // Now login successfully
        $response = $this->post('/login', [
            'email' => 'clear@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');

        // Rate limiter should be cleared
        $this->assertEquals(0, RateLimiter::attempts($throttleKey));
    }

    /**
     * Test remember me functionality
     */
    public function test_remember_me_functionality(): void
    {
        $user = User::factory()->create([
            'email' => 'remember@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'remember@test.com',
            'password' => 'password',
            'remember' => true,
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test User model casts email_verified_at
     */
    public function test_user_model_casts_email_verified_at(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }

    /**
     * Test User model password is hashed on set
     */
    public function test_user_model_password_is_hashed_on_set(): void
    {
        $user = new User();
        $user->name = 'Test';
        $user->email = 'testset@test.com';
        $user->password = 'plain-password';
        $user->jenis_kelamin = 'L';
        $user->save();

        $this->assertTrue(\Hash::check('plain-password', $user->password));
    }
}

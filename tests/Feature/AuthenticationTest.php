<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_student_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();

        $user = User::where('email', 'student@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('student', $user->role);
    }

    public function test_vendor_can_register_with_profile(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Vendor',
            'email' => 'vendor@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'vendor',
            'vendor_name' => 'Test Food Stall',
            'location' => 'Building A, Ground Floor',
            'contact_info' => '123-456-7890',
            'description' => 'Serving delicious food',
        ]);

        $response->assertRedirect(route('vendor.dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'vendor@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('vendor', $user->role);

        $vendor = Vendor::where('user_id', $user->id)->first();
        $this->assertNotNull($vendor);
        $this->assertEquals('Test Food Stall', $vendor->vendor_name);
        $this->assertEquals('Building A, Ground Floor', $vendor->location);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_vendor_redirects_to_vendor_dashboard_after_login(): void
    {
        $user = User::factory()->vendor()->create([
            'email' => 'vendor@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'vendor@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('vendor.dashboard'));
    }

    public function test_student_redirects_to_home_after_login(): void
    {
        $user = User::factory()->student()->create([
            'email' => 'student@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'student@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_access_vendor_routes(): void
    {
        $user = User::factory()->vendor()->create();

        $response = $this->actingAs($user)->get('/vendor/dashboard');

        $response->assertStatus(200);
    }

    public function test_student_cannot_access_vendor_routes(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->get('/vendor/dashboard');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/vendor/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_vendor_role_is_correctly_identified(): void
    {
        $vendor = User::factory()->vendor()->create();
        $student = User::factory()->student()->create();

        $this->assertTrue($vendor->isVendor());
        $this->assertFalse($vendor->isStudent());

        $this->assertTrue($student->isStudent());
        $this->assertFalse($student->isVendor());
    }
}

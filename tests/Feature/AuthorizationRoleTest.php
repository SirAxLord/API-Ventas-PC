<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_customer_cannot_create_product(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $payload = [
            'name' => 'Test Prod',
            'price' => 10,
        ];
        $response = $this->actingAs($customer)->postJson('/v1/products', $payload);
        $response->assertStatus(403);
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = [
            'name' => 'Admin Prod',
            'price' => 99.5,
        ];
        $response = $this->actingAs($admin)->postJson('/v1/products', $payload);
        $response->assertCreated();
        $this->assertDatabaseHas('products', ['name' => 'Admin Prod']);
    }

    public function test_guest_cannot_create_product(): void
    {
        $payload = [
            'name' => 'Guest Prod',
            'price' => 5,
        ];
        $response = $this->postJson('/v1/products', $payload);
        $response->assertStatus(401); // No autenticado
    }
}

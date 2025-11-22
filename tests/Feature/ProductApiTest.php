<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Sembrar datos base
        Products::factory(5)->create();
    }

    public function test_can_list_products_public(): void
    {
        $response = $this->getJson('/v1/products');
        $response->assertOk()
                 ->assertJsonStructure(['data','meta']);
    }

    public function test_can_filter_products_by_category(): void
    {
        $p = Products::factory()->create(['category' => 'computadoras']);
        $response = $this->getJson('/v1/products?category=computadoras');
        $response->assertOk();
        $this->assertTrue(collect($response->json('data'))
            ->pluck('category')
            ->contains('computadoras'));
    }

    public function test_cannot_create_product_without_auth(): void
    {
        $payload = [
            'name' => 'Mouse Gamer',
            'price' => 25.50,
        ];
        $response = $this->postJson('/v1/products', $payload);
        $response->assertStatus(401);
    }

    public function test_validation_errors_on_product_create(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $payload = [
            // Falta name y price inválido
            'price' => -10,
        ];
        $response = $this->postJson('/v1/products', $payload);
        $response->assertStatus(422)
                 ->assertJsonStructure(['error' => ['details']]);
    }

    public function test_can_create_product_with_auth(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $payload = [
            'name' => 'Teclado Mecánico',
            'description' => 'Teclado switch azul retroiluminado.',
            'price' => 75.90,
            'stock' => 10,
            'status' => 'active',
        ];
        $response = $this->postJson('/v1/products', $payload);
        $response->assertCreated()
                 ->assertJsonPath('data.name', 'Teclado Mecánico');
        $this->assertDatabaseHas('products', ['name' => 'Teclado Mecánico']);
    }

    public function test_can_update_product_with_auth(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Products::factory()->create(['name' => 'Old Name']);
        $response = $this->putJson("/v1/products/{$product->id}", [
            'name' => 'New Name',
        ]);
        $response->assertOk()
                 ->assertJsonPath('data.name', 'New Name');
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'New Name']);
    }

    public function test_can_delete_product_with_auth(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Products::factory()->create();
        $response = $this->deleteJson("/v1/products/{$product->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

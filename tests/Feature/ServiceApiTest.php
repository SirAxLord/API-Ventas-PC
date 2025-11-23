<?php

namespace Tests\Feature;

use App\Models\Services;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Services::factory(5)->create();
    }

    public function test_can_list_services_public(): void
    {
        $response = $this->getJson('/api/v1/services');
        $response->assertOk()->assertJsonStructure(['data','meta']);
    }

    public function test_can_filter_services_by_type(): void
    {
        Services::factory()->create(['type' => 'reparacion']);
        $response = $this->getJson('/api/v1/services?type=reparacion');
        $response->assertOk();
        $this->assertTrue(collect($response->json('data'))
            ->pluck('type')
            ->contains('reparacion'));
    }

    public function test_cannot_create_service_without_auth(): void
    {
        $payload = [
            'name' => 'Instalación Office',
            'price' => 15.00,
        ];
        $response = $this->postJson('/api/v1/services', $payload);
        $response->assertStatus(401);
    }

    public function test_validation_errors_on_service_create(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $payload = [
            // Falta name; price negativo
            'price' => -5,
        ];
        $response = $this->postJson('/api/v1/services', $payload);
        $response->assertStatus(422);
    }

    public function test_can_create_service_with_auth(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $payload = [
            'name' => 'Instalación Antivirus Premium',
            'description' => 'Configuración completa de suite antivirus.',
            'price' => 40.00,
            'estimated_time' => 30,
            'type' => 'software',
            'status' => 'active',
        ];
        $response = $this->postJson('/api/v1/services', $payload);
        $response->assertCreated()
                 ->assertJsonPath('data.name', 'Instalación Antivirus Premium');
        $this->assertDatabaseHas('services', ['name' => 'Instalación Antivirus Premium']);
    }

    public function test_can_update_service_with_auth(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $service = Services::factory()->create(['name' => 'Servicio Anterior']);
        $response = $this->putJson("/api/v1/services/{$service->id}", [
            'name' => 'Servicio Actualizado',
        ]);
        $response->assertOk()->assertJsonPath('data.name', 'Servicio Actualizado');
        $this->assertDatabaseHas('services', ['id' => $service->id, 'name' => 'Servicio Actualizado']);
    }

    public function test_can_delete_service_with_auth(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $service = Services::factory()->create();
        $response = $this->deleteJson("/api/v1/services/{$service->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}

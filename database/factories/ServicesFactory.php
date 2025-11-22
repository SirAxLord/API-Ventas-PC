<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services>
 */
class ServicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['mantenimiento','reparacion','software','diagnostico','actualizacion'];
        $status = $this->faker->boolean(92) ? 'active' : 'inactive';
        return [
            'name' => ucfirst($this->faker->words(2, true)),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'estimated_time' => $this->faker->numberBetween(15, 240), // minutos
            'type' => $this->faker->randomElement($types),
            'status' => $status,
        ];
    }
}

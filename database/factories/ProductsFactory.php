<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['computadoras','celulares','auriculares','monitores','accesorios','almacenamiento'];
        $status = $this->faker->boolean(90) ? 'active' : 'inactive';
        return [
            'sku' => strtoupper($this->faker->bothify('PC-####')), // Ej: PC-4821
            'name' => $this->faker->unique()->words(2, true),
            'description' => $this->faker->sentence(12),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->randomFloat(2, 10, 2500),
            'cost_price' => $this->faker->randomFloat(2, 5, 2000),
            'stock' => $this->faker->numberBetween(0, 150),
            'image_url' => $this->faker->imageUrl(640, 480, 'tech', true),
            'status' => $status,
        ];
    }
}

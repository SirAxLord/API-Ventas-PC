<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed directo con algunos productos representativos
        $baseProducts = [
            [
                'sku' => 'PC-LAP-001',
                'name' => 'Laptop Gamer',
                'description' => 'Laptop de alto rendimiento para juegos intensivos.',
                'category' => 'computadoras',
                'price' => 1850.00,
                'cost_price' => 1500.00,
                'stock' => 12,
                'image_url' => 'https://example.com/images/laptop-gamer.jpg',
                'status' => 'active',
            ],
            [
                'sku' => 'ACC-AUD-014',
                'name' => 'Auriculares Inalámbricos',
                'description' => 'Auriculares bluetooth con cancelación de ruido.',
                'category' => 'auriculares',
                'price' => 120.00,
                'cost_price' => 80.00,
                'stock' => 40,
                'image_url' => 'https://example.com/images/auriculares.jpg',
                'status' => 'active',
            ],
            [
                'sku' => 'STR-SSD-512',
                'name' => 'SSD 512GB',
                'description' => 'Unidad de estado sólido rápida para mejorar el rendimiento.',
                'category' => 'almacenamiento',
                'price' => 95.50,
                'cost_price' => 60.00,
                'stock' => 75,
                'image_url' => 'https://example.com/images/ssd-512.jpg',
                'status' => 'active',
            ],
            [
                'sku' => 'PHN-SMT-010',
                'name' => 'Smartphone Pro',
                'description' => 'Teléfono inteligente con cámara avanzada y gran batería.',
                'category' => 'celulares',
                'price' => 950.00,
                'cost_price' => 700.00,
                'stock' => 25,
                'image_url' => 'https://example.com/images/smartphone-pro.jpg',
                'status' => 'active',
            ],
            [
                'sku' => 'MON-24FHD',
                'name' => 'Monitor 24" FHD',
                'description' => 'Monitor full HD de 24 pulgadas ideal para oficina.',
                'category' => 'monitores',
                'price' => 160.00,
                'cost_price' => 120.00,
                'stock' => 30,
                'image_url' => 'https://example.com/images/monitor-24.jpg',
                'status' => 'active',
            ],
        ];

        foreach ($baseProducts as $data) {
            Products::create($data);
        }

        // Productos adicionales aleatorios
        Products::factory(15)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseServices = [
            [
                'name' => 'Mantenimiento General PC',
                'description' => 'Limpieza física, revisión de ventilación y ajustes básicos.',
                'price' => 45.00,
                'estimated_time' => 90,
                'type' => 'mantenimiento',
                'status' => 'active',
            ],
            [
                'name' => 'Instalación Antivirus',
                'description' => 'Instalación y configuración de suite antivirus premium.',
                'price' => 30.00,
                'estimated_time' => 30,
                'type' => 'software',
                'status' => 'active',
            ],
            [
                'name' => 'Cambio de Memoria RAM',
                'description' => 'Instalación de módulos RAM y prueba de estabilidad.',
                'price' => 25.00,
                'estimated_time' => 20,
                'type' => 'actualizacion',
                'status' => 'active',
            ],
            [
                'name' => 'Diagnóstico de Hardware',
                'description' => 'Pruebas para detectar fallos en componentes (CPU, GPU, RAM).',
                'price' => 35.00,
                'estimated_time' => 60,
                'type' => 'diagnostico',
                'status' => 'active',
            ],
            [
                'name' => 'Reparación de Fuente',
                'description' => 'Reemplazo o reparación de fuente de poder defectuosa.',
                'price' => 55.00,
                'estimated_time' => 120,
                'type' => 'reparacion',
                'status' => 'active',
            ],
        ];

        foreach ($baseServices as $data) {
            Services::create($data);
        }

        Services::factory(10)->create();
    }
}

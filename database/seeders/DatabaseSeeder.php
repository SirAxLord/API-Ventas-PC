<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Products;
use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario administrador inicial
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('secret'),
                'role' => 'admin',
            ]
        );

        // Ejecutar seeders específicos
        $this->call([
            ProductsSeeder::class,
            ServicesSeeder::class,
        ]);
    }
}

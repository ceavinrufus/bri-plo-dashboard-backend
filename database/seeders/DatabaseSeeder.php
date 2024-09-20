<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Pengadaan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed departments
        Department::create([
            'code' => 'bcp',
            'name' => 'Building Construction Procurement',
        ]);

        Department::create([
            'code' => 'igp',
            'name' => 'IT Goods and Services Procurement',
        ]);

        Department::create([
            'code' => 'psr',
            'name' => '...',
        ]);

        // Seed a user
        User::factory()->create([
            'name' => 'Ceavin Rufus',
            'email' => 'ceavin.dev@gmail.com',
        ]);

        Pengadaan::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DokumenJaminan;
use App\Models\DokumenPerjanjian;
use App\Models\DokumenSPK;
use App\Models\NodinIpPengadaan;
use App\Models\NodinPlo;
use App\Models\NodinUser;
use App\Models\Pengadaan;
use App\Models\Project;
use App\Models\RekapPembayaran;
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
            'target' => 3.5,
        ]);

        Department::create([
            'code' => 'igp',
            'name' => 'IT Goods and Services Procurement',
            'target' => 7,
        ]);

        Department::create([
            'code' => 'psr',
            'name' => 'Payment Service and Rental',
            'target' => 5.5,
        ]);

        Project::create([
            'kode' => 'P001',
            'nama' => 'Proyek Pembangunan Gedung A',
        ]);

        // Seed a user
        User::factory()->create([
            'name' => 'Ceavin Rufus',
            'pn' => '99999999',
            'email' => 'ceavinr@gmail.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Admin',
            'pn' => '90175686',
            'email' => 'ceavin.dev@gmail.com',
        ]);

        Pengadaan::factory(10)->create();
        NodinPlo::factory(20)->create();
        NodinUser::factory(20)->create();
        NodinIpPengadaan::factory(20)->create();

        DokumenSPK::factory(10)->create();
        DokumenJaminan::factory(10)->create();

        DokumenPerjanjian::factory(10)->create();
        RekapPembayaran::factory(10)->create();
    }
}

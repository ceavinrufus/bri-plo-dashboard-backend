<?php

namespace Database\Factories;

use App\Models\Pengadaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengadaan>
 */
class PengadaanFactory extends Factory
{
    protected $model = Pengadaan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'departemen' => $this->faker->randomElement(['bcp', 'igp', 'psr']),
            'nama_pengadaan' => $this->faker->words(3, true),
            'tanggal_nodin' => $this->faker->optional()->date(),
            'tanggal_spk' => $this->faker->optional()->date(),
            'hari_pengerjaan' => $this->faker->optional()->numberBetween(1, 100),
            'metode' => $this->faker->randomElement(['Pemilihan Langsung', 'Penunjukkan Langsung', 'Lelang']),
            'progres' => "Done",
            'hari_proses' => $this->faker->optional()->numberBetween(1, 100),
            'progres_pengadaan' => $this->faker->optional()->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

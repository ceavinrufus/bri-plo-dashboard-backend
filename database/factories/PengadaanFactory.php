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
        $tanggalNodinUser = $this->faker->dateTimeThisYear();

        return [
            'kode_user' => strtoupper($this->faker->lexify('???')),
            'nodin_user' => $this->faker->words(3, true),
            'tanggal_nodin_user' => $tanggalNodinUser->format('Y-m-d'),
            'departemen' => $this->faker->randomElement(['bcp', 'igp', 'psr']),
            'perihal' => $this->faker->sentence,
            'tanggal_spk' => $this->faker->dateTimeBetween($tanggalNodinUser, 'now')->format('Y-m-d'),
            'metode' => $this->faker->randomElement(['Lelang', 'Pemilihan Langsung', 'Seleksi Langsung', 'Penunjukkan Langsung']),
            'is_verification_complete' => $this->faker->boolean,
            'is_done' => $this->faker->boolean,
            'proses_pengadaan' => $this->faker->optional()->word(),
            'nilai_spk' => $this->faker->optional()->randomFloat(2, 1000, 1000000),
            'anggaran' => $this->faker->optional()->randomFloat(2, 1000, 1000000),
            'hps' => $this->faker->optional()->randomFloat(2, 1000, 1000000),
            'tkdn_percentage' => $this->faker->optional()->randomFloat(2, 0, 100),
            'catatan' => $this->faker->optional()->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

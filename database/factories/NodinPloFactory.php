<?php

namespace Database\Factories;

use App\Models\NodinPlo;
use App\Models\Pengadaan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NodinPlo>
 */
class NodinPloFactory extends Factory
{
    protected $model = NodinPlo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pengadaanIDs = Pengadaan::all()->pluck('id')->toArray();
        $tim = $this->faker->randomElement(['bcr', 'pts', 'ptt']);
        $departemen = $this->faker->randomElement(['bcp', 'igp', 'psr']);

        return [
            'nodin' => 'B.' . $this->faker->randomNumber() . '.P-PLO/' . strtoupper($departemen) . '/' . strtoupper($tim) . '/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_nodin' => $this->faker->date,
            'pengadaan_id' =>  $this->faker->randomElement($pengadaanIDs), // Use existing Pengadaan ID
        ];
    }
}

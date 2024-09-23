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
        return [
            'nodin' => $this->faker->word,
            'tanggal_nodin' => $this->faker->date,
            'pengadaan_id' => Pengadaan::inRandomOrder()->first()->id, // Use existing Pengadaan ID
        ];
    }
}

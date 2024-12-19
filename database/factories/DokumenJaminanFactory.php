<?php

namespace Database\Factories;

use App\Models\DokumenJaminan;
use App\Models\DokumenSpk;
use Illuminate\Database\Eloquent\Factories\Factory;

class DokumenJaminanFactory extends Factory
{
    protected $model = DokumenJaminan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dokumenSpkIDs = DokumenSpk::all()->pluck('id')->toArray();
        $type = $this->faker->randomElement(['JUM', 'JBayar', 'Jampel', 'JPelihara']);

        return [
            'type' => $type,
            'tanggal_diterima' => $this->faker->date,
            'penerbit' => $this->faker->company,
            'nomor_jaminan' => $this->faker->unique()->numerify('BG-#####'),
            'dokumen_keabsahan' => $this->faker->word,
            'nilai' => $this->faker->randomFloat(2, 1000, 100000),
            'waktu_mulai' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'waktu_berakhir' => $this->faker->dateTimeBetween('now', '+1 years'),
            'dokumen_spk_id' => $this->faker->randomElement($dokumenSpkIDs),
        ];
    }
}

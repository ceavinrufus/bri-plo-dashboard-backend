<?php

namespace Database\Factories;

use App\Models\DokumenSpk;
use App\Models\JatuhTempoDokumenSpk;
use Illuminate\Database\Eloquent\Factories\Factory;

class JatuhTempoDokumenSpkFactory extends Factory
{
    protected $model = JatuhTempoDokumenSpk::class;

    public function definition()
    {
        $dokumenIDs = DokumenSpk::all()->pluck('id')->toArray();

        return [
            'keterangan' => $this->faker->sentence,
            'tanggal_mulai' => $tanggalMulai = $this->faker->dateTimeBetween('-1 year', 'now'),
            'tanggal_akhir' => $this->faker->dateTimeBetween($tanggalMulai, '+1 year'),
            'dokumen_spk_id' =>  $this->faker->randomElement($dokumenIDs), // Use existing Dokumen ID
        ];
    }
}

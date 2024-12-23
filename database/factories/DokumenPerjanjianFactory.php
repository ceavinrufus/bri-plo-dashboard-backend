<?php

namespace Database\Factories;

use App\Models\DokumenPerjanjian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DokumenPerjanjianFactory extends Factory
{
    protected $model = DokumenPerjanjian::class;

    public function definition()
    {
        $sentences = [
            'Pengadaan Jasa Kontraktor Pelaksana Pekerjaan Renovasi Lt.10 Gd RO Bandung',
            'Jasa Konsultan Pengawas Renovasi Ruang Kerja PPM Div Gedung BRI 2 Lt 31',
            'Pengadaan Jasa Sewa LED Jl. Malabar – Depan Lippo Plaza Bogor',
            'Pengadaan CCTV untuk Ruang Audit Standard & Quality Development Division Gedung BRI 2 Lantai 25',
            'Pengadaan Aplikasi e-Procurement di Direktorat Fixed Assets Management & Procurement (FAMP) BRI'
        ];
        $tim = $this->faker->randomElement(['bcr', 'pts', 'ptt']);
        $departemen = $this->faker->randomElement(['bcp', 'igp', 'psr']);
        $userIDs = User::all()->pluck('id')->toArray();

        return [
            'tanggal_permohonan_diterima' => $this->faker->date(),
            'tim_pemrakarsa' => $tim,
            'pic_pengadaan_id' => $this->faker->randomElement($userIDs),
            'nomor_spk' => 'SPK.' . $this->faker->randomNumber() . '.P-PLO/' . strtoupper($departemen) . '/' . strtoupper($tim) . '/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_spk' => $this->faker->date(),
            'jenis_pekerjaan' => $this->faker->randomElement($sentences),
            'spk' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1)
            ]),
            'jangka_waktu' => $this->faker->optional()->numberBetween(1, 365),
            'pelaksana_pekerjaan' => json_encode([
                'name' => $this->faker->company,
                'address' => $this->faker->address,
                'phone_number' => $this->faker->phoneNumber
            ]),
            'pic_pelaksana_pekerjaan' => $this->faker->name . ' (' . $this->faker->phoneNumber . ')',
            'nomor_kontrak' => $this->faker->randomNumber() . '.K-PLO/' . strtoupper($departemen) . '/LEG/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_kontrak' => $this->faker->date(),
            'pic_legal_id' => $this->faker->randomElement($userIDs),
        ];
    }
}

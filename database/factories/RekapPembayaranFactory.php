<?php

namespace Database\Factories;

use App\Models\RekapPembayaran;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RekapPembayaranFactory extends Factory
{
    protected $model = RekapPembayaran::class;

    public function definition()
    {
        $userIDs = User::all()->pluck('id')->toArray();

        $tim = $this->faker->randomElement(['bcr', 'pts', 'ptt']);
        $departemen = $this->faker->randomElement(['bcp', 'igp', 'psr']);
        $sentences = [
            'Pengadaan Jasa Kontraktor Pelaksana Pekerjaan Renovasi Lt.10 Gd RO Bandung',
            'Jasa Konsultan Pengawas Renovasi Ruang Kerja PPM Div Gedung BRI 2 Lt 31',
            'Pengadaan Jasa Sewa LED Jl. Malabar – Depan Lippo Plaza Bogor',
            'Pengadaan CCTV untuk Ruang Audit Standard & Quality Development Division Gedung BRI 2 Lantai 25',
            'Pengadaan Aplikasi e-Procurement di Direktorat Fixed Assets Management & Procurement (FAMP) BRI'
        ];


        return [
            'pic_pc_id' => $this->faker->randomElement($userIDs),
            'tanggal_terima' => $this->faker->optional()->date(),
            'nomor_spk' => 'SPK.' . $this->faker->randomNumber() . '.P-PLO/' . strtoupper($departemen) . '/' . strtoupper($tim) . '/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_spk' => $this->faker->date(),
            'nomor_perjanjian' => $this->faker->randomNumber() . '.K-PLO/' . strtoupper($departemen) . '/LEG/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_perjanjian' => $this->faker->optional()->date(),
            'perihal' => $this->faker->randomElement($sentences),
            'spk' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1)
            ]),
            'vendor' => $this->faker->optional()->company,
            'tkdn' => $this->faker->optional()->randomFloat(2, 0, 100),
            'nomor_invoice' => $this->faker->optional()->text(255),
            'invoice' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1)
            ]),
            'nomor_rekening' => $this->faker->optional()->text(255),
            'pic_pay_id' => $this->faker->randomElement($userIDs),
            'nota_fiat' => $this->faker->optional()->text(255),
            'tanggal_fiat' => $this->faker->optional()->date(),
            'sla' => $this->faker->date(),
            'hari_pengerjaan' => $this->faker->optional()->numberBetween(1, 365),
            'status_pembayaran' => $this->faker->optional()->text(255),
            'tanggal_pembayaran' => $this->faker->optional()->date(),
            'keterangan' => $this->faker->optional()->text(255),
        ];
    }
}

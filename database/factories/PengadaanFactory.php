<?php

namespace Database\Factories;

use App\Models\Pengadaan;
use App\Models\User;
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
        $tim = $this->faker->randomElement(['bcr', 'pts', 'ptt']);
        $departemen = $this->faker->randomElement(['bcp', 'igp', 'psr']);
        $sentences = [
            'Pengadaan Jasa Kontraktor Pelaksana Pekerjaan Renovasi Lt.10 Gd RO Bandung',
            'Jasa Konsultan Pengawas Renovasi Ruang Kerja PPM Div Gedung BRI 2 Lt 31',
            'Pengadaan Jasa Sewa LED Jl. Malabar – Depan Lippo Plaza Bogor',
            'Pengadaan CCTV untuk Ruang Audit Standard & Quality Development Division Gedung BRI 2 Lantai 25',
            'Pengadaan Aplikasi e-Procurement di Direktorat Fixed Assets Management & Procurement (FAMP) BRI'
        ];
        $userIDs = User::all()->pluck('id')->toArray();
        $isVerificationComplete = $this->faker->boolean;

        return [
            'kode_user' => "PLO",
            'tim' => $tim,
            'departemen' => $departemen,
            'proyek' => $departemen === 'bcp' ? 'P001' : null,
            'perihal' => $this->faker->randomElement($sentences),
            'metode' => $this->faker->randomElement(['Lelang', 'Pemilihan Langsung', 'Seleksi Langsung', 'Penunjukkan Langsung']),
            'is_verification_complete' => $isVerificationComplete,
            'catatan' => $isVerificationComplete ? $this->faker->optional()->sentence : '',
            'pic_id' => $this->faker->randomElement($userIDs),
            'proses_pengadaan' => $this->faker->randomElement([
                'Penyusunan & Penetapan HPS',
                'Membuat Izin Pengadaan',
                'Pengumuman Pengadaan',
                'Selesai'
            ]),
            'nomor_spk' => 'SPK.' . $this->faker->randomNumber() . '.P-PLO/' . strtoupper($departemen) . '/' . strtoupper($tim) . '/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_spk' => $this->faker->dateTimeBetween($tanggalNodinUser, 'now')->format('Y-m-d'),
            'tanggal_acuan' => $this->faker->dateTimeBetween($tanggalNodinUser, 'now')->format('Y-m-d'),
            'pelaksana_pekerjaan' => $this->faker->name,
            'spk_investasi' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1),
            ]),
            'spk_eksploitasi' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1),
            ]),
            'anggaran_investasi' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1),
                'tanggal_permohonan' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
                'tanggal_terima' => $this->faker->dateTimeThisYear()->format('Y-m-d')
            ]),
            'anggaran_eksploitasi' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1),
                'tanggal_permohonan' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
                'tanggal_terima' => $this->faker->dateTimeThisYear()->format('Y-m-d')
            ]),
            'hps' => json_encode([
                'amount' => $this->faker->randomFloat(2, 10000, 11000),
                'currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
                'rate' => $this->faker->randomFloat(2, 0.1, 1),
                'tanggal_permohonan' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
                'tanggal_terima' => $this->faker->dateTimeThisYear()->format('Y-m-d')
            ]),
            'tkdn_percentage' => $this->faker->optional()->randomFloat(2, 0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

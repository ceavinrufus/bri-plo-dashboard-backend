<?php

namespace Database\Factories;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class DokumenFactory extends Factory
{
    protected $model = Dokumen::class;

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
            'perihal' => $this->faker->randomElement($sentences),
            'nomor_spk' => 'SPK.' . $this->faker->randomNumber() . '.P-PLO/' . strtoupper($departemen) . '/' . strtoupper($tim) . '/' . now()->format('m') . '/' . now()->format('Y'),
            'tanggal_spk' => $this->faker->date(),
            'nama_vendor' => $this->faker->company,
            'pic_id' => $this->faker->randomElement($userIDs),
            'sla_spk_sejak_terbit' => $this->faker->numberBetween(1, 30),
            'sla_spk_sejak_diambil' => $this->faker->numberBetween(1, 30),
            'tanggal' => $this->faker->date(),
            'jangka_waktu' => $this->faker->numberBetween(1, 365),
            'tim' => $this->faker->word,
            'nilai_spk' => $this->faker->randomFloat(2, 1000, 1000000),
            'identitas_vendor' => $this->faker->name,
            'info_vendor' => $this->faker->text,
            'tanggal_pengambilan' => $this->faker->date(),
            'identitas_pengambil' => $this->faker->name,
            'tanggal_pengembalian' => $this->faker->date(),
            'tanggal_jatuh_tempo' => $this->faker->date(),
            'catatan' => $this->faker->text,
            'form_tkdn' => $this->faker->boolean,
            'tanggal_penyerahan_dokumen' => $this->faker->date(),
            'penerima_dokumen' => $this->faker->name,
        ];
    }
}

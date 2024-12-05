<?php

namespace App\GraphQL\Queries\Pengadaan;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PengadaanQuery extends Query
{
    protected $attributes = [
        'name' => 'pengadaan',
        'description' => 'A query to get a specific Pengadaan by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('Pengadaan');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::id(),
                'rules' => ['exists:pengadaans,id']
            ],
            'nomor_spk' => [
                'name' => 'nomor_spk',
                'type' => Type::string(),
                'rules' => ['required_without:id', 'exists:pengadaans,nomor_spk']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            $pengadaan = Pengadaan::with(['nodinPlos', 'nodinUsers', 'nodinIpPengadaans'])->findOrFail($args['id']);
        } elseif (isset($args['nomor_spk'])) {
            $pengadaan = Pengadaan::with(['nodinPlos', 'nodinUsers', 'nodinIpPengadaans'])->where('nomor_spk', $args['nomor_spk'])->firstOrFail();
        } else {
            throw new \InvalidArgumentException('Either id or nomor_spk must be provided.');
        }

        // Log::info('PengadaanQuery: ' . json_encode($pengadaan));
        $pengadaan->pengadaan_log = $pengadaan->pengadaan_log;
        $pengadaan->nodin_users = $pengadaan->nodinUsers;
        $pengadaan->nodin_plos = $pengadaan->nodinPlos;
        $pengadaan->nodin_ip_pengadaans = $pengadaan->nodinIpPengadaans;
        $pengadaan->anggaran_investasi = json_decode($pengadaan->anggaran_investasi);
        $pengadaan->anggaran_eksploitasi = json_decode($pengadaan->anggaran_eksploitasi);
        $pengadaan->hps = json_decode($pengadaan->hps);
        $pengadaan->spk_investasi = json_decode($pengadaan->spk_investasi);
        $pengadaan->spk_eksploitasi = json_decode($pengadaan->spk_eksploitasi);
        return $pengadaan;
    }
}

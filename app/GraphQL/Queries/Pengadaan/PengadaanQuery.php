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
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:pengadaans,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $pengadaan = Pengadaan::with(['nodinPlos', 'nodinUsers'])->findOrFail($args['id']);
        $pengadaan->pengadaan_log = json_decode($pengadaan->pengadaan_log);
        $pengadaan->nodin_users = $pengadaan->nodinUsers;
        $pengadaan->nodin_plos = $pengadaan->nodinPlos;
        $pengadaan->anggaran_investasi = json_decode($pengadaan->anggaran_investasi);
        $pengadaan->anggaran_eksploitasi = json_decode($pengadaan->anggaran_eksploitasi);
        $pengadaan->hps = json_decode($pengadaan->hps);
        $pengadaan->spk_investasi = json_decode($pengadaan->spk_investasi);
        $pengadaan->spk_eksploitasi = json_decode($pengadaan->spk_eksploitasi);
        return $pengadaan;
    }
}

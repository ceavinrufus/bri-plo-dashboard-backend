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
        $pengadaan->nodin_users = $pengadaan->nodinUsers;
        $pengadaan->nodin_plos = $pengadaan->nodinPlos;
        $pengadaan->anggaran = json_decode($pengadaan->anggaran);
        $pengadaan->hps = json_decode($pengadaan->hps);
        $pengadaan->spk = json_decode($pengadaan->spk);
        return $pengadaan;
    }
}

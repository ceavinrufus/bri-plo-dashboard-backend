<?php

namespace App\GraphQL\Queries\Pengadaan;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PengadaansQuery extends Query
{
    protected $attributes = [
        'name' => 'pengadaans',
        'description' => 'A query to get a list of Pengadaans, optionally filtered by department'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Pengadaan'));
    }

    public function args(): array
    {
        return [
            'departemen' => [
                'name' => 'departemen',
                'type' => Type::string(),
                'description' => 'Filter by department',
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of results',
                'defaultValue' => 10,
            ],
            'offset' => [
                'name' => 'offset',
                'type' => Type::int(),
                'description' => 'Skip the first n results',
                'defaultValue' => 0,
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Pengadaan::query();

        if (isset($args['departemen'])) {
            $query->where('departemen', $args['departemen']);
        }

        return $query->with(['nodinPlos', 'nodinUsers'])
            ->offset($args['offset'])
            ->limit($args['limit'])
            ->get()
            ->each(function ($pengadaan) {
                $pengadaan->nodin_plos = $pengadaan->nodinPlos;
                $pengadaan->nodin_users = $pengadaan->nodinUsers;

                $pengadaan->anggaran_investasi = json_decode($pengadaan->anggaran_investasi);
                $pengadaan->anggaran_eksploitasi = json_decode($pengadaan->anggaran_eksploitasi);
                $pengadaan->hps = json_decode($pengadaan->hps);
                $pengadaan->spk_investasi = json_decode($pengadaan->spk_investasi);
                $pengadaan->spk_eksploitasi = json_decode($pengadaan->spk_eksploitasi);
            });
    }
}

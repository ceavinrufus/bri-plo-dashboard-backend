<?php

namespace App\GraphQL\Queries\DokumenPerjanjian;

use App\Models\DokumenPerjanjian;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenPerjanjiansQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen_perjanjians',
        'description' => 'A query to get a list of Dokumen Perjanjians, optionally filtered by vendor name'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('DokumenPerjanjian'));
    }

    public function args(): array
    {
        return [
            'tim_pemrakarsa' => [
                'name' => 'tim_pemrakarsa',
                'type' => Type::string(),
                'description' => 'Filter by tim pemrakarsa',
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of results',
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
        $query = DokumenPerjanjian::query();

        if (isset($args['tim_pemrakarsa'])) {
            $query->where('tim_pemrakarsa', $args['tim_pemrakarsa']);
        }

        if (isset($args['limit'])) {
            $query->offset($args['offset'])->limit($args['limit']);
        }

        return $query->get()
            ->each(function ($dokumen) {
                $dokumen->spk = json_decode($dokumen->spk);
                $dokumen->pic_legal = json_decode($dokumen->pic_legal);
                $dokumen->pic_pengadaan = json_decode($dokumen->pic_pengadaan);
            });
    }
}

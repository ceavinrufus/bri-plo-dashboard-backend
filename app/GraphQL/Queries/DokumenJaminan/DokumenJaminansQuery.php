<?php

namespace App\GraphQL\Queries\DokumenJaminan;

use App\Models\DokumenJaminan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenJaminansQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumenJaminans',
        'description' => 'A query to get a list of all DokumenJaminans'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('DokumenJaminan'));
    }

    public function args(): array
    {
        return [
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
        return DokumenJaminan::query()
            ->offset($args['offset'])
            ->limit($args['limit'])
            ->get()
            ->each(function ($dokumen) {
                $dokumen->nilai = json_decode($dokumen->nilai);
            });
    }
}

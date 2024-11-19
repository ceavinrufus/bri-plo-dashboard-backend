<?php

namespace App\GraphQL\Queries\Dokumen;

use App\Models\Dokumen;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumensQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumens',
        'description' => 'A query to get a list of Dokumens, optionally filtered by vendor name'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Dokumen'));
    }

    public function args(): array
    {
        return [
            'nama_vendor' => [
                'name' => 'nama_vendor',
                'type' => Type::string(),
                'description' => 'Filter by vendor name',
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
        $query = Dokumen::query();

        if (isset($args['nama_vendor'])) {
            $query->where('nama_vendor', $args['nama_vendor']);
        }

        return $query->offset($args['offset'])
            ->limit($args['limit'])
            ->get();
    }
}

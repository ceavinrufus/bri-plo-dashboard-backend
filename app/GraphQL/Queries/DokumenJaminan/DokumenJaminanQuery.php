<?php

namespace App\GraphQL\Queries\DokumenJaminan;

use App\Models\DokumenJaminan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenJaminanQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen_jaminan',
        'description' => 'A query to get a specific DokumenJaminan by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('DokumenJaminan');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:dokumen_jaminan,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return DokumenJaminan::findOrFail($args['id']);
    }
}

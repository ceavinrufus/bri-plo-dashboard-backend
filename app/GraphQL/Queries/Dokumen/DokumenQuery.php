<?php

namespace App\GraphQL\Queries\Dokumen;

use App\Models\Dokumen;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen',
        'description' => 'A query to get a specific Dokumen by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('Dokumen');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:dokumens,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $dokumen = Dokumen::findOrFail($args['id']);
        return $dokumen;
    }
}

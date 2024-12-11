<?php

namespace App\GraphQL\Queries\DokumenSpk;

use App\Models\DokumenSpk;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenSpkQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen',
        'description' => 'A query to get a specific Dokumen SPK by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('DokumenSpk');
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
        $dokumen = DokumenSpk::findOrFail($args['id']);
        $dokumen->spk = json_decode($dokumen->spk);

        return $dokumen;
    }
}

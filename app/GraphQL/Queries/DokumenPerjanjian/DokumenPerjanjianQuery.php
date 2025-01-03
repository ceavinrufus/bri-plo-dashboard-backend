<?php

namespace App\GraphQL\Queries\DokumenPerjanjian;

use App\Models\DokumenPerjanjian;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenPerjanjianQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen_perjanjian',
        'description' => 'A query to get a specific Dokumen Perjanjian by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('DokumenPerjanjian');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:dokumen_perjanjians,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $dokumen = DokumenPerjanjian::findOrFail($args['id']);
        $dokumen->spk = json_decode($dokumen->spk);
        $dokumen->pic_legal = json_decode($dokumen->pic_legal);
        $dokumen->pic_pengadaan = json_decode($dokumen->pic_pengadaan);

        return $dokumen;
    }
}

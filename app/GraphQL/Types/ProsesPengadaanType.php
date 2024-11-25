<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;


class ProsesPengadaanType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ProsesPengadaan',
        'description' => 'A type that represents a proses pengadaan'
    ];

    public function fields(): array
    {
        return [
            'stage' => [
                'type' => Type::string(),
                'description' => 'The stage of the proses pengadaan'
            ],
            'tanggal' => [
                'type' => Type::string(),
                'description' => 'The date of the proses pengadaan'
            ],
            'document' => [
                'type' => Type::string(),
                'description' => 'The document of the proses pengadaan'
            ],
        ];
    }
}

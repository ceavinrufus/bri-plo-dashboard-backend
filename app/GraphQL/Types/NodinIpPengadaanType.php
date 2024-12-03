<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NodinIpPengadaanType extends GraphQLType
{
    protected $attributes = [
        'name' => 'NodinIpPengadaan',
        'description' => 'A type that represents a NodinIpPengadaan'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the NodinIpPengadaan',
                'rules' => ['required']
            ],
            'nodin' => [
                'type' => Type::string(),
                'description' => 'The nodin',
                'rules' => ['required']
            ],
            'tanggal_nodin' => [
                'type' => Type::string(),
                'description' => 'The date of the nodin',
                'rules' => ['required']
            ],
            'pengadaan' => [
                'type' => GraphQL::type('Pengadaan'),
                'description' => 'The pengadaan of the NodinIpPengadaan',
                'rules' => ['required']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the NodinIpPengadaan',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the NodinIpPengadaan',
                'rules' => ['required']
            ],
        ];
    }
}

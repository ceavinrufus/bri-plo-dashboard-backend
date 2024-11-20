<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;


class PriceType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Price',
        'description' => 'A type that represents a price'
    ];

    public function fields(): array
    {
        return [
            'amount' => [
                'type' => Type::float(),
                'description' => 'The amount of the price'
            ],
            'currency' => [
                'type' => Type::string(),
                'description' => 'The currency of the price'
            ],
            'rate' => [
                'type' => Type::float(),
                'description' => 'The rate of the currency'
            ],
            'tanggal_permohonan' => [
                'type' => Type::string(),
                'description' => 'The request date of the price'
            ],
            'tanggal_terima' => [
                'type' => Type::string(),
                'description' => 'The received date of the price'
            ],
        ];
    }
}

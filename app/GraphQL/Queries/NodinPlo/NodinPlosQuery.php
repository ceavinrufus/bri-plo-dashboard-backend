<?php

namespace App\GraphQL\Queries\NodinPlo;

use App\Models\NodinPlo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NodinPlosQuery extends Query
{
    protected $attributes = [
        'name' => 'nodinPlos',
        'description' => 'A query to get a list of all NodinPlos'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Nodin'));
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
        return NodinPlo::query()
            ->offset($args['offset'])
            ->limit($args['limit'])
            ->get();
    }
}

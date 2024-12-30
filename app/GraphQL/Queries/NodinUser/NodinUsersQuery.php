<?php

namespace App\GraphQL\Queries\NodinUser;

use App\Models\NodinUser;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NodinUsersQuery extends Query
{
    protected $attributes = [
        'name' => 'nodinUsers',
        'description' => 'A query to get a list of all NodinUsers'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('NodinUser'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of results',
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
        $query = NodinUser::query();

        if (isset($args['limit'])) {
            $query->offset($args['offset'])->limit($args['limit']);
        }

        return $query->get();
    }
}

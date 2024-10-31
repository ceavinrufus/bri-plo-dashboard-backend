<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'Fetch a list of users',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'departemen' => [
                'type' => Type::string(),
                'description' => 'Filter users by department',
            ],
            'role' => [
                'type' => Type::boolean(),
                'description' => 'Filter users by role',
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'Limit the number of users returned',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $query = User::query();

        if (isset($args['departemen'])) {
            $query->where('departemen', $args['departemen']);
        }

        if (isset($args['role'])) {
            $query->where('role', $args['role']);
        }

        if (isset($args['limit'])) {
            $query->limit($args['limit']);
        }

        return $query->get();
    }
}

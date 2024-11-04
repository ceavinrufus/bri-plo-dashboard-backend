<?php

namespace App\GraphQL\Queries\NodinUser;

use App\Models\NodinUser;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NodinUserQuery extends Query
{
    protected $attributes = [
        'name' => 'nodinUser',
        'description' => 'A query to get a specific NodinUser by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('NodinUser');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:nodin_plo,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return NodinUser::findOrFail($args['id']);
    }
}

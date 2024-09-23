<?php

namespace App\GraphQL\Queries\NodinPlo;

use App\Models\NodinPlo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NodinPloQuery extends Query
{
    protected $attributes = [
        'name' => 'nodinPlo',
        'description' => 'A query to get a specific NodinPlo by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('NodinPlo');
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
        return NodinPlo::findOrFail($args['id']);
    }
}

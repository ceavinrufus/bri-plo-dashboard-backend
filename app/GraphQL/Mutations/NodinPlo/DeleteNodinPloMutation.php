<?php

namespace App\GraphQL\Mutations\NodinPlo;

use App\Models\NodinPlo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteNodinPloMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteNodinPlo',
        'description' => 'A mutation to delete a NodinPlo'
    ];

    public function type(): Type
    {
        return Type::boolean(); // Return true if deletion is successful
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the NodinPlo to delete',
                'rules' => ['required', 'exists:nodin_plos,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $nodinPlo = NodinPlo::findOrFail($args['id']);
        return $nodinPlo->delete();
    }
}

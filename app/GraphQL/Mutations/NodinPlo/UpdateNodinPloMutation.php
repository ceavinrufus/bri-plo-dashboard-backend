<?php

namespace App\GraphQL\Mutations\NodinPlo;

use App\Models\NodinPlo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Arr;

class UpdateNodinPloMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateNodinPlo',
        'description' => 'A mutation to update a NodinPlo'
    ];

    public function type(): Type
    {
        return GraphQL::type('NodinPlo');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the NodinPlo to update',
                'rules' => ['required', 'exists:nodin_plos,id']
            ],
            'nodin' => [
                'type' => Type::string(),
                'description' => 'The nodin'
            ],
            'tanggal_nodin' => [
                'type' => Type::string(),
                'description' => 'The date of the nodin'
            ],
            'pengadaan_id' => [
                'type' => Type::id(),
                'description' => 'The ID of the Pengadaan'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $nodinPlo = NodinPlo::findOrFail($args['id']);
        $nodinPlo->update(Arr::only($args, ['nodin', 'tanggal_nodin', 'pengadaan_id']));

        return $nodinPlo;
    }
}

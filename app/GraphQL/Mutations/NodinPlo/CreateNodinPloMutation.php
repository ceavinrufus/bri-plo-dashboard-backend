<?php

namespace App\GraphQL\Mutations\NodinPlo;

use App\Models\NodinPlo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Arr;

class CreateNodinPloMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createNodinPlo',
        'description' => 'A mutation to create a new NodinPlo'
    ];

    public function type(): Type
    {
        return GraphQL::type('NodinPlo');
    }

    public function args(): array
    {
        return [
            'nodin' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The nodin',
                'rules' => ['required']
            ],
            'tanggal_nodin' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The date of the nodin',
                'rules' => ['required']
            ],
            'pengadaan_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Pengadaan',
                'rules' => ['required', 'exists:pengadaans,id']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return NodinPlo::create(Arr::only($args, ['nodin', 'tanggal_nodin', 'pengadaan_id']));
    }
}

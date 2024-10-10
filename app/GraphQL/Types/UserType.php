<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the user',
            ],
            'pn' => [
                'type' => Type::string(),
                'description' => 'The personal number of the user',
            ],
            'departemen' => [
                'type' => Type::string(),
                'description' => 'The department of the user',
            ],
            'is_maker' => [
                'type' => Type::boolean(),
                'description' => 'Whether the user is a maker',
            ],
            'pengadaans' => [
                'type' => Type::listOf(GraphQL::type('Pengadaan')),
                'description' => 'List of pengadaan of the User'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the user',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the user',
            ],
        ];
    }
}

<?php

namespace App\GraphQL\Types;

use App\Models\NodinUser;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NodinUserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'NodinUser',
        'description' => 'A type that represents a NodinUser',
        'model' => NodinUser::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the NodinUser',
                'rules' => ['required']
            ],
            'nodin' => [
                'type' => Type::string(),
                'description' => 'The nodin',
                'rules' => ['required']
            ],
            'tanggal_nodin' => [
                'type' => Type::string(),
                'description' => 'The date of the nodin',
                'rules' => ['required']
            ],
            'pengadaan' => [
                'type' => GraphQL::type('Pengadaan'),
                'description' => 'The pengadaan of the NodinUser',
                'rules' => ['required']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the NodinUser',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the NodinUser',
                'rules' => ['required']
            ],
        ];
    }
}

<?php

namespace App\GraphQL\Mutations\Pengadaan;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeletePengadaanMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePengadaan',
        'description' => 'A mutation to delete a Pengadaan'
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
                'description' => 'The ID of the Pengadaan to delete',
                'rules' => ['required', 'exists:pengadaan,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $pengadaan = Pengadaan::findOrFail($args['id']);
        return $pengadaan->delete();
    }
}

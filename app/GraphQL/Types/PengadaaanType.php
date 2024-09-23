<?php

namespace App\GraphQL\Types;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;


class PengadaanType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Pengadaan',
        'description' => 'A type that represents a Pengadaan',
        'model' => Pengadaan::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Pengadaan',
                'rules' => ['required']
            ],
            'kode_user' => [
                'type' => Type::string(),
                'description' => 'The user code',
                'rules' => ['required']
            ],
            'nodin_user' => [
                'type' => Type::string(),
                'description' => 'The nodin user'
            ],
            'tanggal_nodin_user' => [
                'type' => Type::string(),
                'description' => 'The nodin user date'
            ],
            'departemen' => [
                'type' => Type::string(),
                'description' => 'The department',
                'rules' => ['required']
            ],
            'perihal' => [
                'type' => Type::string(),
                'description' => 'The subject',
                'rules' => ['required']
            ],
            'tanggal_spk' => [
                'type' => Type::string(),
                'description' => 'The SPK date'
            ],
            'metode' => [
                'type' => Type::string(),
                'description' => 'The method'
            ],
            'is_verification_complete' => [
                'type' => Type::boolean(),
                'description' => 'Is verification complete'
            ],
            'is_done' => [
                'type' => Type::boolean(),
                'description' => 'Is done'
            ],
            'proses_pengadaan' => [
                'type' => Type::string(),
                'description' => 'The procurement process'
            ],
            'nilai_spk' => [
                'type' => Type::int(),
                'description' => 'The SPK value'
            ],
            'nodin_plos' => [
                'type' => Type::listOf(GraphQL::type('NodinPlo')),
                'description' => 'List of nodin plos of the Pengadaan'
            ],
            'anggaran' => [
                'type' => Type::int(),
                'description' => 'The budget'
            ],
            'hps' => [
                'type' => Type::int(),
                'description' => 'The HPS'
            ],
            'tkdn_percentage' => [
                'type' => Type::int(),
                'description' => 'The TKDN percentage'
            ],
            'catatan' => [
                'type' => Type::string(),
                'description' => 'The notes'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the Pengadaan',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the Pengadaan',
                'rules' => ['required']
            ],
        ];
    }
}

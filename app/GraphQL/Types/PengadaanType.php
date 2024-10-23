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
            'tim' => [
                'type' => Type::string(),
                'description' => 'The team',
                'rules' => ['required']
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
            'metode' => [
                'type' => Type::string(),
                'description' => 'The method'
            ],
            'is_verification_complete' => [
                'type' => Type::boolean(),
                'description' => 'Is verification complete'
            ],
            'verification_alert_at' => [
                'type' => Type::string(),
                'description' => 'Verification alert date',
            ],
            'nodin_alert_at' => [
                'type' => Type::string(),
                'description' => 'Nodin alert date',
            ],
            'pic' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the PIC',
                'rules' => ['required', 'exists:users,id']
            ],
            'proses_pengadaan' => [
                'type' => Type::string(),
                'description' => 'The procurement process'
            ],
            'nomor_spk' => [
                'type' => Type::string(),
                'description' => 'The SPK number'
            ],
            'tanggal_spk' => [
                'type' => Type::string(),
                'description' => 'The SPK date'
            ],
            'pelaksana_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The job performer'
            ],
            'nilai_spk' => [
                'type' => Type::float(),
                'description' => 'The SPK value'
            ],
            'nodin_plos' => [
                'type' => Type::listOf(GraphQL::type('NodinPlo')),
                'description' => 'List of nodin plos of the Pengadaan'
            ],
            'anggaran' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The budget'
            ],
            'hps' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The HPS'
            ],
            'tkdn_percentage' => [
                'type' => Type::float(),
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

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
            'nodin_users' => [
                'type' => Type::listOf(GraphQL::type('NodinUser')),
                'description' => 'List of nodin users of the Pengadaan'
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
            'proyek' => [
                'type' => Type::string(),
                'description' => 'The project code',
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
            'tanggal_acuan' => [
                'type' => Type::string(),
                'description' => 'The reference date'
            ],
            'pelaksana_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The job performer'
            ],
            'spk_investasi' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The SPK'
            ],
            'spk_eksploitasi' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The SPK'
            ],
            'nodin_plos' => [
                'type' => Type::listOf(GraphQL::type('NodinPlo')),
                'description' => 'List of nodin plos of the Pengadaan'
            ],
            'anggaran_investasi' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The budget'
            ],
            'anggaran_eksploitasi' => [
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

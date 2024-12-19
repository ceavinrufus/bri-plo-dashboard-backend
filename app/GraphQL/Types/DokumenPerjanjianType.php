<?php

namespace App\GraphQL\Types;

use App\Models\DokumenPerjanjian;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DokumenPerjanjianType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DokumenPerjanjian',
        'description' => 'A type that represents a Dokumen Perjanjian',
        'model' => DokumenPerjanjian::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Dokumen Perjanjian',
                'rules' => ['required']
            ],
            'tanggal_permohonan_diterima' => [
                'type' => Type::string(),
                'description' => 'The date the SPK was received',
                'rules' => ['required']
            ],
            'tim_pemrakarsa' => [
                'type' => Type::string(),
                'description' => 'The initiating team',
                'rules' => ['required']
            ],
            'pic_pengadaan' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the procurement PIC',
                'rules' => ['required', 'exists:users,id']
            ],
            'nomor_spk' => [
                'type' => Type::string(),
                'description' => 'The SPK number',
                'rules' => ['required']
            ],
            'tanggal_spk' => [
                'type' => Type::string(),
                'description' => 'The SPK date',
                'rules' => ['required']
            ],
            'jenis_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The type of work',
                'rules' => ['required']
            ],
            'spk' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The SPK details',
                'rules' => ['required']
            ],
            'jangka_waktu' => [
                'type' => Type::int(),
                'description' => 'The duration',
                'rules' => ['required']
            ],
            'pelaksana_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The executor of the work',
                'rules' => ['required']
            ],
            'pic_pelaksana_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The PIC of the executor of the work',
                'rules' => ['required']
            ],
            'nomor_kontrak' => [
                'type' => Type::string(),
                'description' => 'The Kontrak number',
                'rules' => ['required']
            ],
            'tanggal_kontrak' => [
                'type' => Type::string(),
                'description' => 'The Kontrak date',
                'rules' => ['required']
            ],
            'pic_legal' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the legal PIC',
                'rules' => ['required', 'exists:users,id']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the Dokumen Perjanjian',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the Dokumen Perjanjian',
                'rules' => ['required']
            ],
        ];
    }
}

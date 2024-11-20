<?php

namespace App\GraphQL\Types;

use App\Models\Dokumen;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DokumenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Dokumen',
        'description' => 'A type that represents a Dokumen',
        'model' => Dokumen::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Dokumen',
                'rules' => ['required']
            ],
            'perihal' => [
                'type' => Type::string(),
                'description' => 'The subject',
                'rules' => ['required']
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
            'nama_vendor' => [
                'type' => Type::string(),
                'description' => 'The vendor name',
                'rules' => ['required']
            ],
            'pic' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the PIC',
                'rules' => ['required', 'exists:users,id']
            ],
            'sla_spk_sejak_terbit' => [
                'type' => Type::int(),
                'description' => 'SLA SPK since issuance',
                'rules' => ['required']
            ],
            'sla_spk_sejak_diambil' => [
                'type' => Type::int(),
                'description' => 'SLA SPK since taken',
                'rules' => ['required']
            ],
            'tanggal' => [
                'type' => Type::string(),
                'description' => 'The date',
                'rules' => ['required']
            ],
            'jangka_waktu' => [
                'type' => Type::int(),
                'description' => 'The duration',
                'rules' => ['required']
            ],
            'tim' => [
                'type' => Type::string(),
                'description' => 'The team',
                'rules' => ['required']
            ],
            'spk' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The SPK',
                'rules' => ['required']
            ],
            'identitas_vendor' => [
                'type' => Type::string(),
                'description' => 'The vendor identity',
                'rules' => ['required']
            ],
            'info_vendor' => [
                'type' => Type::string(),
                'description' => 'The vendor information',
                'rules' => ['required']
            ],
            'tanggal_pengambilan' => [
                'type' => Type::string(),
                'description' => 'The retrieval date',
                'rules' => ['required']
            ],
            'identitas_pengambil' => [
                'type' => Type::string(),
                'description' => 'The retriever identity',
                'rules' => ['required']
            ],
            'tanggal_pengembalian' => [
                'type' => Type::string(),
                'description' => 'The return date',
                'rules' => ['required']
            ],
            'tanggal_jatuh_tempo' => [
                'type' => Type::string(),
                'description' => 'The due date',
                'rules' => ['required']
            ],
            'catatan' => [
                'type' => Type::string(),
                'description' => 'The notes',
                'rules' => ['required']
            ],
            'form_tkdn' => [
                'type' => Type::boolean(),
                'description' => 'The TKDN form',
                'rules' => ['required']
            ],
            'tanggal_penyerahan_dokumen' => [
                'type' => Type::string(),
                'description' => 'The document submission date',
                'rules' => ['required']
            ],
            'penerima_dokumen' => [
                'type' => Type::string(),
                'description' => 'The document recipient',
                'rules' => ['required']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the Dokumen',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the Dokumen',
                'rules' => ['required']
            ],
        ];
    }
}

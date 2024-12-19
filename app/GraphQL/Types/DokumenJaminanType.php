<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DokumenJaminanType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DokumenJaminan',
        'description' => 'A type that represents a DokumenJaminan'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the DokumenJaminan',
                'rules' => ['required']
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'The type of the DokumenJaminan',
                'rules' => ['required']
            ],
            'tanggal_diterima' => [
                'type' => Type::string(),
                'description' => 'The received date of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'penerbit' => [
                'type' => Type::string(),
                'description' => 'The penerbit of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'nomor_jaminan' => [
                'type' => Type::string(),
                'description' => 'The guarantee number of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'dokumen_keabsahan' => [
                'type' => Type::string(),
                'description' => 'The validity document of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'nilai' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The value of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'waktu_mulai' => [
                'type' => Type::string(),
                'description' => 'The start time of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'waktu_berakhir' => [
                'type' => Type::string(),
                'description' => 'The end time of the DokumenJaminan',
                'rules' => ['nullable']
            ],
            'dokumen_spk' => [
                'type' => GraphQL::type('DokumenSpk'),
                'description' => 'The dokumen SPK of the DokumenJaminan',
                'rules' => ['required']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the DokumenJaminan',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the DokumenJaminan',
                'rules' => ['required']
            ],
        ];
    }
}

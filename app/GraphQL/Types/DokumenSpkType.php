<?php

namespace App\GraphQL\Types;

use App\Models\DokumenSpk;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DokumenSpkType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DokumenSpk',
        'description' => 'A type that represents a Dokumen SPK',
        'model' => DokumenSpk::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Dokumen SPK',
                'rules' => ['required']
            ],
            'tanggal_spk_diterima' => [
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
            'dokumen_pelengkap' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The supporting documents',
                'rules' => ['required']
            ],
            'tanggal_info_ke_vendor' => [
                'type' => Type::string(),
                'description' => 'Information to the vendor',
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
            'dokumen_yang_dikembalikan' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The returned documents',
                'rules' => ['required']
            ],
            'tkdn_percentage' => [
                'type' => Type::float(),
                'description' => 'The TKDN percentage',
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
            'pic_legal' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the legal PIC',
                'rules' => ['required', 'exists:users,id']
            ],
            'catatan' => [
                'type' => Type::string(),
                'description' => 'The notes',
                'rules' => ['required']
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the Dokumen SPK',
                'rules' => ['required']
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The last update date of the Dokumen SPK',
                'rules' => ['required']
            ],
        ];
    }
}

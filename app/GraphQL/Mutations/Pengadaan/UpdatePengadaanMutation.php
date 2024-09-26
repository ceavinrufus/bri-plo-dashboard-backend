<?php

namespace App\GraphQL\Mutations\Pengadaan;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Arr;

class UpdatePengadaanMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePengadaan',
        'description' => 'A mutation to update a Pengadaan'
    ];

    public function type(): Type
    {
        return GraphQL::type('Pengadaan');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Pengadaan to update',
                'rules' => ['required', 'exists:pengadaan,id']
            ],
            'kode_user' => [
                'type' => Type::string(),
                'description' => 'The user code'
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
                'description' => 'The team'
            ],
            'departemen' => [
                'type' => Type::string(),
                'description' => 'The department'
            ],
            'perihal' => [
                'type' => Type::string(),
                'description' => 'The subject'
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
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $pengadaan = Pengadaan::findOrFail($args['id']);
        $pengadaan->update(Arr::only($args, [
            'kode_user',
            'nodin_user',
            'tanggal_nodin_user',
            'departemen',
            'perihal',
            'tanggal_spk',
            'metode',
            'is_verification_complete',
            'is_done',
            'proses_pengadaan',
            'nilai_spk',
            'anggaran',
            'hps',
            'tkdn_percentage',
            'catatan'
        ]));

        return $pengadaan;
    }
}
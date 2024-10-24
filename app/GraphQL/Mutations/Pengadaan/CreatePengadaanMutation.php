<?php

namespace App\GraphQL\Mutations\Pengadaan;

use App\Models\Pengadaan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Arr;

class CreatePengadaanMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPengadaan',
        'description' => 'A mutation to create a new Pengadaan'
    ];

    public function type(): Type
    {
        return GraphQL::type('Pengadaan');
    }

    public function args(): array
    {
        return [
            'kode_user' => [
                'type' => Type::nonNull(Type::string()),
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
                'type' => Type::nonNull(Type::string()),
                'description' => 'The team',
                'rules' => ['required']
            ],
            'departemen' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The department',
                'rules' => ['required']
            ],
            'proyek' => [
                'type' => Type::string(),
                'description' => 'The project code',
            ],
            'perihal' => [
                'type' => Type::nonNull(Type::string()),
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
                'rules' => ['nullable', 'date']
            ],
            'nodin_alert_at' => [
                'type' => Type::string(),
                'description' => 'Nodin alert date',
                'rules' => ['nullable', 'date']
            ],
            'pic_id' => [
                'type' => Type::nonNull(Type::id()),
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
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return Pengadaan::create(Arr::only($args, [
            'kode_user',
            'nodin_user',
            'tanggal_nodin_user',
            'departemen',
            'perihal',
            'metode',
            'is_verification_complete',
            'verification_alert_at',
            'nodin_alert_at',
            'pic_id',
            'proses_pengadaan',
            'nomor_spk',
            'tanggal_spk',
            'pelaksana_pekerjaan',
            'nilai_spk',
            'anggaran',
            'hps',
            'tkdn_percentage',
            'catatan'
        ]));
    }
}

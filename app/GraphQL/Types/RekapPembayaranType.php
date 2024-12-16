<?php

namespace App\GraphQL\Types;

use App\Models\RekapPembayaran;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RekapPembayaranType extends GraphQLType
{
    protected $attributes = [
        'name' => 'RekapPembayaran',
        'description' => 'A type that represents a Rekap Pembayaran',
        'model' => RekapPembayaran::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the Rekap Pembayaran',
                'rules' => ['required']
            ],
            'pic_pc' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the PIC PC',
                'rules' => ['required', 'exists:users,id']
            ],
            'tanggal_terima' => [
                'type' => Type::string(),
                'description' => 'The date received',
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
            'nomor_perjanjian' => [
                'type' => Type::string(),
                'description' => 'The agreement number',
                'rules' => ['required']
            ],
            'tanggal_perjanjian' => [
                'type' => Type::string(),
                'description' => 'The agreement date',
                'rules' => ['required']
            ],
            'perihal' => [
                'type' => Type::string(),
                'description' => 'The subject',
                'rules' => ['required']
            ],
            'spk' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The SPK details',
                'rules' => ['required']
            ],
            'pelaksana_pekerjaan' => [
                'type' => Type::string(),
                'description' => 'The executor of the work',
                'rules' => ['required']
            ],
            'tkdn' => [
                'type' => Type::float(),
                'description' => 'The TKDN percentage',
                'rules' => ['required']
            ],
            'nomor_invoice' => [
                'type' => Type::string(),
                'description' => 'The invoice number',
                'rules' => ['required']
            ],
            'invoice' => [
                'type' => GraphQL::type('Price'),
                'description' => 'The invoice details',
                'rules' => ['required']
            ],
            'nomor_rekening' => [
                'type' => Type::string(),
                'description' => 'The account number',
                'rules' => ['required']
            ],
            'pic_pay' => [
                'type' => GraphQL::type('User'),
                'description' => 'The ID of the PIC Pay',
                'rules' => ['required', 'exists:users,id']
            ],
            'nota_fiat' => [
                'type' => Type::string(),
                'description' => 'The fiat note',
                'rules' => ['required']
            ],
            'tanggal_fiat' => [
                'type' => Type::string(),
                'description' => 'The fiat date',
                'rules' => ['required']
            ],
            'sla' => [
                'type' => Type::string(),
                'description' => 'The SLA',
                'rules' => ['required']
            ],
            'hari_pengerjaan' => [
                'type' => Type::int(),
                'description' => 'The working days',
                'rules' => ['required']
            ],
            'status_pembayaran' => [
                'type' => Type::string(),
                'description' => 'The payment status',
                'rules' => ['required']
            ],
            'tanggal_pembayaran' => [
                'type' => Type::string(),
                'description' => 'The payment date',
                'rules' => ['required']
            ],
            'keterangan' => [
                'type' => Type::string(),
                'description' => 'The remarks',
                'rules' => ['required']
            ],
        ];
    }
}

<?php

namespace App\GraphQL\Queries\RekapPembayaran;

use App\Models\RekapPembayaran;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class RekapPembayaranQuery extends Query
{
    protected $attributes = [
        'name' => 'rekap_pembayaran',
        'description' => 'A query to get a specific Rekap Pembayaran by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('RekapPembayaran');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:rekap_pembayarans,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $rekapPembayaran = RekapPembayaran::findOrFail($args['id']);
        $rekapPembayaran->spk = json_decode($rekapPembayaran->spk);
        $rekapPembayaran->invoice = json_decode($rekapPembayaran->invoice);

        return $rekapPembayaran;
    }
}

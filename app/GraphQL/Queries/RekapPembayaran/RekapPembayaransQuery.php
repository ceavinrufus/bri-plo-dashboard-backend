<?php

namespace App\GraphQL\Queries\RekapPembayaran;

use App\Models\RekapPembayaran;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class RekapPembayaransQuery extends Query
{
    protected $attributes = [
        'name' => 'rekap_pembayarans',
        'description' => 'A query to get a list of Rekap Pembayarans'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('RekapPembayaran'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of results',
            ],
            'offset' => [
                'name' => 'offset',
                'type' => Type::int(),
                'description' => 'Skip the first n results',
                'defaultValue' => 0,
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $query = RekapPembayaran::query();

        if (isset($args['limit'])) {
            $query->offset($args['offset'])->limit($args['limit']);
        }

        return $query->get()
            ->each(function ($rekapPembayaran) {
                $rekapPembayaran->spk = json_decode($rekapPembayaran->spk);
                $rekapPembayaran->invoice = json_decode($rekapPembayaran->invoice);
            });
    }
}

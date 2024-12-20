<?php

namespace App\GraphQL\Queries\DokumenSpk;

use App\Models\DokumenSpk;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenSpksQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen_spks',
        'description' => 'A query to get a list of Dokumen SPKs, optionally filtered by tim pemrakarsa'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('DokumenSpk'));
    }

    public function args(): array
    {
        return [
            'tim_pemrakarsa' => [
                'name' => 'tim_pemrakarsa',
                'type' => Type::string(),
                'description' => 'Filter by tim pemrakarsa',
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of results',
                'defaultValue' => 10,
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
        $query = DokumenSpk::query();

        if (isset($args['tim_pemrakarsa'])) {
            $query->where('tim_pemrakarsa', $args['tim_pemrakarsa']);
        }

        return $query->with(['dokumenJaminans'])
            ->offset($args['offset'])
            ->limit($args['limit'])
            ->get()
            ->each(function ($dokumen) {
                $dokumen->spk = json_decode($dokumen->spk);
                $dokumen->pic_legal = json_decode($dokumen->pic_legal);
                $dokumen->pic_pengadaan = json_decode($dokumen->pic_pengadaan);
                $dokumen->dokumen_pelengkap = json_decode($dokumen->dokumen_pelengkap);
                $dokumen->dokumen_yang_dikembalikan = json_decode($dokumen->dokumen_yang_dikembalikan);
                $dokumen->dokumen_jaminans = $dokumen->dokumenJaminans->map(function ($jaminan) {
                    $jaminan->nilai = json_decode($jaminan->nilai);
                    return $jaminan;
                });
            });
    }
}

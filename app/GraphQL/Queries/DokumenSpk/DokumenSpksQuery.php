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
        'description' => 'A query to get a list of Dokumen SPKs, optionally filtered by tim pemrakarsa or department',
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
            'department' => [
                'name' => 'department',
                'type' => Type::string(),
                'description' => 'Filter by department',
            ],
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
        $query = DokumenSpk::query();

        // Filter by tim_pemrakarsa
        if (isset($args['tim_pemrakarsa'])) {
            $query->where('tim_pemrakarsa', $args['tim_pemrakarsa']);
        }

        // Filter by department
        if (isset($args['department'])) {
            if ($args['department'] === 'bcp') {
                $query->whereIn('tim_pemrakarsa', ['bcd', 'bcr']);
            } elseif ($args['department'] === 'igp') {
                $query->whereIn('tim_pemrakarsa', ['pts', 'ptg', 'ptt']);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Apply limit and offset if provided
        if (isset($args['limit'])) {
            $query->offset($args['offset'])->limit($args['limit']);
        }

        // Process and return the data
        return $query->with(['dokumenJaminans'])
            ->get()
            ->each(function ($dokumen) {
                $dokumen->spk = json_decode($dokumen->spk);
                $dokumen->pic_legal = json_decode($dokumen->pic_legal);
                $dokumen->pic_pengadaan = json_decode($dokumen->pic_pengadaan);
                $dokumen->dokumen_pelengkap = json_decode($dokumen->dokumen_pelengkap);
                $dokumen->dokumen_yang_dikembalikan = json_decode($dokumen->dokumen_yang_dikembalikan);
                $dokumen->jatuh_tempos = json_decode($dokumen->jatuhTempos);
                $dokumen->dokumen_jaminans = $dokumen->dokumenJaminans->map(function ($jaminan) {
                    $jaminan->nilai = json_decode($jaminan->nilai);
                    return $jaminan;
                });
            });
    }
}

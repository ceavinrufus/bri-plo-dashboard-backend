<?php

namespace App\GraphQL\Queries\DokumenSpk;

use App\Models\DokumenSpk;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class DokumenSpkQuery extends Query
{
    protected $attributes = [
        'name' => 'dokumen_spk',
        'description' => 'A query to get a specific Dokumen SPK by ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('DokumenSpk');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'rules' => ['required', 'exists:dokumen_spks,id']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $dokumen = DokumenSpk::with(['dokumenJaminans'])->findOrFail($args['id']);
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

        return $dokumen;
    }
}

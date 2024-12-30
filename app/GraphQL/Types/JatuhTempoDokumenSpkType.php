<?php

namespace App\GraphQL\Types;

use App\Models\JatuhTempoDokumenSpk;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JatuhTempoDokumenSpkType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JatuhTempoDokumenSpk',
        'description' => 'A type for JatuhTempoDokumenSpk',
        'model' => JatuhTempoDokumenSpk::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the Jatuh Tempo Dokumen SPK'
            ],
            'keterangan' => [
                'type' => Type::string(),
                'description' => 'The keterangan of the Jatuh Tempo Dokumen SPK'
            ],
            'tanggal_mulai' => [
                'type' => Type::string(),
                'description' => 'The start date of the Jatuh Tempo Dokumen SPK'
            ],
            'tanggal_akhir' => [
                'type' => Type::string(),
                'description' => 'The end date of the Jatuh Tempo Dokumen SPK'
            ],
        ];
    }
}

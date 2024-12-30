<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JatuhTempoDokumenSpk extends Model
{
    use HasFactory;

    protected $fillable = [
        'keterangan', // String
        'tanggal_mulai', // Date
        'tanggal_akhir', // Date
    ];

    public function dokumenSpk(): BelongsTo
    {
        return $this->belongsTo(DokumenSpk::class);
    }
}

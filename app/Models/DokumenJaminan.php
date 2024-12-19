<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenJaminan extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'tanggal_diterima',
        'penerbit',
        'nomor_jaminan',
        'dokumen_keabsahan',
        'nilai',
        'waktu_mulai',
        'waktu_berakhir',
    ];

    public function dokumen_spk(): BelongsTo
    {
        return $this->belongsTo(DokumenSpk::class);
    }
}

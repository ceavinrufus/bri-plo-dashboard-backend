<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NodinPlo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nodin',
        'tanggal_nodin',
        'pengadaan_id',
    ];

    public function pengadaan(): BelongsTo
    {
        return $this->belongsTo(Pengadaan::class);
    }
}

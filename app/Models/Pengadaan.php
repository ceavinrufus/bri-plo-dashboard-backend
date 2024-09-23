<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_user',
        'nodin_user',
        'tanggal_nodin_user',
        'departemen',
        'perihal',
        'tanggal_spk',
        'metode',
        'is_verification_complete',
        'is_done',
        'proses_pengadaan',
        'nilai_spk',
        'anggaran',
        'hps',
        'tkdn_percentage',
        'catatan',
    ];

    public function nodinPlos(): HasMany
    {
        return $this->hasMany(NodinPlo::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }
}

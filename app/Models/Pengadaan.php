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
        'tim',
        'departemen',
        'perihal',
        'metode',
        'is_verification_complete',
        'verification_alert_at',
        'nodin_alert_at',
        'is_done',
        'proses_pengadaan',
        'nomor_spk',
        'tanggal_spk',
        'pelaku_pekerjaan',
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

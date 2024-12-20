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
        'tim',
        'departemen',
        'proyek',
        'perihal',
        'metode',
        'verification_completed_at',
        'verification_alert_at',
        'nodin_alert_at',
        'pic_id',
        'proses_pengadaan',
        'pengadaan_log',
        'nomor_spk',
        'tanggal_spk',
        'tanggal_acuan',
        'pelaksana_pekerjaan',
        'spk_investasi',
        'spk_eksploitasi',
        'anggaran_investasi',
        'anggaran_eksploitasi',
        'hps',
        'tkdn_percentage',
        'catatan',
    ];

    protected $casts = [
        'pengadaan_log' => 'array',
    ];

    public function nodinPlos(): HasMany
    {
        return $this->hasMany(NodinPlo::class);
    }

    public function nodinUsers(): HasMany
    {
        return $this->hasMany(NodinUser::class);
    }

    public function nodinIpPengadaans(): HasMany
    {
        return $this->hasMany(NodinIpPengadaan::class);
    }

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'departemen', 'code');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'proyek', 'kode');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id', 'id');
    }
}

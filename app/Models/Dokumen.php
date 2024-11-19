<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'perihal',
        'nomor_spk',
        'tanggal_spk',
        'nama_vendor',
        'pic_id',
        'sla_spk_sejak_terbit',
        'sla_spk_sejak_diambil',
        'tanggal',
        'jangka_waktu',
        'tim',
        'nilai_spk',
        'identitas_vendor',
        'info_vendor',
        'tanggal_pengambilan',
        'identitas_pengambil',
        'tanggal_pengembalian',
        'tanggal_jatuh_tempo',
        'catatan',
        'form_tkdn',
        'tanggal_penyerahan_dokumen',
        'penerima_dokumen'
    ];

    protected $casts = [
        'tanggal_spk' => 'date',
        'tanggal' => 'date',
        'tanggal_pengambilan' => 'date',
        'tanggal_pengembalian' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_penyerahan_dokumen' => 'date',
    ];

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id', 'id');
    }
}

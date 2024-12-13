<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenSpk extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_spk_diterima',
        'tim_pemrakarsa',
        'pic_pengadaan_id',
        'nomor_spk',
        'tanggal_spk',
        'jenis_pekerjaan',
        'spk', // JSON: PriceType in GraphQL
        'jangka_waktu',
        'pelaksana_pekerjaan', // JSON: Nama, Alamat, No Telp
        'pic_pelaksana_pekerjaan', // JSON: Nama, No HP
        'dokumen_pelengkap', // Array
        'tanggal_info_ke_vendor', // Tanggal
        'tanggal_pengambilan',
        'identitas_pengambil',
        'tanggal_pengembalian',
        'dokumen_yang_dikembalikan', // Array
        'tkdn_percentage',
        'tanggal_penyerahan_dokumen',
        'penerima_dokumen',
        'pic_legal_id',
        'catatan'
    ];

    protected $casts = [
        // 'tanggal_spk' => 'date',
        // 'tanggal_info_ke_vendor' => 'date',
        // 'tanggal_spk_diterima' => 'date',
        // 'tanggal_pengambilan' => 'date',
        // 'tanggal_pengembalian' => 'date',
        // 'tanggal_penyerahan_dokumen' => 'date',
    ];

    public function pic_legal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_legal_id', 'id');
    }

    public function pic_pengadaan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_pengadaan_id', 'id');
    }
}

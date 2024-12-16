<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_pc_id',
        'tanggal_terima',
        'nomor_spk',
        'tanggal_spk',
        'nomor_perjanjian',
        'tanggal_perjanjian',
        'perihal',
        'spk', // JSON: PriceType in GraphQL
        'vendor',
        'tkdn',
        'nomor_invoice',
        'invoice', // JSON: PriceType in GraphQL
        'nomor_rekening',
        'pic_pay_id',
        'nota_fiat',
        'tanggal_fiat',
        'sla',
        'hari_pengerjaan',
        'status_pembayaran',
        'tanggal_pembayaran',
        'keterangan'
    ];

    protected $casts = [
        'spk' => 'json',
        'invoice' => 'json',
    ];

    public function pic_pc(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_pc_id', 'id');
    }

    public function pic_pay(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_pay_id', 'id');
    }
}

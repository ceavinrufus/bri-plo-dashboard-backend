<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'departemen',
        'nama_pengadaan',
        'tanggal_nodin',
        'tanggal_spk',
        'hari_pengerjaan',
        'metode',
        'progres',
        'hari_proses',
        'progres_pengadaan',
    ];
}

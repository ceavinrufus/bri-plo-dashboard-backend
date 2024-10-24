<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode',
        'nama',
        'jenis',
    ];

    // Define the relationship: a Project has many Pengadaan
    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'proyek', 'kode');
    }
}

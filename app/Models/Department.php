<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // The primary key is not an integer, so we define it
    protected $primaryKey = 'code';

    // Disable auto-increment since the primary key is a string
    public $incrementing = false;

    // The primary key is a string, so we set this property
    protected $keyType = 'string';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'code',
        'name',
        'target',
    ];

    // Define the relationship: a Department has many Pengadaan
    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'departemen', 'code');
    }

    // Define the relationship: a Department has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'departemen', 'code');
    }
}

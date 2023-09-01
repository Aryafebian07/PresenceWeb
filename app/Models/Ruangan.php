<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode',
        'nama',
    ];

    public function pertemuans()
    {
        return $this->hasMany(Pertemuan::class);
    }
}

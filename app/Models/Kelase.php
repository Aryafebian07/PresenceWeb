<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kelase extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'angkatan',
        'prodi_id',
        'dosen_id',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Matkul extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'prodi_id',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}

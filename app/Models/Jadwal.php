<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Jadwal extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'tahun_ajar',
        'semester',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'total_pertemuan',
        'dosen_id',
        'kelase_id',
        'matkul_id',
    ];
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
    public function kelase()
    {
        return $this->belongsTo(Kelase::class);
    }
    public function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }
    public function pertemuans()
    {
        return $this->hasMany(Pertemuan::class);
    }
}

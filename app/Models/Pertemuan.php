<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Pertemuan extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'status',
        'ke',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'jadwal_id',
        'materi',
        'jenis_pertemuan',
        'metode_belajar',
        'ruangan_id',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}

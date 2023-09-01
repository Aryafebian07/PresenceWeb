<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Absensi extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'nim',
        'long',
        'lat',
        'imei',
        'mahasiswa_id',
        'pertemuan_id',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}

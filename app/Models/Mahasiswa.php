<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Mahasiswa extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'email',
        'nim',
        'angkatan',
        'sistem_kuliah',
        'gender',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'berat_badan',
        'tinggi_badan',
        'golongan_darah',
        'alamat',
        'nohp',
        'notelp',
        'status',
        'prodi_id',
        'kelase_id',
        'user_id',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelase()
    {
        return $this->belongsTo(Kelase::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}

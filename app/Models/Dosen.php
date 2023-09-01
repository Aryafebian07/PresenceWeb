<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Dosen extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'email',
        'nidn',
        'nip',
        'gender',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'sik',
        'alamat',
        'jabatan',
        'nohp',
        'notelp',
        'status',
        'prodi_id',
        'user_id'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelases()
    {
        return $this->hasMany(Kelase::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
/**
 * @property int $id
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class Prodi extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'kode',
        'nama',
        'jenjang',
        'akreditasi',
        'tanggal_berdiri',
        'deskripsi',
        'misi',
        'visi',
        'kompetensi',
        'status',
    ];

    public function matkuls()
    {
        return $this->hasMany(Matkul::class);
    }

    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function kelases()
    {
        return $this->hasMany(Kelase::class);
    }
}

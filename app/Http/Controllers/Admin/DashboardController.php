<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Kelase;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahDosen = Dosen::count();
        $jumlahProdi = Prodi::count();
        $jumlahMatakuliah = Matkul::count();
        $jumlahKelas = Kelase::count();

        return Inertia::render('Dashboard', [
            'jumlahMahasiswa'=>$jumlahMahasiswa,
            'jumlahDosen'=>$jumlahDosen,
            'jumlahProdi'=>$jumlahProdi,
            'jumlahMatakuliah'=>$jumlahMatakuliah,
            'jumlahKelas' =>$jumlahKelas
        ]);
    }

}

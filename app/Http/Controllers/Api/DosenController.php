<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\User;
use Carbon\Carbon;

class DosenController extends Controller
{
    public function jadwaldosens(Request $request){
        $request->validate([
            'dosen_id' => 'required',
        ]);

        $jadwals = Jadwal::where('dosen_id',$request->dosen_id)->get();

        foreach ($jadwals as $jadwal) {
            $data[] = [
                'id' => $jadwal->id,
                'nama' => $jadwal->matkul->nama,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'dosen' => $jadwal->dosen->nama,
                'kelas' => $jadwal->kelase->nama,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function pertemuanberlangsung(Request $request){
            $request->validate([
                'dosen_id' => 'required',
            ]);
            $waktu_sekarang = Carbon::now('Asia/Jakarta')->format('H:i');
            $tanggal_sekarang = Carbon::now('Asia/Jakarta')->format('Y-m-d');
    
            $dosen_id = $request->dosen_id;
            $pertemuan = Pertemuan::where("status","1")
            ->where("tanggal", "=", $tanggal_sekarang)
            ->where("jam_mulai", "<=", $waktu_sekarang)
            ->where("jam_selesai", ">=", $waktu_sekarang)
            ->whereHas('jadwal', function($query) use ($dosen_id) {
                $query->where('dosen_id', $dosen_id);
            })->first();
    
            if (!$pertemuan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak Ada Jadwal',
                ]);
            }
    
            if ($pertemuan->status === "0") {
                $status = "Terjadwal";
            } elseif($pertemuan->status === "1") {
                $status = "Sedang Berlangsung";
            } elseif($pertemuan->status === "2") {
                $status = "Selesai";
            } elseif($pertemuan->status === "3") {
                $status = "Ubah Jadwal";
            }
    
            $data = [
                'id' => $pertemuan->id,
                'jam_mulai' => $pertemuan->jam_mulai,
                'jam_selesai' => $pertemuan->jam_selesai,
                'tanggal' => $pertemuan->tanggal,
                'status' => $status,
                'kode_status'=>$pertemuan->status,
                'nama' => $pertemuan->jadwal->matkul->nama,
                'kelas' =>$pertemuan->jadwal->kelase->nama
            ];
    
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
    }
    
    public function pertemuandetail(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $pertemuan = Pertemuan::where('id', $request->id)->first();

        if (!$pertemuan) {
            return response()->json([
                'success' => false,
                'message' => 'Pertemuan tidak ditemukan',
            ]);
        }

        if ($pertemuan->status === "0") {
            $status = "Terjadwal";
        } elseif($pertemuan->status === "1") {
            $status = "Sedang Berlangsung";
        } elseif($pertemuan->status === "2") {
            $status = "Selesai";
        } elseif($pertemuan->status === "3") {
            $status = "Ubah Jadwal";
        }
        
        if($pertemuan->jenis_pertemuan === "0"){
            $jenis_pertemuan = "Kuliah";
        }elseif($pertemuan->jenis_pertemuan === "1"){
            $jenis_pertemuan = "UTS";
        }elseif($pertemuan->jenis_pertemuan === "2"){
            $jenis_pertemuan = "UAS";
        }else{
            $jenis_pertemuan = "-";
        }
        
        if($pertemuan->metode_belajar === "0"){
            $metode_belajar = "Online";
            $ruangan = "-";
        }elseif($pertemuan->metode_belajar === "1"){
            $metode_belajar = "Offline";
            $ruangan = "-";
        }else{
            $metode_belajar = "";
            $ruangan = "";
        }

        $data = [
            'id' => $pertemuan->id,
            'jam_mulai' => $pertemuan->jam_mulai,
            'jam_selesai' => $pertemuan->jam_selesai,
            'tanggal' => $pertemuan->tanggal,
            'ke' => $pertemuan->ke,
            'status' => $status,
            'kode_status'=>$pertemuan->status,
            'nama' => $pertemuan->jadwal->matkul->nama,
            'kelas' => $pertemuan->jadwal->kelase->nama,
            'jenis_pertemuan' => $jenis_pertemuan,
            'metode_belajar' => $metode_belajar,
            'ruangan' => $ruangan,
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'pertemuan' => $data,
            ],
        ]);


    }
        
}

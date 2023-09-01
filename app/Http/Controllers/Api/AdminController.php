<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dosens(){
        $dosens = Dosen::where('status',0)->get();

        foreach ($dosens as $dosen) {
            $data[] = [
                'username' => $dosen->user->username,
                'nama' => $dosen->user->name
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function mahasiswas(){
        $mahasiswas = Mahasiswa::where('status',0)->get();

        foreach ($mahasiswas as $mahasiswa) {
            $data[] = [
                'username' => $mahasiswa->user->username,
                'nama' => $mahasiswa->user->name
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function jadwalmahasiswas(Request $request){
        $request->validate([
            'kelase_id' => 'required',
        ]);

        $jadwals = Jadwal::where('kelase_id',$request->kelase_id)->get();

        foreach ($jadwals as $jadwal) {
            $data[] = [
                'id' => $jadwal->id,
                'nama' => $jadwal->matkul->nama,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'dosen' => $jadwal->dosen->nama,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function updatenfcdata(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nfcid' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        $nfcid = User::where('nfcid',$request->nfcid)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User tidak ditemukan"
            ]);
        }

        if ($nfcid) {
            return response()->json([
                'success' => false,
                'message' => "NFC ID sudah ada dalam database"
            ]);
        }

        $update = $user->update(['nfcid' => $request->nfcid]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => "Data NFC Berhasil diupdate"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Data NFC Gagal diupdate"
            ]);
        }
    }

    public function pertemuanberlangsung(Request $request){
        $request->validate([
            'kelase_id' => 'required',
        ]);
        $waktu_sekarang = Carbon::now('Asia/Jakarta')->format('H:i');
        $tanggal_sekarang = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $kelase_id = $request->kelase_id;
        $pertemuan = Pertemuan::where("status","1")
        ->where("tanggal", "=", $tanggal_sekarang)
        ->where("jam_mulai", "<=", $waktu_sekarang)
        ->where("jam_selesai", ">=", $waktu_sekarang)
        ->whereHas('jadwal', function($query) use ($kelase_id) {
            $query->where('kelase_id', $kelase_id);
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
            'dosen' =>$pertemuan->jadwal->dosen->nama
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function pertemuanharian(Request $request){
        $request->validate([
            'kelase_id' => 'required',
        ]);
        $tanggal_sekarang = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $kelase_id = $request->kelase_id;
        $pertemuans = Pertemuan::where("tanggal", $tanggal_sekarang)
        ->whereHas('jadwal', function($query) use ($kelase_id) {
            $query->where('kelase_id', $kelase_id);
        })->get();

        $data = [];
        if (!$pertemuans) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak Ada Jadwal',
            ]);
        }else{
            foreach ($pertemuans as $pertemuan) {
                if ($pertemuan->status === "0") {
                    $status = "Terjadwal";
                } elseif($pertemuan->status === "1") {
                    $status = "Sedang Berlangsung";
                } elseif($pertemuan->status === "2") {
                    $status = "Selesai";
                } elseif($pertemuan->status === "3") {
                    $status = "Ubah Jadwal";
                }

                $data[] = [
                    'id' => $pertemuan->id,
                    'jam_mulai' => $pertemuan->jam_mulai,
                    'jam_selesai' => $pertemuan->jam_selesai,
                    'tanggal' => $pertemuan->tanggal,
                    'ke' => $pertemuan->ke,
                    'status' => $status,
                    'kode_status'=>$pertemuan->status,
                    'nama' => $pertemuan->jadwal->matkul->nama,
                    'dosen' => $pertemuan->jadwal->dosen->nama
                ];
            }
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    public function pertemuanriawayat(Request $request){
        $request->validate([
            'kelase_id' => 'required',
        ]);
        $tanggal_sekarang = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $kelase_id = $request->kelase_id;
        $pertemuans = Pertemuan::where("status","2")
        ->whereHas('jadwal', function($query) use ($kelase_id) {
            $query->where('kelase_id', $kelase_id);
        })->get();
        $data = [];
        if (!$pertemuans) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak Ada Jadwal',
            ]);
        }else{
            foreach ($pertemuans as $pertemuan) {
                if ($pertemuan->status === "0") {
                    $status = "Terjadwal";
                } elseif($pertemuan->status === "1") {
                    $status = "Sedang Berlangsung";
                } elseif($pertemuan->status === "2") {
                    $status = "Selesai";
                } elseif($pertemuan->status === "3") {
                    $status = "Ubah Jadwal";
                }

                $data[] = [
                    'id' => $pertemuan->id,
                    'jam_mulai' => $pertemuan->jam_mulai,
                    'jam_selesai' => $pertemuan->jam_selesai,
                    'tanggal' => $pertemuan->tanggal,
                    'ke' => $pertemuan->ke,
                    'status' => $status,
                    'kode_status'=>$pertemuan->status,
                    'nama' => $pertemuan->jadwal->matkul->nama,
                    'dosen' => $pertemuan->jadwal->dosen->nama
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    public function pertemuandetail(Request $request){
        $request->validate([
            'id' => 'required',
            'mahasiswa_id' => 'required',
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
            'dosen' => $pertemuan->jadwal->dosen->nama,
            'jenis_pertemuan' => $jenis_pertemuan,
            'metode_belajar' => $metode_belajar,
            'ruangan' => $ruangan,
        ];

        if($pertemuan->status === "1" || $pertemuan->status === "2"){

            $check =  Absensi::where('pertemuan_id', $request->id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->first();
            if($pertemuan->status === "2" && !$check){
                return response()->json([
                    'success' => true,
                    'message' => 'Tidak Masuk',
                    'data' => [
                        'pertemuan' => $data,
                        'status_absen' => "Tidak Hadir",
                        'waktu_presensi' => "-",
                    ],
                ]);
            }elseif ($check) {
                $jamPresensi = $check->created_at;
                $jamMulai = Carbon::parse($pertemuan->tanggal . " " . $pertemuan->jam_mulai);

                $selisihMenit = $jamPresensi->diffInMinutes($jamMulai);
                if ($selisihMenit > 15) {
                    $status = "Terlambat";
                } else {
                    $status = "Tepat Waktu";
                }

                return response()->json([
                    'success' => true,
                    'data' => [
                        'pertemuan' => $data,
                        'status_absen' => $status,
                        'waktu_presensi' => $jamPresensi->format('H:i'),
                    ],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum Absen',
                    'data' => [
                        'pertemuan' => $data,
                    ],
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Belum E',
                'data' => [
                    'pertemuan' => $data,
                ],
            ]);
        }

    }

    public function absenmahasiswa(Request $request){
        $request->validate([
            'nim' => 'required',
            'imei' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'pertemuan_id' => 'required',
            'mahasiswa_id' => 'required',
            'nfcid' => 'required',
        ]);

        $checkabsen1 = Absensi::where('nim', $request->nim)
        ->where('pertemuan_id',$request->pertemuan_id)
        ->where('mahasiswa_id',$request->mahasiswa_id)
        ->first();

        if($checkabsen1){
            return response()->json([
                'success' => false,
                'message' => 'User sudah absen',
            ]);
        }else{
            $checkabsen2 = Absensi::where('imei', $request->imei)
            ->where('pertemuan_id',$request->pertemuan_id)
            ->where('mahasiswa_id',$request->mahasiswa_id)
            ->first();
            if($checkabsen2){
                return response()->json([
                    'success' => false,
                    'message' => 'DeviceID sudah dipakai absen',
                ]);
            }else{
                $checkabsen3 = Mahasiswa::where('id',$request->mahasiswa_id)->first();

                if(!$checkabsen3){
                    return response()->json([
                        'success' => false,
                        'message' => 'Mahasiswa tidak terdaftar',
                    ]);
                }else{
                    $checkabsen4 = User::where('nfcid',$request->nfcid)->first();

                if(!$checkabsen4){
                    return response()->json([
                        'success' => false,
                        'message' => 'NFC Card tidak terdaftar',
                    ]);
                }else{
                    $checkabsen5 = Mahasiswa::where("id", $request->mahasiswa_id)
                    ->first();

                    if($checkabsen5->user->nfcid != $request->nfcid){
                        return response()->json([
                            'success' => false,
                            'message' => 'NFC Card yang dipakai tidak sesuai',
                        ]);
                    }else{
                        $absen = Absensi::create([
                            'nim' => $request->nim,
                            'imei' => $request->imei,
                            'long' => $request->long,
                            'lat' => $request->lat,
                            'pertemuan_id' => $request->pertemuan_id,
                            'mahasiswa_id' => $request->mahasiswa_id
                        ]);

                        if($absen){
                            return response()->json([
                                'success' => true,
                                'message' => 'Absen Berhasil',
                            ]);
                        }else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Absen Gagal',
                            ]);
                        }
                    }
                }
                }

            }
        }
    }

    public function checkabsen(Request $request)
    {
        $request->validate([
            'pertemuan_id' => 'required',
            'mahasiswa_id' => 'required',
        ]);

        $check =  Absensi::where('pertemuan_id', $request->pertemuan_id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->first();

        if ($check) {
            $jamPresensi = $check->created_at;
            $jamMulai = Carbon::parse($check->pertemuan->tanggal." ".$check->pertemuan->jam_mulai);

            $selisihMenit = $jamPresensi->diffInMinutes($jamMulai);
            if ($selisihMenit > 15) {
                $status = "Terlambat";
            } else {
                $status = "Tepat Waktu";
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'status' => $status,
                    'waktu' => $jamPresensi->format('H:i'),
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Belum Absen',
            ]);
        }
    }

    public function profilemahasiswa(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('id',$request->id)->first();

        if($mahasiswa){
            if($mahasiswa->sistem_kuliah === "0"){
                $sistem_kuliah = "Reguler";
            }elseif($mahasiswa->sistem_kuliah === "1"){
                $sistem_kuliah = "Non Reguler";
            }else{
                $sistem_kuliah = "Error Server";
            }
            if($mahasiswa->status === 0){
                $status = "Aktif";
            }elseif($mahasiswa->sistem_kuliah === 1){
                $status = "Tidak Aktif";
            }else{
                $status = "Error Server";
            }
            $data = [
                'id' => $mahasiswa->id,
                'nama' => $mahasiswa->nama ??"-",
                'email' => $mahasiswa->email ??"-",
                'nim' => $mahasiswa->nim ??"-",
                'angkatan' => $mahasiswa->angkatan ??"-",
                'sistem_kuliah' => $sistem_kuliah ??"-",
                'gender' => $mahasiswa->gender ??"-",
                'agama' => $mahasiswa->agama ??"-",
                'tempat_lahir' => $mahasiswa->tempat_lahir ??"-",
                'tanggal_lahir' => $mahasiswa->tanggal_lahir ??"-",
                'berat_badan' => $mahasiswa->berat_badan ??"-",
                'tinggi_badan' => $mahasiswa->tinggi_badan ??"-",
                'golongan_darah' => $mahasiswa->golongan_darah ??"-",
                'alamat' => $mahasiswa->alamat ??"-",
                'nohp' => $mahasiswa->nohp ??"-",
                'notelp' => $mahasiswa->notelp ??"-",
                'status' => $status ??0,
                'prodi_id' => $mahasiswa->prodi_id ??0,
                'kelase_id' => $mahasiswa->kelase_id ??0,
                'user_id' => $mahasiswa->user_id,
                'profile_photo_path' => $mahasiswa->user->profile_photo_path ??"",
                'profile_photo_url' => $mahasiswa->user->profile_photo_url ??"",
                'program_studi' => $mahasiswa->prodi->nama,
                'kelas' => $mahasiswa->kelase->nama,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Kosong',
            ]);
        }
    }

}

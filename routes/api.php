<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DosenController;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $role = $user->getRoleNames()->toArray();
    $data = [];
    if($role[0]=== "admin" || $role[0]=== "Admin"){
        $data = [
            'id' => $user->id,
            'nama' => $user->name ??"",
            'username' => $user->username ??"",
            'email' => $user->email ??"",
            'profile_photo_path' => $user->profile_photo_path ??"",
            'profile_photo_url' => $user->profile_photo_url ??"",
            'role' => $role[0]
        ];
    }elseif($role[0] === 'mahasiswa' || $role[0] === 'Mahasiswa'){
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $data = [
            'id' => $mahasiswa->id,
            'nama' => $user->name ??"",
            'email' => $user->email ??"",
            'nim' => $mahasiswa->nim ??"",
            'angkatan' => $mahasiswa->angkatan ??"",
            'sistem_kuliah' => $mahasiswa->sistem_kuliah ??"",
            'gender' => $mahasiswa->gender ??"",
            'agama' => $mahasiswa->agama ??"",
            'tempat_lahir' => $mahasiswa->tempat_lahir ??"",
            'tanggal_lahir' => $mahasiswa->tanggal_lahir ??"",
            'berat_badan' => $mahasiswa->berat_badan ??"",
            'tinggi_badan' => $mahasiswa->tinggi_badan ??"",
            'golongan_darah' => $mahasiswa->golongan_darah ??"",
            'alamat' => $mahasiswa->alamat ??"",
            'nohp' => $mahasiswa->nohp ??"",
            'notelp' => $mahasiswa->notelp ??"",
            'status' => $mahasiswa->status ??0,
            'prodi_id' => $mahasiswa->prodi_id ??0,
            'kelase_id' => $mahasiswa->kelase_id ??0,
            'user_id' => $user->id ??0,
            'profile_photo_path' => $user->profile_photo_path ??"",
            'profile_photo_url' => $user->profile_photo_url ??"",
            'role' => $role[0]
        ];
    }elseif($role[0] === 'dosen' || $role[0] === 'Dosen'){
        $dosen = Dosen::where('user_id', $user->id)->first();
        $data = [
            'id' => $dosen->id,
            'nama' => $user->name ??"",
            'email' => $user->email ??"",
            'nidn' => $dosen->nidn ??"",
            'nip' =>  $dosen->nip ??"",
            'gender' => $dosen->gender ??"",
            'agama' => $dosen->agama ??"",
            'tempat_lahir' => $dosen->tempat_lahir ??"",
            'tanggal_lahir' => $dosen->tanggal_lahir ??"",
            'pendidikan' => $dosen->pendidikan ??"",
            'sik' => $dosen->sik ??"",
            'alamat' => $dosen->alamat ??"",
            'jabatan' => $dosen->jabatan ??"",
            'nohp' => $dosen->nohp ??"",
            'notelp' => $dosen->notelp ??"",
            'status' => $dosen->status ??"",
            'prodi_id' => $dosen->prodi_id ??"",
            'user_id' => $user->id ??"",
            'profile_photo_path' => $user->profile_photo_path ??"",
            'profile_photo_url' => $user->profile_photo_url ??"",
            'role' => $role[0]
        ];
    }
    return $data;
});

Route::get('/dosens', [AdminController::class, 'dosens']);
Route::get('/mahasiswas', [AdminController::class, 'mahasiswas']);
Route::post('/jadwalmahasiswas', [AdminController::class, 'jadwalmahasiswas']);
Route::post('/pertemuanberlangsung', [AdminController::class, 'pertemuanberlangsung']);
Route::post('/pertemuanharian', [AdminController::class, 'pertemuanharian']);
Route::post('/pertemuandetail', [AdminController::class, 'pertemuandetail']);
Route::post('/pertemuanriwayat', [AdminController::class, 'pertemuanriawayat']);
Route::post('/updatenfcdata', [AdminController::class, 'updatenfcdata']);
Route::post('/absenmahasiswa', [AdminController::class, 'absenmahasiswa']);
Route::post('/checkabsen', [AdminController::class, 'checkabsen']);

Route::post('/profilemahasiswa', [AdminController::class, 'profilemahasiswa']);

Route::post('/jadwaldosens', [DosenController::class, 'jadwaldosens']);
Route::post('/pertemuandosenberlangsung', [DosenController::class, 'pertemuanberlangsung']);
Route::post('/pertemuandosendetail', [DosenController::class, 'pertemuandetail']);

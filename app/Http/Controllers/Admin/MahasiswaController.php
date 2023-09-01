<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Kelase;
use Spatie\Permission\Models\Role;

class MahasiswaController extends Controller
{

    public function index()
    {
        return Inertia::render('Mahasiswas/Index', [
            'mahasiswas' => Mahasiswa::orderBy('nim')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($mahasiswa) => [
                'id' => $mahasiswa->id,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'prodi' => $mahasiswa->prodi->nama,
                'kelase' => $mahasiswa->kelase->nama,
                'status' => $mahasiswa->status,
            ]),]);
    }

    public function create()
    {
        $prodiOptions = Prodi::select('id', 'nama')->get()->map(function ($prodi) {
            return [
                'value' => $prodi->id,
                'label' => $prodi->nama,
            ];
        });

        $kelaseOptions = kelase::select('id', 'nama','prodi_id','angkatan')->distinct()->get()->map(function ($kelase) {
            return [
                'value' => $kelase->id,
                'label' => $kelase->nama,
                'angkatan' => $kelase->angkatan,
                'prodi_id' => $kelase->prodi_id,
            ];
        });

        $angkatanOptions = Kelase::select('angkatan','prodi_id')->distinct()->get()->map(function ($kelase) {
            return [
                'value' => $kelase->angkatan,
                'label' => $kelase->angkatan,
                'prodi_id' => $kelase->prodi_id,
            ];
        });

        $currentYear = date('Y');
        $years = [];

        for ($i = $currentYear; $i >= ($currentYear - 10); $i--) {
            $years[] = [
                'value' => $i,
                'label' => $i,
            ];
        }

        return inertia('Mahasiswas/Create', [
            'prodiOptions' => $prodiOptions,
            'angkatanOptions' => $angkatanOptions,
            'kelaseOptions' => $kelaseOptions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['required'],
            'nama' => ['required'],
            'angkatan' => ['required'],
            'sistem_kuliah' => ['required'],
            'email' => ['nullable', 'email'],
            'gender' => ['required'],
            'agama' => ['nullable'],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable'],
            'berat_badan' => ['nullable'],
            'tinggi_badan' => ['nullable'],
            'golongan_darah' => ['nullable'],
            'alamat' => ['nullable'],
            'nohp' => ['nullable'],
            'notelp' => ['nullable'],
            'status' => ['required', 'integer'],
            'prodi_id' => ['required','integer'],
            'kelase_id' => ['required','integer'],
        ]);

        if (empty($validated['email'])) {
            $validated['email'] = $validated['nim'].'@example.co.id';
        }

        $password = bcrypt('12345678');
        $user = User::create([
            'username' => $validated['nim'],
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $password,
        ]);

        $role = Role::firstOrCreate(['name' => 'Mahasiswa']);
        $user->assignRole($role);

        Mahasiswa::Create([
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'angkatan' => $validated['angkatan'],
            'sistem_kuliah' => $validated['sistem_kuliah'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'agama' => $validated['agama'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'golongan_darah' => $validated['golongan_darah'],
            'alamat' => $validated['alamat'],
            'nohp' => $validated['nohp'],
            'notelp' => $validated['notelp'],
            'status' => $validated['status'],
            'prodi_id' => $validated['prodi_id'],
            'kelase_id' => $validated['kelase_id'],
            'user_id' => $user->id,
        ]);

        return Redirect::route('mahasiswas.index')->with('success', 'Mahasiswa created.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $prodiOptions = Prodi::select('id', 'nama')->get()->map(function ($prodi) {
            return [
                'value' => $prodi->id,
                'label' => $prodi->nama,
            ];
        });

        $kelaseOptions = kelase::select('id', 'nama','prodi_id','angkatan')->distinct()->get()->map(function ($kelase) {
            return [
                'value' => $kelase->id,
                'label' => $kelase->nama,
                'angkatan' => $kelase->angkatan,
                'prodi_id' => $kelase->prodi_id,
            ];
        });

        $angkatanOptions = Kelase::select('angkatan','prodi_id')->distinct()->get()->map(function ($kelase) {
            return [
                'value' => $kelase->angkatan,
                'label' => $kelase->angkatan,
                'prodi_id' => $kelase->prodi_id,
            ];
        });

        return Inertia::render('Mahasiswas/Edit',[
            'mahasiswa' => [
            'id' => $mahasiswa->id,
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'angkatan' => $mahasiswa->angkatan,
            'sistem_kuliah' => $mahasiswa->sistem_kuliah,
            'email' => $mahasiswa->email,
            'gender' => $mahasiswa->gender,
            'agama' => $mahasiswa->agama,
            'tempat_lahir' => $mahasiswa->tempat_lahir,
            'tanggal_lahir' => $mahasiswa->tanggal_lahir,
            'berat_badan' => $mahasiswa->berat_badan,
            'tinggi_badan' => $mahasiswa->tinggi_badan,
            'golongan_darah' =>$mahasiswa->golongan_darah,
            'alamat' => $mahasiswa->alamat,
            'nohp' => $mahasiswa->nohp,
            'notelp' => $mahasiswa->notelp,
            'status' => $mahasiswa->status,
            'prodi_id' => $mahasiswa->prodi_id,
            'kelase_id' => $mahasiswa->kelase_id,
            ],
            'prodiOptions' => $prodiOptions,
            'angkatanOptions' => $angkatanOptions,
            'kelaseOptions' => $kelaseOptions,
        ]);
    }

    public function update(Request $request,Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => ['required'],
            'nama' => ['required'],
            'angkatan' => ['required'],
            'sistem_kuliah' => ['required'],
            'email' => ['nullable', 'email'],
            'gender' => ['required'],
            'agama' => ['nullable'],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable'],
            'berat_badan' => ['nullable'],
            'tinggi_badan' => ['nullable'],
            'golongan_darah' => ['nullable'],
            'alamat' => ['nullable'],
            'nohp' => ['nullable'],
            'notelp' => ['nullable'],
            'status' => ['required', 'integer'],
            'prodi_id' => ['required','integer'],
            'kelase_id' => ['required','integer'],
        ]);

        if (empty($validated['email'])) {
            $validated['email'] = $validated['nip'].'@example.co.id';
        }

        $mahasiswa->update($validated);
        $mahasiswa->user()->update([
            'username' => $validated['nim'],
            'name' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        return Redirect::route('mahasiswas.index')->with('success', 'Mahasiswa updated.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return Redirect::route('mahasiswas.index')->with('success', 'Mahasiswa Deleted.');
    }
}

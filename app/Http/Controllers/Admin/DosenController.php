<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DosenController extends Controller
{
    public function index()
    {
        return Inertia::render('Dosens/Index', [
            'dosens' => Dosen::orderBy('nama')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($dosen) => [
                'id' => $dosen->id,
                'nama' => $dosen->nama,
                'prodi' => $dosen->prodi->nama,
                'pendidikan' => $dosen->pendidikan,
                'status' => $dosen->status,
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

        return inertia('Dosens/Create', [
            'prodiOptions' => $prodiOptions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required'],
            'email' => ['nullable', 'email'],
            'nidn' => ['nullable'],
            'nip' => ['nullable'],
            'gender' => ['nullable'],
            'agama' => ['nullable'],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable'],
            'pendidikan' => ['required'],
            'sik' => ['nullable'],
            'alamat' => ['nullable'],
            'jabatan' => ['nullable'],
            'nohp' => ['nullable'],
            'notelp' => ['nullable'],
            'status' => ['required', 'integer'],
            'prodi_id' => ['required'],
        ]);

        if (empty($validated['nidn'])) {
            $username = $validated['nip'];
        } else {
            $username = $validated['nidn'];
        }
        if (empty($validated['email'])) {
            $validated['email'] = $username.'@example.co.id';
        }

        $password = bcrypt('12345678');
        $user = User::create([
            'username' => $username,
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $password,
        ]);

        $role = Role::firstOrCreate(['name' => 'Dosen']);
        $user->assignRole($role);

        Dosen::Create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nidn' => $validated['nidn'],
            'nip' => $validated['nip'],
            'gender' => $validated['gender'],
            'agama' => $validated['agama'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'pendidikan' => $validated['pendidikan'],
            'sik' => $validated['sik'],
            'alamat' => $validated['alamat'],
            'jabatan' => $validated['jabatan'],
            'nohp' => $validated['nohp'],
            'notelp' => $validated['notelp'],
            'status' => $validated['status'],
            'prodi_id' => $validated['prodi_id'],
            'user_id' => $user->id,
        ]);

        return Redirect::route('dosens.index')->with('success', 'Dosen created.');
    }

    public function edit(Dosen $dosen)
    {
        $prodiOptions = Prodi::select('id', 'nama')->get()->map(function ($prodi) {
            return [
                'value' => $prodi->id,
                'label' => $prodi->nama,
            ];
        });

        return Inertia::render('Dosens/Edit',[
            'dosen' => [
                'id' => $dosen->id,
                'nama' => $dosen->nama,
                'email' => $dosen->email,
                'nidn' => $dosen->nidn,
                'nip' => $dosen->nip,
                'gender' => $dosen->gender,
                'agama' => $dosen->agama,
                'tempat_lahir' => $dosen->tempat_lahir,
                'tanggal_lahir' => $dosen->tanggal_lahir,
                'pendidikan' => $dosen->pendidikan,
                'sik' => $dosen->sik,
                'alamat' => $dosen->alamat,
                'jabatan' => $dosen->jabatan,
                'nohp' => $dosen->nohp,
                'notelp' => $dosen->notelp,
                'status' =>$dosen->status,
                'prodi_id' => $dosen->prodi_id,
            ],
            'prodiOptions' => $prodiOptions,
        ]);
    }

    public function update(Request $request,Dosen $dosen)
    {
        $validated = $request->validate([
            'nama' => ['required'],
            'email' => ['nullable', 'email'],
            'nidn' => ['nullable'],
            'nip' => ['nullable'],
            'gender' => ['nullable'],
            'agama' => ['nullable'],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable'],
            'pendidikan' => ['required'],
            'sik' => ['nullable'],
            'alamat' => ['nullable'],
            'jabatan' => ['nullable'],
            'nohp' => ['nullable'],
            'notelp' => ['nullable'],
            'status' => ['required', 'integer'],
            'prodi_id' => ['required'],
        ]);
        if (empty($validated['nidn'])) {
            $username = $validated['nip'];
        } else {
            $username = $validated['nidn'];
        }
        if (empty($validated['email'])) {
            $validated['email'] = $validated['nip'].'@example.co.id';
        }

        $dosen->update($validated);
        $dosen->user()->update([
            'username' => $username,
            'name' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        return Redirect::route('dosens.index')->with('success', 'Dosen updated.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return Redirect::route('dosens.index')->with('success', 'Mata Dosen Deleted.');
    }
}

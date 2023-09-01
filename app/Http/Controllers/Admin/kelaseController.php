<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Kelase;
use App\Models\Prodi;
use App\Models\Dosen;

class kelaseController extends Controller
{
    public function index()
    {
        return Inertia::render('Kelases/Index', [
            'kelases' => Kelase::orderBy('angkatan')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($kelas) => [
                'id' => $kelas->id,
                'nama' => $kelas->nama,
                'prodi' => $kelas->prodi->nama,
                'dosen' => $kelas->dosen->nama,
                'angkatan' => $kelas->angkatan,
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
        $dosenOptions = Dosen::select('id', 'nama','prodi_id')->get()->map(function ($dosen) {
            return [
                'value' => $dosen->id,
                'label' => $dosen->nama,
                'prodi_id' => $dosen->prodi_id,
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

        return inertia('Kelases/Create', [
            'prodiOptions' => $prodiOptions,
            'dosenOptions' => $dosenOptions,
            'angkatanOptions' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required'],
            'angkatan' => ['required'],
            'dosen_id' => ['required','integer'],
            'prodi_id' => ['required','integer'],
        ]);
        Kelase::create($validated);

        return Redirect::route('kelases.index')->with('success', 'Kelas created.');
    }

    public function edit(Kelase $kelase)
    {
        $prodiOptions = Prodi::select('id', 'nama')->get()->map(function ($prodi) {
            return [
                'value' => $prodi->id,
                'label' => $prodi->nama,
            ];
        });
        $dosenOptions = Dosen::select('id', 'nama','prodi_id')->get()->map(function ($dosen) {
            return [
                'value' => $dosen->id,
                'label' => $dosen->nama,
                'prodi_id' => $dosen->prodi_id,
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
        // dd($kelas);
        return Inertia::render('Kelases/Edit',[
            'kelas' => [
                'id' => $kelase->id,
                'nama' => $kelase->nama,
                'angkatan' => $kelase->angkatan,
                'dosen_id' => $kelase->dosen_id,
                'prodi_id' => $kelase->prodi_id,
            ],
            'prodiOptions' => $prodiOptions,
            'dosenOptions' => $dosenOptions,
            'angkatanOptions' => $years,
        ]);
    }

    public function update(Request $request,Kelase $kelase)
    {
        $validated = $request->validate([
            'nama' => ['required'],
            'angkatan' => ['required'],
            'dosen_id' => ['required','integer'],
            'prodi_id' => ['required','integer'],
        ]);

        $kelase->update($validated);

        return Redirect::route('kelases.index')->with('success', 'Kelas updated.');
    }

    public function destroy(Kelase $kelase)
    {
        $kelase->delete();

        return Redirect::route('matkuls.index')->with('success', 'Kelas Deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Matkul;
use App\Models\Prodi;


class MatkulController extends Controller
{
    public function index()
    {
        return Inertia::render('Matkuls/Index', [
            'matkuls' => Matkul::orderBy('kode')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($matkul) => [
                'id' => $matkul->id,
                'nama' => $matkul->nama,
                'kode' => $matkul->kode,
                'sks' => $matkul->sks,
                'prodi' => $matkul->prodi->nama
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

        return inertia('Matkuls/Create', [
            'prodiOptions' => $prodiOptions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required'],
            'nama' => ['required'],
            'sks' => ['required','integer'],
            'prodi_id' => ['required'],
        ]);
        Matkul::create($validated);

        return Redirect::route('matkuls.index')->with('success', 'Mata Kuliah created.');
    }

    public function edit(Matkul $matkul)
    {
        $prodiOptions = Prodi::select('id', 'nama')->get()->map(function ($prodi) {
            return [
                'value' => $prodi->id,
                'label' => $prodi->nama,
            ];
        });

        return Inertia::render('Matkuls/Edit',[
            'matkul' => [
                'id' => $matkul->id,
                'nama' => $matkul->nama,
                'kode' => $matkul->kode,
                'sks' => $matkul->sks,
                'prodi_id' => $matkul->prodi_id,
            ],
            'prodiOptions' => $prodiOptions,
        ]);
    }

    public function update(Request $request,Matkul $matkul)
    {
        $validated = $request->validate([
            'kode' => ['required'],
            'nama' => ['required'],
            'sks' => ['required','integer'],
            'prodi_id' => ['required'],
        ]);

        $matkul->update($validated);

        return Redirect::route('matkuls.index')->with('success', 'Mata Kuliah updated.');
    }

    public function destroy(Matkul $matkul)
    {
        $matkul->delete();

        return Redirect::route('matkuls.index')->with('success', 'Mata Kuliah Deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function index()
    {
        return Inertia::render('Prodis/Index', [
            'prodis' => Prodi::orderBy('kode')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($prodi) => [
                'id' => $prodi->id,
                'nama' => $prodi->nama,
                'kode' => $prodi->kode,
                'jenjang' => $prodi->jenjang,
                'akreditasi' => $prodi->akreditasi,
                'tanggal_berdiri' => $prodi->tanggal_berdiri,
                'status' => $prodi->status,
                'visi' => $prodi->visi,
                'misi' => $prodi->misi,
                'deskripsi' => $prodi->deskripsi,
                'kompetensi' => $prodi->kompetensi,
            ]),]);
    }

    public function create()
    {
        return Inertia::render('Prodis/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required'],
            'nama' => ['required'],
            'jenjang' => ['required','string'],
            'akreditasi' => ['required','string'],
            'tanggal_berdiri' => ['required','date'],
            'status' => ['required','integer'],
            'visi' => ['nullable'],
            'misi' => ['nullable'],
            'deskripsi' => ['nullable'],
            'kompetensi' => ['nullable'],
        ]);
        Prodi::create($validated);

        return Redirect::route('prodis.index')->with('success', 'Program Studi created.');
    }

    public function edit(Prodi $prodi)
    {
        // dd($prodi);
        return Inertia::render('Prodis/Edit',[
            'prodi' => [
                'id' => $prodi->id,
                'nama' => $prodi->nama,
                'kode' => $prodi->kode,
                'jenjang' => $prodi->jenjang,
                'akreditasi' => $prodi->akreditasi,
                'tanggal_berdiri' => $prodi->tanggal_berdiri,
                'status' => $prodi->status,
                'visi' => $prodi->visi,
                'misi' => $prodi->misi,
                'deskripsi' => $prodi->deskripsi,
                'kompetensi' => $prodi->kompetensi,
            ]
        ]);
    }

    public function update(Request $request,Prodi $prodi)
    {
        $validated = $request->validate([
            'kode' => ['required'],
            'nama' => ['required'],
            'jenjang' => ['required','string'],
            'akreditasi' => ['required','string'],
            'tanggal_berdiri' => ['required','date'],
            'status' => ['required','integer'],
            'visi' => ['nullable'],
            'misi' => ['nullable'],
            'deskripsi' => ['nullable'],
            'kompetensi' => ['nullable'],
        ]);

        $prodi->update($validated);

        return Redirect::route('prodis.index')->with('success', 'Program Studi updated.');
    }

    public function destroy(Prodi $prodi)
    {
        $prodi->delete();

        return Redirect::route('prodis.index')->with('success', 'Program Studi Deleted.');
    }
}

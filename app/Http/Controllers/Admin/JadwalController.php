<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use App\Models\Kelase;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Pertemuan;
use Illuminate\Support\Carbon;


class JadwalController extends Controller
{
    public function index()
    {
        return Inertia::render('Jadwals/Index', [
            'jadwals' => Jadwal::orderBy('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($jadwal) => [
                'id' => $jadwal->id,
                'kelase' => $jadwal->kelase->nama,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'kode' => $jadwal->matkul->kode,
                'nama' => $jadwal->matkul->nama,
                'dosen' => $jadwal->dosen->nama,
            ]),]);
    }

    public function create()
    {

        $dosenOptions = Dosen::select('id', 'nama','prodi_id')->get()->map(function ($dosen) {
            return [
                'value' => $dosen->id,
                'label' => $dosen->nama,
                'prodi_id' => $dosen->prodi_id,
            ];
        });
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

        $matkulOptions = Matkul::select('id', 'nama','prodi_id')->distinct()->get()->map(function ($matkul) {
            return [
                'value' => $matkul->id,
                'label' => $matkul->nama,
                'prodi_id' => $matkul->prodi_id,
            ];
        });

        $currentYear = date('Y');
        $years = [];

        for ($i = $currentYear; $i >= ($currentYear - 10); $i--) {
            // Determine academic year label (Gasal or Genap)
            $academicYearLabel = ($i % 2 !== 0) ? 'Gasal' : 'Genap';

            // Generate both the value and label for the option
            $value = $i . '/' . ($i + 1);
            $label = $i . '/' . ($i + 1);

            // Add both Gasal and Genap options for each academic year
            $years[] = [
                'value' => $value . ' Gasal',
                'label' => $label . ' Gasal',
            ];
            $years[] = [
                'value' => $value . ' Genap',
                'label' => $label . ' Genap',
            ];
        }

        return inertia('Jadwals/Create', [
            'prodiOptions' => $prodiOptions,
            'dosenOptions' => $dosenOptions,
            'kelaseOptions' => $kelaseOptions,
            'matkulOptions' => $matkulOptions,
            'tahunOptions' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajar' => ['required'],
            'semester' => ['required','integer'],
            'hari' => ['required'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'total_pertemuan' => ['required','integer'],
            'dosen_id' => ['required','integer'],
            'kelase_id' => ['required','integer'],
            'matkul_id' => ['required','integer'],
        ]);
        $jadwal = Jadwal::create($validated);

        if($jadwal){
            $startingDate = Carbon::now(); // Change to the desired starting date
            $englishDay = $this->convertToEnglishDay($jadwal->hari);

            for ($ke = 1; $ke <= $jadwal->total_pertemuan; $ke++) {
                $nextDate = $startingDate->copy()->next($englishDay)->addWeeks($ke - 1);$nextDate = $startingDate->copy()->next($englishDay)->addWeeks($ke - 1);
                $dataPertemuan = [
                    'status' => '0',
                    'ke' => $ke,
                    'tanggal' => $nextDate->format('Y-m-d'),
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                    'jadwal_id' => $jadwal->id,
                ];

                // Create a Pertemuan entry
                Pertemuan::create($dataPertemuan);
            }
        }

        return Redirect::route('jadwals.index')->with('success', 'Jadwal created.');
    }

    public function edit(Jadwal $jadwal)
    {
        $dosenOptions = Dosen::select('id', 'nama','prodi_id')->get()->map(function ($dosen) {
            return [
                'value' => $dosen->id,
                'label' => $dosen->nama,
                'prodi_id' => $dosen->prodi_id,
            ];
        });
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

        $matkulOptions = Matkul::select('id', 'nama','prodi_id')->distinct()->get()->map(function ($matkul) {
            return [
                'value' => $matkul->id,
                'label' => $matkul->nama,
                'prodi_id' => $matkul->prodi_id,
            ];
        });

        $currentYear = date('Y');
        $years = [];

        for ($i = $currentYear; $i >= ($currentYear - 10); $i--) {
            // Determine academic year label (Gasal or Genap)
            $academicYearLabel = ($i % 2 !== 0) ? 'Gasal' : 'Genap';

            // Generate both the value and label for the option
            $value = $i . '/' . ($i + 1);
            $label = $i . '/' . ($i + 1);

            // Add both Gasal and Genap options for each academic year
            $years[] = [
                'value' => $value . ' Gasal',
                'label' => $label . ' Gasal',
            ];
            $years[] = [
                'value' => $value . ' Genap',
                'label' => $label . ' Genap',
            ];
        }
        return Inertia::render('Jadwals/Edit',[
            'jadwal' => [
                'id' => $jadwal->id,
                'tahun_ajar' => $jadwal->tahun_ajar,
                'semester' => $jadwal->semester,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'total_pertemuan' => $jadwal->total_pertemuan,
                'dosen_id' => $jadwal->dosen_id,
                'kelase_id' => $jadwal->kelase_id   ,
                'matkul_id' => $jadwal->matkul_id,
                'prodi_id' => $jadwal->kelase->prodi_id,
            ],
            'prodiOptions' => $prodiOptions,
            'dosenOptions' => $dosenOptions,
            'kelaseOptions' => $kelaseOptions,
            'matkulOptions' => $matkulOptions,
            'tahunOptions' => $years,
        ]);
    }

    public function update(Request $request,Jadwal $jadwal)
    {
        $validated = $request->validate([
            'tahun_ajar' => ['required'],
            'semester' => ['required','integer'],
            'hari' => ['required'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'total_pertemuan' => ['required','integer'],
            'dosen_id' => ['required','integer'],
            'kelase_id' => ['required','integer'],
            'matkul_id' => ['required','integer'],
        ]);

        $jadwal->update($validated);

        return Redirect::route('jadwals.index')->with('success', 'Jadwal updated.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return Redirect::route('jadwlas.index')->with('success', 'Kelas Deleted.');
    }
    private function convertToEnglishDay($indonesianDay)
    {
        $daysMapping = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];

        return $daysMapping[$indonesianDay] ?? null;
    }
}


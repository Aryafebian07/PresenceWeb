<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // Tambahkan ini

use App\Models\Matkul;
use App\Models\Pertemuan;
use App\Models\Jadwal;
use Carbon\Carbon;

class GeneratePertemuanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('GeneratePertemuanJob started.');
        $englishDay = Carbon::now()->addDay()->format('l');
        $indonesianDay = $this->convertToIndonesianDay($englishDay);
        if ($indonesianDay) {
            $matkuls = Matkul::whereHas('jadwals', function ($query) use ($indonesianDay) {
                $query->where('hari', $indonesianDay);
            })->get();
            if (!$matkuls->isEmpty()) {
                foreach ($matkuls as $matkul) {
                    Log::info('Data Matkul: ' . json_encode($matkul));
                    $totalPertemuan = $matkul->total_pertemuan;
                    $jadwals = $matkul->jadwals()->where('hari', $indonesianDay)->get();

                    if (!$jadwals->isEmpty()) {
                        foreach ($jadwals as $jadwal) {
                            Log::info('Data Jadwal: ' . json_encode($jadwal));

                            $pertemuanTerakhir = Pertemuan::where('jadwal_id', $jadwal->id)
                                ->orderBy('ke', 'desc')
                                ->first();

                            $startingDate = $pertemuanTerakhir ? Carbon::parse($pertemuanTerakhir->tanggal) : Carbon::now();
                            Log::info('Starting Date: ' . $startingDate);

                            $jumlahPertemuanTerjadwal = $pertemuanTerakhir ? $pertemuanTerakhir->ke : 0;

                            if ($jumlahPertemuanTerjadwal < $totalPertemuan) {
                                $ke = $jumlahPertemuanTerjadwal + 1;
                                $englishDay = $this->convertToEnglishDay($jadwal->hari);
                                if (!$englishDay) {
                                    Log::error('Hari ' . $jadwal->hari . ' tidak valid.');
                                    continue;
                                }
                                $nextDate = $startingDate->copy()->next($englishDay)->addWeeks($ke - 1);
                                Log::info('Starting nextDate: ' . $nextDate);
                                $data = [
                                    'status' =>'0',
                                    'ke' => $ke,
                                    'tanggal' => $nextDate->format('Y-m-d'),
                                    'jam_mulai' => $jadwal->jam_mulai,
                                    'jam_selesai' => $jadwal->jam_selesai,
                                    'jadwal_id' => $jadwal->id,
                                ];

                                // Cetak log untuk data yang akan dimasukkan
                                Log::info('Data Pertemuan yang akan dimasukkan: ' . json_encode($data));

                                // Simpan data ke dalam tabel Pertemuan
                                Pertemuan::create($data);
                            }
                        }
                    } else {
                        Log::error('Tidak ada jadwal untuk matakuliah dengan ID: ' . $matkul->id);
                    }
                }
            }else{
                Log::error('Tidak ada jadwal untuk matakuliah dengan jadwal pada hari besok (' . $indonesianDay . ')');
            }
        }else{
            Log::error('Hari besok tidak valid.');
        }
        Log::info('GeneratePertemuanJob finished.');
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

    private function convertToIndonesianDay($englishDay)
    {
        $daysMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $daysMapping[$englishDay] ?? null;
    }
}

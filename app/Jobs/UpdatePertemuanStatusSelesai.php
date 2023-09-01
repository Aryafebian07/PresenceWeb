<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Pertemuan;
use Carbon\Carbon;

class UpdatePertemuanStatusSelesai implements ShouldQueue
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
        $now = Carbon::now('Asia/Jakarta');
        // Update the status of Pertemuan where tanggal = now and jam_selesai = now
        Pertemuan::where('tanggal', $now->format('Y-m-d'))
            ->where('jam_selesai', '<=', $now->format('H:i'))
            ->where('status', '!=', '2') // Make sure it's not already updated
            ->update(['status' => '2']);
    }
}

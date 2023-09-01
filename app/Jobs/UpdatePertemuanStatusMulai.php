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


class UpdatePertemuanStatusMulai implements ShouldQueue
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
        
        $formattedDate = $now->format('Y-m-d');
        $formattedTime = $now->format('H:i');

       // Update the status of Pertemuan where tanggal = now and jam_mulai = now
       Pertemuan::where('tanggal', $formattedDate)
           ->where('jam_mulai', '<=', $formattedTime)
           ->where('status', '!=', '1') // Make sure it's not already updated
           ->update(['status' => '1']);
    }
}

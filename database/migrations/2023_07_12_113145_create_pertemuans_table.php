<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pertemuans', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('ke');
            $table->string('tanggal');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->text('materi')->nullable();
            $table->string('jenis_pertemuan')->nullable();
            $table->string('metode_belajar')->nullable();
            $table->unsignedBigInteger('jadwal_id')->default(0);
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            // $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuans');
    }
};

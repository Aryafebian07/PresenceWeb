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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajar');
            $table->string('semester');
            $table->string('hari');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->integer('total_pertemuan');
            $table->unsignedBigInteger('dosen_id')->default(0);
            $table->unsignedBigInteger('kelase_id')->default(0);
            $table->unsignedBigInteger('matkul_id')->default(0);
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('kelase_id')->references('id')->on('kelases')->onDelete('cascade');
            $table->foreign('matkul_id')->references('id')->on('matkuls')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};

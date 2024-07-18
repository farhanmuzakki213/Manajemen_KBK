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
        Schema::create('hasil_verifikasi_soal_ujian', function (Blueprint $table) {
            $table->bigInteger('ver_rps_uas_id')->unsigned();
            $table->integer('jumlah_soal');
            $table->json('soal_data');
            $table->timestamps();
            $table->foreign('ver_rps_uas_id')->references('id_ver_rps_uas')->on('ver_rps_uas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_verifikasi_soal_ujian');
    }
};

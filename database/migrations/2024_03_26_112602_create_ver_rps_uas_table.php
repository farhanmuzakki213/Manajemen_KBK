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
        Schema::create('ver_rps_uas', function (Blueprint $table) {
            $table->bigInteger('id_ver_rps_uas')->primary();
            $table->bigInteger('rep_rps_uas_id');
            $table->bigInteger('dosen_id');
            $table->enum('status_verifikasi', ['0', '1'])->default('0')->comment('0: Tidak Diverifikasi, 1: Diverifikasi');
            $table->enum('rekomendasi', ['0', '1', '2', '3'])->default('0')->comment('0: Belum Diveriikasi, 1: Tidak Layak Pakai, 2: Revisi, 3: layak Dipakai');
            $table->text('saran')->nullable();
            $table->date('tanggal_diverifikasi');
        });

        Schema::table('ver_rps_uas', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rep_rps_uas_id')->references('id_rep_rps_uas')->on('rep_rps_uas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_rps_uas');
    }
};

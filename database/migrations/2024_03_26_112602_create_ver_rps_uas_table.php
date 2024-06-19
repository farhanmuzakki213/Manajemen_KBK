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
            $table->bigInteger('id_ver_rps_uas')->primary()->unsigned();
            $table->bigInteger('rep_rps_uas_id');
            $table->bigInteger('pengurus_id');
            $table->enum('rekomendasi', ['0', '1', '2', '3'])->default('0')->comment('0: Belum Diveriikasi, 1: Tidak Layak Pakai, 2: Revisi, 3: layak Dipakai');
            $table->text('saran')->nullable();
            $table->timestamp('tanggal_diverifikasi');
            $table->timestamps();
        });

        Schema::table('ver_rps_uas', function (Blueprint $table) {
            $table->foreign('pengurus_id')->references('id_pengurus')->on('pengurus_kbk')
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

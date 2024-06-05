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
        Schema::create('ver_berita_acara_detail_pivot', function (Blueprint $table) {
            $table->bigInteger('berita_acara_id');
            $table->bigInteger('ver_rps_uas_id');
            $table->bigInteger('prodi_id');
        });

        Schema::table('ver_berita_acara_detail_pivot', function (Blueprint $table) {
            $table->foreign('berita_acara_id')->references('id_berita_acara')->on('ver_berita_acara')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ver_rps_uas_id')->references('id_ver_rps_uas')->on('ver_rps_uas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_berita_acara_detail_pivot');
    }
};

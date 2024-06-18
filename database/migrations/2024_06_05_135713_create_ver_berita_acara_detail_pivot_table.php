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
            $table->bigInteger('berita_acara_id')->unsigned();
            $table->bigInteger('ver_rps_uas_id')->unsigned();
            $table->bigInteger('jenis_kbk_id')->unsigned();

            // Pastikan tipe data kolom sesuai dengan tipe data di tabel referensi
            // Pastikan urutan pembuatan tabel sudah benar

            $table->foreign('berita_acara_id')->references('id_berita_acara')->on('ver_berita_acara')->onDelete('cascade');
            $table->foreign('ver_rps_uas_id')->references('id_ver_rps_uas')->on('ver_rps_uas')->onDelete('cascade');
            /* $table->primary(['berita_acara_id']); */
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

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
        Schema::create('ver_berita_acara', function (Blueprint $table) {
            $table->bigInteger('id_berita_acara')->primary();
            $table->bigInteger('kajur');
            $table->bigInteger('kaprodi');
            $table->string('file_berita_acara');
            $table->enum('Status_dari_kaprodi', ['0', '1'])->default('0')->comment('0: Di Tolak, 1: Disetujui');
            $table->enum('Status_dari_kajur', ['0', '1'])->default('0')->comment('0: Tidak diketahui, 1: Di ketahui');
            $table->enum('type', ['0', '1'])->comment('0: RPS, 1: UAS');
            $table->date('tanggal_disetujui_kaprodi');
            $table->date('tanggal_diketahui_kajur');
        });

        Schema::table('ver_berita_acara', function (Blueprint $table) {
            $table->foreign('kajur')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kaprodi')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_berita_acara');
    }
};

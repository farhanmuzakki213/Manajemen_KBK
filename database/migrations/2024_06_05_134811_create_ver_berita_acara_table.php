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
            $table->bigIncrements('id_berita_acara')->unsigned();
            $table->bigInteger('kajur');
            $table->bigInteger('kaprodi');
            $table->bigInteger('jenis_kbk_id');
            $table->string('file_berita_acara');
            $table->enum('Status_dari_kaprodi', ['0', '1'])->default('0')->comment('0: Di Tolak, 1: Disetujui');
            $table->enum('Status_dari_kajur', ['0', '1'])->default('0')->comment('0: Tidak diketahui, 1: Di ketahui');
            $table->enum('type', ['0', '1'])->comment('0: RPS, 1: UAS');
            $table->timestamp('tanggal_disetujui_kaprodi')->nullable();
            $table->timestamp('tanggal_diketahui_kajur')->nullable();
            $table->timestamp('tanggal_upload')->nullable();
        });

        Schema::table('ver_berita_acara', function (Blueprint $table) {
            $table->foreign('kajur')->references('id_pimpinan_jurusan')->on('pimpinan_jurusan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kaprodi')->references('id_pimpinan_prodi')->on('pimpinan_prodi')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_kbk_id')->references('id_jenis_kbk')->on('jenis_kbk')
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

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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->bigInteger('id_kurikulum')->primary();
            $table->string('kode_kurikulum');
            $table->string('nama_kurikulum');
            $table->string('tahun');
            $table->bigInteger('prodi_id');
            $table->enum('status', ['0', '1'])->default(1)->comment('0: Tidak Aktif, 1: Aktif');
        });

        Schema::table('kurikulum', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};

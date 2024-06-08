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
        Schema::create('pimpinan_prodi', function (Blueprint $table) {
            $table->bigInteger('id_pimpinan_prodi')->primary();
            $table->bigInteger('jabatan_pimpinan_id');
            $table->bigInteger('prodi_id');
            $table->bigInteger('dosen_id');
            $table->string('periode');
            $table->enum('status_pimpinan_prodi', ['0', '1'])->default(1);
        });

        Schema::table('pimpinan_prodi', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jabatan_pimpinan_id')->references('id_jabatan_pimpinan')->on('jabatan_pimpinan')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinan_prodi');
    }
};

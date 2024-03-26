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
        Schema::create('dosen_matkul', function (Blueprint $table) {
            $table->id('id_dosen_matkul');
            $table->bigInteger('dosen_id')->unsigned();
            $table->bigInteger('matkul_id')->unsigned();
            $table->bigInteger('kelas_id')->unsigned();
            $table->bigInteger('smt_thnakd_id')->unsigned();
        });

        Schema::table('dosen_matkul', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('matkul_id')->references('id_matkul')->on('matkul')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id_kelas')->on('kelas')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('smt_thnakd_id')->references('id_smt_thnakd')->on('smt_thnakd')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_matkul');
    }
};

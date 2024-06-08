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
        Schema::create('dosen_matkul_detail_pivot', function (Blueprint $table) {
            $table->bigInteger('dosen_matkul_id');
            $table->bigInteger('matkul_kbk_id');
            $table->bigInteger('kelas_id');
        });

        Schema::table('dosen_matkul_detail_pivot', function (Blueprint $table) {
            $table->foreign('dosen_matkul_id')->references('id_dosen_matkul')->on('dosen_matkul')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('matkul_kbk_id')->references('id_matkul_kbk')->on('matkul_kbk')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id_kelas')->on('kelas')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_matkul_detail_pivot');
    }
};

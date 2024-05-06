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
        Schema::create('matkul_kbk', function (Blueprint $table) {
            $table->bigInteger('id_matkul_kbk')->primary();
            $table->bigInteger('matkul_id');
            $table->bigInteger('jenis_kbk_id');
            $table->bigInteger('kurikulum_id');
        });

        Schema::table('matkul_kbk', function (Blueprint $table) {
            $table->foreign('matkul_id')->references('id_matkul')->on('matkul')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_kbk_id')->references('id_jenis_kbk')->on('jenis_kbk')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kurikulum_id')->references('id_kurikulum')->on('kurikulum')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matkul_kbk');
    }
};

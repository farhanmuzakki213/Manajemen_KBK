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
        Schema::create('dosen_kbk', function (Blueprint $table) {
            $table->bigInteger('id_dosen_kbk')->primary();
            $table->bigInteger('jenis_kbk_id');
            $table->bigInteger('dosen_id');
        });

        Schema::table('dosen_kbk', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
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
        Schema::dropIfExists('dosen_kbk');
    }
};

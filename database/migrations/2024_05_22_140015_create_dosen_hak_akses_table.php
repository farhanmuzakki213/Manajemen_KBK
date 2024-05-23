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
        Schema::create('dosen_hak_akses', function (Blueprint $table) {
            $table->bigInteger('id_dosen_hak_akses')->primary();
            $table->bigInteger('dosen_id');
            $table->bigInteger('hak_akses_id');
        });

        Schema::table('dosen_hak_akses', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hak_akses_id')->references('id_hak_akses')->on('hak_akses')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_hak_akses');
    }
};

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
        Schema::create('matkul', function (Blueprint $table) {
            $table->bigInteger('id_matkul')->primary();
            $table->string('kode_matkul');
            $table->string('nama_matkul');
            $table->enum('TP', ['T', 'P', 'T/P']);
            $table->string('sks');
            $table->string('jam');
            $table->string('sks_teori');
            $table->string('sks_praktek');
            $table->string('jam_teori');
            $table->string('jam_praktek');
            $table->string('semester');
            $table->bigInteger('kurikulum_id');
            // $table->bigInteger('smt_thnakd_id');
        });

        Schema::table('matkul', function (Blueprint $table) {
            $table->foreign('kurikulum_id')->references('id_kurikulum')->on('kurikulum')
                    ->onUpdate('cascade')->onDelete('cascade');
                    
            // $table->foreign('smt_thnakd_id')->references('id_smt_thnakd')->on('smt_thnakd')
            // ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matkul');
    }
};

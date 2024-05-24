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
        Schema::create('ver_rps', function (Blueprint $table) {
            $table->uuid('id_ver_rps')->primary();
            $table->bigInteger('rep_rps_id');
            $table->bigInteger('dosen_id');
            $table->string('file_verifikasi')->nullable();
            $table->enum('status_ver_rps', ['0', '1'])->default('0')->comment('0: Tidak Diverifikasi, 1: Diverifikasi');
            $table->text('catatan')->nullable();
            $table->date('tanggal_diverifikasi');
        });

        Schema::table('ver_rps', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rep_rps_id')->references('id_rep_rps')->on('rep_rps')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_rps');
    }
};

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
        Schema::create('ver_uas', function (Blueprint $table) {
            $table->id('id_ver_uas');
            $table->bigInteger('dosen_id')->unsigned();
            $table->string('file');
            $table->enum('status', ['diverifikasi', 'tidak diverifikasi']);
            $table->text('catatan')->nullable();
            $table->date('tanggal_diverifikasi');
        });

        Schema::table('ver_uas', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ver_uas');
    }
};

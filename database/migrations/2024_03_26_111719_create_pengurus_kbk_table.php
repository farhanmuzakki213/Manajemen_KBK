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
        Schema::create('pengurus_kbk', function (Blueprint $table) {
            $table->id('id_pengurus');
            $table->bigInteger('jenis_kbk_id')->unsigned();
            $table->bigInteger('dosen_id')->unsigned();
            $table->bigInteger('jabatan_kbk_id')->unsigned();
            $table->enum('status', ['0', '1'])->default(1);
        });

        Schema::table('pengurus_kbk', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jabatan_kbk_id')->references('id_jabatan_kbk')->on('jabatan_kbk')
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
        Schema::dropIfExists('pengurus_kbk');
    }
};
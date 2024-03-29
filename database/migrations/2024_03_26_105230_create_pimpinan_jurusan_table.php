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
        Schema::create('pimpinan_jurusan', function (Blueprint $table) {
            $table->id('id_pimpinan_jurusan');
            $table->bigInteger('jabatan_pimpinan_id')->unsigned();
            $table->bigInteger('jurusan_id')->unsigned();
            $table->bigInteger('dosen_id')->unsigned();
            $table->string('periode');
            $table->enum('status', ['0', '1'])->default(1);
        });

        Schema::table('pimpinan_jurusan', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jabatan_pimpinan_id')->references('id_jabatan_pimpinan')->on('jabatan_pimpinan')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id_jurusan')->on('jurusan')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinan_jurusan');
    }
};

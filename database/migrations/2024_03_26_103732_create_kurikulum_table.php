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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id('id_kurikulum');
            $table->string('kode_kurikulum');
            $table->string('nama_kurikulum');
            $table->string('tahun');
            $table->bigInteger('prodi_id')->unsigned();
            $table->enum('status', ['0', '1'])->default(1);
        });

        Schema::table('kurikulum', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};

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
        Schema::create('rep_uas', function (Blueprint $table) {
            $table->id('id_rep_uas');
            $table->bigInteger('smt_thnakd_id')->unsigned();
            $table->bigInteger('ver_uas_id')->unsigned();
            $table->bigInteger('matkul_id')->unsigned();
            $table->string('file');
            $table->timestamps();
        });

        Schema::table('rep_uas', function (Blueprint $table) {
            $table->foreign('smt_thnakd_id')->references('id_smt_thnakd')->on('smt_thnakd')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ver_uas_id')->references('id_ver_uas')->on('ver_uas')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('matkul_id')->references('id_matkul')->on('matkul')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rep_uas');
    }
};

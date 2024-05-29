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
        Schema::create('rep_rps', function (Blueprint $table) {
            $table->bigInteger('id_rep_rps')->primary();
            $table->bigInteger('smt_thnakd_id');
            $table->bigInteger('dosen_id');
            $table->bigInteger('matkul_id');
            $table->string('file');
            $table->timestamps();
        });

        Schema::table('rep_rps', function (Blueprint $table) {
            $table->foreign('smt_thnakd_id')->references('id_smt_thnakd')->on('smt_thnakd')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
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
        Schema::dropIfExists('rep_rps');
    }
};

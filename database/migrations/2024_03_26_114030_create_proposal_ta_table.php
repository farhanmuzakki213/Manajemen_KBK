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
        Schema::create('proposal_ta', function (Blueprint $table) {
            $table->bigInteger('id_proposal_ta')->primary();
            $table->bigInteger('mahasiswa_id');
            $table->string('judul');
            $table->enum('status_proposal_ta', ['0', '1', '2', '3'])->default('0')->comment('0: Diajukan, 1: Ditolak, 2: Direvisi, 3: Diterima');
            $table->string('file_proposal');
            $table->bigInteger('pembimbing_satu');
            $table->bigInteger('pembimbing_dua');
            $table->bigInteger('jenis_kbk_id');
        });

        Schema::table('proposal_ta', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_satu')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_dua')->references('id_dosen')->on('dosen')
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
        Schema::dropIfExists('proposal_ta');
    }
};

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
        Schema::create('review_proposal_ta', function (Blueprint $table) {
            $table->bigInteger('id_penugasan')->primary();
            $table->bigInteger('proposal_ta_id');
            $table->bigInteger('reviewer_satu');
            $table->bigInteger('reviewer_dua');
            $table->bigInteger('pimpinan_prodi_id');
            $table->enum('status_final_proposal', ['0', '1'])->default('0')->comment('0: Belum Final, 1: Final');
            $table->timestamp('tanggal_penugasan');
        });

        Schema::table('review_proposal_ta', function (Blueprint $table) {
            $table->foreign('proposal_ta_id')->references('id_proposal_ta')->on('proposal_ta')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reviewer_satu')->references('id_dosen_kbk')->on('dosen_kbk')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reviewer_dua')->references('id_dosen_kbk')->on('dosen_kbk')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pimpinan_prodi_id')->references('id_pimpinan_prodi')->on('pimpinan_prodi')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_proposal_ta');
    }
};

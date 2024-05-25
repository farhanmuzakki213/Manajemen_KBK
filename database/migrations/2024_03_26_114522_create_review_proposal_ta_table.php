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
            $table->uuid('id_penugasan')->primary();
            $table->bigInteger('proposal_ta_id');
            $table->bigInteger('reviewer_satu');
            $table->bigInteger('reviewer_dua');
            $table->enum('status_review_proposal', ['0', '1', '2', '3'])->default('0')->comment('0: Di Ajukan, 1: Di Tolak, 2: Di Revisi, 3: Di Terima');
            $table->enum('status_final_proposal', ['0', '1'])->default('0')->comment('0: Belum Final, 1: Final');
            $table->text('catatan')->nullable();
            $table->date('tanggal_penugasan');
            $table->date('tanggal_review')->nullable();
        });

        Schema::table('review_proposal_ta', function (Blueprint $table) {
            $table->foreign('proposal_ta_id')->references('id_proposal_ta')->on('proposal_ta')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reviewer_satu')->references('id_dosen')->on('dosen')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reviewer_dua')->references('id_dosen')->on('dosen')
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

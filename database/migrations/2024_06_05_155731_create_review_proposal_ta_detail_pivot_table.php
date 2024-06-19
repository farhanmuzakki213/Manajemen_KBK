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
        Schema::create('review_proposal_ta_detail_pivot', function (Blueprint $table) {
            $table->bigInteger('penugasan_id');
            $table->enum('dosen', ['1','2'])->comment('1: Reviewer Satu, 2: Reviewer Dua');
            $table->enum('status_review_proposal', ['0', '1', '2', '3'])->default('0')->comment('0: Di Ajukan, 1: Di Tolak, 2: Di Revisi, 3: Di Terima');
            $table->text('catatan');
            $table->timestamp('tanggal_review');
            $table->unique(['penugasan_id', 'dosen']);
        });

        Schema::table('review_proposal_ta_detail_pivot', function (Blueprint $table) {
            $table->foreign('penugasan_id')->references('id_penugasan')->on('review_proposal_ta')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_proposal_ta_detail_pivot');
    }
};

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
        Schema::create('penugasan_reviewer_proposal_ta', function (Blueprint $table) {
            $table->bigInteger('id_penugasan')->primary();
            $table->bigInteger('proposal_ta_id');
            $table->bigInteger('dosen_id');
            $table->date('tanggal_penugasan');
            $table->string('status')->default('diajukan');
        });

        Schema::table('penugasan_reviewer_proposal_ta', function (Blueprint $table) {
            $table->foreign('proposal_ta_id')->references('id_proposal_ta')->on('proposal_ta')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_reviewer_proposal_ta');
    }
};

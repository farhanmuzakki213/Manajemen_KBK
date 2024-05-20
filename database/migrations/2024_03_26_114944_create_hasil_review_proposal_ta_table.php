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
        Schema::create('hasil_review_proposal_ta', function (Blueprint $table) {
            $table->bigInteger('id_hasil')->primary();
            $table->bigInteger('penugasan_id');
            $table->string('hasil');
            $table->text('catatan')->nullable();
            $table->date('tanggal_review');
        });

        Schema::table('hasil_review_proposal_ta', function (Blueprint $table) {
            $table->foreign('penugasan_id')->references('id_penugasan')->on('penugasan_reviewer_proposal_ta')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_review_proposal_ta');
    }
};

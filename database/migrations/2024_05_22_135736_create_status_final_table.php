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
        Schema::create('status_final', function (Blueprint $table) {
            $table->bigInteger('id_status')->primary();
            $table->bigInteger('proposal_ta_id');
            $table->string('status_final');
        });

        Schema::table('status_final', function (Blueprint $table) {
            $table->foreign('proposal_ta_id')->references('id_proposal_ta')->on('proposal_ta')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_final');
    }
};

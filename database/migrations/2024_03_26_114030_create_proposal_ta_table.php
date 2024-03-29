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
            $table->id('id_proposal_ta');
            $table->string('judul');
            $table->bigInteger('mahasiswa_id')->unsigned();
            $table->string('file');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::table('proposal_ta', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa')
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

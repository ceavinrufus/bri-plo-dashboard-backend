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
        Schema::create('jatuh_tempo_dokumen_spks', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->unsignedBigInteger('dokumen_spk_id');
            $table->foreign('dokumen_spk_id')->references('id')->on('dokumen_spks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jatuh_tempo_dokumen_spks');
    }
};

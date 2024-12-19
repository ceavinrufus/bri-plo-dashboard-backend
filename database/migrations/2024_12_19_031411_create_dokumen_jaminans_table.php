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
        Schema::create('dokumen_jaminans', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->date('tanggal_diterima')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('nomor_jaminan')->nullable();
            $table->string('dokumen_keabsahan')->nullable();
            $table->json('nilai')->nullable();
            $table->date('waktu_mulai')->nullable();
            $table->date('waktu_berakhir')->nullable();
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
        Schema::dropIfExists('dokumen_jaminans');
    }
};

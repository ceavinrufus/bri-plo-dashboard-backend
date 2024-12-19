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
        Schema::create('dokumen_perjanjians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_permohonan_diterima')->nullable();
            $table->string('tim_pemrakarsa')->nullable();
            $table->foreignId('pic_pengadaan_id')->constrained('users')->nullable();
            $table->string('nomor_spk');
            $table->date('tanggal_spk')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->json('spk')->nullable();
            $table->integer('jangka_waktu')->nullable();
            $table->string('pelaksana_pekerjaan')->nullable();
            $table->string('pic_pelaksana_pekerjaan')->nullable();
            $table->string('nomor_kontrak');
            $table->date('tanggal_kontrak')->nullable();
            $table->foreignId('pic_legal_id')->constrained('users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_perjanjians');
    }
};

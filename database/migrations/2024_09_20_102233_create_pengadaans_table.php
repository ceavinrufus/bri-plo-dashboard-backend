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
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_user');
            $table->date('nodin_user')->nullable();
            $table->date('tanggal_nodin_user')->nullable();
            $table->string('departemen');
            $table->foreign('departemen')->references('code')->on('departments')->onDelete('restrict');
            $table->string('perihal');
            $table->date('tanggal_spk')->nullable();
            $table->enum('metode', ['Lelang', 'Pemilihan Langsung', 'Seleksi Langsung', 'Penunjukkan Langsung'])->nullable();
            $table->boolean('is_verification_complete')->nullable();
            $table->boolean('is_done')->nullable();
            $table->string('proses_pengadaan')->nullable();
            $table->integer('nilai_spk')->nullable();
            $table->integer('anggaran')->nullable();
            $table->integer('hps')->nullable();
            $table->integer('tkdn_percentage')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaans');
    }
};
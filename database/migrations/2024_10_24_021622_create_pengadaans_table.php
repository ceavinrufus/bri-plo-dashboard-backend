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
            $table->string('tim');
            $table->string('departemen');
            $table->foreign('departemen')->references('code')->on('departments')->onDelete('restrict');
            $table->string('proyek')->nullable();
            $table->foreign('proyek')->references('kode')->on('projects')->onDelete('restrict')->onUpdate('cascade');
            $table->string('perihal');
            $table->enum('metode', ['Lelang', 'Pemilihan Langsung', 'Seleksi Langsung', 'Penunjukkan Langsung'])->nullable();
            $table->boolean('is_verification_complete')->nullable();
            $table->date('verification_alert_at')->nullable();
            $table->date('nodin_alert_at')->nullable();
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('proses_pengadaan')->nullable();
            $table->string('nomor_spk')->nullable();
            $table->date('tanggal_spk')->nullable();
            $table->date('tanggal_acuan')->nullable();
            $table->string('pelaksana_pekerjaan')->nullable();
            $table->json('spk_investasi')->nullable();
            $table->json('spk_eksploitasi')->nullable();
            $table->json('anggaran_investasi')->nullable();
            $table->json('anggaran_eksploitasi')->nullable();
            $table->json('hps')->nullable();
            $table->float('tkdn_percentage')->nullable();
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

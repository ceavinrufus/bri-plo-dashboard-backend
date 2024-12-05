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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('perihal')->nullable();
            $table->string('nomor_spk');
            $table->date('tanggal_spk')->nullable();
            $table->string('nama_vendor')->nullable();
            $table->foreignId('pic_id')->constrained('users')->nullable();
            $table->integer('sla_spk_sejak_terbit')->nullable();
            $table->integer('sla_spk_sejak_diambil')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('jangka_waktu')->nullable();
            $table->string('tim')->nullable();
            $table->json('spk')->nullable();
            $table->string('identitas_vendor')->nullable();
            $table->text('info_vendor')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->string('identitas_pengambil')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('form_tkdn')->nullable();
            $table->date('tanggal_penyerahan_dokumen')->nullable();
            $table->string('penerima_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};

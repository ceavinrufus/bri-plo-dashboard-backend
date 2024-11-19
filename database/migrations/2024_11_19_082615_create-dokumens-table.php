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
            $table->string('perihal');
            $table->string('nomor_spk');
            $table->date('tanggal_spk');
            $table->string('nama_vendor');
            $table->foreignId('pic_id')->constrained('users');
            $table->integer('sla_spk_sejak_terbit');
            $table->integer('sla_spk_sejak_diambil');
            $table->date('tanggal');
            $table->integer('jangka_waktu');
            $table->string('tim');
            $table->decimal('nilai_spk', 15, 2);
            $table->string('identitas_vendor');
            $table->text('info_vendor');
            $table->date('tanggal_pengambilan');
            $table->string('identitas_pengambil');
            $table->date('tanggal_pengembalian');
            $table->date('tanggal_jatuh_tempo');
            $table->text('catatan');
            $table->boolean('form_tkdn');
            $table->date('tanggal_penyerahan_dokumen');
            $table->string('penerima_dokumen');
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

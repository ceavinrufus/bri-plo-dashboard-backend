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
        Schema::create('dokumen_spks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_spk_diterima')->nullable();
            $table->string('tim_pemrakarsa')->nullable();
            $table->foreignId('pic_pengadaan_id')->nullable()->constrained('users');
            $table->string('nomor_spk');
            $table->date('tanggal_spk')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->json('spk')->nullable();
            $table->integer('jangka_waktu')->nullable();
            $table->string('pelaksana_pekerjaan')->nullable();
            $table->string('pic_pelaksana_pekerjaan')->nullable();
            $table->string('dokumen_pelengkap')->nullable();
            $table->date('tanggal_info_ke_vendor')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->string('identitas_pengambil')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->json('dokumen_yang_dikembalikan')->nullable();
            $table->decimal('tkdn_percentage', 5, 2)->nullable();
            $table->date('tanggal_penyerahan_dokumen')->nullable();
            $table->string('penerima_dokumen')->nullable();
            $table->foreignId('pic_legal_id')->nullable()->constrained('users');
            $table->text('catatan')->nullable();
            $table->boolean('is_pekerjaan_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_spks');
    }
};

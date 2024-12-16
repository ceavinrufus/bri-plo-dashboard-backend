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
        Schema::create('rekap_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_pc_id')->constrained('users')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->string('nomor_spk')->nullable();
            $table->date('tanggal_spk')->nullable();
            $table->string('nomor_perjanjian')->nullable();
            $table->date('tanggal_perjanjian')->nullable();
            $table->string('perihal')->nullable();
            $table->json('spk')->nullable();
            $table->string('vendor')->nullable();
            $table->string('tkdn')->nullable();
            $table->string('nomor_invoice')->nullable();
            $table->json('invoice')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->foreignId('pic_pay_id')->constrained('users')->nullable();
            $table->string('nota_fiat')->nullable();
            $table->date('tanggal_fiat')->nullable();
            $table->date('sla')->nullable();
            $table->integer('hari_pengerjaan')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pembayarans');
    }
};

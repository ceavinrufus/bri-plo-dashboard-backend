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
            $table->string('nama_pengadaan');
            $table->date('tanggal_nodin')->nullable();
            $table->date('tanggal_spk')->nullable();
            $table->integer('hari_pengerjaan')->nullable();
            $table->string('metode')->nullable();
            $table->string('progres')->nullable();
            $table->integer('hari_proses')->nullable();
            $table->string('progres_pengadaan')->nullable();
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

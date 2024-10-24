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
        Schema::create('nodin_plos', function (Blueprint $table) {
            $table->id();
            $table->string('nodin');
            $table->date('tanggal_nodin');
            $table->unsignedBigInteger('pengadaan_id');
            $table->foreign('pengadaan_id')->references('id')->on('pengadaans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodin_plos');
    }
};

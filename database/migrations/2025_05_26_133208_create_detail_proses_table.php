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
    Schema::create('detail_proses', function (Blueprint $table) {
        $table->id('id_detail_proses');
        $table->unsignedBigInteger('id_proses');
        $table->unsignedBigInteger('id_bahan');
        $table->foreign('id_proses')->references('id_proses')->on('proses_produksi')->onDelete('cascade');
        $table->foreign('id_bahan')->references('id_bahan')->on('bahan')->onDelete('cascade');
        $table->integer('kuantitas');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_proses');
    }
};

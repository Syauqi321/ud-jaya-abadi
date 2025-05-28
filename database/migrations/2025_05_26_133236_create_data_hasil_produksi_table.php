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
   Schema::create('data_hasil_produksi', function (Blueprint $table) {
       $table->id('id_data_hasil_produksi');
       $table->unsignedBigInteger('id_proses');
       $table->unsignedBigInteger('id_produk');
       $table->foreign('id_proses')->references('id_proses')->on('proses_produksi')->onDelete('cascade');
       $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
       $table->integer('kuantitas');
       $table->text('keterangan')->nullable();
       $table->timestamps();
   });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_hasil_produksi');
    }
};

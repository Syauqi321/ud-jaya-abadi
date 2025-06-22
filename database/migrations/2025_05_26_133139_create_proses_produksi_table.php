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
    Schema::create('proses_produksi', function (Blueprint $table) {
        $table->id('id_proses');
        $table->string('kode_produksi');
        $table->date('tanggal');

        // Kolom dari hasil produksi langsung dimasukkan ke sini
        $table->unsignedBigInteger('id_produk')->nullable();
        $table->integer('kuantitas')->nullable();
        $table->text('keterangan')->nullable();
        $table->boolean('status')->nullable();

        $table->timestamps();

        // Foreign key relasi ke produk
        $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_produksi');
    }
};

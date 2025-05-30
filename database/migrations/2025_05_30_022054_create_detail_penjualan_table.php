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
        Schema::create('detail_penjualan', function (Blueprint $table) {
    $table->id(); // atau $table->bigIncrements('id_detail_penjualan');
    $table->unsignedBigInteger('id_penjualan');
    $table->unsignedBigInteger('id_produk');
    $table->integer('kuantitas');
    $table->integer('harga_jual');
    $table->timestamps();

    // Foreign keys
    $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
    $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};

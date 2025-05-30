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
        Schema::create('detail_pembelian', function (Blueprint $table) {
    $table->id(); // id auto increment Laravel
    $table->unsignedBigInteger('id_pembelian');
    $table->unsignedBigInteger('id_bahan');
    $table->integer('kuantitas');
    $table->integer('harga');
    $table->timestamps();

    // Foreign key setup
    $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');
    $table->foreign('id_bahan')->references('id_bahan')->on('bahan')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};

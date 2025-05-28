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
     Schema::create('pembelian', function (Blueprint $table) {
    $table->id('id_pembelian');
    $table->unsignedBigInteger('id_bahan');
    $table->foreign('id_bahan')->references('id_bahan')->on('bahan')->onDelete('cascade');
    $table->date('tanggal');
    $table->integer('kuantitas');
    $table->decimal('harga', 15, 2);
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};

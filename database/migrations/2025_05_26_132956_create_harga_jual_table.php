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
     Schema::create('harga_jual', function (Blueprint $table) {
    $table->id('id_harga');

    // Buat kolom foreign key dulu
    $table->unsignedBigInteger('id_produk');

    // Lalu buat relasinya
    $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');

    $table->date('tanggal');
    $table->decimal('harga', 15, 2);
    $table->boolean('status')->nullable();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_jual');
    }
};

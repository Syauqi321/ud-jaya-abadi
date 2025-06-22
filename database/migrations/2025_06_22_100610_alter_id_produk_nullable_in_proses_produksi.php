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
    Schema::table('proses_produksi', function (Blueprint $table) {
        $table->unsignedBigInteger('id_produk')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('proses_produksi', function (Blueprint $table) {
        $table->unsignedBigInteger('id_produk')->nullable(false)->change();
    });
}

};

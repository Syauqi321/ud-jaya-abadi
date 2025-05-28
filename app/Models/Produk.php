<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama', 'stok'];

    public function hargaJual()
    {
        return $this->hasMany(HargaJual::class, 'id_produk');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_produk');
    }

    public function dataHasilProduksi()
    {
        return $this->hasMany(DataHasilProduksi::class, 'id_produk');
    }
}

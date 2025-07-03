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

    // Relasi untuk harga jual aktif (status = true)
    // Di model Produk
    public function hargaJualTerbaru()
    {
        return $this->hasOne(HargaJual::class, 'id_produk')->latestOfMany('tanggal');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk');
    }

    public function prosesProduksi()
    {
        return $this->hasMany(prosesProduksi::class, 'id_produk');
    }
}

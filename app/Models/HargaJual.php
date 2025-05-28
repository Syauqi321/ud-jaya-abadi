<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaJual extends Model
{
    protected $table = 'harga_jual';
    protected $primaryKey = 'id_harga';
    protected $fillable = ['id_produk', 'tanggal', 'harga', 'status'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}

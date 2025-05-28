<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHasilProduksi extends Model
{
    protected $table = 'data_hasil_produksi';
    protected $primaryKey = 'id_data_hasil_produksi';
    protected $fillable = ['id_proses', 'id_produk', 'kuantitas', 'keterangan'];

    public function prosesProduksi()
    {
        return $this->belongsTo(ProsesProduksi::class, 'id_proses');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}

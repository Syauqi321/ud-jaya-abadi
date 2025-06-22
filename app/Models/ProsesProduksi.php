<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesProduksi extends Model
{
    protected $table = 'proses_produksi';
    protected $primaryKey = 'id_proses';
    protected $fillable = ['kode_produksi', 'tanggal', 'id_produk', 'kuantitas', 'keterangan'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function detailProses()
    {
        return $this->hasMany(DetailProses::class, 'id_proses');
    }
}

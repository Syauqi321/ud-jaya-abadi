<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesProduksi extends Model
{
    protected $table = 'proses_produksi';
    protected $primaryKey = 'id_proses';
    protected $fillable = ['kode_produksi', 'tanggal'];

    public function dataHasilProduksi()
    {
        return $this->hasMany(DataHasilProduksi::class, 'id_proses');
    }

    public function detailProses()
    {
        return $this->hasMany(DetailProses::class, 'id_proses');
    }
}

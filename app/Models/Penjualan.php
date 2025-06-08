<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['id_pelanggan', 'tanggal'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }


    public function getTotalAttribute()
    {
        return $this->detailPenjualan->sum(function ($detail) {
            return $detail->kuantitas * $detail->harga_jual;
        });
    }

}


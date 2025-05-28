<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = ['id_bahan', 'tanggal', 'kuantitas', 'harga'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }
}

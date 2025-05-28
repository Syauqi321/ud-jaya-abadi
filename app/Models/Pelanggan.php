<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['nama', 'alamat', 'telp'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}

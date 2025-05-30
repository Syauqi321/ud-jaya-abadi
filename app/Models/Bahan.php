<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    protected $fillable = ['nama', 'stok'];

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_bahan');
    }

    public function detailProses()
    {
        return $this->hasMany(DetailProses::class, 'id_bahan');
    }
}

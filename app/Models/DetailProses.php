<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailProses extends Model
{
    protected $table = 'detail_proses';
    protected $primaryKey = 'id_detail_proses';
    protected $fillable = ['id_proses', 'id_bahan', 'kuantitas'];

    public function prosesProduksi()
    {
        return $this->belongsTo(ProsesProduksi::class, 'id_proses');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }
}

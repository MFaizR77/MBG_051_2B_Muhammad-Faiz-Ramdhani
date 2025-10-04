<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    protected $table = 'permintaan_detail'; // sesuai nama tabel di soal

    protected $fillable = ['permintaan_id', 'bahan_id', 'jumlah_diminta'];

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
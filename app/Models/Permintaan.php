<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $table = 'permintaan'; 

    protected $fillable = [
        'pemohon_id',
        'tgl_masak',
        'menu_makan',
        'jumlah_porsi',
        'status'
    ];

     protected $casts = [
        'tgl_masak' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi jika ada
    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function details()
    {
        return $this->hasMany(PermintaanDetail::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'kategori',
        'jumlah',
        'satuan',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'status',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    // Relasi: Bahan bisa dipakai di banyak permintaan detail
    public function permintaanDetails()
    {
        return $this->hasMany(PermintaanDetail::class, 'bahan_id');
    }

    // Helper: Hitung status berdasarkan aturan bisnis
    public function hitungStatus()
    {
        if ($this->jumlah == 0) {
            return 'habis';
        }

        $today = Carbon::today();
        $kadaluarsa = Carbon::parse($this->tanggal_kadaluarsa);

        if ($today->greaterThanOrEqualTo($kadaluarsa)) {
            return 'kadaluarsa';
        }

        if ($kadaluarsa->diffInDays($today) <= 3) {
            return 'segera_kadaluarsa';
        }

        return 'tersedia';
    }

    // Mutator: otomatis update status saat jumlah/tanggal berubah
    public function setJumlahAttribute($value)
    {
        $this->attributes['jumlah'] = $value;
        $this->attributes['status'] = $this->hitungStatus();
    }

    public function setTanggalKadaluarsaAttribute($value)
    {
        $this->attributes['tanggal_kadaluarsa'] = $value;
        $this->attributes['status'] = $this->hitungStatus();
    }
}
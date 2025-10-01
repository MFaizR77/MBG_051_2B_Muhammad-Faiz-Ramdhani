<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{


    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'gudang' atau 'dapur'
    ];

    protected $hidden = ['password'];

    // Relasi: User (gudang/dapur) bisa punya banyak permintaan (jika dapur)
    public function permintaan()
    {
        return $this->hasMany(Permintaan::class, 'pemohon_id');
    }
}
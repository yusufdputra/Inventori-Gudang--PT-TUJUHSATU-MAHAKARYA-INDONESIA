<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $table = 'peminjamans';
    protected $dates = ['deleted_at'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'id_barang')->withTrashed();
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'id_pegawai')->withTrashed();
    }
}
